@extends('layouts.public')

@section('title', 'Panduan Antrean')

@section('head')
    @include('bantuan.styles')
@endsection

@section('body_class', 'help-page')

@section('content')
    <div class="help-shell">
        <section class="help-hero">
            <span class="help-kicker">Panduan Antrean</span>
            <h1>Cara mengambil antrean dengan benar.</h1>
            <p>Ikuti langkah ini agar proses antrean berjalan lancar dan status Anda muncul dengan benar di sistem.</p>
            <div class="help-hero-actions">
                <a class="help-pill help-pill--light" href="{{ route('antrean') }}">Buka Halaman Antrean</a>
                <a class="help-pill help-pill--outline" href="{{ route('bantuan.gps') }}">Panduan GPS</a>
            </div>
        </section>

        <section class="help-section help-panel">
            <div class="help-steps">
                <div class="help-step">
                    <span class="help-step-index">1</span>
                    <div>
                        <h3>Masuk ke akun Anda</h3>
                        <p>Login terlebih dahulu agar sistem bisa menautkan antrean ke nama pelanggan Anda.</p>
                    </div>
                </div>
                <div class="help-step">
                    <span class="help-step-index">2</span>
                    <div>
                        <h3>Buka halaman antrean</h3>
                        <p>Di halaman ini Anda akan melihat status antrean saat ini dan tombol untuk menambah antrean.</p>
                    </div>
                </div>
                <div class="help-step">
                    <span class="help-step-index">3</span>
                    <div>
                        <h3>Pilih layanan yang dibutuhkan</h3>
                        <p>Pilih minimal satu layanan, lalu lanjutkan ke langkah berikutnya jika diperlukan.</p>
                    </div>
                </div>
                <div class="help-step">
                    <span class="help-step-index">4</span>
                    <div>
                        <h3>Izinkan GPS dan pastikan berada di radius yang sesuai</h3>
                        <p>Sistem akan memeriksa posisi Anda sebelum antrean berhasil dibuat.</p>
                    </div>
                </div>
                <div class="help-step">
                    <span class="help-step-index">5</span>
                    <div>
                        <h3>Konfirmasi antrean</h3>
                        <p>Setelah semua valid, tekan tombol Ambil Antrean dan tunggu nomor antrean Anda tampil.</p>
                    </div>
                </div>
            </div>

            <div class="help-note">
                <strong>Catatan penting</strong>
                <p class="mb-0">Jika Anda sudah memiliki antrean aktif, tombol tambah antrean tidak akan muncul sampai antrean lama selesai atau dibatalkan.</p>
            </div>

            <div class="help-footer-cta">
                <a class="help-pill help-pill--light" href="{{ route('bantuan.faq') }}">Kembali ke FAQ</a>
                <a class="help-pill help-pill--outline" href="{{ route('bantuan.login-google') }}">Panduan Login Google</a>
            </div>
        </section>
    </div>
@endsection