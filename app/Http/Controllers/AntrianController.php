<?php

namespace App\Http\Controllers;

use App\Events\AntreanListUpdate;
use App\Models\Antrian;
use App\Models\Layanan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AntrianController extends Controller
{
    public function index()
    {
        $data_antrian = Antrian::where('status', 'menunggu')
            ->whereDate('created_at', Carbon::today())
            ->orderBy('waktu_masuk', 'asc')
            ->get();
        $dipanggil = Antrian::where('status', 'sedang dilayani')->first();
        $layananAktif = Layanan::where('is_active', true)
            ->orderBy('nama', 'asc')
            ->get();

        $punyaAntrianAktif = false;
        $antrianSayaAktif = null;
        $posisiAntrianSaya = null;

        if (Auth::check() && Auth::user()->username) {
            $antrianSayaAktif = Antrian::with(['layanan1', 'layanan2'])
                ->where('nama_pelanggan', Auth::user()->username)
                ->whereIn('status', ['menunggu', 'sedang dilayani'])
                ->whereDate('created_at', Carbon::today())
                ->orderBy('waktu_masuk', 'asc')
                ->first();

            $punyaAntrianAktif = (bool) $antrianSayaAktif;

            if ($antrianSayaAktif && $antrianSayaAktif->status === 'menunggu') {
                $posisiAntrianSaya = Antrian::where('status', 'menunggu')
                    ->whereDate('created_at', Carbon::today())
                    ->where(function ($query) use ($antrianSayaAktif) {
                        $query->where('waktu_masuk', '<', $antrianSayaAktif->waktu_masuk)
                            ->orWhere(function ($sameTimeQuery) use ($antrianSayaAktif) {
                                $sameTimeQuery->where('waktu_masuk', $antrianSayaAktif->waktu_masuk)
                                    ->where('id', '<=', $antrianSayaAktif->id);
                            });
                    })
                    ->count();
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

        $punyaAntrianAktif = Antrian::where('nama_pelanggan', $user->username)
            ->whereIn('status', ['menunggu', 'sedang dilayani'])
            ->whereDate('created_at', Carbon::today())
            ->exists();

        if ($punyaAntrianAktif) {
            return back()->with('error', 'Anda sudah berada di dalam daftar antrian saat ini.');
        }

        $antrianTerakhir = Antrian::whereDate('created_at', Carbon::today())
            ->orderBy('id', 'desc')
            ->first();

        $nomorBaru = 1;
        if ($antrianTerakhir) {
            $nomorBaru = (int)$antrianTerakhir->nomor_antrian + 1;
        }

        $nomorFormat = str_pad($nomorBaru, 2, '0', STR_PAD_LEFT);

        $newAntrian = Antrian::create([
            'nomor_antrian' => $nomorFormat,
            'nama_pelanggan' => $user->username,
            'layanan_id1' => $request->input('layanan_id1'),
            'layanan_id2' => $request->input('layanan_id2'),
            'status' => 'menunggu',
            'waktu_masuk' => now()
        ]);

        $antrianList = Antrian::where('status', 'menunggu')
            ->whereDate('created_at', Carbon::today())
            ->orderBy('waktu_masuk', 'asc')
            ->get();

        // broadcast(new AntreanListUpdate($antrianList))->toOthers();

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

        $antrianAktif = Antrian::where('nama_pelanggan', $user->username)
            ->whereIn('status', ['menunggu', 'sedang dilayani'])
            ->whereDate('created_at', Carbon::today())
            ->orderBy('waktu_masuk', 'asc')
            ->first();

        if (!$antrianAktif) {
            return back()->with('error', 'Tidak ada antrean aktif yang bisa dibatalkan.');
        }

        $antrianAktif->update([
            'status' => 'batal',
            'waktu_selesai' => now(),
        ]);

        $antrianList = Antrian::where('status', 'menunggu')
            ->whereDate('created_at', Carbon::today())
            ->orderBy('waktu_masuk', 'asc')
            ->get();

        // broadcast(new AntreanListUpdate($antrianList))->toOthers();

        return back()->with('success', 'Antrean Anda berhasil dibatalkan.');
    }








}
