<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Antrean;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RekapController extends Controller
{
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
}
