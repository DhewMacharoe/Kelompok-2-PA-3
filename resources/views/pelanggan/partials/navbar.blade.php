<nav class="navbar navbar-expand-lg" style="background-color: #1a1a1a; box-shadow: 0 2px 10px rgba(0,0,0,0.5);">
    <div class="container">
        <a class="navbar-brand text-decoration-none d-flex align-items-center gap-2" href="{{ route('home') }}"
            style="color: #d4af37; font-weight: bold; font-size: 1.3rem;">
            <i class="fas fa-scissors"></i> Arga's Home
        </a>

        <button class="navbar-toggler text-white border-0" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars fs-1"></i>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav gap-lg-4 text-center mt-3 mt-lg-0">
                <li class="nav-item">
<<<<<<< Updated upstream
                    <a class="nav-link fw-bold {{ request()->routeIs('home') ? 'active' : '' }}" 
                        href="{{ route('home') }}" 
                        style="color: {{ request()->routeIs('home') ? '#d4af37' : 'white' }}; transition: color 0.3s ease;"
                        onmouseover="this.style.color='#d4af37'" 
                        onmouseout="this.style.color='{{ request()->routeIs('home') ? '#d4af37' : 'white' }}'">
                        Beranda
                    </a>
=======
                    <a class="nav-link active fw-bold"  href="#" style="color: #d4af37;">Beranda</a>
>>>>>>> Stashed changes
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold {{ request()->routeIs('layanan') ? 'active' : '' }}" 
                        href="{{ route('layanan') }}"
                        style="color: {{ request()->routeIs('layanan') ? '#d4af37' : 'white' }}; transition: color 0.3s ease;"
                        onmouseover="this.style.color='#d4af37'" 
                        onmouseout="this.style.color='{{ request()->routeIs('layanan') ? '#d4af37' : 'white' }}'">
                        Layanan
                    </a>
                </li>
                <li class="nav-item">
<<<<<<< Updated upstream
                    <a class="nav-link fw-bold {{ request()->routeIs('antrian') ? 'active' : '' }}" 
                        href="{{ route('antrian') }}"
                        style="color: {{ request()->routeIs('antrian') ? '#d4af37' : 'white' }}; transition: color 0.3s ease;"
                        onmouseover="this.style.color='#d4af37'" 
                        onmouseout="this.style.color='{{ request()->routeIs('antrian') ? '#d4af37' : 'white' }}'">
                        Antrian
                    </a>
=======
                    <a class="nav-link text-white" href="{{ route('antrian') }}">Antrian</a>
>>>>>>> Stashed changes
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-bold {{ request()->routeIs('rekomendasi') ? 'active' : '' }}" 
                        href="{{ route('rekomendasi') }}"
                        style="color: {{ request()->routeIs('rekomendasi') ? '#d4af37' : 'white' }}; transition: color 0.3s ease;"
                        onmouseover="this.style.color='#d4af37'" 
                        onmouseout="this.style.color='{{ request()->routeIs('rekomendasi') ? '#d4af37' : 'white' }}'">
                        Gaya Rambut
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
                        Menu Cafe
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
