<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\ValidatesQueueLocation;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Layanan;
use App\Models\Galeri;
use App\Models\Menu;
use App\Models\Antrean;
use Illuminate\Http\Request;
use App\Events\AntreanUpdate;

class PublicController extends Controller
{
    use ValidatesQueueLocation;

    public function index()
    {
        $dipanggil = Antrean::where('status', 'sedang dilayani')->first();
        $jumlahMenunggu = Antrean::where('status', 'menunggu')->count();
        return view('index', compact('dipanggil', 'jumlahMenunggu'));
    }

    public function antrean()
    {
        $dipanggil = Antrean::where('status', 'sedang dilayani')->first();
        $menunggu = Antrean::where('status', 'menunggu')->orderBy('waktu_masuk', 'asc')->get();
        $jumlahMenunggu = $menunggu->count();
        return view('antrean', compact('dipanggil', 'menunggu', 'jumlahMenunggu'));
    }

    public function rekomendasi()
    {
        return view('pelanggan.rekomendasi.rekomendasi');
    }

    public function layanan()
    {
        return view('pelanggan.layanan.layanan');
    }

    public function galeri()
    {
        // Hanya ambil gaya rambut yang aktif
        $galeris = Galeri::where('is_active', true)->get();
        return view('pelanggan.galeri.galeri', compact('galeris'));
    }

    public function menu()
    {
        // Ambil hanya menu yang tersedia untuk halaman pelanggan
        $menus = Menu::where('is_available', true)->get();
        return view('pelanggan.menu.menu', compact('menus'));
    }
    public function daftarAntrean(Request $request)
    {
        $user = Auth::user();

        // Pastikan user sudah memiliki username
        if (!$user->username) {
            return redirect()->route('set.username')->with('error', 'Silakan atur username terlebih dahulu untuk mengantri.');
        }

        // Opsional: Cek apakah user sudah mengantri hari ini dan statusnya belum selesai/batal
        $antreanAktif = Antrean::where('nama_pelanggan', $user->username)
            ->whereIn('status', ['menunggu', 'sedang dilayani'])
            ->whereDate('created_at', Carbon::today())
            ->first();

        if ($antreanAktif) {
            return back()->with('error', 'Anda sudah berada di dalam daftar antrean saat ini.');
        }

        $locationValidation = $request->validate([
            'user_latitude' => 'required|numeric|between:-90,90',
            'user_longitude' => 'required|numeric|between:-180,180',
        ], [
            'user_latitude.required' => 'Akses lokasi gagal. Silakan aktifkan GPS/location dan coba lagi.',
            'user_longitude.required' => 'Akses lokasi gagal. Silakan aktifkan GPS/location dan coba lagi.',
            'user_latitude.numeric' => 'Data lokasi tidak valid.',
            'user_longitude.numeric' => 'Data lokasi tidak valid.',
        ]);

        $queueLocation = $this->queueLocationConfig();
        $targetLatitude = (float) ($queueLocation['latitude'] ?? 0);
        $targetLongitude = (float) ($queueLocation['longitude'] ?? 0);
        $radiusMeters = (int) ($queueLocation['radius_meters'] ?? 200);

        if ($targetLatitude === 0.0 && $targetLongitude === 0.0) {
            return back()->with('error', 'Konfigurasi lokasi antrean belum tersedia.')->withInput();
        }

        $distanceMeters = $this->distanceInMeters(
            (float) $locationValidation['user_latitude'],
            (float) $locationValidation['user_longitude'],
            $targetLatitude,
            $targetLongitude
        );

        if ($distanceMeters > $radiusMeters) {
            return back()->with('error', 'Anda harus berada dalam radius maksimal ' . $radiusMeters . ' meter dari lokasi antrean untuk mengambil antrean.')->withInput();
        }

        // Generate nomor antrean (Sesuaikan formatnya jika ada aturan khusus dari database Anda)
        $jumlahAntreanHariIni = Antrean::whereDate('created_at', Carbon::today())->count();
        $nomorAntreanBaru = 'A' . str_pad($jumlahAntreanHariIni + 1, 3, '0', STR_PAD_LEFT);

        // Masukkan data antrean baru
        $antrean = Antrean::create([
            'nomor_antrean_seq' => $nomorAntreanBaru,
            'nama_pelanggan' => $user->username,
            'status' => 'menunggu',
            'waktu_masuk' => Carbon::now(),
        ]);

        // (Opsional) Jika menggunakan Laravel Reverb/Pusher, uncomment baris di bawah agar admin real-time terupdate
        event(new AntreanUpdate($antrean));

        return back()->with('success', 'Antrean anda terdaftar silahkan tunggu');
    }
}
