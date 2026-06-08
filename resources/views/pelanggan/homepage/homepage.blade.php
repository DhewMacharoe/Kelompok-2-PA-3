@extends('pelanggan.layouts.app')

@section('title', 'Dashboard - Arga Home\'s')

@push('styles')
@include('pelanggan.homepage.style-index')
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero d-flex flex-column justify-content-center align-items-center px-3 text-center position-relative">
    <div class="hero-overlay"></div>
    <div class="hero-content z-index-2 w-100">
        <h6 class="hero-subtitle mb-2">SELAMAT DATANG DI</h6>
        <h1 class="hero-title mb-3">ARGA HOME'S</h1>
        <div class="hero-divider-container mb-3 d-flex align-items-center justify-content-center gap-3">
            <span class="hero-divider-line"></span>
            <span class="hero-divider-text">Barber, Coffee & Food</span>
            <span class="hero-divider-line"></span>
        </div>
        <p class="hero-desc mx-auto mb-4">
            Tempat pangkas rambut premium dengan layanan walk-in queue terbaiks.
        </p>
        <a href="{{ route('antrean') }}" class="btn hero-cta-btn px-4 py-2.5 fw-semibold shadow-sm">
            <i class="fas fa-users me-2"></i>Ambil Antrean
        </a>
    </div>
</section>

<!-- Main Container -->
<div class="container py-4 px-3">

    <!-- Queue Status Card / Row -->
    <div class="card queue-status-card border-0 shadow-sm mb-5">
        <div class="card-body p-0">
            <div class="row g-0 align-items-stretch">
                <!-- Col 1: Antrean Menunggu -->
                <div class="col-6 col-md-4 p-4 d-flex align-items-center gap-3 queue-info-section">
                    <div class="queue-icon-circle flex-shrink-0 shadow-sm" style="background-color: #fffcf5; border: 1px solid #e8a53a;">
                        <i class="fas fa-users" style="color: #e8a53a;"></i>
                    </div>
                    <div class="queue-info-details">
                        <h6 class="mb-1 text-dark fw-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">Antrean Menunggu</h6>
                        <p class="mb-1 small text-secondary">Jumlah pelanggan dalam antrean</p>
                        <h4 class="mb-0 queue-large-val">{{ $jumlahAntrean }} orang</h4>
                    </div>
                </div>

                <!-- Col 2: Sedang Dilayani -->
                <div class="col-6 col-md-3 p-4 d-flex align-items-center gap-3 queue-info-section border-start-md">
                    <div class="queue-icon-circle flex-shrink-0 shadow-sm" style="background-color: #fffcf5; border: 1px solid #e8a53a;">
                        <i class="fas fa-chair" style="color: #e8a53a;"></i>
                    </div>
                    <div class="queue-info-details">
                        <h6 class="mb-1 text-dark fw-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">Sedang Dilayani</h6>
                        <h4 class="mb-0 queue-large-val-gold" id="antrean-nomor">
                            {{ $antrean ? $antrean->nomor_antrean_seq : 'Belum Ada' }}
                        </h4>
                    </div>
                </div>

                <!-- Col 3: Status Pelayanan -->
                <div class="col-12 col-md-5 p-3 border-start-md d-flex">
                    <div class="status-pelayanan-box p-3 rounded border w-100 bg-white">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="dot-blink bg-success rounded-circle" style="width: 8px; height: 8px;"></span>
                            <span class="fw-bold text-dark small" style="letter-spacing: 0.5px; font-size: 0.75rem;">Status Pelayanan</span>
                        </div>
                        <a href="{{ route('antrean') }}" class="btn btn-gold-accent w-100 text-white fw-bold mb-2 py-2.5 d-flex align-items-center justify-content-center gap-2" id="antrean-status" style="font-size: 0.88rem; border-radius: 8px; letter-spacing: 0.2px;">
                            <i class="fas fa-ticket-alt"></i> Cek Detail Antrean
                        </a>
                        <div class="d-flex align-items-start gap-2 mt-2 pt-1">
                            <i class="far fa-clock text-success mt-1" style="font-size: 0.95rem;"></i>
                            <div>
                                @if ($antrean)
                                <h6 class="mb-0 fw-bold text-dark" style="font-size: 0.82rem;">Sedang Melayani Nomor<strong> {{ $antrean->nomor_antrean_seq }}</strong></h6>
                                <p class="mb-0 text-muted" style="font-size: 0.72rem; line-height: 1.3;">
                                    Antrean berikutnya akan dipanggil<strong></strong> setelah layanan selesai
                                </p>
                                @else
                                <h6 class="mb-0 fw-bold text-dark" style="font-size: 0.82rem;">Menunggu Panggilan Antrean</h6>
                                <p class="mb-0 text-muted" style="font-size: 0.72rem; line-height: 1.3;">
                                    Pelanggan akan dipanggil sesuai urutan antrean.
                                </p>
                                @endif
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>

