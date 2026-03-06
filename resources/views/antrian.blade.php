@extends('layouts.public')

@section('title', 'Informasi Antrian')

@section('header')
    <button class="header-back" onclick="history.back()">← Kembali</button>
    <div class="header-title">Antrian</div>
    <div class="live-badge"><span class="live-dot"></span> LIVE</div>
@endsection

@section('content')
    <section class="hero" style="text-align:center; padding:28px 16px;">
        <div class="hero-label">Sedang Dilayani</div>
        <div class="hero-number-box" style="display:inline-block; margin:8px auto;">
            <div class="hero-number">{{ $dipanggil ? $dipanggil->nomor_antrian : '--' }}</div>
        </div>
        <div class="hero-name">{{ $dipanggil ? substr($dipanggil->nama_pelanggan, 0, 3) . '***' : 'Kosong' }}</div>
    </section>

    <div class="info-bar">
        <div class="info-chip accent">👥 Menunggu: <strong>{{ $jumlahMenunggu }}</strong></div>
        <div class="info-chip">⏱ Rata-rata: <strong>±1 jam</strong></div>
    </div>

    <div class="section-label">Urutan Antrian</div>

    <div class="card-list" style="padding-bottom:16px;">
        @forelse($menunggu as $item)
            <div class="queue-card">
                <div class="queue-number">{{ $item->nomor_antrian }}</div>
                <div class="queue-info">
                    <div class="queue-name">{{ substr($item->nama_pelanggan, 0, 3) }}***</div>
                    <div class="queue-time">Masuk: {{ \Carbon\Carbon::parse($item->waktu_masuk)->format('H:i') }} WIB</div>
                </div>
                <div class="queue-badge">
                    <span class="badge badge-waiting">Menunggu</span>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div class="empty-icon">✅</div>
                <div class="empty-title">Tidak ada antrian saat ini</div>
                <div class="empty-desc">Kamu bisa langsung datang sekarang!</div>
            </div>
        @endforelse
    </div>
@endsection

@section('action_bar')
    <div class="action-bar">
        <a href="{{ url('/') }}" class="btn btn-primary">← Kembali ke Halaman Utama</a>
    </div>
@endsection
