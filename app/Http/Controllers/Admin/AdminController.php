<?php

namespace App\Http\Controllers\Admin;
use App\Events\AntreanListUpdate;
use App\Http\Controllers\Controller;
use App\Models\Antrian;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $dipanggil = Antrian::where('status', 'sedang dilayani')->first();
        $jumlahMenunggu = Antrian::where('status', 'menunggu')->whereDate('created_at', Carbon::today())->count();
        $jumlahSelesai = Antrian::where('status', 'selesai')->whereDate('updated_at', Carbon::today())->count();
        $antrianMenunggu = Antrian::where('status', 'menunggu')->orderBy('waktu_masuk', 'asc')->limit(3)->get();
        $batal= Antrian::where('status', 'batal')->whereDate('updated_at', Carbon::today())->count();
        $jumlahPengunjung = Antrian::whereDate('created_at', Carbon::today())->count();


        $statistikData = [
            'pengunjung' => $jumlahPengunjung,
            'menunggu' => $jumlahMenunggu,
            'selesai' => $jumlahSelesai,
            'batal' => $batal,
        ];

        return view('admin.dashboard', compact('statistikData', 'antrianMenunggu', 'dipanggil'));
    }

    // Fungsi Panggil Antrian Selanjutnya
    public function panggil($id)
    {

        Antrian::where('status', 'sedang dilayani')->update([
            'status' => 'selesai',
            'waktu_selesai' => now()
        ]);


        $antrian = Antrian::findOrFail($id);
        $antrian->update(['status' => 'sedang dilayani']);

        $antrianList = Antrian::where('status', 'menunggu')->orderBy('waktu_masuk', 'asc')->get();

        broadcast(new AntreanListUpdate($antrianList))->toOthers();

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
        // Mengambil data antrian yang kolom 'created_at' nya adalah hari ini
        $antrians = Antrian::whereDate('created_at', now()->today())
                            ->orderBy('created_at', 'asc')
                            ->get();

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


        $nomorFormat = str_pad($nomorBaru, 2, '0', STR_PAD_LEFT);

        // Simpan ke database
        $antrian = Antrian::create([
            'nomor_antrian' => $nomorFormat,
            'nama_pelanggan' => $request->nama_pelanggan,
            'status' => 'menunggu',
            'waktu_masuk' => now()
        ]);

        $antrianList = Antrian::where('status', 'menunggu')->orderBy('waktu_masuk', 'asc')->get();

        broadcast(new AntreanListUpdate($antrianList))->toOthers();

        return redirect()->route('admin.antrian')->with('success', 'Pelanggan atas nama ' . $request->nama_pelanggan . ' berhasil ditambahkan ke antrian.');
    }


}
