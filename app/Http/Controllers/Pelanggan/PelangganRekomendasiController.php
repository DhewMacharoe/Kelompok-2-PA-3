<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // Untuk memanggil API AI eksternal

class PelangganRekomendasiController extends Controller
{
    public function rekomendasi()
    {
        return view('pelanggan.rekomendasi.rekomendasi');
    }

    public function process(Request $request)
    {
        $request->validate([
            'bentuk_wajah' => 'required|string',
            'akurasi_sistem' => 'required|numeric'
        ]);

        $bentukWajah = $request->input('bentuk_wajah');
        $akurasi = $request->input('akurasi_sistem');

        // Map Rekomendasi
        $rekomendasiMap = [
            'Heart' => ['Textured Fringe', 'Side Part', 'Slicked Back', 'Messy Quiff'],
            'Oblong' => ['Buzz Cut', 'Crew Cut', 'Side Part', 'Classic Taper'],
            'Oval' => ['Pompadour', 'Fringe Fade', 'Quiff', 'Undercut'],
            'Round' => ['Faux Hawk', 'Spiky', 'High Fade', 'Pompadour'],
            'Square' => ['Crew Cut', 'Buzz Cut', 'Faux Hawk', 'French Crop']
        ];

        $rekomendasiRambut = $rekomendasiMap[$bentukWajah] ?? ['Konsultasikan dengan kapster'];

        // Kembalikan langsung ke frontend tanpa me-reload halaman
        return response()->json([
            'status' => 'success',
            'data' => [
                'bentuk_wajah' => $bentukWajah,
                'akurasi_sistem' => $akurasi,
                'rekomendasi' => $rekomendasiRambut
            ]
        ]);
    }

    // Method baru untuk meng-handle AI Generatif
    public function generate(Request $request)
    {
        $request->validate([
            'image_base64' => 'required|string',
            'gaya_rambut' => 'required|string',
        ]);

        $imageBase64 = $request->input('image_base64');
        $gayaRambut = $request->input('gaya_rambut');

        /* 
         * LOGIKA INTEGRASI API AI GENERATIF (Image-to-Image)
         * Anda harus menghubungkan blok ini dengan API nyata seperti Replicate, Midjourney API, 
         * atau server Flask/FastAPI milik Anda yang menjalankan Stable Diffusion / ControlNet.
         */

        try {
            /* 
            // CONTOH CALL API (Misal menggunakan Replicate API):
            $response = Http::withToken(env('REPLICATE_API_TOKEN'))
                ->post('https://api.replicate.com/v1/predictions', [
                    'version' => '...', // ID Model Inpainting rambut
                    'input' => [
                        'image' => $imageBase64,
                        'prompt' => 'A highly detailed photo of a man wearing ' . $gayaRambut . ' hairstyle, photorealistic, 8k',
                    ]
                ]);
            */

            // =======================================================
            // KARENA INI SIMULASI, kita kembalikan gambar placeholder 
            // yang menunjukkan seolah-olah proses berhasil.
            // =======================================================

            // Simulasi delay proses AI (hapus fungsi sleep ini saat API asli terpasang)
            sleep(3);

            // Gunakan gambar dummy/placeholder berdasarkan nama gaya rambut
            $dummyImageUrl = "https://ui-avatars.com/api/?name=" . urlencode($gayaRambut) . "&size=300&background=random";

            return response()->json([
                'status' => 'success',
                'image_url' => $dummyImageUrl, // URL gambar hasil generate
                'message' => 'Generate berhasil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghubungi server AI: ' . $e->getMessage()
            ], 500);
        }
    }
}
