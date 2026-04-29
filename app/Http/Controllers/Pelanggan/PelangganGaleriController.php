<?php

namespace App\Http\Controllers\Pelanggan;
use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;

class PelangganGaleriController extends Controller
{
    public function index()
    {
        $galeris = Galeri::where('is_active', true)
            ->latest()
            ->get();

        return view('pelanggan.galeri.galeri', compact('galeris'));
    }
}
