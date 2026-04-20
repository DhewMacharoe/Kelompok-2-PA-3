<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AntrianController extends Controller
{
    public function index()
    {
        $antrianSedangDilayani = Antrian::where('status', 'sedang dilayani')->first();
        $antrianMenunggu = Antrian::where('status', 'menunggu')
            ->whereDate('created_at', Carbon::today())
            ->orderBy('waktu_masuk', 'asc')
            ->get();
        $jumlahMenunggu = $antrianMenunggu->count();

        $punyaAntrianAktif = false;
        if (Auth::check() && Auth::user()->username) {
            $punyaAntrianAktif = Antrian::where('nama_pelanggan', Auth::user()->username)
                ->whereIn('status', ['menunggu', 'sedang dilayani'])
                ->whereDate('created_at', Carbon::today())
                ->exists();
        }

        return view('pelanggan.antrian.antrian', compact('antrianSedangDilayani', 'antrianMenunggu', 'jumlahMenunggu', 'punyaAntrianAktif'));
    }



    public function create()
    {
        return view('antrian.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pelanggan'      => 'required|integer',
            'id_pemilik'        => 'required|integer',
            'nomor_antrian'     => 'required|string',
            'waktu_pengambilan' => 'required|date',
            'status'            => 'required|string',
            'metode_antrian'    => 'required|string',
        ]);

        Antrian::create($request->all());
        return redirect()->route('antrian.index')->with('success', 'Antrian berhasil ditambahkan!');
    }



}
