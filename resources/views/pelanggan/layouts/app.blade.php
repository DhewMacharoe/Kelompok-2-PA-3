<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Arga\'s Home')</title>
    <link rel="icon" type="image/svg+xml"
        href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.2/svgs/solid/scissors.svg">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    @vite(['resources/js/app.js'])

    @stack('styles')

    <style>
        /* Styling dasar Navbar agar rapi jika belum pakai navbar Bootstrap murni */
        .navbar-custom { background-color: #1a1a1a; padding: 15px 5%; box-shadow: 0 2px 10px rgba(0,0,0,0.5); }
        .navbar-custom .logo { color: #d4af37; font-weight: bold; font-size: 1.3rem; text-decoration: none; }
        .navbar-custom .nav-links a { color: white; text-decoration: none; margin-left: 20px; font-weight: 500; }
        .navbar-custom .nav-links a:hover { color: #d4af37; }
    </style>
</head>
<body class="bg-light">
    @include('pelanggan.partials.navbar')

    <main>
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
