@extends('layouts.public')

@section('body_class', 'auth-page auth-page--public')
@section('hide_public_chrome', '1')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/arga-auth.css') }}">
@endsection

@section('title', isset($activeBarbershop) && $activeBarbershop->nama_brand ? 'Lengkapi Profil - ' . $activeBarbershop->nama_brand : "Lengkapi Profil - Margaya Toba")

@section('content')
    <div class="auth-shell auth-shell--public">
        <div class="auth-card auth-card--compact">
            <div class="auth-form">
                <div class="auth-form-inner">
                    <div class="auth-kicker">Langkah terakhir</div>
                    <h2 class="auth-section-title">Lengkapi profil Anda</h2>
                    @if (session('error'))
                        <div class="auth-alert auth-alert--error small text-start">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="auth-alert auth-alert--error small text-start">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('set.username.post') }}" method="POST">
                        @csrf
                        <div class="auth-input-group">
                            <label for="username" class="auth-label">Username</label>
                            <input type="text" id="username" name="username" required class="auth-input"
                                placeholder="Masukkan username" value="{{ old('username', auth()->user()->username) }}" minlength="3" maxlength="20"
                                pattern="[A-Za-z0-9_ ]+" title="Hanya menggunakan huruf, angka, underscore dan spasi. Maksimal 20 karakter.">
                        </div>

                        <div class="auth-input-group">
                            <label for="no_whatsapp" class="auth-label">Nomor WhatsApp</label>
                            <input type="text" id="no_whatsapp" name="no_whatsapp" required class="auth-input"
                                placeholder="Contoh: 081234567890" value="{{ old('no_whatsapp', auth()->user()->no_whatsapp) }}"
                                pattern="^08[0-9]{8,13}$" title="Format nomor WhatsApp tidak valid (harus diawali 08 dan berisi 10-15 angka).">
                            <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">Digunakan untuk mengirimkan notifikasi antrean.</small>
                        </div>

                        <button type="submit" class="auth-button auth-button--google mt-3 py-3">Simpan Profil</button>
                    </form>

                    <p class="auth-footer-copy mb-0">Setelah disimpan, Anda akan diarahkan kembali ke halaman utama Margaya
                        Toba.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
