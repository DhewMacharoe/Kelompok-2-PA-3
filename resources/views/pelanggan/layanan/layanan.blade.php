@extends('pelanggan.layouts.app')

@section('title', 'Layanan')

@push('styles')
    @include('pelanggan.layanan.styles')
    @include('pelanggan.homepage.style-index')
@endpush


@section('content')
    <section class="layanan-hero">
        <div class="layanan-hero-overlay">
            <div class="layanan-hero-text">
                <h1>Daftar Layanan</h1>
                <p>Lihat pilihan layanan yang tersedia beserta harga dan estimasi waktunya.</p>
            </div>
        </div>
    </section>

    <section class="layanan-content">
        <div class="layanan-section-header">
            <h3>Daftar Layanan</h3>
        </div>

        <div class="layanan-grid">
            @forelse($layanans as $layanan)
                <div class="layanan-card">
                    <div class="layanan-card-image">
                        @if ($layanan->foto)
                            @php
                                // Sementara: dukung URL eksternal dari seeder API gambar.
                                // <img src="{{ asset('storage/' . $layanan->foto) }}" alt="{{ $layanan->nama }}">
                                $fotoLayanan = \Illuminate\Support\Str::startsWith($layanan->foto, ['http://', 'https://'])
                                    ? $layanan->foto
                                    : asset('storage/' . $layanan->foto);
                            @endphp
                            <img src="{{ $fotoLayanan }}" alt="{{ $layanan->nama }}">
                        @else
                            <img src="https://via.placeholder.com/1200x800?text=No+Image" alt="{{ $layanan->nama }}">
                        @endif
                    </div>
                    <div class="layanan-card-body">
                        <h4>{{ $layanan->nama }}</h4>
                        <p class="layanan-desc">{{ $layanan->deskripsi }}</p>
                        <p class="layanan-time">⏱ {{ $layanan->estimasi_waktu }} menit</p>
                        <p class="layanan-price">Rp{{ number_format($layanan->harga, 0, ',', '.') }}</p>
                    </div>
                </div>
            @empty
                <div class="layanan-empty">
                    <p>Maaf, saat ini belum ada layanan yang tersedia.</p>
                </div>
            @endforelse
        </div>
        
    </section>
@endsection
