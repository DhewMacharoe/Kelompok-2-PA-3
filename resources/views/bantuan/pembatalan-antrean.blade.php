@extends('layouts.public')

@section('title', 'Panduan Pembatalan Antrean')

@section('head')
    @include('bantuan.styles')
@endsection

@section('body_class', 'help-page')

@section('content')
    <div class="help-shell">
        <section class="help-hero">
            <span class="help-kicker">Panduan Pembatalan Antrean</span>
            <h1>Batalkan antrean hanya saat status masih menunggu.</h1>
            <p>Gunakan panduan ini jika Anda tidak jadi datang dan masih ingin mengosongkan antrean aktif Anda.</p>
            <div class="help-hero-actions">
                <a class="help-pill help-pill--light" href="{{ route('antrean') }}">Buka Halaman Antrean</a>
                <a class="help-pill help-pill--outline" href="{{ route('bantuan.faq') }}">Lihat FAQ</a>
            </div>
        </section>

        <section class="help-section help-panel">
            <div class="help-steps">
                <div class="help-step">
                    <span class="help-step-index">1</span>
                    <div>
                        <h3>Buka halaman antrean saat sudah login</h3>
                        <p>Pastikan Anda sudah masuk dengan akun yang memiliki antrean aktif.</p>
                    </div>
                </div>
                <div class="help-step">
                    <span class="help-step-index">2</span>
                    <div>
                        <h3>Periksa kartu antrean pribadi</h3>
                        <p>Tombol batal hanya muncul jika antrean Anda masih berstatus menunggu.</p>
                    </div>
                </div>
                <div class="help-step">
                    <span class="help-step-index">3</span>
                    <div>
                        <h3>Tekan tombol Batalkan Antrean Saya</h3>
                        <p>Konfirmasi pembatalan jika sistem meminta persetujuan tambahan.</p>
                    </div>
                </div>
                <div class="help-step">
                    <span class="help-step-index">4</span>
                    <div>
                        <h3>Tunggu status diperbarui</h3>
                        <p>Setelah berhasil, antrean Anda akan keluar dari daftar aktif dan Anda bisa membuat antrean baru jika perlu.</p>
                    </div>
                </div>
            </div>

            <div class="help-note">
                <strong>Ingat</strong>
                <p class="mb-0">Jika antrean sudah sedang dilayani, pembatalan tidak bisa dilakukan dari halaman pelanggan.</p>
            </div>

            <div class="help-footer-cta">
                <a class="help-pill help-pill--light" href="{{ route('bantuan.antrean') }}">Kembali ke Panduan Antrean</a>
                <a class="help-pill help-pill--outline" href="{{ route('bantuan.faq') }}">Buka FAQ</a>
            </div>
        </section>
    </div>
@endsection