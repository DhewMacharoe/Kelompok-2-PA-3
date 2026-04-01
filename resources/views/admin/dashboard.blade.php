@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('header_title')
    <div class="header-logo">
        <div class="logo-icon">✂</div> Admin Panel
    </div>
@endsection

@section('header_right')
    <div style="display:flex; gap:8px; align-items:center;">
        <span style="font-size:11px; color:var(--text-muted);">👤 {{ auth()->user()->name ?? 'Admin' }}</span>
        <form action="{{ route('logout') }}" method="POST" style="margin:0;">
            @csrf
            <button type="submit" class="header-action">Keluar</button>
        </form>
    </div>
@endsection

@section('content')
    <section class="hero" style="text-align:center; padding:24px 16px;">
        <div class="hero-label">Sedang Dilayani</div>
        <div class="hero-number-box" style="display:inline-block; margin:8px auto;">
            <div class="hero-number">{{ $dipanggil ? $dipanggil->nomor_antrian : '--' }}</div>
        </div>
        <div class="hero-name">{{ $dipanggil ? $dipanggil->nama_pelanggan : 'Tidak ada antrian aktif' }}</div>

        @if ($dipanggil)
            <form action="{{ route('admin.antrian.selesai', $dipanggil->id) }}" method="POST" style="margin-top:12px;">
                @csrf
                <button type="submit" class="badge"
                    style="background:var(--success); color:white; border:none; padding:6px 16px; font-size:12px; cursor:pointer;">✔
                    Tandai Selesai</button>
            </form>
        @endif
    </section>

    <div class="summary-grid">
        <div class="summary-card">
            <div class="s-label">👥 Menunggu</div>
            <div class="s-value">{{ $jumlahMenunggu }}</div>
            <div class="s-sub">orang</div>
        </div>
        <div class="summary-card">
            <div class="s-label">✅ Selesai</div>
            <div class="s-value">{{ $jumlahSelesai }}</div>
            <div class="s-sub">hari ini</div>
        </div>
    </div>

    <div class="section-label">Antrian Menunggu</div>

    <div class="card-list">
        @forelse($antrianMenunggu as $item)
            <div class="queue-card" style="display:flex; justify-content:space-between; align-items:center;">
                <div style="display:flex; align-items:center; gap:16px;">
                    <div class="queue-number">{{ $item->nomor_antrian }}</div>
                    <div class="queue-info">
                        <div class="queue-name">{{ $item->nama_pelanggan }}</div>
                        <div class="queue-time">Masuk: {{ \Carbon\Carbon::parse($item->waktu_masuk)->format('H:i') }}</div>
                    </div>
                </div>
                <form action="{{ route('admin.antrian.batal', $item->id) }}" method="POST"
                    onsubmit="return confirm('Yakin ingin membatalkan antrian ini?');">
                    @csrf
                    <button type="submit"
                        style="background:none; border:none; color:var(--danger); font-size:12px; cursor:pointer; text-decoration:underline;">Batal</button>
                </form>
            </div>
        @empty
        @endforelse
    </div>

    <div class="section-label" style="margin-top:8px;">Menu Navigasi</div>
    <div class="nav-grid">
        <a href="{{ url('admin/layanan') }}" class="nav-card admin-card">
            <div class="nav-card-icon">📋</div>
            <div class="nav-card-label">Kelola Layanan</div>
        </a>
        <a href="{{ url('admin/galeri') }}" class="nav-card admin-card">
            <div class="nav-card-icon">💈</div>
            <div class="nav-card-label">Kelola Galeri</div>
        </a>
        <a href="{{ url('admin/menu') }}" class="nav-card admin-card">
            <div class="nav-card-icon">☕</div>
            <div class="nav-card-label">Menu Kafe</div>
        </a>
        <a href="{{ url('admin/rekap') }}" class="nav-card admin-card">
            <div class="nav-card-icon">📊</div>
            <div class="nav-card-label">Rekap</div>
        </a>
    </div>

    <div style="height:100px;"></div>

    <div class="action-bar">
        @if ($antrianMenunggu->count() > 0)
            <form action="{{ route('admin.antrian.panggil', $antrianMenunggu->first()->id) }}" method="POST"
                style="width:100%;">
                @csrf
                <button type="submit" class="btn btn-primary" style="width:100%;">▶ PANGGIL No.
                    {{ $antrianMenunggu->first()->nomor_antrian }}</button>
            </form>
        @else
            <button class="btn btn-primary" style="opacity:0.5; cursor:not-allowed;">▶ PANGGIL BERIKUTNYA</button>
        @endif
        <a href="{{ url('admin/tambah-pelanggan') }}" class="btn btn-secondary">+ Tambah Pelanggan</a>
    </div>
@endsection
