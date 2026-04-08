<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Antrian;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $dipanggil = Antrian::where('status', 'sedang dilayani')->first();
        $jumlahMenunggu = Antrian::where('status', 'menunggu')->count();
        $jumlahSelesai = Antrian::where('status', 'selesai')->whereDate('updated_at', Carbon::today())->count();
        $antrianMenunggu = Antrian::where('status', 'menunggu')->orderBy('waktu_masuk', 'asc')->get();

        return view('admin.dashboard', compact('dipanggil', 'jumlahMenunggu', 'jumlahSelesai', 'antrianMenunggu'));
    }

    // Fungsi Panggil Antrian Selanjutnya
    public function panggil($id)
    {
        // 1. Jika ada yang sedang dilayani, otomatis ubah statusnya jadi 'selesai'
        Antrian::where('status', 'sedang dilayani')->update([
            'status' => 'selesai',
            'waktu_selesai' => now()
        ]);

        // 2. Ubah pelanggan yang dipilih menjadi 'sedang dilayani'
        $antrian = Antrian::findOrFail($id);
        $antrian->update(['status' => 'sedang dilayani']);

        return redirect()->back()->with('success', 'Antrian ' . $antrian->nomor_antrian . ' sedang dilayani.');
    }

    // Fungsi Selesaikan Antrian Manual
    public function selesai($id)
    {
        $antrian = Antrian::findOrFail($id);
        $antrian->update([
            'status' => 'selesai',
            'waktu_selesai' => now()
        ]);

        return redirect()->back()->with('success', 'Layanan selesai.');
    }

    // Fungsi Batalkan Antrian
    public function batal($id)
    {
        $antrian = Antrian::findOrFail($id);
        $antrian->update([
            'status' => 'batal',
            'waktu_selesai' => now() // Mencatat waktu dibatalkan
        ]);

        return redirect()->back()->with('success', 'Antrian ' . $antrian->nomor_antrian . ' dibatalkan.');
    }
    public function antrian()
    {
        // Ambil semua data antrian, urutkan dari yang terbaru
        $antrians = Antrian::orderBy('created_at', 'desc')->get();
        return view('admin.antrian.antrian', compact('antrians'));
    }

    // Menampilkan halaman form tambah pelanggan
    public function tambahPelanggan()
    {
        return view('admin.tambah-pelanggan');
    }

    // Memproses data pelanggan baru ke database
    public function simpanPelanggan(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|max:255'
        ]);

        // Cari nomor antrian terakhir di hari yang sama
        $antrianTerakhir = Antrian::whereDate('created_at', Carbon::today())
            ->orderBy('id', 'desc')
            ->first();

        // Generate nomor baru
        $nomorBaru = 1;
        if ($antrianTerakhir) {
            $nomorBaru = (int)$antrianTerakhir->nomor_antrian + 1;
        }

        // Format angka menjadi 2 digit (misal: 1 jadi 01, 2 jadi 02)
        $nomorFormat = str_pad($nomorBaru, 2, '0', STR_PAD_LEFT);

        // Simpan ke database
        Antrian::create([
            'nomor_antrian' => $nomorFormat,
            'nama_pelanggan' => $request->nama_pelanggan,
            'status' => 'menunggu',
            'waktu_masuk' => now()
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Pelanggan atas nama ' . $request->nama_pelanggan . ' berhasil ditambahkan ke antrian.');
    }
}
