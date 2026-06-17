<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class PelangganMenuCafeController extends Controller
{
    public function index()
    {
        $activeDesign = \App\Models\Design::where('is_active', true)->first();
        if ($activeDesign && !$activeDesign->is_cafe_active) {
            abort(404);
        }

        // Ambil hanya menu yang tersedia untuk halaman pelanggan
        $menus = Menu::where('is_available', true)->get();
        return view('pelanggan.menu.menu', compact('menus'));
    }
}
