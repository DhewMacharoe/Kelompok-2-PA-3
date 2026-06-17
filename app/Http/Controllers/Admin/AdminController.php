<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Antrean;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        if (auth()->check() && auth()->user()->hasRole('super_admin') && !session()->has('current_barbershop_id')) {
            return redirect()->route('super-admin.dashboard');
        }

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

        // Tren Pengunjung 7 Hari Terakhir - Dioptimalkan menjadi 1 query
        $trendLabels = [];
        $trendData = [];
        $startDate = Carbon::today()->subDays(6);
        $endDate = Carbon::today()->endOfDay();

        $trendCounts = Antrean::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('DATE(created_at) as date, count(*) as total')
            ->groupBy('date')
            ->pluck('total', 'date')
            ->toArray();

        for ($i = 6; $i >= 0; $i--) {
            $tanggal = Carbon::today()->subDays($i);
            $dateString = $tanggal->toDateString();
            $trendLabels[] = $tanggal->translatedFormat('l');
            $trendData[] = $trendCounts[$dateString] ?? 0;
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
}
