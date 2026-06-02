@extends('layouts.public')

@section('title', 'Panduan GPS')

@section('head')
    @include('bantuan.styles')
@endsection

@section('body_class', 'help-page')

@section('content')
    <div class="help-shell">
        <section class="help-hero">
            <span class="help-kicker">Panduan GPS</span>
            <h1>Aktifkan lokasi agar antrean bisa diverifikasi.</h1>
            <p>Halaman ini menjelaskan cara mengaktifkan GPS dan apa yang harus dilakukan jika perangkat menolak izin lokasi.</p>
            <div class="help-hero-actions">
                <a class="help-pill help-pill--light" href="{{ route('antrean') }}">Buka Halaman Antrean</a>
                <a class="help-pill help-pill--outline" href="{{ route('bantuan.antrean') }}">Panduan Antrean</a>
            </div>
        </section>

        <section class="help-section help-panel">
            <div class="help-steps">
                <div class="help-step">
                    <span class="help-step-index">1</span>
                    <div>
                        <h3>Buka halaman antrean dari perangkat Anda</h3>
                        <p>Gunakan browser yang mendukung akses lokasi, lalu buka halaman antrean seperti biasa.</p>
                    </div>
                </div>
                <div class="help-step">
                    <span class="help-step-index">2</span>
                    <div>
                        <h3>Izinkan akses lokasi</h3>
                        <p>Saat browser meminta izin, pilih Izinkan agar sistem bisa membaca posisi Anda.</p>
                    </div>
                </div>
                <div class="help-step">
                    <span class="help-step-index">3</span>
                    <div>
                        <h3>Pastikan Anda berada dekat titik antrean</h3>
                        <p>Jika Anda terlalu jauh dari lokasi, sistem akan menolak proses pengambilan antrean.</p>
                    </div>
                </div>
                <div class="help-step">
                    <span class="help-step-index">4</span>
                    <div>
                        <h3>Jika izin ditolak, ubah pengaturan browser</h3>
                        <p>Buka pengaturan situs pada browser dan aktifkan izin lokasi, lalu muat ulang halaman.</p>
                    </div>
                </div>
            </div>

            <div class="help-note">
                <strong>Tip singkat</strong>
                <p class="mb-0">Di ponsel, aktifkan juga GPS perangkat agar browser dapat mengirimkan posisi secara akurat.</p>
            </div>

            <div class="help-footer-cta">
                <a class="help-pill help-pill--light" href="{{ route('bantuan.pembatalan-antrean') }}">Panduan Pembatalan</a>
                <a class="help-pill help-pill--outline" href="{{ route('bantuan.faq') }}">Kembali ke FAQ</a>
            </div>
        </section>
    </div>
@endsection