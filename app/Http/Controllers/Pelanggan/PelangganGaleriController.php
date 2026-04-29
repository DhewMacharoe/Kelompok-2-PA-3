<?php

namespace App\Http\Controllers;
<<<<<<< Updated upstream

=======
use App\Models\Galeri;
>>>>>>> Stashed changes
use Illuminate\Http\Request;

class PelangganGaleriController extends Controller
{
<<<<<<< Updated upstream
    //
=======
    public function index()
    {
        $galeris = Galeri::where('is_active', true)
            ->latest()
            ->get();

        return view('pelanggan.galeri.galeri', compact('galeris'));
    }
>>>>>>> Stashed changes
}
