@extends('layouts.public')

@section('title', 'Layanan Barbershop')

@section('header')
    <button class="header-back" onclick="history.back()">← Kembali</button>
    <div class="header-title">Layanan</div>
    <div style="width:64px;"></div>
@endsection

@section('content')
    <div class="banner">
        <span class="banner-label">FOTO BARBERSHOP</span>
        <div class="banner-text">
            <div class="banner-title">Arga Barbershop</div>
            <div class="banner-sub">Potongan terbaik untuk penampilan terbaikmu ✂</div>
        </div>
    </div>

    <div class="filter-bar">
        <button class="filter-chip active">Semua</button>
        <button class="filter-chip">✂ Rambut</button>
        <button class="filter-chip">🪒 Jenggot</button>
        <button class="filter-chip">💆 Perawatan</button>
    </div>

    @foreach (['Layanan Rambut', 'Layanan Jenggot', 'Perawatan'] as $kategori)
        @php $layananKategori = $layanans->where('kategori', $kategori); @endphp

        @if ($layananKategori->count() > 0)
            <div class="category-label">
                {{ $kategori == 'Layanan Rambut' ? '✂' : ($kategori == 'Layanan Jenggot' ? '🪒' : '💆') }}
                {{ $kategori }}
            </div>

            <div class="card-list">
                @foreach ($layananKategori as $item)
                    <div class="card">
                        <div class="card-body">
                            <div class="card-row">
                                <div class="card-img"
                                    @if ($item->foto) style="background-image:url('{{ asset('storage/' . $item->foto) }}'); background-size:cover;" @endif>
                                    @if (!$item->foto)
                                        FOTO
                                    @endif
                                </div>
                                <div class="card-info">
                                    <div class="card-title">{{ $item->nama }}</div>
                                    <div class="card-desc">{{ $item->deskripsi }}</div>
                                    <div class="card-meta">
                                        <span>⏱ ±{{ $item->estimasi_waktu ?? '-' }}</span>
                                        <span class="card-price">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
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
    <div class="spacer-lg"></div>
@endsection

@section('action_bar')
    <div class="action-bar">
        <a href="{{ url('/') }}" class="btn btn-primary">← Kembali ke Halaman Utama</a>
    </div>
@endsection
