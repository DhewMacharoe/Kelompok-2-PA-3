<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $activeBarbershop->nama_brand ?? 'Arga Barbershop')</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <!-- PWA Manifest & iOS Tags -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#fdfbf8">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="{{ $activeBarbershop->nama_brand ?? 'Arga Barbershop' }}">
    <link class="apple-touch-icon" rel="apple-touch-icon" href="{{ isset($activeBarbershop) && $activeBarbershop->favicon ? asset($activeBarbershop->favicon) : asset('assets/images/logo.png') }}">
    @if(isset($activeBarbershop) && $activeBarbershop->warna_primer)
    <style>
        :root {
            --accent-gold: {{ $activeBarbershop->warna_primer }} !important;
            --gold: {{ $activeBarbershop->warna_primer }} !important;
            --primary: {{ $activeBarbershop->warna_primer }} !important;
        }
        .btn-primary, .bg-primary, .btn-submit, .btn-edit-profile, .btn-tambah {
            background-color: {{ $activeBarbershop->warna_primer }} !important;
            border-color: {{ $activeBarbershop->warna_primer }} !important;
        }
        .text-gold, .icon-gold, .text-primary {
            color: {{ $activeBarbershop->warna_primer }} !important;
        }
    </style>
    @endif
    @yield('head')
</head>

<body class="@yield('body_class')">
    <div class="page-wrapper">

        @php
            $hidePublicChrome = trim($__env->yieldContent('hide_public_chrome')) === '1';
        @endphp

        @unless ($hidePublicChrome)
            <header class="header">
                @yield('header')
                @auth
                    <div class="header-actions-right">
                        <span class="header-greeting">Halo, {{ Auth::user()->username ?? Auth::user()->name }}</span>
                        @if(auth()->user()->hasRole('admin'))
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-primary">Dasbor Admin</a>
                        @else
                            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger py-2 px-3" aria-label="Keluar dari Aplikasi">Keluar</button>
                            </form>
                        @endif
                    </div>
                @endauth
            </header>

            <nav class="pub-nav">
                <ul class="pub-nav-list">
                    <li><a href="{{ url('/') }}" class="{{ Request::is('/') ? 'active' : '' }}">Home</a></li>
                    <li><a href="{{ url('layanan') }}" class="{{ Request::is('layanan') ? 'active' : '' }}">Layanan</a></li>
                    <li><a href="{{ url('antrean') }}" class="{{ Request::is('antrean') ? 'active' : '' }}">Antrean</a></li>
                    <li><a href="{{ url('rekomendasi') }}" class="{{ Request::is('rekomendasi') ? 'active' : '' }}">Gaya
                            Rambut</a></li>
                    <li><a href="{{ url('galeri') }}" class="{{ Request::is('galeri') ? 'active' : '' }}">Galeri</a></li>
                    <li><a href="{{ url('menu') }}" class="{{ Request::is('menu') ? 'active' : '' }}">Café</a></li>
                </ul>
            </nav>
        @endunless

        <div class="main-content">
            @yield('content')
        </div>

        @yield('action_bar')

    </div>

    <!-- PWA Service Worker Registration -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js').then(function(registration) {
                    console.log('ServiceWorker registered from public layout:', registration.scope);
                    
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
