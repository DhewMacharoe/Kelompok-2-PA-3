@extends('pelanggan.layouts.app')

@section('title', 'Galeri Gaya Rambut')

@section('content')
    <div class="container py-4">
        <h2 class="text-center mb-4 text-gold fw-bold">Galeri Gaya Rambut</h2>

        <div class="filter-bar mb-4 d-flex justify-content-center gap-2 flex-wrap">
            <button class="filter-chip active btn btn-outline-gold">Semua</button>
            <button class="filter-chip btn btn-outline-secondary">Oval</button>
            <button class="filter-chip btn btn-outline-secondary">Bulat</button>
            <button class="filter-chip btn btn-outline-secondary">Persegi</button>
            <button class="filter-chip btn btn-outline-secondary">Lonjong</button>
        </div>
        Menampilkan <strong>{{ $galeris->count() }}</strong> gaya rambut
    </div>

    <div class="gallery-grid">
        @foreach ($galeris as $gaya)
            <div class="gallery-item">
                <div class="gallery-photo"
                    @if ($gaya->foto) style="background-image:url('{{ asset('storage/' . $gaya->foto) }}'); background-size:cover;" @endif>
                    @if (!$gaya->foto)
                        FOTO<br>{{ strtoupper($gaya->nama) }}
                    @endif
                </div>
                <div class="gallery-info">
                    <div class="gallery-name">{{ $gaya->nama }}</div>
                    <div class="gallery-tag">Cocok: {{ $gaya->bentuk_wajah }}</div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('rekomendasi') }}" class="btn btn-gold">🔍 Coba Analisis Wajahmu</a>
    </div>
    </div>
@endsection
