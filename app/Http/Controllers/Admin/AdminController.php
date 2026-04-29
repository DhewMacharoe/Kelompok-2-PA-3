<?php

namespace App\Http\Controllers\Admin;
use App\Events\AntreanListUpdate;
use App\Events\AntreanUpadate;
use App\Http\Controllers\Controller;
use App\Models\Antrian;
use App\Models\Layanan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function dashboard()
    {
        Antrian::cancelExpiredWaitingQueues();

        $dipanggil = Antrian::where('status', 'sedang dilayani')->first();
        $jumlahMenunggu = Antrian::where('status', 'menunggu')->whereDate('created_at', Carbon::today())->count();
        $jumlahSelesai = Antrian::where('status', 'selesai')->whereDate('updated_at', Carbon::today())->count();
        $antrianMenunggu = Antrian::whereDate('created_at', now()->today())->where('status', 'menunggu')->orderBy('created_at', 'asc')->limit(3)->get();
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



    // Fungsi Selesaikan Antrian Manual
    public function selesai($id)
    {
        $antrian = Antrian::findOrFail($id);
        $antrian->update([
            'status' => 'selesai',
            'waktu_selesai' => now()
        ]);

        event(new AntreanUpadate($antrian));

        return redirect()->back()->with('success', 'Layanan selesai.');
    }

    // Fungsi Batalkan Antrian
    public function batal($id)
    {
        $antrian = Antrian::findOrFail($id);
        $antrian->update([
            'status' => 'batal',
            'waktu_selesai' => now()
        ]);

        event(new AntreanUpadate($antrian));

        return redirect()->back()->with('success', 'Antrian ' . $antrian->nomor_antrian . ' dibatalkan.');
    }
    public function antrian()
    {
        Antrian::cancelExpiredWaitingQueues();

        $layananAktif = Layanan::where('is_active', true)
            ->orderBy('nama', 'asc')
            ->get();

        $antrians = Antrian::orderBy('created_at', 'asc')->get();

        return view('admin.antrian.antrian', compact('antrians', 'layananAktif'));
    }

    public function rekapPemasukan(Request $request)
    {
        $periode = $request->get('periode', 'bulan');
        $referensi = Carbon::now();
        $mulai = $referensi->copy()->startOfMonth();
        $selesai = $referensi->copy()->endOfMonth();
        $labelPeriode = 'Bulan ini';

        if ($periode === 'hari') {
            $mulai = $referensi->copy()->startOfDay();
            $selesai = $referensi->copy()->endOfDay();
            $labelPeriode = 'Hari ini';
        } elseif ($periode === 'minggu') {
            $mulai = $referensi->copy()->startOfWeek();
            $selesai = $referensi->copy()->endOfWeek();
            $labelPeriode = 'Minggu ini';
        } elseif ($periode === 'tahun') {
            $mulai = $referensi->copy()->startOfYear();
            $selesai = $referensi->copy()->endOfYear();
            $labelPeriode = 'Tahun ini';
        } elseif ($periode === 'custom') {
            if ($request->filled('bulan_pilih')) {
                $bulanPilih = Carbon::createFromFormat('Y-m', $request->string('bulan_pilih')->toString());
                $mulai = $bulanPilih->copy()->startOfMonth();
                $selesai = $bulanPilih->copy()->endOfMonth();
                $labelPeriode = 'Bulan terpilih';
            } else {
                $mulai = $request->filled('dari')
                    ? Carbon::parse($request->input('dari'))
                    : $referensi->copy()->startOfMonth();
                $selesai = $request->filled('sampai')
                    ? Carbon::parse($request->input('sampai'))
                    : $referensi->copy()->endOfMonth();
                $labelPeriode = 'Periode custom';
            }
        }

        $mulai = $mulai->copy()->startOfDay();
        $selesai = $selesai->copy()->endOfDay();

        $antrians = Antrian::query()
            ->with([
                'layanans' => function ($query) {
                    $query->select('layanans.id', 'nama', 'harga');
                },
                'layanan1:id,nama,harga',
                'layanan2:id,nama,harga',
            ])
            ->where('status', 'selesai')
            ->whereBetween('updated_at', [$mulai, $selesai])
            ->orderByDesc('updated_at')
            ->get();

        $totalPemasukan = $antrians->sum(function (Antrian $antrian) {
            return $antrian->totalPemasukanRekap();
        });

        return view('admin.rekap.rekap', compact(
            'antrians',
            'periode',
            'labelPeriode',
            'mulai',
            'selesai',
            'totalPemasukan'
        ));
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
            'nama_pelanggan' => 'required|string|max:255',
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
        $layananId1 = $request->input('layanan_id1');
        $layananId2 = $request->input('layanan_id2');

        $antrian = Antrian::create([
            'nomor_antrian' => $nomorFormat,
            'nama_pelanggan' => $request->nama_pelanggan,
            'layanan_id1' => $layananId1,
            'layanan_id2' => $layananId2,
            'status' => 'menunggu',
            'waktu_masuk' => now()
        ]);

        $antrian->layanans()->sync(array_values(array_filter([$layananId1, $layananId2])));

        $antrianList = Antrian::where('status', 'menunggu')
            ->whereDate('created_at', Carbon::today())
            ->orderBy('waktu_masuk', 'asc')
            ->get();

        event(new AntreanListUpdate($antrianList));

        return redirect()->route('admin.antrian')->with('success', 'Pelanggan atas nama ' . $request->nama_pelanggan . ' berhasil ditambahkan ke antrian.');
    }


}
