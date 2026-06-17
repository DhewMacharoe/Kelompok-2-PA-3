<?php

namespace App\Http\Controllers;

use App\Models\Barbershop;
use Illuminate\Http\Request;

class BarbershopMapController extends Controller
{
    /**
     * Display the interactive map showing all active barbershops.
     */
    public function index()
    {
        $barbershops = Barbershop::where('is_active', true)->get();
        return view('pelanggan.map', compact('barbershops'));
    }
}
