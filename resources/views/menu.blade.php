@extends('layouts.public')

@section('title', 'Menu Kafe')

@section('header')
    <button class="header-back" onclick="history.back()">← Kembali</button>
    <div class="header-title">Menu Kafe</div>
    <div style="width:64px;"></div>
@endsection

@section('content')
    <div class="banner">
        <span class="banner-label">FOTO KAFE</span>
        <div class="banner-text">
            <div class="banner-title">Kafe Arga</div>
            <div class="banner-sub">Nikmati waktu menunggu dengan minuman terbaik ☕</div>
        </div>
    </div>

    <div class="filter-bar">
        <button class="filter-chip active">Semua</button>
        <button class="filter-chip">☕ Minuman</button>
        <button class="filter-chip">🍞 Makanan</button>
    </div>

    @foreach (['Minuman', 'Makanan Ringan'] as $kategori)
        @php $menuKategori = $menus->where('kategori', $kategori); @endphp

        @if ($menuKategori->count() > 0)
            <div class="category-label">
                {{ $kategori == 'Minuman' ? '☕' : '🍞' }} {{ $kategori }}
            </div>

            <div class="card-list">
                @foreach ($menuKategori as $item)
                    <div class="card {{ !$item->is_available ? 'style="opacity:0.65;"' : '' }}">
                        <div class="card-body">
                            <div class="card-row">
                                <div class="card-img"
                                    @if (!$item->is_available) style="background:var(--placeholder-dark);" @endif>
                                    FOTO MENU
                                </div>
                                <div class="card-info">
                                    <div class="card-title">{{ $item->nama }}</div>
                                    <div class="card-desc">{{ $item->deskripsi }}</div>
                                    <div class="card-meta">
                                        <span class="card-price">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                                        @if ($item->is_available)
                                            <span class="badge badge-available">✅ Tersedia</span>
                                        @else
                                            <span class="badge badge-empty">❌ Habis</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="spacer-md"></div>
        @endif
    @endforeach

    <div style="height:100px;"></div>
@endsection

@section('action_bar')
    <div class="action-bar">
        <a href="{{ url('/') }}" class="btn btn-primary">← Kembali ke Halaman Utama</a>
    </div>
@endsection
