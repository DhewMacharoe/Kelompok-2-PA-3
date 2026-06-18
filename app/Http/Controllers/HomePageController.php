<?php

namespace App\Http\Controllers;

use App\Models\Antrean;
use App\Models\Layanan;
use App\Models\Menu;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;

class HomePageController extends Controller
{
    public function index()
    {
        $antrean = Antrean::getQueueBeingServed();


        $jumlahAntrean = Antrean::where('status', 'menunggu')
            ->whereDate('created_at', Carbon::today())
            ->count();

        $tenantId = app()->bound('currentTenantId') ? app('currentTenantId') : 1;
        $layanans = \Illuminate\Support\Facades\Cache::remember("active_layanans_tenant_{$tenantId}", 3600, function () {
            return Layanan::where('is_active', true)->get();
        });
        $menus = \Illuminate\Support\Facades\Cache::remember("active_menus_tenant_{$tenantId}", 3600, function () {
            return Menu::where('is_available', true)->get();
        });

        $punyaAntreanAktif = false;
        $antreanSayaAktif = null;
        if (Auth::check() && Auth::user()->username) {
            $antreanSayaAktif = Antrean::getCustomerActiveQueue(Auth::user()->username);
            $punyaAntreanAktif = (bool) $antreanSayaAktif;
        }

        return view('pelanggan.homepage.homepage', compact('antrean', 'jumlahAntrean', 'layanans', 'menus', 'punyaAntreanAktif', 'antreanSayaAktif'));
    }
}

