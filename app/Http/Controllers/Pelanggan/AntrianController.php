<?php

namespace App\Http\Controllers\Pelanggan;

use App\Events\AntreanListUpdate;
use App\Http\Controllers\Controller;
use App\Models\Antrian;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AntrianController extends Controller
{
    public function index()
    {
        $data_antrian = Antrian::getTodayWaitingQueues();
        $dipanggil = Antrian::getQueueBeingServed();
        $layananAktif = Layanan::where('is_active', true)
            ->orderBy('nama', 'asc')
            ->get();

        $punyaAntrianAktif = false;
        $antrianSayaAktif = null;
        $posisiAntrianSaya = null;

        if (Auth::check() && Auth::user()->username) {
            $antrianSayaAktif = Antrian::with(['layanan1', 'layanan2'])
                ->byCustomerName(Auth::user()->username)
                ->todayActiveQueues()
                ->orderBy('waktu_masuk', 'asc')
                ->first();

            $punyaAntrianAktif = (bool) $antrianSayaAktif;

            if ($antrianSayaAktif && $antrianSayaAktif->status === 'menunggu') {
                $posisiAntrianSaya = $antrianSayaAktif->calculateQueuePosition();
            }
        }

        return view('pelanggan.antrian.antrian', compact(
            'data_antrian',
            'dipanggil',
            'punyaAntrianAktif',
            'layananAktif',
            'antrianSayaAktif',
            'posisiAntrianSaya'
        ));
    }

    public function create()
    {
        return view('antrian.create');
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

        if (Antrian::customerHasActiveQueue($user->username)) {
            return back()->with('error', 'Anda sudah berada di dalam daftar antrian saat ini.');
        }

        $lastNumber = Antrian::getLastQueueNumberToday();
        $nomorFormat = str_pad($lastNumber + 1, 2, '0', STR_PAD_LEFT);

        Antrian::create([
            'nomor_antrian' => $nomorFormat,
            'nama_pelanggan' => $user->username,
            'layanan_id1' => $request->input('layanan_id1'),
            'layanan_id2' => $request->input('layanan_id2'),
            'status' => 'menunggu',
            'waktu_masuk' => now()
        ]);

        $this->broadcastQueueUpdate();

        return back()->with('success', 'Antrian anda terdaftar silahkan tunggu.');
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

        $antrianAktif = Antrian::getCustomerActiveQueue($user->username);

        if (!$antrianAktif) {
            return back()->with('error', 'Tidak ada antrean aktif yang bisa dibatalkan.');
        }

        $antrianAktif->cancelQueue();
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
        $antrianList = Antrian::getTodayWaitingQueues();
        event(new AntreanListUpdate($antrianList));
        // broadcast(new AntreanListUpdate($antrianList))->toOthers();
    }
}
