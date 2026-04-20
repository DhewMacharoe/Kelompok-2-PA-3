@extends('pelanggan.layouts.app')

@section('title', 'Layanan Barbershop')

@section('content')
    <div class="container py-4">
        <div class="banner bg-gold text-white p-4 rounded mb-4 text-center">
            <h3 class="mb-2">✂ Arga Barbershop</h3>
            <p class="mb-0">Potongan terbaik untuk penampilan terbaikmu</p>
        </div>

        <div class="filter-bar mb-4 d-flex justify-content-center gap-2 flex-wrap">
            <button class="filter-chip active btn btn-outline-gold">Semua</button>
            <button class="filter-chip btn btn-outline-secondary">✂ Rambut</button>
            <button class="filter-chip btn btn-outline-secondary">🪒 Jenggot</button>
            <button class="filter-chip btn btn-outline-secondary">💆 Perawatan</button>
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
                                            <span class="card-price">Rp
                                                {{ number_format($item->harga, 0, ',', '.') }}</span>
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
