@extends('layouts.public')

@section('title', 'Galeri Gaya Rambut')

@section('header')
    <button class="header-back" onclick="history.back()">← Kembali</button>
    <div class="header-title">Galeri Gaya Rambut</div>
    <div style="width:64px;"></div>
@endsection

@section('content')
    <div class="filter-bar">
        <button class="filter-chip active">Semua</button>
        <button class="filter-chip">Oval</button>
        <button class="filter-chip">Bulat</button>
        <button class="filter-chip">Persegi</button>
        <button class="filter-chip">Lonjong</button>
    </div>

    <div style="padding:4px 16px 8px; font-size:11px; color:var(--text-muted);">
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

    <div style="height:100px;"></div>
@endsection

@section('action_bar')
    <div class="action-bar">
        <a href="{{ url('rekomendasi') }}" class="btn btn-primary">🔍 Coba Analisis Wajahmu</a>
    </div>
@endsection
