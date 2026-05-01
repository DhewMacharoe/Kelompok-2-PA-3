@extends('pelanggan.layouts.app')

@section('title', 'Dashboard - Arga Home\'s')

@push('styles')
@include('pelanggan.homepage.style-index')
@endpush


@section('content')
<section class="hero d-flex justify-content-center align-items-center px-3">
    <div class="card queue-card shadow-lg border-0">
        <div class="bg-gold text-white p-3 d-flex align-items-center justify-content-center gap-3">
            <i class="fas fa-users fs-1"></i>
            <div>
                <h5 class="mb-0 fs-6">Status Antrean</h5>
                <p class="mb-0 small opacity-75">Total Antrean {{ $jumlahAntrean }}</p>
            </div>
        </div>

        <div class="card-body text-center py-4">
            @if ($antrean)
            <div class="text-uppercase small text-muted mb-2 font-weight-bold">Sekarang Melayani</div>

            <h2 class="mb-2 fw-bold text-dark" id="antrean-nomor" style="letter-spacing: 3px; font-size: 2.5rem;">
                {{ $antrean->nomor_antrean }}
            </h2>

            <div class="d-inline-flex align-items-center px-3 py-2 rounded-pill bg-light text-dark fw-semibold mb-3 border"
                id="antrean-status">
                <span class="dot bg-success rounded-circle me-2" style="width: 10px; height: 10px;"></span>
                {{ $antrean->status === 'sedang dilayani' ? 'Sedang Dilayani' : ucfirst($antrean->status) }}
            </div>

            <p class="mb-0 text-muted fw-bold">{{ $antrean->nama_pelanggan }}</p>
            @else
            <div class="py-3">
                <i class="fas fa-user-circle text-muted fs-2 mb-2"></i>
                <p class="mb-0 text-muted">Kursi Pangkas Kosong</p>
            </div>
            @endif
        </div>
    </div>
