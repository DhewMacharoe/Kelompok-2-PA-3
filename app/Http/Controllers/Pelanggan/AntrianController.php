<?php

namespace App\Http\Controllers\Pelanggan;

use App\Events\AntreanListUpdate;
use App\Http\Controllers\Controller;
use App\Models\Antrean;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AntrianController extends Controller
{
    public function index()
    {
        $data_antrean = Antrean::getTodayWaitingQueues();
        $dipanggil = Antrean::getQueueBeingServed();
        $layananAktif = Layanan::where('is_active', true)
            ->orderBy('nama', 'asc')
            ->get();

        $punyaAntreanAktif = false;
        $antreanSayaAktif = null;
        $posisiAntreanSaya = null;

        if (Auth::check() && Auth::user()->username) {
            $antreanSayaAktif = Antrean::with(['layanan1', 'layanan2'])
                ->byCustomerName(Auth::user()->username)
                ->todayActiveQueues()
                ->orderBy('waktu_masuk', 'asc')
                ->first();

            $punyaAntreanAktif = (bool) $antreanSayaAktif;

            if ($antreanSayaAktif && $antreanSayaAktif->status === 'menunggu') {
                $posisiAntreanSaya = $antreanSayaAktif->calculateQueuePosition();
            }
        }

        return view('pelanggan.antrian.antrian', compact(
            'data_antrean',
            'dipanggil',
            'punyaAntreanAktif',
            'layananAktif',
            'antreanSayaAktif',
            'posisiAntreanSaya'
        ));
    }

    public function create()
    {
        return view('antrean.create');
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login.user')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        if (!$user->username) {
            return redirect()->route('set.username')->with('error', 'Silakan atur username terlebih dahulu untuk mengantri.');
        }

        $this->validateQueueRequest($request);

        if (Antrean::customerHasActiveQueue($user->username)) {
            return back()->with('error', 'Anda sudah berada di dalam daftar antrean saat ini.');
        }

        $lastNumber = Antrean::getLastQueueNumberToday();
        $nomorFormat = str_pad($lastNumber + 1, 2, '0', STR_PAD_LEFT);

        Antrean::create([
            'nomor_antrean' => $nomorFormat,
            'nama_pelanggan' => $user->username,
            'layanan_id1' => $request->input('layanan_id1'),
            'layanan_id2' => $request->input('layanan_id2'),
            'status' => 'menunggu',
            'waktu_masuk' => now()
        ]);

        $this->broadcastQueueUpdate();

        return back()->with('success', 'Antrean anda terdaftar silahkan tunggu.');
    }

    public function cancelMyQueue()
    {
        if (!Auth::check()) {
            return redirect()->route('login.user')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();
        if (!$user->username) {
            return redirect()->route('set.username')->with('error', 'Silakan atur username terlebih dahulu.');
        }

        $antreanAktif = Antrean::getCustomerActiveQueue($user->username);

        if (!$antreanAktif) {
            return back()->with('error', 'Tidak ada antrean aktif yang bisa dibatalkan.');
        }

        $antreanAktif->cancelQueue();
        $this->broadcastQueueUpdate();

        return back()->with('success', 'Antrean Anda berhasil dibatalkan.');
    }

    // ============ PRIVATE HELPERS ============

    private function validateQueueRequest(Request $request): void
    {
        $request->validate([
            'layanan_id1' => [
                'required',
                Rule::exists('layanans', 'id')->where(function ($query) {
                    $query->where('is_active', true);
                }),
            ],
            'layanan_id2' => [
                'nullable',
                'different:layanan_id1',
                Rule::exists('layanans', 'id')->where(function ($query) {
                    $query->where('is_active', true);
                }),
            ],
        ]);
    }

    private function broadcastQueueUpdate(): void
    {
        $antreanList = Antrean::getTodayWaitingQueues();
        event(new AntreanListUpdate($antreanList));
        // broadcast(new AntreanListUpdate($antreanList))->toOthers();
    }
}
