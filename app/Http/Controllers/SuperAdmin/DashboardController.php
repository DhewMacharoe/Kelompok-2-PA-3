<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Barbershop;
use App\Models\User;
use App\Models\Antrean;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display global statistics and barbershop listings.
     */
    public function index()
    {
        $totalBarbershops = Barbershop::count();
        $totalAdmins = User::role('admin')->count();
        
        $today = Carbon::today();
        $totalQueuesToday = Antrean::withoutGlobalScopes()
            ->whereDate('created_at', $today)
            ->count();
            
        $queuesByStatus = Antrean::withoutGlobalScopes()
            ->whereDate('created_at', $today)
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
            
        $queuesMenunggu = $queuesByStatus['menunggu'] ?? 0;
        $queuesSelesai = $queuesByStatus['selesai'] ?? 0;
        $queuesBatal = $queuesByStatus['batal'] ?? 0;

        // Fetch all barbershops with their queue statistics for today
        $barbershops = Barbershop::all()->map(function ($barber) use ($today) {
            $stats = Antrean::withoutGlobalScopes()
                ->where('barbershop_id', $barber->id)
                ->whereDate('created_at', $today)
                ->selectRaw('status, count(*) as count')
                ->groupBy('status')
                ->pluck('count', 'status')
                ->toArray();
                
            $barber->queues_menunggu = $stats['menunggu'] ?? 0;
            $barber->queues_selesai = $stats['selesai'] ?? 0;
            $barber->queues_batal = $stats['batal'] ?? 0;
            $barber->queues_total = array_sum($stats);
            
            return $barber;
        });

        return view('super_admin.dashboard', compact(
            'totalBarbershops',
            'totalAdmins',
            'totalQueuesToday',
            'queuesMenunggu',
            'queuesSelesai',
            'queuesBatal',
            'barbershops'
        ));
    }

    /**
     * Switch context to a specific tenant or clear the context.
     */
    public function switchTenant($id)
    {
        if ($id === 'clear') {
            session()->forget([
                'current_barbershop_id',
                'current_barbershop_slug',
                'current_barbershop_nama',
            ]);
            return redirect()->route('super-admin.dashboard')->with('success', 'Keluar dari mode kelola tenant.');
        }

        $barbershop = Barbershop::findOrFail($id);
        
        session([
            'current_barbershop_id' => $barbershop->id,
            'current_barbershop_slug' => $barbershop->slug,
            'current_barbershop_nama' => $barbershop->nama,
        ]);

        return redirect()->route('admin.dashboard')->with('success', "Beralih ke tenant: {$barbershop->nama}");
    }
}