<!-- Navigation Menu Grid -->
<div class="row g-3 mb-5 text-center justify-content-center">
    <div class="col-6 col-md-3">
        <a href="{{ route('antrean') }}" class="text-decoration-none menu-grid-item d-block h-100">
            <div class="menu-grid-card p-3 rounded shadow-sm border bg-white transition-hover h-100 d-flex flex-column align-items-center justify-content-center">
                <i class="far fa-address-card menu-grid-icon"></i>
                <div class="menu-grid-text">Antrean</div>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ route('pelanggan.layanan') }}" class="text-decoration-none menu-grid-item d-block h-100">
            <div class="menu-grid-card p-3 rounded shadow-sm border bg-white transition-hover h-100 d-flex flex-column align-items-center justify-content-center">
                <i class="fas fa-cut menu-grid-icon"></i>
                <div class="menu-grid-text">Layanan</div>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ route('galeri') }}" class="text-decoration-none menu-grid-item d-block h-100">
            <div class="menu-grid-card p-3 rounded shadow-sm border bg-white transition-hover h-100 d-flex flex-column align-items-center justify-content-center">
                <i class="far fa-image menu-grid-icon"></i>
                <div class="menu-grid-text">Galeri</div>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-3">
        <a href="{{ route('menu') }}" class="text-decoration-none menu-grid-item d-block h-100">
            <div class="menu-grid-card p-3 rounded shadow-sm border bg-white transition-hover h-100 d-flex flex-column align-items-center justify-content-center">
                <i class="fas fa-coffee menu-grid-icon"></i>
                <div class="menu-grid-text">Menu Café</div>
            </div>
        </a>
    </div>
</div>

<!-- Layanan yang Ditawarkan Section -->
<div class="d-flex justify-content-between align-items-center mb-4 mt-2">
    <h4 class="section-title ps-1 mb-0 fw-bold d-flex align-items-center gap-2">
        <i class="fas fa-star text-gold-accent"></i> Layanan yang Ditawarkan
    </h4>
    <a href="{{ route('pelanggan.layanan') }}" class="text-decoration-none text-gold-accent fw-bold small link-hover-effect">
        Lihat Semua Layanan <i class="fas fa-arrow-right ms-1"></i>
    </a>
</div>

@php
$count = $layanans->count();

