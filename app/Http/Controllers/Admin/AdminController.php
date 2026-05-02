<?php

namespace App\Http\Controllers\Admin;

use App\Events\AntreanListUpdate;
use App\Events\AntreanUpdate;
use App\Http\Controllers\Controller;
use App\Models\Antrean;
use App\Models\Layanan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function dashboard()
    {
        Antrean::cancelExpiredWaitingQueues();

        $dipanggil = Antrean::where('status', 'sedang dilayani')->first();
        $jumlahMenunggu = Antrean::where('status', 'menunggu')->whereDate('created_at', Carbon::today())->count();
        $jumlahSelesai = Antrean::where('status', 'selesai')->whereDate('updated_at', Carbon::today())->count();
        $antreanMenunggu = Antrean::whereDate('created_at', now()->today())->where('status', 'menunggu')->orderBy('created_at', 'asc')->limit(3)->get();
        $batal = Antrean::where('status', 'batal')->whereDate('updated_at', Carbon::today())->count();
        $jumlahPengunjung = Antrean::whereDate('created_at', Carbon::today())->count();


        $statistikData = [
            'pengunjung' => $jumlahPengunjung,
            'menunggu' => $jumlahMenunggu,
            'selesai' => $jumlahSelesai,
            'batal' => $batal,
        ];

        return view('admin.dashboard', compact('statistikData', 'antreanMenunggu', 'dipanggil'));
    }



    // Fungsi Selesaikan Antrean Manual
    public function selesai($id)
    {
        $antrean = Antrean::findOrFail($id);
        $antrean->update([
            'status' => 'selesai',
            'waktu_selesai' => now()
        ]);

        event(new AntreanUpdate($antrean));

        return redirect()->back()->with('success', 'Layanan selesai.');
    }

    // Fungsi Batalkan Antrean
    public function batal($id)
    {
        $antrean = Antrean::findOrFail($id);
        $antrean->update([
            'status' => 'batal',
            'waktu_selesai' => now()
        ]);

        event(new AntreanUpdate($antrean));

        return redirect()->back()->with('success', 'Antrean ' . $antrean->nomor_antrean . ' dibatalkan.');
    }
    public function antrean()
    {
        Antrean::cancelExpiredWaitingQueues();

        $validated = request()->validate([
            'tanggal' => ['nullable', 'date_format:Y-m-d'],
            'status' => ['nullable', Rule::in(['all', 'menunggu', 'selesai', 'batal'])],
        ]);

        $selectedTanggal = $validated['tanggal'] ?? null;
        $selectedStatus = $validated['status'] ?? 'all';

        $layananAktif = Layanan::where('is_active', true)
            ->orderBy('nama', 'asc')
            ->get();

        $antreans = Antrean::query()
            ->orderBy('created_at', 'asc')
            ->when($selectedStatus !== 'all', function ($query) use ($selectedStatus) {
                $query->where('status', $selectedStatus);
            })
            ->when($selectedTanggal, function ($query) use ($selectedTanggal, $selectedStatus) {
                $query->where(function ($dateQuery) use ($selectedTanggal, $selectedStatus) {
                    if (in_array($selectedStatus, ['selesai', 'batal'], true)) {
                        $dateQuery->whereDate('waktu_selesai', $selectedTanggal);

                        return;
                    }

                    if ($selectedStatus === 'all') {
                        $dateQuery->whereDate('created_at', $selectedTanggal)
                            ->orWhereDate('waktu_selesai', $selectedTanggal);

                        return;
                    }

                    $dateQuery->whereDate('created_at', $selectedTanggal);
                });
            })
            ->get();

        return view('admin.antrean.antrean', compact(
            'antreans',
            'layananAktif',
            'selectedTanggal',
            'selectedStatus'
        ));
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

        $antreans = Antrean::query()
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

        $totalPemasukan = $antreans->sum(function (Antrean $antrean) {
            return $antrean->totalPemasukanRekap();
        });

        return view('admin.rekap.rekap', compact(
            'antreans',
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

        // Generate nomor antrean dengan format 2-digit yang auto-reset per hari
        $nomorFormat = Antrean::generateDailyQueueNumber();

        // Simpan ke database
        $layananId1 = $request->input('layanan_id1');
        $layananId2 = $request->input('layanan_id2');

        $antrean = Antrean::create([
            'nomor_antrean' => $nomorFormat,
            'nama_pelanggan' => $request->nama_pelanggan,
            'layanan_id1' => $layananId1,
            'layanan_id2' => $layananId2,
            'status' => 'menunggu',
            'waktu_masuk' => now()
        ]);

        $antrean->layanans()->sync(array_values(array_filter([$layananId1, $layananId2])));

        $antreanList = Antrean::where('status', 'menunggu')
            ->whereDate('created_at', Carbon::today())
            ->orderBy('waktu_masuk', 'asc')
            ->get();

        event(new AntreanListUpdate($antreanList));

        return redirect()->route('admin.antrean')->with('success', 'Pelanggan atas nama ' . $request->nama_pelanggan . ' berhasil ditambahkan ke antrean.');
    }
}

