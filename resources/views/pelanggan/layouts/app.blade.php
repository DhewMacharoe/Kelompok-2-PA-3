<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $activeBarbershop->nama_brand ?? 'Arga Home\'s')</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v={{ time() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Leaflet CSS untuk Queue Location Map -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />

    <!-- PWA Manifest -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#fdfbf8"> <!-- Sesuaikan dengan warna brand Anda -->
    <!-- iOS PWA Meta Tags -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Arga Barbershop">
    <link rel="apple-touch-icon" href="{{ isset($activeBarbershop) && $activeBarbershop->favicon ? asset($activeBarbershop->favicon) : asset('assets/images/logo.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/js/app.js'])

    @if(isset($activeBarbershop) && $activeBarbershop->warna_primer)
    <style>
        :root {
            --accent-gold: {{ $activeBarbershop->warna_primer }} !important;
            --gold: {{ $activeBarbershop->warna_primer }} !important;
            --primary: {{ $activeBarbershop->warna_primer }} !important;
        }
    </style>
    @endif

    @stack('styles')

    @if(isset($activeBarbershop) && $activeBarbershop->warna_primer)
    <style>
        /* Background & Borders */
        .btn-primary, .bg-primary, .btn-submit, .btn-edit-profile, .btn-tambah,
        .btn-gold, .btn-gold-accent, .bg-gold-accent, .border-gold-accent,
        .hero-cta-btn, .service-icon-wrapper, .btn-buat-antrean-layanan {
            background-color: {{ $activeBarbershop->warna_primer }} !important;
            border-color: {{ $activeBarbershop->warna_primer }} !important;
        }
        
        .btn-buat-antrean-layanan {
            background: {{ $activeBarbershop->warna_primer }} !important;
            box-shadow: 0 4px 12px {{ $activeBarbershop->warna_primer }}4d !important;
        }
        
        /* Hover Background & Borders */
        .btn-gold-accent:hover, .hero-cta-btn:hover, .btn-buat-antrean-layanan:hover {
            background-color: {{ $activeBarbershop->warna_primer }}e6 !important;
            border-color: {{ $activeBarbershop->warna_primer }}e6 !important;
            background: {{ $activeBarbershop->warna_primer }}e6 !important;
            box-shadow: 0 6px 18px {{ $activeBarbershop->warna_primer }}73 !important;
        }
        
        /* Text & Icons */
        .text-gold, .icon-gold, .text-primary, .text-gold-accent, .queue-large-val-gold,
        .service-price-text, .detail-modal-price, .footer-custom h5, .footer-custom .icon-gold,
        .hero-divider-text, .hero-subtitle, .footer-custom a:hover, .layanan-price, .modal-price,
        .modal-back:hover, .btn-back-bottom:hover {
            color: {{ $activeBarbershop->warna_primer }} !important;
        }
        
        #btn-cancel-my-queue {
            border-color: {{ $activeBarbershop->warna_primer }} !important;
            color: {{ $activeBarbershop->warna_primer }} !important;
            background: transparent !important;
        }
        
        #btn-cancel-my-queue:hover {
            background: {{ $activeBarbershop->warna_primer }} !important;
            color: #ffffff !important;
        }
        
        .btn-back-bottom:hover, .modal-back:hover {
            border-color: {{ $activeBarbershop->warna_primer }} !important;
        }

        #layananDetailModal .modal-image-wrapper {
            color: {{ $activeBarbershop->warna_primer }} !important;
            background-color: {{ $activeBarbershop->warna_primer }}14 !important;
        }
        
        .hero-divider-line {
            background-color: {{ $activeBarbershop->warna_primer }} !important;
        }
        
        .footer-custom {
            border-top-color: {{ $activeBarbershop->warna_primer }} !important;
        }
        
        /* Cards hover border */
        .menu-grid-card:hover {
            border-color: {{ $activeBarbershop->warna_primer }} !important;
        }
        .menu-grid-card:hover .menu-grid-icon,
        .menu-grid-card:hover .menu-grid-text {
            color: {{ $activeBarbershop->warna_primer }} !important;
        }
        .service-custom-card:hover {
            border-color: {{ $activeBarbershop->warna_primer }} !important;
        }
        
        /* Navbar custom styles overrides */
        .pelanggan-navbar .nav-link:hover,
        .pelanggan-navbar .nav-link.active {
            color: {{ $activeBarbershop->warna_primer }} !important;
            background-color: {{ $activeBarbershop->warna_primer }}14 !important;
        }
        .pelanggan-navbar .navbar-nav a[href*="login"] {
            background-color: {{ $activeBarbershop->warna_primer }} !important;
            border-color: {{ $activeBarbershop->warna_primer }} !important;
        }
        .pelanggan-navbar .navbar-nav a[href*="login"]:hover {
            background-color: {{ $activeBarbershop->warna_primer }}e6 !important;
            border-color: {{ $activeBarbershop->warna_primer }}e6 !important;
        }
        .pelanggan-navbar .navbar-nav a[href*="profile"],
        .pelanggan-navbar .navbar-nav button[type="submit"] {
            color: {{ $activeBarbershop->warna_primer }} !important;
            border-color: {{ $activeBarbershop->warna_primer }} !important;
        }
        .pelanggan-navbar .navbar-nav a[href*="profile"]:hover,
        .pelanggan-navbar .navbar-nav button[type="submit"]:hover {
            background-color: {{ $activeBarbershop->warna_primer }} !important;
            color: #ffffff !important;
        }
        

        
        /* Gallery Page Overrides */
        .galeri-line {
            background-color: {{ $activeBarbershop->warna_primer }} !important;
        }
        .galeri-card:hover {
            border-color: {{ $activeBarbershop->warna_primer }} !important;
        }
    </style>
    @endif

    <style>
        /* =========================================
           GLOBAL STYLES
           ========================================= */
        html,
        body {
            display: flex;
            flex-direction: column;
            font-family: 'Outfit', sans-serif;
            background-color: #fcfcfc !important; /* Latar belakang abu-abu sangat terang mirip putih */
            color: #1a1a1a;
        }

        main {
            flex: 1;
        }

        .sticky-header-wrapper {
            position: sticky;
            top: 0;
            z-index: 1030;
            width: 100%;
        }

        /* =========================================
           FOOTER STYLES
           ========================================= */
        .footer-custom {
            background-color: #1a1a1a;
            color: #d1d1d1;
            padding: 50px 0 20px;
            border-top: 3px solid #e8a53a;
        }

        .footer-custom h5 {
            color: #e8a53a;
            font-weight: 700;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 1.1rem;
        }

        .footer-list {
            line-height: 1.6;
        }

        .footer-list li {
            margin-bottom: 12px;
            font-size: 0.95rem;
        }

        .footer-custom a {
            color: #d1d1d1;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-custom a:hover {
            color: #e8a53a;
        }

        .footer-custom .icon-gold {
            color: #e8a53a;
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .map-container {
            border-radius: 12px;
            overflow: hidden;
            border: 2px solid #333;
            height: 150px;
        }

        .footer-bottom {
            background-color: #151515;
            padding: 15px 0;
            margin-top: 40px;
            text-align: center;
            font-size: 0.9rem;
            color: #888;
        }
    </style>
</head>

<body>

    <div class="sticky-header-wrapper">
        @include('pelanggan.partials.navbar')
    </div>

    <main style="min-height: 60vh">
        @yield('content')
    </main>

    <footer class="footer-custom">
        <div class="container">
            <div class="row gy-4">

                <div class="col-lg-3 col-md-6">
                    <h5 class="mb-3 d-flex align-items-center">
                        <i class="fas fa-cut me-2" style="color:#e8a53a;"></i> {{ strtoupper($activeBarbershop->nama_brand ?? "ARGA HOME'S") }}
                    </h5>
                    <p style="font-size: 0.95rem; line-height: 1.6;">
                        {{ $activeDesign->deskripsi_hero ?? 'Tempat pangkas rambut premium dengan layanan walk-in queue. Dapatkan pengalaman grooming terbaik!' }}
                    </p>
                    <div class="mt-3">
                        @if(isset($activeBarbershop) && isset($activeBarbershop->kontak['instagram']))
                            <a href="{{ $activeBarbershop->kontak['instagram'] }}" target="_blank" class="me-3 fs-5"><i class="fab fa-instagram"></i></a>
                        @else
                            <a href="#" class="me-3 fs-5"><i class="fab fa-instagram"></i></a>
                        @endif
                        
                        @if(isset($activeBarbershop) && isset($activeBarbershop->kontak['facebook']))
                            <a href="{{ $activeBarbershop->kontak['facebook'] }}" target="_blank" class="me-3 fs-5"><i class="fab fa-facebook"></i></a>
                        @else
                            <a href="#" class="me-3 fs-5"><i class="fab fa-facebook"></i></a>
                        @endif
                        
                        @if(isset($activeBarbershop) && isset($activeBarbershop->kontak['whatsapp']))
                            @php
                                $wa = preg_replace('/[^0-9]/', '', $activeBarbershop->kontak['whatsapp']);
                                if(str_starts_with($wa, '0')) $wa = '62' . substr($wa, 1);
                            @endphp
                            <a href="https://wa.me/{{ $wa }}" target="_blank" class="fs-5"><i class="fab fa-whatsapp"></i></a>
                        @else
                            <a href="#" class="fs-5"><i class="fab fa-whatsapp"></i></a>
                        @endif
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5>Jam Buka</h5>
                    <ul class="list-unstyled footer-list">
                        <li>
                            <i class="fas fa-clock icon-gold"></i> 
                            <strong>Senin - Jumat:</strong><br>
                            <span style="margin-left: 30px; display:inline-block;">10:00 - 21:00</span>
                        </li>
                        <li>
                            <i class="fas fa-clock icon-gold"></i> 
                            <strong>Sabtu - Minggu:</strong><br>
                            <span style="margin-left: 30px; display:inline-block;">09:00 - 22:00</span>
                        </li>
                        @php
                            $liburStatus = \App\Models\Setting::get('queue_libur_note', 'libur');
                        @endphp
                        @if($liburStatus === 'buka')
                            <li class="text-success mt-2">
                                <i class="fas fa-check-circle text-success icon-gold"></i> 
                                Tetap Buka pada Hari Raya
                            </li>
                        @else
                            <li class="text-danger mt-2">
                                <i class="fas fa-info-circle text-danger icon-gold"></i> 
                                Libur pada Hari Raya
                            </li>
                        @endif
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5>Hubungi Kami</h5>
                    <ul class="list-unstyled footer-list">
                        <li class="d-flex align-items-start">
                            <i class="fas fa-map-marker-alt icon-gold mt-1"></i> 
                            <span>{{ $activeBarbershop->alaamat ?? 'Jl.P.Siantar Km 2, Tampubolon, Sibolahotangaso Kec. Balige, Tobasa, Sumatera Utara' }}</span>
                        </li>
                        <li><i class="fas fa-phone-alt icon-gold"></i> {{ isset($activeBarbershop) && isset($activeBarbershop->kontak['whatsapp']) ? $activeBarbershop->kontak['whatsapp'] : '0821-6789-3019' }}</li>
                        <li><i class="fas fa-envelope icon-gold"></i> {{ $activeBarbershop->email ?? 'joebarberid@gmail.com' }}</li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5>Lokasi Kami</h5>
                    @php
                        $latitude = \App\Models\Setting::get('queue_latitude', 2.33758);
                        $longitude = \App\Models\Setting::get('queue_longitude', 99.079255);
                    @endphp
                    <div class="map-container mb-2">
                        <iframe src="https://maps.google.com/maps?q={{ $latitude }},{{ $longitude }}&z=15&output=embed" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <a id="footer-maps-btn" href="https://www.google.com/maps/search/?api=1&query={{ $latitude }},{{ $longitude }}" target="_blank" class="btn btn-outline-light w-100 d-flex align-items-center justify-content-center gap-2" style="border-color: #444; font-size: 0.85rem; border-radius: 6px;">
                        Lihat di Maps <i class="fas fa-external-link-alt" style="color: {{ $activeBarbershop->warna_primer ?? '#e8a53a' }};"></i>
                    </a>
                </div>

            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <p class="mb-0">&copy; {{ date('Y') }} {{ $activeBarbershop->nama_brand ?? "Arga Home's" }} Barbershop. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form');

            forms.forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    setTimeout(() => {
                        if (event.defaultPrevented) return;
                        const submitButtons = form.querySelectorAll('button[type="submit"]');

                        submitButtons.forEach(function(button) {
                            if (!button.closest('.navbar') && !button.closest('nav')) {
                                const originalText = button.textContent.trim();
                                const loadingText = button.dataset.loadingText ||
                                    'Memproses...';

                                button.disabled = true;
                                button.textContent = loadingText;
                                button.dataset.originalText = originalText;
                            }
                        });
                    }, 0);
                });
            });
        });
    </script>
        <!-- PWA Service Worker & Install Handler -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js').then(function(registration) {
                    console.log('ServiceWorker registration successful with scope: ', registration.scope);

                    // Monitor Service Worker updates
                    registration.addEventListener('updatefound', () => {
                        const newWorker = registration.installing;
                        if (newWorker) {
                            newWorker.addEventListener('statechange', () => {
                                if (newWorker.state === 'installed') {
                                    if (navigator.serviceWorker.controller) {
                                        // New SW version is available, prompt user using SweetAlert2
                                        if (typeof Swal !== 'undefined') {
                                            Swal.fire({
                                                title: 'Pembaruan Tersedia!',
                                                text: 'Versi baru aplikasi telah diunduh. Silakan muat ulang halaman untuk mengaktifkan fitur terbaru.',
                                                icon: 'info',
                                                showCancelButton: true,
                                                confirmButtonColor: '{{ $activeBarbershop->warna_primer ?? "#d4af37" }}',
                                                cancelButtonColor: '#6c757d',
                                                confirmButtonText: 'Muat Ulang',
                                                cancelButtonText: 'Nanti'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    window.location.reload();
                                                }
                                            });
                                        } else {
                                            if (confirm('Versi baru aplikasi tersedia. Muat ulang sekarang?')) {
                                                window.location.reload();
                                            }
                                        }
                                    }
                                }
                            });
                        }
                    });
                }, function(err) {
                    console.log('ServiceWorker registration failed: ', err);
                });
            });
        }


    </script>


    <!-- Leaflet JS untuk Queue Location Map (must load before module scripts) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')
</body>

</html>
