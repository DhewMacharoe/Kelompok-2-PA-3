@extends('layouts.public')

@section('title', 'Pusat Bantuan')

@section('head')
    @include('bantuan.styles')
@endsection

@section('body_class', 'help-page')

@section('content')
    <div class="help-shell">
        <section class="help-hero">
            <span class="help-kicker">Pusat Bantuan</span>
            <h1>Bantuan singkat untuk antrean, login, GPS, dan pembatalan.</h1>
            <p>
                Gunakan halaman ini untuk menemukan jawaban cepat dan panduan langkah demi langkah.
                Semua konten dibuat singkat agar nyaman dibaca di desktop maupun mobile.
            </p>

            <div class="help-hero-actions">
                <a class="help-pill help-pill--light" href="{{ route('bantuan.faq') }}">Buka FAQ</a>
                <a class="help-pill help-pill--outline" href="{{ route('bantuan.antrean') }}">Panduan Antrean</a>
                <a class="help-pill help-pill--outline" href="{{ route('bantuan.login-google') }}">Login Google</a>
            </div>
        </section>

        <section class="help-section help-grid">
            <a href="{{ route('bantuan.faq') }}" class="help-card help-card-grid-item">
                <div class="help-card-icon"><i class="fas fa-question-circle"></i></div>
                <h2>FAQ</h2>
                <p>Jawaban cepat untuk pertanyaan yang paling sering muncul.</p>
            </a>

            <a href="{{ route('bantuan.antrean') }}" class="help-card help-card-grid-item">
                <div class="help-card-icon"><i class="fas fa-ticket-alt"></i></div>
                <h2>Panduan Antrean</h2>
                <p>Cara mengambil antrean, memilih layanan, dan membaca status antrean.</p>
            </a>

            <a href="{{ route('bantuan.login-google') }}" class="help-card help-card-grid-item">
                <div class="help-card-icon"><i class="fab fa-google"></i></div>
                <h2>Panduan Login Google</h2>
                <p>Langkah masuk dengan akun Google dan apa yang perlu dilakukan setelahnya.</p>
            </a>

            <a href="{{ route('bantuan.gps') }}" class="help-card help-card-grid-item--wide">
                <div class="help-card-icon"><i class="fas fa-location-dot"></i></div>
                <h2>Panduan GPS</h2>
                <p>Aktifkan izin lokasi dan pastikan perangkat berada dalam radius antrean.</p>
            </a>

            <a href="{{ route('bantuan.pembatalan-antrean') }}" class="help-card help-card-grid-item--wide">
                <div class="help-card-icon"><i class="fas fa-ban"></i></div>
                <h2>Panduan Pembatalan Antrean</h2>
                <p>Ketahui kapan antrean bisa dibatalkan dan bagaimana melakukannya.</p>
            </a>
        </section>

        <section class="help-section help-panel">
            <div class="help-panel-header">
                <div>
                    <h2>Mulai dari sini</h2>
                    <p>Jika baru pertama kali memakai sistem, ikuti urutan ini.</p>
                </div>
                <span class="help-badge"><i class="fas fa-sparkles"></i> Cepat dan ringkas</span>
            </div>

            <div class="help-steps">
                <div class="help-step">
                    <span class="help-step-index">1</span>
                    <div>
                        <h3>Masuk dengan akun Google</h3>
                        <p>Buka halaman login Google, pilih akun, lalu lengkapi username jika diminta.</p>
                    </div>
                </div>
                <div class="help-step">
                    <span class="help-step-index">2</span>
                    <div>
                        <h3>Cek panduan GPS</h3>
                        <p>Izinkan lokasi di browser agar sistem bisa memeriksa jarak ke titik antrean.</p>
                    </div>
                </div>
                <div class="help-step">
                    <span class="help-step-index">3</span>
                    <div>
                        <h3>Ambil antrean atau baca FAQ</h3>
                        <p>Kalau masih bingung, buka FAQ untuk melihat jawaban singkat sebelum memulai.</p>
                    </div>
                </div>
            </div>

            <div class="help-footer-cta">
                <a class="help-pill help-pill--light" href="{{ route('home') }}">Kembali ke Beranda</a>
                <a class="help-pill help-pill--outline" href="{{ route('bantuan.faq') }}">Lihat FAQ Lengkap</a>
            </div>
        </section>
    </div>
@endsection