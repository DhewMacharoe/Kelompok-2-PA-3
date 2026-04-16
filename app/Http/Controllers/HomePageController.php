<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomePageController extends Controller
{
    public function index()
    {
        $antrian = Antrian::get()->where('status', 'sedang dilayani')->first();


        $jumlahAntrian= Antrian::where('status', 'menunggu')
        ->whereDate('created_at', Carbon::today())
        ->count();

        $flora = "flora";

        return view('pelanggan.homepage.homepage', compact('antrian', 'jumlahAntrian', 'flora'));
    }
}
