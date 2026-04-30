<style>
    .pelanggan-navbar .navbar-brand img {
        height: 32px;
        width: auto;
        display: block;
    }

    .pelanggan-navbar .navbar-toggler {
        padding: 0;
        line-height: 1;
    }

    .pelanggan-navbar .navbar-toggler i {
        font-size: 1.35rem;
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

<nav class="navbar navbar-expand-lg pelanggan-navbar fixed-top"
    style="background-color: #1a1a1a; box-shadow: 0 2px 10px rgba(0,0,0,0.5);">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between w-100 py-2">
            <a href="{{ route('home') }}" class="navbar-brand m-0 p-0 d-flex align-items-center">
                <img src="{{ asset('assets/images/favicon.png') }}" alt="Arga Home's Logo" class="img-fluid "
                    style="max-height: 40px;">
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
                    <a class="nav-link fw-bold {{ request()->routeIs('rekomendasi') ? 'active' : '' }}"
                        href="{{ route('rekomendasi') }}"
                        style="color: {{ request()->routeIs('rekomendasi') ? '#d4af37' : 'white' }}; transition: color 0.3s ease;"
                        onmouseover="this.style.color='#d4af37'"
                        onmouseout="this.style.color='{{ request()->routeIs('rekomendasi') ? '#d4af37' : 'white' }}'">
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
                        style="color: {{ request()->routeIs('menu') ? '#d4af37' : 'white' }}; transition: color 0.3s ease;"
                        onmouseover="this.style.color='#d4af37'"
                        onmouseout="this.style.color='{{ request()->routeIs('menu') ? '#d4af37' : 'white' }}'">
                        Café
                    </a>
                </li>

                @guest
                    <li class="nav-item d-flex align-items-center justify-content-center">
                        <a href="{{ route('login.user') }}" class="btn btn-sm fw-bold px-3"
                            style="background-color: #d4af37; color: #1a1a1a; border-radius: 8px;">
                            Login
                        </a>
                    </li>
                @endguest

                @auth
                    <li class="nav-item d-flex align-items-center justify-content-center">
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-sm fw-bold px-3"
                                style="background-color: transparent; color: #d4af37; border: 1px solid #d4af37; border-radius: 8px;">
                                Logout
                            </button>
                        </form>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
