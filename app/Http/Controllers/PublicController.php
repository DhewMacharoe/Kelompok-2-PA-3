<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Galeri;
use App\Models\Menu;
use App\Models\Antrian;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        $dipanggil = Antrian::where('status', 'sedang dilayani')->first();
        $jumlahMenunggu = Antrian::where('status', 'menunggu')->count();
        return view('index', compact('dipanggil', 'jumlahMenunggu'));
    }

    public function antrian()
    {
        $dipanggil = Antrian::where('status', 'sedang dilayani')->first();
        $menunggu = Antrian::where('status', 'menunggu')->orderBy('waktu_masuk', 'asc')->get();
        $jumlahMenunggu = $menunggu->count();
        return view('antrian', compact('dipanggil', 'menunggu', 'jumlahMenunggu'));
    }

    public function rekomendasi()
    {
        return view('rekomendasi');
    }

        public function layanan()
    {
        $barber = Layanan::where('is_active', 1)
            ->where('kategori', 'barber')
            ->get();

        $kafe = Layanan::where('is_active', 1)
            ->where('kategori', 'kafe')
            ->get();

        return view('public.layanan', compact('barber', 'kafe'));
    }

    public function galeri()
    {
        // Hanya ambil gaya rambut yang aktif
        $galeris = Galeri::where('is_active', true)->get();
        return view('galeri', compact('galeris'));
    }

    public function menu()
    {
        // Ambil semua menu (yang habis tetap ditampilkan dengan label silang)
        $menus = Menu::all();
        return view('menu', compact('menus'));
    }
}
