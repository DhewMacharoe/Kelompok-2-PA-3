<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Arga Home\'s')</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

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
    <link rel="apple-touch-icon" href="{{ asset('assets/images/logo.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/js/app.js'])

    @stack('styles')

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
                        <i class="fas fa-cut me-2" style="color:#e8a53a;"></i> ARGA HOME'S
                    </h5>
                    <p style="font-size: 0.95rem; line-height: 1.6;">
                        Tempat pangkas rambut premium dengan layanan walk-in queue. Dapatkan pengalaman grooming terbaik!
                    </p>
                    <div class="mt-3">
                        <a href="#" class="me-3 fs-5"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="me-3 fs-5"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="fs-5"><i class="fab fa-whatsapp"></i></a>
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
                        <li class="text-danger mt-2">
                            <i class="fas fa-info-circle text-danger icon-gold"></i> 
                            Libur pada Hari Raya
                        </li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5>Hubungi Kami</h5>
                    <ul class="list-unstyled footer-list">
                        <li class="d-flex align-items-start">
                            <i class="fas fa-map-marker-alt icon-gold mt-1"></i> 
                            <span>Jl.P.Siantar Km 2, Tampubolon, Sibolahotangaso Kec. Balige, Tobasa, Sumatera Utara</span>
                        </li>
                        <li><i class="fas fa-phone-alt icon-gold"></i> 0821-6789-3019</li>
                        <li><i class="fas fa-envelope icon-gold"></i> joebarberid@gmail.com</li>
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
                        Lihat di Maps <i class="fas fa-external-link-alt" style="color: #e8a53a;"></i>
                    </a>
                </div>

            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <p class="mb-0">&copy; {{ date('Y') }} Arga Home's Barbershop & Cafe. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form');

            forms.forEach(function(form) {
                form.addEventListener('submit', function() {
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
                });
            });
        });
    </script>
        <!-- PWA Service Worker & Install Handler -->
    <script>
        let deferredPrompt;

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
                                                confirmButtonColor: '#d4af37',
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

        // Capture PWA installation prompt event
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            const installBtnContainer = document.getElementById('install-pwa-nav');
            if (installBtnContainer) {
                installBtnContainer.style.setProperty('display', 'flex', 'important');
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            const installBtn = document.getElementById('install-pwa-btn');
            if (installBtn) {
                installBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    if (!deferredPrompt) return;
                    deferredPrompt.prompt();
                    deferredPrompt.userChoice.then((choiceResult) => {
                        if (choiceResult.outcome === 'accepted') {
                            console.log('User accepted the PWA install prompt');
                        } else {
                            console.log('User dismissed the PWA install prompt');
                        }
                        deferredPrompt = null;
                        const installBtnContainer = document.getElementById('install-pwa-nav');
                        if (installBtnContainer) {
                            installBtnContainer.style.setProperty('display', 'none', 'important');
                        }
                    });
                });
            }
        });

        window.addEventListener('appinstalled', (evt) => {
            console.log('Arga Barbershop PWA was installed.');
            const installBtnContainer = document.getElementById('install-pwa-nav');
            if (installBtnContainer) {
                installBtnContainer.style.setProperty('display', 'none', 'important');
            }
        });
    </script>


    <!-- Leaflet JS untuk Queue Location Map (must load before module scripts) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')
</body>

</html>
