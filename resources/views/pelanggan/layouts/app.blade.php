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
        }

        main {
            flex: 1;
            /* Mendorong footer agar selalu di bawah */
        }

        /* Wrapper Sticky untuk Navbar */
        .sticky-header-wrapper {
            position: sticky;
            top: 0;
            z-index: 1030;
            width: 100%;
        }

        /* =========================================
           NAVBAR STYLES
           ========================================= */
        .navbar-custom {
            background-color: #1a1a1a;
            padding: 15px 5%;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        }

        .navbar-custom .logo {
            color: #d4af37;
            font-weight: bold;
            font-size: 1.3rem;
            text-decoration: none;
        }

        .navbar-custom .nav-links a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-weight: 500;
        }

        .navbar-custom .nav-links a:hover {
            color: #d4af37;
        }

        /* =========================================
           FOOTER STYLES
           ========================================= */
        .footer-custom {
            background-color: #1a1a1a;
            color: #d1d1d1;
            padding: 50px 0 20px;
            border-top: 3px solid #d4af37;
        }

        .footer-custom h5 {
            color: #d4af37;
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
            color: #d4af37;
        }

        .footer-custom .icon-gold {
            color: #d4af37;
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
            background-color: #1a1a1a;
            padding: 15px 0;
            margin-top: 40px;
            text-align: center;
            font-size: 0.9rem;
        }
    </style>
</head>

<body class="bg-light">

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
                    <h5 class="mb-3">
                        <i class="fas fa-cut me-2"></i>Arga Home's
                    </h5>
                    <p style="font-size: 0.95rem; line-height: 1.6;">
                        Tempat pangkas rambut premium dengan layanan walk-in queue. Dapatkan pengalaman grooming
                        terbaik!
                    </p>
                    <div class="mt-3">
                        <a href="" class="me-3 fs-5"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="me-3 fs-5"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="fs-5"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5>Jam Buka</h5>
                    <ul class="list-unstyled footer-list">
                        <li><i class="fas fa-clock icon-gold"></i> <strong>Senin - Jumat:</strong><br> 10:00 - 21:00
                        </li>
                        <li><i class="fas fa-clock icon-gold"></i> <strong>Sabtu - Minggu:</strong><br> 09:00 - 22:00
                        </li>
                        <li class="text-danger mt-2"><i class="fas fa-info-circle icon-gold text-danger"></i> Libur pada
                            Hari Raya</li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5>Hubungi Kami</h5>
                    <ul class="list-unstyled footer-list">
                        <li><i class="fas fa-map-marker-alt icon-gold"></i> Jl P.Siantar Km 2 Tampubolon,Sibolahotangsas Kec. Balige, Toba, Sumatera Utara</li>
                        <li><i class="fas fa-phone-alt icon-gold"></i> 0821-6789-3019</li>
                        <li><i class="fas fa-envelope icon-gold"></i> jtobabarber@gmail.com</li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5>Lokasi Kami</h5>
                    <div class="map-container">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3986.498167979275!2d99.0793!3d2.3376!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x302e05f7e7bdbf51%3A0xfb263b04d75d4b75!2sARGA%20home&#39;s!5e0!3m2!1sid!2sid!4v1777469578899!5m2!1sid!2sid"
                            width="100%" height="100%" style="border:0;" allowfullscreen loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>

            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12">
                        <p class="mb-0">&copy; {{ date('Y') }} Arga Home's Barbershop & Cafe. All rights reserved.
                        </p>
                    </div>
                </div>
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

    <!-- Leaflet JS untuk Queue Location Map (must load before module scripts) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>

    @stack('scripts')
</body>

</html>
