<?php

namespace App\Http\Controllers;

use App\Models\Antrean;
use App\Models\Layanan;
use App\Models\Menu;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HomePageController extends Controller
{
    public function index()
    {
        $antrian = Antrean::get()->where('status', 'sedang dilayani')->first();


        $jumlahAntrean = Antrean::where('status', 'menunggu')
            ->whereDate('created_at', Carbon::today())
            ->count();

        $layanans = Layanan::where('is_active', true)->get();
        $menus = Menu::where('is_available', true)->get();

        return view('pelanggan.homepage.homepage', compact('antrian', 'jumlahAntrean', 'layanans', 'menus'));
    }
}
