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
        // Ambil 1 antrian yang sedang dipanggil
        $dipanggil = Antrian::where('status', 'dipanggil')->first();
        // Hitung total antrian yang statusnya menunggu
        $jumlahMenunggu = Antrian::where('status', 'menunggu')->count();

        return view('index', compact('dipanggil', 'jumlahMenunggu'));
    }

    public function antrian()
    {
        // Ambil 1 antrian yang sedang dipanggil
        $dipanggil = Antrian::where('status', 'dipanggil')->first();

        // Ambil daftar orang yang sedang menunggu, diurutkan dari yang paling lama datang
        $menunggu = Antrian::where('status', 'menunggu')->orderBy('waktu_masuk', 'asc')->get();

        // Hitung jumlahnya
        $jumlahMenunggu = $menunggu->count();

        return view('antrian', compact('dipanggil', 'menunggu', 'jumlahMenunggu'));
    }

    public function rekomendasi()
    {
        return view('rekomendasi');
    }

    public function layanan()
    {
        // Hanya ambil layanan yang statusnya aktif
        $layanans = Layanan::where('is_active', true)->get();
        return view('layanan', compact('layanans'));
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
