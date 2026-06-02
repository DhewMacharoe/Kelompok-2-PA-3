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
            'akurasi_sistem' => 'required|numeric'
        ]);

        $bentukWajah = $request->input('bentuk_wajah');
        $akurasi = $request->input('akurasi_sistem');

        // Rekomendasi dibuat lebih informatif agar pengguna paham alasan setiap pilihan.
        $rekomendasiMap = [
            'Heart' => [
                'summary' => 'Cocok untuk menyeimbangkan dahi yang lebih lebar dengan volume yang lebih lembut di area depan dan samping.',
                'tips' => [
                    'Pilih tekstur ringan di bagian fringe agar area dahi tidak terlalu menonjol.',
                    'Pertahankan sisi yang rapi tetapi jangan terlalu tipis.',
                    'Hindari volume terlalu tinggi di bagian atas kepala.'
                ],
                'rekomendasi' => [
                    ['name' => 'Textured Fringe', 'reason' => 'Mengarahkan fokus ke area mata dan membuat proporsi dahi terlihat lebih seimbang.', 'barber_note' => 'Minta fringe bertekstur dengan layer tipis di bagian depan.', 'priority' => 'Paling disarankan'],
                    ['name' => 'Side Part', 'reason' => 'Belahan samping memberi garis visual yang rapi dan menstabilkan komposisi wajah.', 'barber_note' => 'Minta belahan samping natural dengan sisi tidak terlalu kontras.', 'priority' => 'Rapi dan aman'],
                    ['name' => 'Slicked Back', 'reason' => 'Bagus untuk tampilan formal karena memberi kesan bersih tanpa menambah lebar di dahi.', 'barber_note' => 'Gunakan pomade tipis agar hasilnya tetap natural.', 'priority' => 'Formal'],
                    ['name' => 'Messy Quiff', 'reason' => 'Sedikit volume di depan membantu menyeimbangkan bagian atas wajah.', 'barber_note' => 'Minta quiff yang lebih lembut, bukan yang terlalu tinggi.', 'priority' => 'Lebih santai']
                ]
            ],
            'Oblong' => [
                'summary' => 'Tujuannya memecah kesan wajah yang panjang dengan potongan yang lebih pendek dan proporsional.',
                'tips' => [
                    'Jaga tinggi rambut agar tidak membuat wajah terlihat makin panjang.',
                    'Gunakan potongan yang memberi ilusi lebar di samping.',
                    'Poni ringan bisa membantu memendekkan tampilan wajah.'
                ],
                'rekomendasi' => [
                    ['name' => 'Buzz Cut', 'reason' => 'Potongan sangat pendek menjaga bentuk wajah tetap seimbang dan praktis dirawat.', 'barber_note' => 'Minta panjang yang konsisten di seluruh kepala.', 'priority' => 'Paling praktis'],
                    ['name' => 'Crew Cut', 'reason' => 'Memberi struktur rapi tanpa menambah tinggi pada area atas.', 'barber_note' => 'Sisi pendek, atas pendek-menengah.', 'priority' => 'Rapi'],
                    ['name' => 'Side Part', 'reason' => 'Belahan samping membantu memberi dimensi horizontal yang menyeimbangkan panjang wajah.', 'barber_note' => 'Buat belahan natural dan jangan terlalu tinggi di atas.', 'priority' => 'Seimbang'],
                    ['name' => 'Classic Taper', 'reason' => 'Taper halus memberi bentuk yang bersih tanpa membuat wajah terlihat lebih panjang.', 'barber_note' => 'Minta transisi halus dari samping ke atas.', 'priority' => 'Natural']
                ]
            ],
            'Oval' => [
                'summary' => 'Bentuk wajah yang paling fleksibel, jadi hampir semua gaya bisa masuk selama proporsinya dijaga.',
                'tips' => [
                    'Coba gaya yang sesuai karakter, dari formal sampai kasual.',
                    'Jaga bagian atas agar tidak terlalu berat bila ingin tampilan seimbang.',
                    'Variasi tekstur akan membuat hasil lebih hidup.'
                ],
                'rekomendasi' => [
                    ['name' => 'Pompadour', 'reason' => 'Memberi volume stylish tanpa mengganggu keseimbangan alami wajah oval.', 'barber_note' => 'Minta volume sedang dengan sisi yang rapi.', 'priority' => 'Paling stylish'],
                    ['name' => 'Fringe Fade', 'reason' => 'Poni depan menambah karakter dan cocok untuk look yang lebih muda.', 'barber_note' => 'Gabungkan fade halus dengan fringe ringan.', 'priority' => 'Trendy'],
                    ['name' => 'Quiff', 'reason' => 'Memberi kesan tegas sekaligus tetap menjaga proporsi wajah.', 'barber_note' => 'Arahkan volume ke depan dan atas secara moderat.', 'priority' => 'Serbaguna'],
                    ['name' => 'Undercut', 'reason' => 'Kontras samping yang bersih membuat wajah oval terlihat lebih modern.', 'barber_note' => 'Minta disconnect yang tidak terlalu ekstrem.', 'priority' => 'Modern']
                ]
            ],
            'Round' => [
                'summary' => 'Potongan ideal adalah yang memberi kesan lebih tegas dan sedikit memanjang pada wajah.',
                'tips' => [
                    'Tambahkan tinggi di bagian atas untuk membantu memanjangkan wajah.',
                    'Sisi yang lebih pendek akan memberi efek wajah lebih ramping.',
                    'Hindari poni tebal yang memotong lebar wajah.'
                ],
                'rekomendasi' => [
                    ['name' => 'Faux Hawk', 'reason' => 'Garis tengah yang naik memberi ilusi wajah lebih panjang dan tegas.', 'barber_note' => 'Buat bagian samping lebih pendek dengan puncak yang terarah.', 'priority' => 'Paling tegas'],
                    ['name' => 'Spiky', 'reason' => 'Tekstur ke atas membantu menciptakan dimensi vertikal pada wajah.', 'barber_note' => 'Minta tekstur rapi yang tetap mudah dibentuk.', 'priority' => 'Aktif'],
                    ['name' => 'High Fade', 'reason' => 'Fade tinggi memberi kesan struktur wajah yang lebih bersih dan ramping.', 'barber_note' => 'Padukan fade tinggi dengan bagian atas yang sedang.', 'priority' => 'Rapi'],
                    ['name' => 'Pompadour', 'reason' => 'Volume di atas menambah tinggi visual tanpa menambah lebar berlebihan.', 'barber_note' => 'Jangan terlalu penuh di samping.', 'priority' => 'Stylish']
                ]
            ],
            'Square' => [
                'summary' => 'Cocok dengan potongan yang tetap tegas tetapi tidak terlalu keras agar rahang terlihat seimbang.',
                'tips' => [
                    'Pertahankan garis rambut yang rapi namun jangan terlalu kaku.',
                    'Tekstur lembut di atas membantu mengurangi kesan kotak yang terlalu dominan.',
                    'Potongan pendek tetap aman selama transisinya halus.'
                ],
                'rekomendasi' => [
                    ['name' => 'Crew Cut', 'reason' => 'Potongan pendek dan bersih menjaga karakter tegas wajah square tetap terkontrol.', 'barber_note' => 'Buat top pendek dengan sisi yang rapi.', 'priority' => 'Paling aman'],
                    ['name' => 'Buzz Cut', 'reason' => 'Memberi tampilan minimalis dan menonjolkan struktur wajah yang kuat.', 'barber_note' => 'Minta panjang yang seragam dan neat.', 'priority' => 'Minimalis'],
                    ['name' => 'Faux Hawk', 'reason' => 'Menambah dinamika di bagian tengah wajah tanpa menghapus karakter tegas.', 'barber_note' => 'Buat tinggi secukupnya, jangan terlalu ekstrem.', 'priority' => 'Berani'],
                    ['name' => 'French Crop', 'reason' => 'Poni pendek dan tekstur lembut membantu menyeimbangkan garis rahang yang kuat.', 'barber_note' => 'Minta fringe pendek dengan tekstur natural.', 'priority' => 'Modern']
                ]
            ]
        ];

        $faceProfile = $rekomendasiMap[$bentukWajah] ?? [
            'summary' => 'Kami belum menemukan pola wajah yang cocok, jadi konsultasi langsung dengan kapster tetap jadi pilihan terbaik.',
            'tips' => ['Pilih gaya yang menjaga proporsi wajah tetap seimbang.', 'Gunakan foto yang lebih jelas untuk hasil deteksi yang lebih akurat.'],
            'rekomendasi' => [
                ['name' => 'Konsultasikan dengan kapster', 'reason' => 'Rekomendasi otomatis belum tersedia untuk bentuk wajah ini.', 'barber_note' => 'Tunjukkan foto hasil analisis agar kapster bisa menyesuaikan potongan secara langsung.', 'priority' => 'Konsultasi']
            ]
        ];

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

