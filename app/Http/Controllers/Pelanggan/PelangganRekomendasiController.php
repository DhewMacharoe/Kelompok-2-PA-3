<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PelangganRekomendasiController extends Controller
{
    // Menggunakan nama method rekomendasi() sesuai dengan pesan error sebelumnya
    public function rekomendasi()
    {
        // Path disesuaikan ke pelanggan/rekomendasi/rekomendasi.blade.php
        return view('pelanggan.rekomendasi.rekomendasi');
    }

    public function process(Request $request)
    {
        // 1. Validasi Input JSON dari browser
        $request->validate([
            'bentuk_wajah' => 'required|string',
            'akurasi_sistem' => 'required|numeric'
        ]);

        $bentukWajah = $request->input('bentuk_wajah');
        $akurasi = $request->input('akurasi_sistem');

        // 2. Mapping Rekomendasi (Logika Bisnis Barbershop)
        $rekomendasiMap = [
            'Heart' => ['Textured Fringe', 'Side Part', 'Slicked Back'],
            'Oblong' => ['Buzz Cut', 'Crew Cut', 'Side Part'],
            'Oval' => ['Pompadour', 'Fringe Fade', 'Quiff'],
            'Round' => ['Faux Hawk', 'Spiky', 'Undercut'],
            'Square' => ['Crew Cut', 'Buzz Cut', 'Faux Hawk']
        ];

        $rekomendasiRambut = $rekomendasiMap[$bentukWajah] ?? ['Konsultasikan dengan kapster'];

        // 3. Siapkan data untuk dikembalikan ke View
        $data_ai = [
            'bentuk_wajah' => $bentukWajah,
            'akurasi_sistem' => $akurasi,
            'rekomendasi' => $rekomendasiRambut
        ];

        // Karena kita menggunakan AJAX/Fetch dari JS, kita simpan session manual
        // lalu kita kembalikan response JSON agar JS bisa me-reload halaman
        session()->flash('hasil_analisis', $data_ai);

        return response()->json([
            'status' => 'success',
            'message' => 'Analisis berhasil'
        ]);
    }
}