</section>
<div class="container py-5">

    <div class="text-center mb-5">
        <img src="{{ asset('assets/images/logo.png') }}" alt="Arga Home's Logo" class="img-fluid"
            style="max-height: 380px;">
    </div>

    <div class="row text-center mb-5 g-4">
        <div class="col-6 col-md-3">
            <a href="{{ route('antrean') }}" class="text-decoration-none text-dark fw-bold menu-item d-block">
                <div class="icon-circle shadow-sm"><i class="fas fa-id-card"></i></div>
                Antrean
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('galeri') }}" class="text-decoration-none text-dark fw-bold menu-item d-block">
                <div class="icon-circle shadow-sm"><i class="fas fa-images"></i></div>
                Galeri
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('pelanggan.layanan') }}" class="text-decoration-none text-dark fw-bold menu-item d-block">
                <div class="icon-circle shadow-sm"><i class="fas fa-cut"></i></div>
                Layanan
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('menu') }}" class="text-decoration-none text-dark fw-bold menu-item d-block">
                <div class="icon-circle shadow-sm"><i class="fas fa-coffee"></i></div>
                Menu Café
            </a>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="border-gold-left ps-2 mb-0 fw-bold">Layanan Yang Ditawarkan</h4>
        <a href="{{ route('pelanggan.layanan') }}" class="text-decoration-none text-gold fw-semibold small">
            Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
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
            <div class="col-12 col-md-6">
                <a href="{{ route('pelanggan.layanan', ['id' => $layanan->id]) }}"
                    class="text-decoration-none d-block h-100">
                    <div
                        class="bg-white p-3 rounded shadow-sm border transition-hover h-100 d-flex justify-content-between align-items-center">

                        <div class="d-flex align-items-center gap-3 overflow-hidden">
                            <div class="bg-light rounded-circle d-flex flex-shrink-0 align-items-center justify-content-center"
                                style="width: 45px; height: 45px;">
                                <i class="fas fa-cut text-gold fs-5"></i>
                            </div>
                            <div class="text-start text-truncate">
                                <h6 class="mb-1 fw-bold text-dark text-truncate">{{ $layanan->nama }}</h6>
                                <div class="text-muted small d-flex align-items-center gap-2 text-truncate">
                                    <span><i class="far fa-clock text-gold"></i> {{ $layanan->estimasi_waktu ?? '-' }}
                                        mnt</span>
                                    @if ($layanan->deskripsi)
                                    <span>•</span>
                                    <span class="text-truncate opacity-75">{{ $layanan->deskripsi }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="text-end ms-3 flex-shrink-0">
                            <div class="fw-bold text-dark" style="font-size: 1.1rem;">
                                Rp{{ number_format($layanan->harga, 0, ',', '.') }}
                            </div>
                            <div class="text-gold small fw-semibold mt-1">
                                Lihat <i class="fas fa-chevron-right ms-1" style="font-size: 0.7rem;"></i>
                            </div>
                        </div>

                    </div>
                </a>
            </div>
            @endforeach
        </div>
    @php
        $makanan = collect($menus)->where('kategori', 'Makanan')->take(6);
        $minuman = collect($menus)->where('kategori', 'Minuman')->take(6);
    @endphp

    @if($makanan->isNotEmpty())
    <div class="d-flex justify-content-between align-items-center mb-4 mt-5">
        <h4 class="border-gold-left ps-2 mb-0 fw-bold">Menu Makanan</h4>
        <a href="{{ route('menu', ['kategori' => 'Makanan']) }}" class="text-decoration-none text-gold fw-semibold small">
            Lihat Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
        </a>
    </div>

    <div class="row g-3">
        @foreach ($makanan as $menu)
        <div class="col-6 col-md-4 col-lg-3 col-xl-2">
            @php
            $fotoMenu = null;
            if (!empty($menu->foto)) {
            $fotoMenu = \Illuminate\Support\Str::startsWith($menu->foto, ['http://', 'https://'])
            ? $menu->foto
            : asset('images/' . $menu->foto);
            }
            @endphp
            <div role="button" tabindex="0" class="detail-card-button" data-bs-toggle="modal"
                data-bs-target="#detailModal" data-type="menu" data-title="{{ $menu->nama }}"
                data-image="{{ $fotoMenu ?? 'https://via.placeholder.com/600x400?text=No+Image' }}"
                data-price="Rp{{ number_format($menu->harga, 0, ',', '.') }}"
                data-description="{{ e($menu->deskripsi ?? 'Tidak ada deskripsi.') }}"
                data-category="{{ $menu->kategori ?? '-' }}"
                data-availability="{{ $menu->is_available ? 'Tersedia' : 'Habis' }}" data-extra="Menu Cafe"
                data-show-meta="0">
                <div class="card haircut-card shadow-sm border-0 h-100">
                    <img src="{{ $fotoMenu ?? 'https://via.placeholder.com/600x400?text=No+Image' }}"
                        class="card-img-top haircut-img" alt="{{ $menu->nama }}">
                    <div class="card-body p-2 text-center">
                        <h6 class="card-title text-muted mb-1" style="font-size: 0.9rem;">{{ $menu->nama }}</h6>
                        <p class="card-text fw-bold text-dark mb-0">
                            Rp{{ number_format($menu->harga, 0, ',', '.') }}</p>
                        <div class="detail-card-meta">
                            <span class="detail-card-badge"><i class="fas fa-utensils"></i> Makanan</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    @if($minuman->isNotEmpty())
    <div class="d-flex justify-content-between align-items-center mb-4 mt-5">
        <h4 class="border-gold-left ps-2 mb-0 fw-bold">Menu Minuman</h4>
        <a href="{{ route('menu', ['kategori' => 'Minuman']) }}" class="text-decoration-none text-gold fw-semibold small">
            Lihat Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
        </a>
    </div>

    <div class="row g-3">
        @foreach ($minuman as $menu)
        <div class="col-6 col-md-4 col-lg-3 col-xl-2">
            @php
            $fotoMenu = null;
            if (!empty($menu->foto)) {
            $fotoMenu = \Illuminate\Support\Str::startsWith($menu->foto, ['http://', 'https://'])
            ? $menu->foto
            : asset('images/' . $menu->foto);
            }
            @endphp
            <div role="button" tabindex="0" class="detail-card-button" data-bs-toggle="modal"
                data-bs-target="#detailModal" data-type="menu" data-title="{{ $menu->nama }}"
                data-image="{{ $fotoMenu ?? 'https://via.placeholder.com/600x400?text=No+Image' }}"
                data-price="Rp{{ number_format($menu->harga, 0, ',', '.') }}"
                data-description="{{ e($menu->deskripsi ?? 'Tidak ada deskripsi.') }}"
                data-category="{{ $menu->kategori ?? '-' }}"
                data-availability="{{ $menu->is_available ? 'Tersedia' : 'Habis' }}" data-extra="Menu Cafe"
                data-show-meta="0">
                <div class="card haircut-card shadow-sm border-0 h-100">
                    <img src="{{ $fotoMenu ?? 'https://via.placeholder.com/600x400?text=No+Image' }}"
                        class="card-img-top haircut-img" alt="{{ $menu->nama }}">
                    <div class="card-body p-2 text-center">
                        <h6 class="card-title text-muted mb-1" style="font-size: 0.9rem;">{{ $menu->nama }}</h6>
                        <p class="card-text fw-bold text-dark mb-0">
                            Rp{{ number_format($menu->harga, 0, ',', '.') }}</p>
                        <div class="detail-card-meta">
                            <span class="detail-card-badge"><i class="fas fa-mug-hot"></i> Minuman</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    @if($makanan->isEmpty() && $minuman->isEmpty())
    <div class="col-12">
        <div class="alert alert-light border text-center mb-0 mt-4">
            Menu cafe belum tersedia saat ini.
        </div>
    </div>
    @endif
</div>
@endsection
@push('scripts')
@include('pelanggan.homepage.script-index')
@endpush