if ($count <= 4) {
    $selectedLayanans=$layanans;
    } else {
    $first=$layanans->first();
    $last = $layanans->last();

    $midIndex = (int) floor($count / 2) - 1;
    $middle = $layanans->slice($midIndex, 2);

    $selectedLayanans = collect([$first])
    ->merge($middle)
    ->push($last);
    }
    @endphp

    <div class="row g-3 mb-5">
        @foreach ($selectedLayanans as $layanan)
        <div class="col-12 col-md-6 col-lg-4">
            <div role="button" tabindex="0" class="detail-card-button text-decoration-none d-block h-100"
                data-bs-toggle="modal" data-bs-target="#detailModal"
                data-type="layanan" data-title="{{ $layanan->nama }}"
                data-image="{{ 'https://images.unsplash.com/photo-1503951914875-452162b0f3f1?q=80&w=600&auto=format&fit=crop' }}"
                data-price="Rp{{ number_format($layanan->harga, 0, ',', '.') }}"
                data-description="{{ e($layanan->deskripsi ?? 'Layanan barbershop premium.') }}"
                data-category="Barber"
                data-availability="Tersedia"
                data-extra="Layanan Barber"
                data-estimation="{{ $layanan->estimasi_waktu ?? '-' }} mnt"
                data-show-meta="1">
                <div class="service-custom-card p-3 rounded shadow-sm border bg-white transition-hover h-100 d-flex gap-3 align-items-start">
                    <div class="service-icon-wrapper rounded-circle flex-shrink-0 d-flex align-items-center justify-content-center text-white bg-dark shadow-sm">
                        <i class="fas fa-cut"></i>
                    </div>
                    <div class="service-details-wrapper text-start d-flex flex-column justify-content-between h-100 w-100">
                        <div>
                            <h6 class="service-title-text mb-1 fw-bold text-dark">{{ $layanan->nama }}</h6>
                            <div class="service-meta-text text-secondary small d-flex align-items-center gap-1 mb-2">
                                <i class="far fa-clock text-gold-accent"></i> {{ $layanan->estimasi_waktu ?? '-' }} menit
                            </div>
                            @if ($layanan->deskripsi)
                            <p class="service-desc mb-2 text-muted small">
                                {{ $layanan->deskripsi }}
                            </p>
                            @endif
                        </div>
                        <div class="service-price-text fw-bold text-gold-accent mt-1">
                            Rp{{ number_format($layanan->harga, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Menu Café Favorit Section -->
    @php
    $makanan = collect($menus)->where('kategori', 'Makanan')->take(2);
    $minuman = collect($menus)->where('kategori', 'Minuman')->take(2);
    $combinedMenus = $makanan->merge($minuman)->take(4);
    @endphp

    @if($combinedMenus->isNotEmpty())
    <div class="d-flex justify-content-between align-items-center mb-4 mt-5">
        <h4 class="section-title ps-1 mb-0 fw-bold d-flex align-items-center gap-2">
            <i class="fas fa-coffee text-gold-accent"></i> Menu Café Favorit
        </h4>
        <a href="{{ route('menu') }}" class="text-decoration-none text-gold-accent fw-bold small link-hover-effect">
            Lihat Menu Lengkap <i class="fas fa-arrow-right ms-1"></i>
        </a>
    </div>

    <div class="row g-3 mb-5 justify-content-center">
        @foreach ($combinedMenus as $menu)
        <div class="col-6 col-md-3">
            @php
            $fotoMenu = null;
            if (!empty($menu->foto)) {
            $fotoMenu = \Illuminate\Support\Str::startsWith($menu->foto, ['http://', 'https://'])
            ? $menu->foto
            : asset('images/' . $menu->foto);
            }
            @endphp
            <div role="button" tabindex="0" class="detail-card-button text-decoration-none d-block h-100" data-bs-toggle="modal"
                data-bs-target="#detailModal" data-type="menu" data-title="{{ $menu->nama }}"
                data-image="{{ $fotoMenu ?? 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?q=80&w=600&auto=format&fit=crop' }}"
                data-price="Rp{{ number_format($menu->harga, 0, ',', '.') }}"
                data-description="{{ e($menu->deskripsi ?? 'Tidak ada deskripsi.') }}"
                data-category="{{ $menu->kategori ?? '-' }}"
                data-availability="{{ $menu->is_available ? 'Tersedia' : 'Habis' }}" data-extra="Menu Cafe"
                data-show-meta="0">
                <div class="cafe-menu-card border-0 shadow-sm rounded bg-white transition-hover h-100 overflow-hidden d-flex flex-column text-center">
                    <div class="cafe-menu-img-wrapper position-relative overflow-hidden" style="padding-top: 75%;">
                        <img src="{{ $fotoMenu ?? 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?q=80&w=600&auto=format&fit=crop' }}"
                            class="w-100 h-100 position-absolute top-0 start-0" style="object-fit: cover; transition: transform 0.3s;" alt="{{ $menu->nama }}">
                    </div>
                    <div class="p-3 d-flex flex-column justify-content-between flex-grow-1">
                        <h6 class="cafe-menu-title mb-1 text-dark text-truncate fw-bold" style="font-size: 0.95rem;">{{ $menu->nama }}</h6>
                        <p class="cafe-menu-price fw-bold mb-0 text-gold-accent" style="font-size: 1rem;">
                            Rp{{ number_format($menu->harga, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="col-12">
        <div class="alert alert-light border text-center mb-0 mt-4 shadow-sm">
            <i class="fas fa-info-circle text-muted me-2"></i> Menu cafe belum tersedia saat ini.
        </div>
    </div>
    @endif
    </div>

    <!-- Beautiful Bootstrap Detail Modal -->
    <div class="modal fade detail-modal" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0 bg-white" style="border-radius: 16px; overflow: hidden;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-dark" id="detailModalTitle">-</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-3 text-center">
                    <img id="detailModalImage" src="" alt="Detail Image" class="detail-modal-img mb-3 shadow-sm">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span id="detailModalPrice" class="detail-modal-price">-</span>
                        <span id="detailModalType" class="badge bg-dark px-3 py-2 rounded-pill">-</span>
                    </div>

                    <div class="detail-modal-card p-3 rounded mb-3 bg-light border">
                        <div class="row g-2 text-start">
                            <div class="col-6">
                                <span class="text-secondary small d-block">Status</span>
                                <strong id="detailModalStatus" class="text-success">-</strong>
                            </div>
                            <div class="col-6" id="detailModalMetaRow">
                                <span class="text-secondary small d-block" id="detailModalMetaLabel">Detail</span>
                                <strong id="detailModalMeta">-</strong>
                            </div>
                        </div>
                    </div>

                    <div class="text-start">
                        <h6 class="fw-bold text-dark mb-2">Deskripsi</h6>
                        <p id="detailModalDescription" class="detail-modal-text text-secondary mb-0">-</p>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <span id="detailModalExtra" class="d-none">-</span>
                    <button type="button" class="btn btn-secondary w-100 py-2 fw-semibold" data-bs-dismiss="modal" style="border-radius: 8px;">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    @endsection

    @push('scripts')
    @include('pelanggan.homepage.script-index')
    @endpush