<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Barbershop')</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <!-- PWA Manifest & iOS Tags -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#fdfbf8">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Arga Barbershop">
    <link class="apple-touch-icon" rel="apple-touch-icon" href="{{ asset('assets/images/logo.png') }}">
</head>

<body>
    <div class="page-wrapper">

        <header class="header">
            <button class="header-back" onclick="window.location='{{ url('/') }}'">← Dasbor</button>
            <div class="header-title">@yield('header_title', 'Kelola Barbershop')</div>
            <div style="width:80px;"></div>
            @yield('header_right')
        </header>

        <nav class="admin-nav">
            <ul class="admin-nav-list">
                <li><a href="{{ url('dashboard') }}"
                        class="{{ Request::is('dashboard') ? 'active' : '' }}">Dasbor</a></li>
                <li><a href="{{ url('admin/antrean') }}"
                        class="{{ Request::is('admin/antrean') ? 'active' : '' }}">Antrean</a></li>
                <li><a href="{{ url('admin/layanan') }}"
                        class="{{ Request::is('admin/layanan') ? 'active' : '' }}">Layanan</a></li>
                <li><a href="{{ route('admin.galeri') }}"
                        class="{{ Request::is('admin/galeri') ? 'active' : '' }}">Galeri</a></li>
                <li><a href="{{ url('admin/menu') }}" class="{{ Request::is('admin/menu') ? 'active' : '' }}">Menu
                        Kafe</a></li>
                <li><a href="{{ url('admin/rekap') }}"
                        class="{{ Request::is('admin/rekap') ? 'active' : '' }}">Rekap</a></li>
            </ul>
        </nav>

        <div class="main-content">
            @yield('content')
        </div>

    </div>
    <!-- PWA Service Worker Registration -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js').then(function(registration) {
                    console.log('ServiceWorker registered from admin layout:', registration.scope);
                    
                    registration.addEventListener('updatefound', () => {
                        const newWorker = registration.installing;
                        if (newWorker) {
                            newWorker.addEventListener('statechange', () => {
                                if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                                    if (confirm('Versi baru aplikasi tersedia. Muat ulang sekarang untuk menikmati fitur terbaru?')) {
                                        window.location.reload();
                                    }
                                }
                            });
                        }
                    });
                }, function(err) {
                    console.log('ServiceWorker registration failed:', err);
                });
            });
        }
    </script>
    @stack('scripts')
</body>

</html>
