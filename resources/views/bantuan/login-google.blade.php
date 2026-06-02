@extends('layouts.public')

@section('title', 'Panduan Login Google')

@section('head')
    @include('bantuan.styles')
@endsection

@section('body_class', 'help-page')

@section('content')
    <div class="help-shell">
        <section class="help-hero">
            <span class="help-kicker">Panduan Login Google</span>
            <h1>Masuk dengan akun Google dalam beberapa langkah.</h1>
            <p>Gunakan panduan ini jika Anda baru pertama kali masuk atau jika login sebelumnya belum selesai.</p>
            <div class="help-hero-actions">
                <a class="help-pill help-pill--light" href="{{ route('login.user') }}">Buka Halaman Login</a>
                <a class="help-pill help-pill--outline" href="{{ route('bantuan.faq') }}">Lihat FAQ</a>
            </div>
        </section>

        <section class="help-section help-panel">
            <div class="help-steps">
                <div class="help-step">
                    <span class="help-step-index">1</span>
                    <div>
                        <h3>Buka halaman login Google</h3>
                        <p>Pilih menu Masuk di situs ini lalu buka halaman login Google.</p>
                    </div>
                </div>
                <div class="help-step">
                    <span class="help-step-index">2</span>
                    <div>
                        <h3>Pilih akun Google</h3>
                        <p>Pilih akun Gmail yang ingin dipakai, lalu izinkan akses sesuai instruksi Google.</p>
                    </div>
                </div>
                <div class="help-step">
                    <span class="help-step-index">3</span>
                    <div>
                        <h3>Lengkapi username jika diminta</h3>
                        <p>Jika akun belum punya username, sistem akan meminta Anda mengisinya terlebih dahulu.</p>
                    </div>
                </div>
                <div class="help-step">
                    <span class="help-step-index">4</span>
                    <div>
                        <h3>Lanjut ke antrean atau layanan</h3>
                        <p>Setelah masuk, Anda bisa membuka antrean, layanan, atau halaman profil tanpa login ulang.</p>
                    </div>
                </div>
            </div>

            <div class="help-note">
                <strong>Jika login gagal</strong>
                <p class="mb-0">Pastikan koneksi internet stabil dan pop-up Google tidak diblokir oleh browser Anda.</p>
            </div>

            <div class="help-footer-cta">
                <a class="help-pill help-pill--light" href="{{ route('bantuan.antrean') }}">Panduan Antrean</a>
                <a class="help-pill help-pill--outline" href="{{ route('bantuan.gps') }}">Panduan GPS</a>
            </div>
        </section>
    </div>
@endsection