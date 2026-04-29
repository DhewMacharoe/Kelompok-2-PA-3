<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Arga Barbershop')</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    @yield('head')
</head>

<body class="@yield('body_class')">
    <div class="page-wrapper">

        @php
            $hidePublicChrome = trim($__env->yieldContent('hide_public_chrome')) === '1';
        @endphp

        @unless($hidePublicChrome)
            <header class="header">
                @yield('header')
                @auth
                    <div style="position: absolute; top: 10px; right: 10px; display: flex; align-items: center; gap: 10px;">
                        <span>Halo, {{ Auth::user()->username ?? Auth::user()->name }}</span>
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" style="padding: 5px 10px; background: red; color: white; border: none; border-radius: 4px; cursor: pointer;">Logout</button>
                        </form>
                    </div>
                @endauth
            </header>

            <nav class="pub-nav">
                <ul class="pub-nav-list">
                    <li><a href="{{ url('/') }}" class="{{ Request::is('/') ? 'active' : '' }}">Home</a></li>
                    <li><a href="{{ url('layanan') }}" class="{{ Request::is('layanan') ? 'active' : '' }}">Layanan</a></li>
                    <li><a href="{{ url('antrian') }}" class="{{ Request::is('antrian') ? 'active' : '' }}">Antrian</a></li>
                    <li><a href="{{ url('rekomendasi') }}" class="{{ Request::is('rekomendasi') ? 'active' : '' }}">Gaya
                            Rambut</a></li>
                    <li><a href="{{ url('galeri') }}" class="{{ Request::is('galeri') ? 'active' : '' }}">Galeri</a></li>
                    <li><a href="{{ url('menu') }}" class="{{ Request::is('menu') ? 'active' : '' }}">Menu Kafe</a></li>
                </ul>
            </nav>
        @endunless

        <div class="main-content">
            @yield('content')
        </div>

        @yield('action_bar')

    </div>

    @stack('scripts')
</body>

</html>
