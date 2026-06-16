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
    }

    .pelanggan-navbar .nav-link:hover,
    .pelanggan-navbar .nav-link.active {
        color: #cc7c1b !important;
        background-color: rgba(204, 124, 27, 0.08);
    }

    .pelanggan-navbar .navbar-toggler {
        padding: 0;
        line-height: 1;
        color: #1a1a1a !important;
        background: transparent !important;
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

    .pelanggan-navbar .navbar-nav a[href*="login"] {
        background-color: #d5913e !important;
        color: #ffffff !important;
        border: 1px solid #d5913e !important;
    }

    .pelanggan-navbar .navbar-nav a[href*="login"]:hover {
        background-color: #b37e33 !important;
        border-color: #b37e33 !important;
    }

    .pelanggan-navbar .navbar-nav a[href*="profile"],
    .pelanggan-navbar .navbar-nav button[type="submit"] {
        color: #cc7c1b !important;
        border: 1px solid #cc7c1b !important;
        background: transparent !important;
    }

    .pelanggan-navbar .navbar-nav a[href*="profile"]:hover,
    .pelanggan-navbar .navbar-nav button[type="submit"]:hover {
        background-color: #cc7c1b !important;
        color: #ffffff !important;
    }

    @media (max-width: 991.98px) {
        .pelanggan-navbar .navbar-brand {
            font-size: 1rem !important;
            max-width: calc(100% - 70px);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .pelanggan-navbar .navbar-collapse {
            padding-top: 8px;
            padding-bottom: 8px;
        }

        .pelanggan-navbar .nav-link {
            padding-top: 0.55rem;
            padding-bottom: 0.55rem;
        }

        .pelanggan-navbar .navbar-nav .btn {
            width: 100%;
            margin-top: 6px;
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

<nav class="navbar navbar-expand-lg pelanggan-navbar"
    style="background-color: #1a1a1a; box-shadow: 0 2px 10px rgba(0,0,0,0.5);">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between w-100 py-2">
            <a href="{{ route('home') }}" class="navbar-brand m-0 p-0 d-flex align-items-center gap-2">
                @if(isset($activeDesign) && $activeDesign->favicon)
                    <img src="{{ asset($activeDesign->favicon) }}" alt="{{ $activeDesign->nama_brand ?? 'Arga Home\'s Logo' }}" class="img-fluid " style="max-height: 40px;">
                @else
                    <img src="{{ asset('assets/images/logo.png') }}" alt="{{ $activeDesign->nama_brand ?? 'Arga Home\'s Logo' }}" class="img-fluid " style="max-height: 40px;">
                @endif
                <span style="font-weight: 700; color: #fff; font-size: 1.2rem; display: none;" class="d-none d-sm-block">{{ $activeDesign->nama_brand ?? '' }}</span>
            </a>

            <button class="navbar-toggler text-white border-0 shadow-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav gap-lg-4 text-center mt-3 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link fw-bold {{ request()->routeIs('home') ? 'active' : '' }}"
                        href="{{ route('home') }}"
                        style="color: {{ request()->routeIs('home') ? '#d4af37' : 'white' }}; transition: color 0.3s ease;"
                        onmouseover="this.style.color='#d4af37'"
                        onmouseout="this.style.color='{{ request()->routeIs('home') ? '#d4af37' : 'white' }}'">
                        Beranda
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold {{ request()->routeIs('antrean') ? 'active' : '' }}"
                        href="{{ route('antrean') }}"
                        style="color: {{ request()->routeIs('antrean') ? '#d4af37' : 'white' }}; transition: color 0.3s ease;"
                        onmouseover="this.style.color='#d4af37'"
                        onmouseout="this.style.color='{{ request()->routeIs('antrean') ? '#d4af37' : 'white' }}'">
                        Antrean
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold {{ request()->routeIs('pelanggan.layanan') ? 'active' : '' }}"
                        href="{{ route('pelanggan.layanan') }}"
                        style="color: {{ request()->routeIs('pelanggan.layanan') ? '#d4af37' : 'white' }}; transition: color 0.3s ease;"
                        onmouseover="this.style.color='#d4af37'"
                        onmouseout="this.style.color='{{ request()->routeIs('pelanggan.layanan') ? '#d4af37' : 'white' }}'">
                        Layanan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold {{ request()->routeIs('rekomendasi.index') ? 'active' : '' }}"
                        href="{{ route('rekomendasi.index') }}"
                        style="color: {{ request()->routeIs('rekomendasi.index') ? '#d4af37' : 'white' }}; transition: color 0.3s ease;"
                        onmouseover="this.style.color='#d4af37'"
                        onmouseout="this.style.color='{{ request()->routeIs('rekomendasi.index') ? '#d4af37' : 'white' }}'">
                        Rekomendasi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold {{ request()->routeIs('galeri') ? 'active' : '' }}"
                        href="{{ route('galeri') }}"
                        style="color: {{ request()->routeIs('galeri') ? '#d4af37' : 'white' }}; transition: color 0.3s ease;"
                        onmouseover="this.style.color='#d4af37'"
                        onmouseout="this.style.color='{{ request()->routeIs('galeri') ? '#d4af37' : 'white' }}'">
                        Galeri
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold {{ request()->routeIs('menu') ? 'active' : '' }}"
                        href="{{ route('menu') }}"
                        style="color: {{ request()->routeIs('menu') ? '#d4af37' : 'white' }}; transition: color 0.3s ease; white-space: nowrap;"
                        onmouseover="this.style.color='#d4af37'"
                        onmouseout="this.style.color='{{ request()->routeIs('menu') ? '#d4af37' : 'white' }}'">
                        Menu Café
                    </a>
                </li>


                @guest
                    <li class="nav-item d-flex align-items-center justify-content-center">
                        <a href="{{ route('login.user') }}" class="btn btn-sm fw-bold px-3"
                            style="background-color: #d4af37; color: #1a1a1a; border-radius: 8px;">
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
