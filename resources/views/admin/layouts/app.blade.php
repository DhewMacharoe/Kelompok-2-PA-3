<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Antrean App</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    @vite(['resources/js/app.js'])

    <style>
        :root {
            --primary-blue: #0578FB;
            --dark-bg: #2C3E50;
            --light-gray: #f4f7f6;
        }

        body {
            background-color: var(--light-gray);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* Sidebar Styling */
        .sidebar {
            background-color: var(--dark-bg);
            height: 100%;
            color: white;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            margin: 5px 15px;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .sidebar .nav-link:hover {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar .nav-link.active {
            background-color: var(--primary-blue) !important;
            color: white !important;
        }

        .main-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .content-area {
            flex: 1;
            padding: 20px;
            max-width: 1180px;
            margin: 0 auto;
            width: 100%;
        }

        /* Header & Footer */
        .main-header {
            background: white;
            padding: 15px 25px;
            border-bottom: 1px solid #dee2e6;
        }

        .main-footer {
            background: white;
            padding: 15px;
            border-top: 1px solid #dee2e6;
            text-align: center;
            font-size: 0.9rem;
            color: #6c757d;
        }

        /* Reusable Components from previous design */
        .queue-card-main {
            background-color: var(--dark-bg);
            color: white;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
        }

        .queue-number {
            font-size: 4.5rem;
            font-weight: 800;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        @media (max-width: 768px) {
            .sidebar {
                min-height: auto;
            }
        }
    </style>
</head>

<body>

    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-md-3 col-lg-2">
                @include('admin.layouts.sidebar')
            </div>

            <div class="col-md-9 col-lg-10 main-wrapper">
                @include('admin.layouts.header')

                <main class="content-area">
                    @yield('content')
                </main>

                @include('admin.layouts.footer')
            </div>
        </div>
    </div>
    @stack('scripts')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
