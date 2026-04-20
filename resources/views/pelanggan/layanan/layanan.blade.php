@extends('layouts.public')

@section('title', 'Layanan')

@section('content')
<section class="layanan-hero">
    <div class="layanan-hero-overlay">
        <div class="layanan-hero-text">
            <h1>Daftar Layanan</h1>
            <p>Lihat pilihan layanan yang tersedia beserta harga dan estimasi waktunya.</p>
        </div>
    </div>
</section>

<section class="layanan-content">
    <div class="layanan-section-header">
        <h3>Daftar Layanan</h3>
    </div>

    <div class="layanan-grid">
        <div class="layanan-card">
            <div class="layanan-card-image">
                <img src="https://images.unsplash.com/photo-1622286342621-4bd786c2447c?q=80&w=1200&auto=format&fit=crop" alt="Potong Rambut Reguler">
            </div>
            <div class="layanan-card-body">
                <h4>Potong Rambut Reguler</h4>
                <p class="layanan-desc">Layanan potong rambut untuk tampilan rapi dan nyaman digunakan sehari-hari.</p>
                <p class="layanan-time">⏱ 20–30 menit</p>
                <p class="layanan-price">Rp35.000</p>
            </div>
        </div>

        <div class="layanan-card">
            <div class="layanan-card-image">
                <img src="https://images.unsplash.com/photo-1517832606299-7ae9b720a186?q=80&w=1200&auto=format&fit=crop" alt="Potong Rambut dan Cuci">
            </div>
            <div class="layanan-card-body">
                <h4>Potong Rambut + Cuci</h4>
                <p class="layanan-desc">Layanan potong rambut yang dilengkapi cuci rambut agar terasa lebih segar dan bersih.</p>
                <p class="layanan-time">⏱ 30–45 menit</p>
                <p class="layanan-price">Rp45.000</p>
            </div>
        </div>

        <div class="layanan-card">
            <div class="layanan-card-image">
                <img src="https://images.unsplash.com/photo-1503951914875-452162b0f3f1?q=80&w=1200&auto=format&fit=crop" alt="Cukur Jenggot dan Kumis">
            </div>
            <div class="layanan-card-body">
                <h4>Cukur Jenggot & Kumis</h4>
                <p class="layanan-desc">Perapihan jenggot dan kumis untuk tampilan wajah yang lebih bersih dan terawat.</p>
                <p class="layanan-time">⏱ 15–20 menit</p>
                <p class="layanan-price">Rp20.000</p>
            </div>
        </div>

        <div class="layanan-card">
            <div class="layanan-card-image">
                <img src="https://images.unsplash.com/photo-1519699047748-de8e457a634e?q=80&w=1200&auto=format&fit=crop" alt="Hair Styling">
            </div>
            <div class="layanan-card-body">
                <h4>Hair Styling</h4>
                <p class="layanan-desc">Penataan rambut menggunakan produk styling agar hasil akhir lebih rapi dan menarik.</p>
                <p class="layanan-time">⏱ 15–25 menit</p>
                <p class="layanan-price">Rp25.000</p>
            </div>
        </div>

        <div class="layanan-card">
            <div class="layanan-card-image">
                <img src="https://images.unsplash.com/photo-1521590832167-7bcbfaa6381f?q=80&w=1200&auto=format&fit=crop" alt="Creambath Rambut">
            </div>
            <div class="layanan-card-body">
                <h4>Creambath Rambut</h4>
                <p class="layanan-desc">Perawatan rambut untuk membantu membersihkan kulit kepala dan membuat rambut lebih rileks.</p>
                <p class="layanan-time">⏱ 30–40 menit</p>
                <p class="layanan-price">Rp50.000</p>
            </div>
        </div>

        <div class="layanan-card">
            <div class="layanan-card-image">
                <img src="https://images.unsplash.com/photo-1622287162716-f311baa1a2b8?q=80&w=1200&auto=format&fit=crop" alt="Paket Lengkap">
            </div>
            <div class="layanan-card-body">
                <h4>Paket Lengkap</h4>
                <p class="layanan-desc">Potong rambut, cuci rambut, dan penataan rambut dalam satu layanan yang lebih lengkap.</p>
                <p class="layanan-time">⏱ 45–60 menit</p>
                <p class="layanan-price">Rp65.000</p>
            </div>
        </div>
    </div>

    <div class="layanan-note">
        <p>Informasi layanan ini membantu pelanggan mengetahui pilihan layanan yang tersedia.</p>
    </div>
</section>
@endsection