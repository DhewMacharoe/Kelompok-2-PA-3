@extends('layouts.public')

@section('body_class', 'auth-page auth-page--public')
@section('hide_public_chrome', '1')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/arga-auth.css') }}">
@endsection

@section('title', "Set Username - Arga's Home")

@section('content')
<div class="auth-shell auth-shell--public">
    <div class="auth-card auth-card--compact">
        <div class="auth-form">
            <div class="auth-form-inner">
                <div class="auth-badge">
                    <div class="auth-dot"></div>
                    <span>Profile Setup</span>
                </div>

                <div class="auth-kicker">Langkah terakhir</div>
                <h2 class="auth-section-title">Pilih username untuk Arga's Home</h2>
                <p class="auth-section-copy">Username ini akan menjadi identitas Anda di sistem. Pilih yang unik, mudah diingat, dan sesuai aturan karakter.</p>

                @if(session('error'))
                    <div class="auth-alert auth-alert--error small text-start">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('set.username.post') }}" method="POST">
                    @csrf
                    <div class="auth-input-group">
                        <label for="username" class="auth-label">Username</label>
                        <input type="text" id="username" name="username" required class="auth-input" placeholder="Masukkan username">
                    </div>

                    <button type="submit" class="auth-button auth-button--google">Simpan Username</button>
                </form>

                <p class="auth-footer-copy mb-0">Setelah disimpan, Anda akan diarahkan kembali ke halaman utama Arga's Home.</p>
            </div>
        </div>
    </div>
</div>
@endsection