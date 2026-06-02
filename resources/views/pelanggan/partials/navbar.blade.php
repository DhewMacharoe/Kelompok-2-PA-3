@include('pelanggan.shared.style-common')

<nav class="navbar navbar-expand-lg pelanggan-navbar">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between w-100 py-2">
            <a href="{{ route('home') }}" class="navbar-brand m-0 p-0 d-flex align-items-center">
                <img src="{{ asset('assets/images/favicon.png') }}" alt="Arga Home's Logo" class="img-fluid navbar-logo">
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
                    <a class="nav-link fw-bold nav-link-gold {{ request()->routeIs('home') ? 'is-active' : '' }}"
                        href="{{ route('home') }}">
                        Beranda
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold nav-link-gold {{ request()->routeIs('antrean') ? 'is-active' : '' }}"
                        href="{{ route('antrean') }}">
                        Antrean
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold nav-link-gold {{ request()->routeIs('pelanggan.layanan') ? 'is-active' : '' }}"
                        href="{{ route('pelanggan.layanan') }}">
                        Layanan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold nav-link-gold {{ request()->routeIs('rekomendasi.index') ? 'is-active' : '' }}"
                        href="{{ route('rekomendasi.index') }}">
                        Rekomendasi
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold nav-link-gold {{ request()->routeIs('galeri') ? 'is-active' : '' }}"
                        href="{{ route('galeri') }}">
                        Galeri
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold nav-link-gold {{ request()->routeIs('menu') ? 'is-active' : '' }}"
                        href="{{ route('menu') }}">
                        Menu Kafe
                    </a>
                </li>

                @guest
                    <li class="nav-item d-flex align-items-center justify-content-center">
                        <a href="{{ route('login.user') }}" class="btn btn-sm fw-bold px-3 btn-gold-solid">
                            Masuk
                        </a>
                    </li>
                @endguest

                @auth
                    <li class="nav-item d-flex align-items-center justify-content-center">
                        @if (auth()->user()->hasRole('admin'))
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm fw-bold px-3 btn-gold-outline">
                                Dashboard Admin
                            </a>
                        @else
                            <div class="d-flex gap-2 align-items-center">
                                <a href="{{ route('profile.edit') }}" class="btn btn-sm fw-bold px-3 btn-gold-outline">
                                    Profil Saya
                                </a>
                                <form action="{{ route('logout') }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="btn btn-sm fw-bold px-3 btn-gold-outline">
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
