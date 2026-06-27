<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // Untuk memanggil API AI eksternal
use Illuminate\Support\Str;

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
            'akurasi_sistem' => 'required|numeric',
            'gender' => 'required|string',
            'age_group' => 'required|string',
            'hair_type' => 'required|string'
        ]);

        $bentukWajah = $request->input('bentuk_wajah');
        $akurasi = $request->input('akurasi_sistem');
        $gender = $request->input('gender', 'male');
        $ageGroup = $request->input('age_group', 'adult');
        $hairType = $request->input('hair_type', 'Lurus');

        $jsonPath = public_path('ai_model/rekomendasi_rules.json');
        $faceProfile = null;

        if (file_exists($jsonPath)) {
            $rekomendasiMap = json_decode(file_get_contents($jsonPath), true);
            $faceProfile = $rekomendasiMap[$gender][$ageGroup][$bentukWajah][$hairType] ?? null;
        }

        if (!$faceProfile) {
            $faceProfile = [
                'summary' => 'Kami belum menemukan pola yang cocok untuk kriteria ini, jadi konsultasi langsung dengan kapster tetap jadi pilihan terbaik.',
                'tips' => ['Pilih gaya yang menjaga proporsi wajah tetap seimbang.', 'Gunakan foto yang lebih jelas untuk hasil deteksi yang lebih akurat.'],
                'rekomendasi' => [
                    ['name' => 'Konsultasikan dengan kapster', 'reason' => 'Rekomendasi otomatis belum tersedia untuk kriteria ini.', 'barber_note' => 'Tunjukkan foto hasil analisis agar kapster bisa menyesuaikan potongan secara langsung.', 'priority' => 'Konsultasi']
                ]
            ];
        }

        // Tambahkan URL gambar front/side/back untuk setiap rekomendasi berdasarkan file di folder images
        foreach ($faceProfile['rekomendasi'] as &$rek) {
            $name = is_array($rek) && isset($rek['name']) ? $rek['name'] : (string) $rek;
            
            $views = [
                'front' => 'Depan',
                'side' => 'Samping',
                'back' => 'Belakang',
            ];
            
            $rek['images'] = [];
            foreach ($views as $key => $suffix) {
                // Check if there is an exact filename or override
                $fileName = $name . ' ' . $suffix . '.png';
                if ($name === 'Undercut' && $key === 'back') {
                    $fileName = 'Undecut Belakang.png';
                }
                
                $fullPath = base_path('images/Gaya Rambut/' . $fileName);
                if (file_exists($fullPath)) {
                    $rek['images'][$key] = asset('images/Gaya Rambut/' . rawurlencode($fileName));
                } else {
                    // Fallback to default image
                    $rek['images'][$key] = asset('assets/images/rambut/buzz_cut.png');
                }
            }
        }

        // Kembalikan langsung ke frontend tanpa me-reload halaman
        return response()->json([
            'status' => 'success',
            'data' => [
                'bentuk_wajah' => $bentukWajah,
                'akurasi_sistem' => $akurasi,
                'summary' => $faceProfile['summary'],
                'tips' => $faceProfile['tips'],
                'rekomendasi' => $faceProfile['rekomendasi']
            ]
        ]);
    }

}

