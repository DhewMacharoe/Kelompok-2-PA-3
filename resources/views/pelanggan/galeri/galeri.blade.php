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
                @php
                    $imageUrl = \Illuminate\Support\Str::startsWith($galeri->gambar, ['http://', 'https://']) ? $galeri->gambar : asset('images/' . $galeri->gambar);
                    $desc = $galeri->deskripsi ?: "Dokumentasi visual Arga Home's Barber, Coffee & Food.";
                @endphp
                <div class="galeri-card" style="cursor: pointer;"
                     data-image="{{ $imageUrl }}"
                     data-title="{{ $galeri->judul }}"
                     data-description="{{ e($desc) }}">
                    <div class="galeri-card-image">
                            <img src="{{ $imageUrl }}" alt="{{ $galeri->judul }}">
                    </div>

                    <div class="galeri-card-body">
                        <h3>{{ $galeri->judul }}</h3>
                        <p>{{ $desc }}</p>
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

    <div class="modal-overlay" id="galeriDetailModal">
        <div class="modal-card">
            <button class="modal-close" id="modalCloseBtn">×</button>
            <div class="modal-image-wrapper">
                <img src="" alt="Galeri Image" id="modalGaleriImage">
            </div>
            <div class="modal-content">
                <h3 id="modalGaleriTitle"></h3>
                <p class="modal-description" id="modalGaleriDescription"></p>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modalOverlay = document.getElementById('galeriDetailModal');
        const modalCloseBtn = document.getElementById('modalCloseBtn');
        const modalImage = document.getElementById('modalGaleriImage');
        const modalTitle = document.getElementById('modalGaleriTitle');
        const modalDescription = document.getElementById('modalGaleriDescription');

        document.querySelectorAll('.galeri-card').forEach(item => {
            item.addEventListener('click', function() {
                modalImage.src = this.dataset.image;
                modalTitle.textContent = this.dataset.title;
                modalDescription.textContent = this.dataset.description;
                modalOverlay.classList.add('active');
            });
        });

        if (modalCloseBtn) {
            modalCloseBtn.addEventListener('click', function() {
                modalOverlay.classList.remove('active');
            });
        }

        if (modalOverlay) {
            modalOverlay.addEventListener('click', function(event) {
                if (event.target === modalOverlay) {
                    modalOverlay.classList.remove('active');
                }
            });
        }
    });
</script>
@endpush

@endsection