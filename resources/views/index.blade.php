@extends('layouts.public')

@section('title', 'Barbershop & Cafe — Halaman Utama')

@section('header')
    <div class="header-logo">
        <div class="logo-icon">✂</div> Arga Barbershop
    </div>
    <div class="live-badge"><span class="live-dot"></span> LIVE</div>
@endsection

@section('content')
    <section class="hero" style="text-align:center; padding:28px 16px;">
        <div class="hero-label">Nomor Dipanggil</div>
        <div class="hero-number-box" style="display:inline-block; margin:8px auto;">
            <div class="hero-number">{{ $dipanggil ? $dipanggil->nomor_antrian : '--' }}</div>
        </div>
        <div class="hero-name">{{ $dipanggil ? substr($dipanggil->nama_pelanggan, 0, 3) . '***' : 'Tidak ada antrian' }}
        </div>
        <div class="hero-subtitle">{{ $dipanggil ? 'Sedang dilayani' : 'Silakan mendaftar di kasir' }}</div>
    </section>

    <div class="info-bar">
        <div class="info-chip accent">👥 Menunggu: <strong>{{ $jumlahMenunggu }}</strong></div>
        <div class="info-chip">⏱ Rata-rata: <strong>±1 jam</strong></div>
    </div>

    <div class="nav-grid">
        <a href="{{ url('layanan') }}" class="nav-card">
            <div class="nav-card-icon">✂</div>
            <div class="nav-card-label">Layanan</div>
        </a>
        <a href="{{ url('antrian') }}" class="nav-card">
            <div class="nav-card-icon">👥</div>
            <div class="nav-card-label">Antrian</div>
        </a>
        <a href="{{ url('rekomendasi') }}" class="nav-card">
            <div class="nav-card-icon">💈</div>
            <div class="nav-card-label">Gaya Rambut</div>
        </a>
        <a href="{{ url('menu') }}" class="nav-card">
            <div class="nav-card-icon">☕</div>
            <div class="nav-card-label">Menu Kafe</div>
        </a>
    </div>

    <div style="padding:0 16px 16px;">
        <div
            style="padding:12px 16px; background:var(--bg); border:1px solid var(--border-light); border-radius:var(--radius-md); font-size:12px; color:var(--text-secondary); text-align:center;">
            ⏱ Durasi rata-rata layanan: <strong>±1 jam</strong> — Senin s/d Sabtu, 09.00–20.00 WIB
        </div>
    </div>

    <div style="padding:0 16px 24px; text-align:center;">
        <a href="{{ url('login') }}" style="font-size:11px; color:var(--text-muted); text-decoration:underline;">Masuk
            sebagai Admin →</a>
    </div>
@endsection
