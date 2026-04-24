<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Layanan;
use App\Models\Galeri;
use App\Models\Menu;
use App\Models\Antrian;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        $dipanggil = Antrian::where('status', 'sedang dilayani')->first();
        $jumlahMenunggu = Antrian::where('status', 'menunggu')->count();
        return view('index', compact('dipanggil', 'jumlahMenunggu'));
    }

    public function antrian()
    {
        $dipanggil = Antrian::where('status', 'sedang dilayani')->first();
        $menunggu = Antrian::where('status', 'menunggu')->orderBy('waktu_masuk', 'asc')->get();
        $jumlahMenunggu = $menunggu->count();
        return view('antrian', compact('dipanggil', 'menunggu', 'jumlahMenunggu'));
    }

    public function rekomendasi()
    {
        return view('rekomendasi');
    }

    public function layanan()
    {
        return view('pelanggan.layanan.layanan');
    }

    public function galeri()
    {
        // Hanya ambil gaya rambut yang aktif
        $galeris = Galeri::where('is_active', true)->get();
        return view('galeri', compact('galeris'));
    }

    public function menu()
    {
        // Ambil semua menu (yang habis tetap ditampilkan dengan label silang)
        $menus = Menu::all();
        return view('pelanggan.menu.menu', compact('menus'));
    }
    public function daftarAntrian(Request $request)
    {
        $user = Auth::user();

        // Pastikan user sudah memiliki username
        if (!$user->username) {
            return redirect()->route('set.username')->with('error', 'Silakan atur username terlebih dahulu untuk mengantri.');
        }

        // Opsional: Cek apakah user sudah mengantri hari ini dan statusnya belum selesai/batal
        $antrianAktif = Antrian::where('nama_pelanggan', $user->username)
            ->whereIn('status', ['menunggu', 'sedang dilayani'])
            ->whereDate('created_at', Carbon::today())
            ->first();

        if ($antrianAktif) {
            return back()->with('error', 'Anda sudah berada di dalam daftar antrian saat ini.');
        }

        // Generate nomor antrian (Sesuaikan formatnya jika ada aturan khusus dari database Anda)
        $jumlahAntrianHariIni = Antrian::whereDate('created_at', Carbon::today())->count();
        $nomorAntrianBaru = 'A' . str_pad($jumlahAntrianHariIni + 1, 3, '0', STR_PAD_LEFT);

        // Masukkan data antrian baru
        $antrian = Antrian::create([
            'nomor_antrian' => $nomorAntrianBaru,
            'nama_pelanggan' => $user->username,
            'status' => 'menunggu',
            'waktu_masuk' => Carbon::now(),
        ]);

        // (Opsional) Jika menggunakan Laravel Reverb/Pusher, uncomment baris di bawah agar admin real-time terupdate
        event(new \App\Events\AntreanUpadate($antrian));

        return back()->with('success', 'Antrian anda terdaftar silahkan tunggu');
    }
}
