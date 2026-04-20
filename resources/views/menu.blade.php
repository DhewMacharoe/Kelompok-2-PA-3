@extends('pelanggan.layouts.app')

@section('title', 'Menu Kafe')

@section('content')
    <div class="container py-4">
        <div class="banner bg-gold text-white p-4 rounded mb-4 text-center">
            <h3 class="mb-2">☕ Kafe Arga</h3>
            <p class="mb-0">Nikmati waktu menunggu dengan minuman terbaik</p>
        </div>

        <div class="filter-bar mb-4 d-flex justify-content-center gap-2 flex-wrap">
            <button class="filter-chip active btn btn-outline-gold">Semua</button>
            <button class="filter-chip btn btn-outline-secondary">☕ Minuman</button>
            <button class="filter-chip btn btn-outline-secondary">🍞 Makanan</button>
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
                                            <span class="card-price">Rp
                                                {{ number_format($item->harga, 0, ',', '.') }}</span>
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
            @endif
        @endforeach
    </div>
@endsection
