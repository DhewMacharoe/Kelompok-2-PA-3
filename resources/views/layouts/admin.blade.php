<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Barbershop')</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>

<body>
    <div class="page-wrapper">

        <header class="header">
            <button class="header-back" onclick="window.location='{{ url('/') }}'">← Dashboard</button>
            <div class="header-title">@yield('header_title', 'Kelola Barbershop')</div>
            <div style="width:80px;"></div>
             @yield('header_right')
        </header>

        <nav class="admin-nav">
            <ul class="admin-nav-list">
                <li><a href="{{ url('dashboard') }}"
                        class="{{ Request::is('dashboard') ? 'active' : '' }}">Dashboard</a></li>
                <li><a href="{{ url('admin/antrian') }}"
                        class="{{ Request::is('admin/antrian') ? 'active' : '' }}">Antrian</a></li>
                <li><a href="{{ url('admin/layanan') }}"
                        class="{{ Request::is('admin/layanan') ? 'active' : '' }}">Layanan</a></li>
                <li><a href="{{ url('admin/galeri') }}"
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
    @stack('scripts')
</body>

</html>
