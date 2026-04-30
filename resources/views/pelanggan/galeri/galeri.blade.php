@extends('pelanggan.layouts.app')

@section('title', 'Galeri')

@section('content')

@include('pelanggan.galeri.style-index')

<section class="galeri-hero">
    <div class="galeri-hero-overlay">
        <div class="galeri-hero-text">
            <h1>Galeri Arga Home's</h1>
            <p>
                Lihat suasana barbershop, hasil potongan rambut, dan area coffee
                di Arga Home's sebelum datang ke tempat.
            </p>
        </div>
    </div>
</section>

<section class="galeri-content">
    <div class="galeri-section-header">
        <h2>Galeri Arga Home's</h2>
        <div class="galeri-line"></div>
    </div>

    @if($galeris->count() > 0)
        <div class="galeri-grid">
            @foreach($galeris as $galeri)
                <div class="galeri-card">
                    <div class="galeri-card-image">
                            <img src="{{ \Illuminate\Support\Str::startsWith($galeri->gambar, ['http://', 'https://']) ? $galeri->gambar : asset('images/' . $galeri->gambar) }}" 
                             alt="{{ $galeri->judul }}">
                    </div>

                    <div class="galeri-card-body">
                        <h3>{{ $galeri->judul }}</h3>

                        @if($galeri->deskripsi)
                            <p>{{ $galeri->deskripsi }}</p>
                        @else
                            <p>Dokumentasi visual Arga Home's Barber, Coffee & Food.</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="galeri-empty">
            <h3>Belum Ada Foto Galeri</h3>
            <p>Foto galeri akan ditampilkan setelah pemilik menambahkan data dari halaman admin.</p>
        </div>
    @endif
</section>

@endsection