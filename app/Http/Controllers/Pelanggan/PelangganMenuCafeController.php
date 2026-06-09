<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class PelangganMenuCafeController extends Controller
{
    public function index()
    {
        // Ambil hanya menu yang tersedia untuk halaman pelanggan
        $menus = Menu::where('is_available', true)->get();
        return view('pelanggan.menu.menu', compact('menus'));
    }
}
