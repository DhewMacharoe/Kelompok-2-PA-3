<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use Illuminate\Http\Request;

class AntrianController extends Controller
{
    public function index()
    {
        $data_antrian = Antrian::all();

        return view('antrian.index', compact('data_antrian'));
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
