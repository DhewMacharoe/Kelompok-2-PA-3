@extends('layouts.public')

@section('title', 'FAQ Bantuan')

@section('head')
    @include('bantuan.styles')
@endsection

@section('body_class', 'help-page')

@section('content')
    <div class="help-shell">
        <section class="help-hero">
            <span class="help-kicker">FAQ</span>
            <h1>Pertanyaan yang paling sering muncul.</h1>
            <p>Gunakan daftar singkat ini untuk mempercepat penyelesaian masalah sebelum membuka halaman panduan.</p>

            <div class="help-hero-actions">
                <a class="help-pill help-pill--light" href="{{ route('bantuan.index') }}">Pusat Bantuan</a>
                <a class="help-pill help-pill--outline" href="{{ route('bantuan.antrean') }}">Panduan Antrean</a>
                <a class="help-pill help-pill--outline" href="{{ route('bantuan.login-google') }}">Panduan Login Google</a>
            </div>
        </section>

        <section class="help-section help-panel">
            <div class="help-faq-list">
                <details class="help-faq-item">
                    <summary>Bagaimana cara masuk dengan Google?</summary>
                    <div class="help-faq-answer">
                        Buka halaman login Google, pilih akun Gmail, lalu ikuti instruksi di layar. Jika diminta,
                        lengkapi username agar akun bisa dipakai untuk antrean.
                    </div>
                </details>
                <details class="help-faq-item">
                    <summary>Mengapa GPS harus diaktifkan saat mengambil antrean?</summary>
                    <div class="help-faq-answer">
                        Sistem memeriksa apakah Anda berada di dekat lokasi antrean. Jika lokasi dimatikan, sistem tidak
                        bisa memastikan jarak Anda ke titik antrean.
                    </div>
                </details>
                <details class="help-faq-item">
                    <summary>Kapan antrean bisa dibatalkan?</summary>
                    <div class="help-faq-answer">
                        Antrean bisa dibatalkan selama statusnya masih menunggu. Jika antrean sudah sedang dilayani,
                        tombol batal tidak lagi tersedia.
                    </div>
                </details>
                <details class="help-faq-item">
                    <summary>Kenapa saya tidak melihat tombol tambah antrean?</summary>
                    <div class="help-faq-answer">
                        Biasanya karena Anda masih punya antrean aktif. Selesaikan atau batalkan antrean tersebut lebih
                        dulu sebelum membuat antrean baru.
                    </div>
                </details>
                <details class="help-faq-item">
                    <summary>Apa yang harus dilakukan jika izin lokasi ditolak?</summary>
                    <div class="help-faq-answer">
                        Buka pengaturan browser di perangkat Anda, aktifkan izin lokasi untuk situs ini, lalu muat ulang
                        halaman dan coba lagi.
                    </div>
                </details>
                <details class="help-faq-item">
                    <summary>Di mana saya bisa melihat status antrean saya?</summary>
                    <div class="help-faq-answer">
                        Setelah login, buka halaman antrean. Status antrean Anda akan tampil pada kartu antrean pribadi
                        di sisi kanan atau bawah halaman.
                    </div>
                </details>
            </div>

            <div class="help-note">
                <strong>Butuh panduan yang lebih spesifik?</strong>
                <p class="mb-0">Gunakan halaman panduan di bawah FAQ untuk antrean, login Google, GPS, dan pembatalan antrean.</p>
            </div>

            <div class="help-link-row">
                <a class="help-link-inline" href="{{ route('bantuan.antrean') }}">Panduan Antrean</a>
                <a class="help-link-inline" href="{{ route('bantuan.login-google') }}">Panduan Login Google</a>
                <a class="help-link-inline" href="{{ route('bantuan.gps') }}">Panduan GPS</a>
                <a class="help-link-inline" href="{{ route('bantuan.pembatalan-antrean') }}">Panduan Pembatalan Antrean</a>
            </div>
        </section>
    </div>
@endsection