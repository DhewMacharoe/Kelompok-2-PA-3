<style>
    .pelanggan-navbar {
        background-color: #ffffff !important;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.04) !important;
        border-bottom: 1px solid #f0f0f0 !important;
        padding-top: 10px !important;
        padding-bottom: 10px !important;
        transition: all 0.3s ease;
    }

    .pelanggan-navbar .navbar-brand img {
        max-height: 44px !important;
        height: 44px !important;
        width: auto !important;
        display: block;
    }

    .pelanggan-navbar .nav-link {
        color: #2b2b2b !important;
        font-weight: 600 !important;
        font-size: 0.92rem;
        padding: 0.5rem 1rem !important;
        border-radius: 6px;
        transition: all 0.2s ease;
        white-space: nowrap !important;
    }

    .pelanggan-navbar .nav-link:hover,
    .pelanggan-navbar .nav-link.active {
        color: {{ $activeDesign->warna_primer ?? '#d4af37' }} !important;
        background-color: {{ $activeDesign->warna_primer ?? '#d4af37' }}18 !important;
    }

    .pelanggan-navbar .navbar-toggler {
        padding: 0;
        line-height: 1;
        color: #1a1a1a !important;
        background: transparent !important;
        border: none !important;
        box-shadow: none !important;
    }

    .pelanggan-navbar .navbar-toggler i {
        font-size: 1.35rem !important;
        color: #1a1a1a !important;
    }

    /* Auth buttons */
    .pelanggan-navbar .navbar-nav .btn {
        border-radius: 8px !important;
        font-size: 0.85rem !important;
        padding: 6px 16px !important;
        transition: all 0.25s ease;
    }

    .btn-gold {
        color: {{ $activeDesign->warna_primer ?? '#d4af37' }} !important;
        border: 1px solid {{ $activeDesign->warna_primer ?? '#d4af37' }} !important;
        background: transparent !important;
    }

    .btn-gold:hover {
        background-color: {{ $activeDesign->warna_primer ?? '#d4af37' }} !important;
        color: #1a1a1a !important;
    }

    /* Garis pemisah Logo | Nama */
    .pelanggan-navbar .brand-divider {
        display: inline-block;
        width: 1px;
        height: 20px;
        background: #ddd;
        margin: 0 10px;
        vertical-align: middle;
        flex-shrink: 0;
    }

    .pelanggan-navbar .brand-name {
        font-weight: 700;
        color: #1a1a1a;
        font-size: 1rem;
        vertical-align: middle;
        white-space: nowrap;
    }

    /* Ubah Lokasi — pill badge kecil di sebelah brand */
    .lokasi-badge {
        font-size: 0.72rem;
        font-weight: 500;
        color: #888 !important;
        border: 1px solid #ddd;
        border-radius: 20px;
        padding: 3px 10px;
        white-space: nowrap;
        transition: all 0.2s ease;
        text-decoration: none !important;
        line-height: 1.4;
        flex-shrink: 0;
    }

    .lokasi-badge:hover {
        color: {{ $activeDesign->warna_primer ?? '#d4af37' }} !important;
        border-color: {{ $activeDesign->warna_primer ?? '#d4af37' }};
    }

    @media (max-width: 991.98px) {
        .pelanggan-navbar .navbar-brand {
            font-size: 1rem !important;
            max-width: calc(100% - 70px);
            white-space: nowrap;
            overflow: hidden;
        }

        .pelanggan-navbar .navbar-collapse {
            padding-top: 8px;
            padding-bottom: 8px;
            border-top: 1px solid #f0f0f0;
        }

        .pelanggan-navbar .nav-link {
            padding-top: 0.55rem;
            padding-bottom: 0.55rem;
        }

        .pelanggan-navbar .navbar-nav .btn {
            width: 100%;
            margin-top: 6px;
        }

        .lokasi-badge {
            display: none !important;
        }
    }

    @media (max-width: 575.98px) {
        .pelanggan-navbar .container {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        .pelanggan-navbar .navbar-toggler i {
            font-size: 1.2rem !important;
        }
    }
</style>

<nav class="navbar navbar-expand-lg pelanggan-navbar">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between w-100 py-1 gap-2">

            {{-- KIRI: Logo | Nama Brand --}}
            <a href="{{ route('barbershop.home') }}" class="navbar-brand m-0 p-0 d-flex align-items-center flex-shrink-0">
                @if(isset($activeDesign) && $activeDesign->favicon)
                    <img src="{{ asset($activeDesign->favicon) }}"
                         alt="{{ $activeDesign->nama_brand ?? 'Logo' }}"
                         class="img-fluid"
                         style="max-height: 40px;">
                @else
                    <img src="{{ asset('assets/images/logo.png') }}"
                         alt="{{ $activeDesign->nama_brand ?? 'Logo' }}"
                         class="img-fluid"
                         style="max-height: 40px;">
                @endif

                {{-- Garis "|" pemisah --}}
                <span class="brand-divider d-none d-sm-inline-block"></span>

                {{-- Nama brand --}}
                <span class="brand-name d-none d-sm-inline">
                    {{ $activeDesign->nama_brand ?? '' }}
                </span>
            </a>

            {{-- TENGAH: Ubah Lokasi badge (desktop only) --}}
            <a href="{{ route('home') }}" class="lokasi-badge d-none d-lg-inline-flex align-items-center gap-1">
                <i class="fas fa-map-marker-alt me-1" style="color: {{ $activeDesign->warna_primer ?? '#d4af37' }};"></i>
                {{ session('current_barbershop_nama') ?? 'Pilih Lokasi' }}
            </a>

            {{-- Mobile toggler --}}
            <button class="navbar-toggler ms-auto" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav"
                aria-controls="navbarNav"
                aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav gap-lg-4 text-center mt-3 mt-lg-0">

                <li class="nav-item">
                    <a class="nav-link fw-bold {{ request()->routeIs('barbershop.home') ? 'active' : '' }}"
                        href="{{ route('barbershop.home') }}">
                        Beranda
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link fw-bold {{ request()->routeIs('antrean') ? 'active' : '' }}"
                        href="{{ route('antrean') }}">
                        Antrean
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link fw-bold {{ request()->routeIs('pelanggan.layanan') ? 'active' : '' }}"
                        href="{{ route('pelanggan.layanan') }}">
                        Layanan
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link fw-bold {{ request()->routeIs('rekomendasi.index') ? 'active' : '' }}"
                        href="{{ route('rekomendasi.index') }}">
                        Rekomendasi
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link fw-bold {{ request()->routeIs('galeri') ? 'active' : '' }}"
                        href="{{ route('galeri') }}">
                        Galeri
                    </a>
                </li>

                @if($activeDesign->is_cafe_active ?? true)
                <li class="nav-item">
                    <a class="nav-link fw-bold {{ request()->routeIs('menu') ? 'active' : '' }}"
                        href="{{ route('menu') }}">
                        Menu Café
                    </a>
                </li>
                @endif

                {{-- Ubah Lokasi — mobile only (dalam collapse) --}}
                <li class="nav-item d-lg-none">
                    <a class="nav-link fw-bold" href="{{ route('home') }}"
                        style="color: #888 !important; font-size: 0.85rem;">
                        <i class="fas fa-map-marker-alt me-1"
                           style="color: {{ $activeDesign->warna_primer ?? '#d4af37' }};"></i>
                        Ubah Lokasi
                    </a>
                </li>

                @guest
                    <li class="nav-item d-flex align-items-center justify-content-center">
                        <a href="{{ route('login.user') }}" class="btn btn-sm fw-bold px-3"
                            style="background-color: {{ $activeDesign->warna_primer ?? '#d4af37' }}; color: #1a1a1a; border-radius: 8px;">
                            Masuk
                        </a>
                    </li>
                @endguest

                @auth
                    <li class="nav-item d-flex align-items-center justify-content-center">
                        @if (auth()->user()->hasRole('admin'))
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-gold">
                                Dasbor Admin
                            </a>
                        @else
                            <div class="d-flex gap-2 align-items-center">
                                <a href="{{ route('profile.index') }}" class="btn btn-sm btn-gold">
                                    Profil
                                </a>
                                <form action="{{ route('logout') }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        @endif
                    </li>
                @endauth

            </ul>
        </div>
    </div>
</nav>
