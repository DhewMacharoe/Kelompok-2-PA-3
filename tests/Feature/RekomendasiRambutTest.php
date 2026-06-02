<?php

namespace Tests\Feature;

use Tests\TestCase;

class RekomendasiRambutTest extends TestCase
{
    /**
     * Test recommendation mapping for all 5 shapes.
     */
    public function test_recommendation_mapping_and_images_exist(): void
    {
        $faceShapes = ['Heart', 'Oblong', 'Oval', 'Round', 'Square'];

        foreach ($faceShapes as $shape) {
            $response = $this->postJson(route('rekomendasi.process'), [
                'bentuk_wajah' => $shape,
                'akurasi_sistem' => 95.5
            ]);

            $response->assertStatus(200)
                ->assertJsonStructure([
                    'status',
                    'data' => [
                        'bentuk_wajah',
                        'akurasi_sistem',
                        'summary',
                        'tips',
                        'rekomendasi' => [
                            '*' => [
                                'name',
                                'reason',
                                'barber_note',
                                'priority',
                                'images' => [
                                    'front',
                                    'side',
                                    'back'
                                ]
                            ]
                        ]
                    ]
                ]);

            $data = $response->json('data');
            $this->assertEquals($shape, $data['bentuk_wajah']);

            foreach ($data['rekomendasi'] as $rek) {
                $name = $rek['name'];
                $this->assertNotEmpty($rek['images']['front']);
                $this->assertNotEmpty($rek['images']['side']);
                $this->assertNotEmpty($rek['images']['back']);

                // Verifikasi file fisiknya
                $views = [
                    'front' => 'Depan',
                    'side' => 'Samping',
                    'back' => 'Belakang',
                ];

                foreach ($views as $key => $suffix) {
                    $fileName = $name . ' ' . $suffix . '.png';
                    if ($name === 'Undercut' && $key === 'back') {
                        $fileName = 'Undecut Belakang.png';
                    }

                    $fullPath = base_path('images/Gaya Rambut/' . $fileName);
                    
                    // Kita asumsikan gambar yang di-map di controller ada di disk, 
                    // kecuali untuk kapster/rekomendasi di luar folder.
                    $url = $rek['images'][$key];
                    if (file_exists($fullPath)) {
                        $expectedUrl = asset('images/Gaya Rambut/' . rawurlencode($fileName));
                        $this->assertEquals($expectedUrl, $url, "URL mismatch for $name ($key)");
                    } else {
                        // Jika tidak ada di folder, harus fallback ke buzz_cut.png
                        $this->assertStringContainsString('buzz_cut.png', $url, "Should fallback for $name ($key)");
                    }

                    // Assert that the image is loadable or physically exists (for static public assets)
                    if (str_contains($url, '/assets/')) {
                        $urlPath = parse_url($url, PHP_URL_PATH);
                        // Remove leading slash if any
                        $cleanPath = ltrim($urlPath, '/');
                        $this->assertFileExists(public_path($cleanPath));
                    } else {
                        $urlPath = parse_url($url, PHP_URL_PATH);
                        $imgResponse = $this->get($urlPath);
                        $imgResponse->assertStatus(200);
                    }
                }
            }
        }
    }

    /**
     * Test fallback behavior for unknown face shapes.
     */
    public function test_fallback_behavior_for_unknown_shapes(): void
    {
        $response = $this->postJson(route('rekomendasi.process'), [
            'bentuk_wajah' => 'UnknownShape',
            'akurasi_sistem' => 0.0
        ]);

        $response->assertStatus(200);
        $data = $response->json('data');

        $this->assertEquals('UnknownShape', $data['bentuk_wajah']);
        $this->assertCount(1, $data['rekomendasi']);
        $this->assertEquals('Konsultasikan dengan kapster', $data['rekomendasi'][0]['name']);
        
        // Cek bahwa semua gambar di fallback
        $images = $data['rekomendasi'][0]['images'];
        $this->assertStringContainsString('buzz_cut.png', $images['front']);
        $this->assertStringContainsString('buzz_cut.png', $images['side']);
        $this->assertStringContainsString('buzz_cut.png', $images['back']);

        foreach (['front', 'side', 'back'] as $key) {
            $url = $images[$key];
            if (str_contains($url, '/assets/')) {
                $urlPath = parse_url($url, PHP_URL_PATH);
                $cleanPath = ltrim($urlPath, '/');
                $this->assertFileExists(public_path($cleanPath));
            } else {
                $urlPath = parse_url($url, PHP_URL_PATH);
                $imgResponse = $this->get($urlPath);
                $imgResponse->assertStatus(200);
            }
        }
    }
}
