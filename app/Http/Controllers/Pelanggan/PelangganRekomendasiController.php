<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class PelangganRekomendasiController extends Controller
{
    /**
     * Menampilkan halaman rekomendasi.
     */
    public function rekomendasi()
    {
        return view('pelanggan.rekomendasi.rekomendasi');
    }

    /**
     * Memproses bentuk wajah dan mengembalikan data rekomendasi.
     */
    public function process(Request $request)
    {
        $validated = $request->validate([
            'bentuk_wajah' => 'required|string',
            'akurasi_sistem' => 'required|numeric'
        ]);

        $profile = $this->getFaceProfile($validated['bentuk_wajah']);
        $this->attachHairImages($profile['rekomendasi']);

        return response()->json([
            'status' => 'success',
            'data' => array_merge(['bentuk_wajah' => $validated['bentuk_wajah']], $profile)
        ]);
    }

    /**
     * Mendapatkan profil rekomendasi berdasarkan bentuk wajah.
     */
    private function getFaceProfile(string $shape): array
    {
        $map = [
            'Heart'  => ['summary' => 'Menyeimbangkan dahi lebar.', 'tips' => ['Volume lembut samping'], 'rekomendasi' => [['name' => 'Textured Fringe', 'priority' => 'Disarankan']]],
            'Oblong' => ['summary' => 'Memecah kesan wajah panjang.', 'tips' => ['Potongan pendek'], 'rekomendasi' => [['name' => 'Buzz Cut', 'priority' => 'Praktis']]],
            'Oval'   => ['summary' => 'Bentuk wajah fleksibel.', 'tips' => ['Variasi tekstur'], 'rekomendasi' => [['name' => 'Pompadour', 'priority' => 'Stylish']]],
            'Round'  => ['summary' => 'Memberi kesan tegas & ramping.', 'tips' => ['Volume atas'], 'rekomendasi' => [['name' => 'Faux Hawk', 'priority' => 'Tegas']]],
            'Square' => ['summary' => 'Menyeimbangkan rahang tegas.', 'tips' => ['Tekstur lembut'], 'rekomendasi' => [['name' => 'Crew Cut', 'priority' => 'Aman']],]
        ];

        return $map[$shape] ?? [
            'summary' => 'Konsultasikan dengan kapster untuk hasil terbaik.',
            'tips' => ['Gunakan foto jelas'],
            'rekomendasi' => [['name' => 'Konsultasi Kapster', 'priority' => 'Saran']]
        ];
    }

    /**
     * Menambahkan data aset gambar ke array rekomendasi.
     */
    private function attachHairImages(array &$recommendations): void
    {
        foreach ($recommendations as &$rek) {
            $name = $rek['name'];
            $rek['images'] = [
                'front' => $this->getImagePath($name, 'Depan'),
                'side'  => $this->getImagePath($name, 'Samping'),
                'back'  => $this->getImagePath($name, 'Belakang'),
            ];
        }
    }

    private function getImagePath(string $name, string $view): string
    {
        $fileName = "{$name} {$view}.png";
        $fullPath = base_path("images/Gaya Rambut/{$fileName}");

        return file_exists($fullPath)
            ? asset("images/Gaya Rambut/" . rawurlencode($fileName))
            : asset("assets/images/rambut/default.png");
    }

    /**
     * Memproses Virtual Try-On (Simulasi).
     */
    public function generate(\Illuminate\Http\Request $request)
    {
        $request->validate(['image' => 'required|string', 'hairstyle' => 'required|string']);

        try {
            // Tembak langsung ke API PythonAnywhere kamu
            $response = \Illuminate\Support\Facades\Http::post('https://DhewGanz.pythonanywhere.com/generate_hair', [
                'hairstyle' => $request->input('hairstyle')
            ]);

            if ($response->successful()) {
                return response()->json([
                    'status' => 'success',
                    'generated_image_url' => $response->json('generated_image_url')
                ]);
            }

            throw new \Exception('Server AI gagal merespon.');
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
