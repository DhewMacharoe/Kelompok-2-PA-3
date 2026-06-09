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

        @unless ($hidePublicChrome)
            <header class="header">
                @yield('header')
                @auth
                    <div class="header-actions-right">
                        <span class="header-greeting">Halo, {{ Auth::user()->username ?? Auth::user()->name }}</span>
                        @if(auth()->user()->hasRole('admin'))
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-primary">Dashboard Admin</a>
                        @else
                            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger">Logout</button>
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

    @stack('scripts')
</body>

</html>
