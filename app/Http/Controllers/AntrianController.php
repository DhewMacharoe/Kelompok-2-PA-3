<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AntrianController extends Controller
{
    public function index()
    {
        $data_antrian = Antrian::where('status', 'menunggu')->whereDate('created_at', Carbon::today())->get();
        $dipanggil = Antrian::where('status', 'sedang dilayani')->first();

        return view('pelanggan.antrian.antrian ', compact('data_antrian', 'dipanggil'));
    }

    public function create()
    {
        return view('antrian.create');
    }


    public function store(Request $request)
    {
        $validateAntrian =$request->validate([
            'nama_pelanggan' => 'required|string|max:255',
        ]);

        $antrianTerakhir = Antrian::whereDate('created_at', Carbon::today())
            ->orderBy('id', 'desc')
            ->first();

        $nomorBaru = 1;
        if ($antrianTerakhir) {
            $nomorBaru = (int)$antrianTerakhir->nomor_antrian + 1;
        }

        $nomorFormat = str_pad($nomorBaru, 2, '0', STR_PAD_LEFT);

        $newAntrian = Antrian::create([
            'nomor_antrian' => $nomorFormat,
            'nama_pelanggan' => $validateAntrian['nama_pelanggan'],
            'status' => 'menunggu',
            'waktu_masuk' => now()
        ]);

    }








}
