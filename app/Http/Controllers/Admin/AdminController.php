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

        $dipanggil = Antrean::getQueueBeingServed();
        $jumlahMenunggu = Antrean::where('status', 'menunggu')->whereDate('created_at', Carbon::today())->count();
        $jumlahMenungguHariIni = $jumlahMenunggu;
        $jumlahSelesai = Antrean::where('status', 'selesai')->whereDate('updated_at', Carbon::today())->count();
        $antreanMenunggu = Antrean::whereDate('created_at', now()->today())->where('status', 'menunggu')->orderBy('created_at', 'asc')->limit(3)->get();
        $batal = Antrean::where('status', 'batal')->whereDate('updated_at', Carbon::today())->count();

        // Query status antrean hari ini untuk statistik chart
        $dataStatus = Antrean::whereDate('created_at', Carbon::today())
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $statistikData = [
            $dataStatus['menunggu'] ?? 0,
            $dataStatus['selesai'] ?? 0,
            $dataStatus['batal'] ?? 0,
        ];

        // Tren Pengunjung 7 Hari Terakhir
        $trendLabels = [];
        $trendData = [];
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = Carbon::today()->subDays($i);
            $trendLabels[] = $tanggal->translatedFormat('l');
            $trendData[] = Antrean::whereDate('created_at', $tanggal)->count();
        }

        return view('admin.dashboard', compact(
            'statistikData',
            'trendLabels',
            'trendData',
            'antreanMenunggu',
            'dipanggil',
            'jumlahMenungguHariIni'
        ));
    }



    // Fungsi Selesaikan Antrean Manual
    public function selesai($id)
    {
        $antrean = Antrean::findOrFail($id);
        $antrean->update([
            'status' => 'selesai',
            'waktu_selesai' => now()
        ]);

        try {
            event(new AntreanUpdate($antrean));
        } catch (\Exception $e) {
            \Log::warning('Realtime broadcast failed: ' . $e->getMessage());
        }

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

        try {
            event(new AntreanUpdate($antrean));
        } catch (\Exception $e) {
            \Log::warning('Realtime broadcast failed: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Antrean ' . $antrean->nomor_antrean_seq . ' dibatalkan.');
    }
    public function antrean()
    {
        Antrean::cancelExpiredWaitingQueues();
        Antrean::autoCancelIfOutsideOperationalHours();

        $validated = request()->validate([
            'tanggal' => ['nullable', 'date_format:Y-m-d'],
            'status' => ['nullable', Rule::in(['all', 'menunggu', 'selesai', 'batal'])],
        ]);

        $selectedTanggal = $validated['tanggal'] ?? null;
        $selectedStatus = $validated['status'] ?? 'menunggu';

        $layananAktif = Layanan::where('is_active', true)
            ->orderBy('nama', 'asc')
            ->get();

        $jumlahMenungguHariIni = Antrean::where('status', 'menunggu')
            ->whereDate('created_at', Carbon::today())
            ->count();

        // Ambil data "sedang dilayani"
        $currentServing = Antrean::getQueueBeingServed();

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
            'selectedStatus',
            'currentServing',
            'jumlahMenungguHariIni'
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
        if (!Antrean::isOperationalHour()) {
            return redirect()->back()->withErrors(['nama_pelanggan' => 'Antrean tidak dapat ditambah di luar jam operasional.'])->withInput();
        }

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
            'nomor_antrean_seq' => $nomorFormat,
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

        try {
            event(new AntreanListUpdate($antreanList));
        } catch (\Exception $e) {
            \Log::warning('Realtime broadcast failed: ' . $e->getMessage());
        }

        return redirect()->route('admin.antrean')->with('success', 'Pelanggan atas nama ' . $request->nama_pelanggan . ' berhasil ditambahkan ke antrean.');
    }

    public function lokasi()
    {
        $defaultConfig = config('queue_location.location', []);

        $latitude = \App\Models\Setting::get('queue_latitude', $defaultConfig['latitude'] ?? 2.33758);
        $longitude = \App\Models\Setting::get('queue_longitude', $defaultConfig['longitude'] ?? 99.079255);
        $radius = \App\Models\Setting::get('queue_radius_meters', $defaultConfig['radius_meters'] ?? 100);
        $jam_buka = \App\Models\Setting::get('queue_jam_buka', '09:00');
        $jam_tutup = \App\Models\Setting::get('queue_jam_tutup', '21:00');

        return view('admin.lokasi.index', compact('latitude', 'longitude', 'radius', 'jam_buka', 'jam_tutup'));
    }

    public function simpanLokasi(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'radius_meters' => 'required|integer|min:1',
            'jam_buka' => 'required|date_format:H:i',
            'jam_tutup' => 'required|date_format:H:i',
        ]);

        \App\Models\Setting::set('queue_latitude', $request->input('latitude'));
        \App\Models\Setting::set('queue_longitude', $request->input('longitude'));
        \App\Models\Setting::set('queue_radius_meters', $request->input('radius_meters'));
        \App\Models\Setting::set('queue_jam_buka', $request->input('jam_buka'));
        \App\Models\Setting::set('queue_jam_tutup', $request->input('jam_tutup'));

        return redirect()->back()->with('success', 'Pengaturan antrean berhasil diperbarui.');
    }
}

