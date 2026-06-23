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
        color: <?php echo e($activeBarbershop->warna_primer ?? '#d4af37'); ?> !important;
        background-color: <?php echo e($activeBarbershop->warna_primer ?? '#d4af37'); ?>14 !important;
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

    .pelanggan-navbar .navbar-nav a[href*="login"] {
        background-color: <?php echo e($activeBarbershop->warna_primer ?? '#d4af37'); ?> !important;
        color: #ffffff !important;
        border: 1px solid <?php echo e($activeBarbershop->warna_primer ?? '#d4af37'); ?> !important;
    }

    .pelanggan-navbar .navbar-nav a[href*="login"]:hover {
        background-color: <?php echo e($activeBarbershop->warna_primer ?? '#d4af37'); ?>e6 !important;
        border-color: <?php echo e($activeBarbershop->warna_primer ?? '#d4af37'); ?>e6 !important;
    }

    .pelanggan-navbar .navbar-nav a[href*="profile"],
    .pelanggan-navbar .navbar-nav button[type="submit"] {
        color: <?php echo e($activeBarbershop->warna_primer ?? '#d4af37'); ?> !important;
        border: 1px solid <?php echo e($activeBarbershop->warna_primer ?? '#d4af37'); ?> !important;
        background: transparent !important;
    }

    .pelanggan-navbar .navbar-nav a[href*="profile"]:hover,
    .pelanggan-navbar .navbar-nav button[type="submit"]:hover {
        background-color: <?php echo e($activeBarbershop->warna_primer ?? '#d4af37'); ?> !important;
        color: #ffffff !important;
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

        .brand-text {
            font-size: 0.85rem !important;
            padding: 0.4rem 0.6rem !important;
        }
    }

    .brand-text {
        font-family: 'Outfit', sans-serif;
        font-weight: 600;
        font-size: 0.92rem;
        color: #2b2b2b !important;
        padding: 0.5rem 0.75rem !important;
        border-radius: 6px;
        transition: all 0.2s ease;
        white-space: nowrap !important;
        display: inline-block;
    }

    .brand-text:hover {
        color: <?php echo e($activeBarbershop->warna_primer ?? '#d4af37'); ?> !important;
        background-color: <?php echo e($activeBarbershop->warna_primer ?? '#d4af37'); ?>14 !important;
    }

</style>

<nav class="navbar navbar-expand-lg pelanggan-navbar">
    <div class="container">
        <div class="d-flex align-items-center justify-content-between w-100 py-2">
            <a href="<?php echo e(route('barbershop.home', ['slug' => $activeBarbershop->slug ?? 'arga-barbershop'])); ?>" class="navbar-brand m-0 p-0 d-flex align-items-center gap-2">
                <?php if(isset($activeBarbershop) && $activeBarbershop->favicon): ?>
                    <img src="<?php echo e(asset($activeBarbershop->favicon)); ?>" alt="<?php echo e($activeBarbershop->nama_brand ?? 'Arga Home\'s Logo'); ?>" class="img-fluid" style="max-height: 40px;">
                <?php else: ?>
                    <img src="<?php echo e(asset('assets/images/logo.png')); ?>" alt="<?php echo e($activeBarbershop->nama_brand ?? 'Arga Home\'s Logo'); ?>" class="img-fluid" style="max-height: 40px;">
                <?php endif; ?>
                <span class="brand-text"><?php echo e($activeBarbershop->nama_brand ?? 'Arga Barbershop'); ?></span>
            </a>

            
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
                    <a class="nav-link fw-bold <?php echo e(request()->routeIs('barbershop.home') ? 'active' : ''); ?>"
                        href="<?php echo e(route('barbershop.home', ['slug' => $activeBarbershop->slug ?? 'arga-barbershop'])); ?>">
                        Beranda
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link fw-bold <?php echo e(request()->routeIs('antrean') ? 'active' : ''); ?>"
                        href="<?php echo e(route('antrean', ['slug' => $activeBarbershop->slug ?? 'arga-barbershop'])); ?>">
                        Antrean
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link fw-bold <?php echo e(request()->routeIs('pelanggan.layanan') ? 'active' : ''); ?>"
                        href="<?php echo e(route('pelanggan.layanan', ['slug' => $activeBarbershop->slug ?? 'arga-barbershop'])); ?>">
                        Layanan
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link fw-bold <?php echo e(request()->routeIs('rekomendasi.index') ? 'active' : ''); ?>"
                        href="<?php echo e(route('rekomendasi.index', ['slug' => $activeBarbershop->slug ?? 'arga-barbershop'])); ?>">
                        Rekomendasi
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link fw-bold <?php echo e(request()->routeIs('galeri') ? 'active' : ''); ?>"
                        href="<?php echo e(route('galeri', ['slug' => $activeBarbershop->slug ?? 'arga-barbershop'])); ?>">
                        Galeri
                    </a>
                </li>

                <?php if(auth()->guard()->guest()): ?>
                    <li class="nav-item d-flex align-items-center justify-content-center">
                        <a href="<?php echo e(route('login.user')); ?>" class="btn btn-sm fw-bold px-3"
                            style="background-color: <?php echo e($activeBarbershop->warna_primer ?? '#d4af37'); ?>; color: #1a1a1a; border-radius: 8px;">
                            Masuk
                        </a>
                    </li>
                <?php endif; ?>

                <?php if(auth()->guard()->check()): ?>
                    <li class="nav-item d-flex align-items-center justify-content-center">
                        <?php if(auth()->user()->hasRole('admin')): ?>
                            <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-sm btn-gold">
                                Dasbor Admin
                            </a>
                        <?php else: ?>
                            <div class="d-flex gap-2 align-items-center">
                                <a href="<?php echo e(route('profile.index')); ?>" class="btn btn-sm btn-gold">
                                    Profil
                                </a>
                                <form action="<?php echo e(route('logout')); ?>" method="POST" class="m-0">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </li>
                <?php endif; ?>

                <li class="nav-item">
                    <a class="nav-link fw-bold" href="<?php echo e(route('home')); ?>">
                        <i class="fas fa-map-marker-alt me-1" style="color: <?php echo e($activeBarbershop->warna_primer ?? '#d4af37'); ?>;"></i>
                        Lihat Lokasi Lain
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>
<?php /**PATH D:\s6\pa 3\pa_3v3\Kelompok-2-PA-3\resources\views\pelanggan\partials\navbar.blade.php ENDPATH**/ ?>