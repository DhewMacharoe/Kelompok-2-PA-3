<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Super Admin Dashboard') - Portal Multi-Tenant</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v={{ time() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        :root {
            --primary-gold: #cc7c1b;
            --primary-blue: #0578FB;
            --dark-bg: #111827;
            --sidebar-bg: #1f2937;
            --light-gray: #f9fafb;
        }

        body {
            background-color: var(--light-gray);
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            overflow-x: hidden;
        }

        /* Sidebar Styling */
        .sidebar {
            background-color: var(--sidebar-bg);
            height: 100vh;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            z-index: 1000;
            transition: all 0.3s;
            border-right: 1px solid #374151;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.7);
            padding: 12px 20px;
            margin: 5px 15px;
            border-radius: 8px;
            transition: all 0.2s;
            font-weight: 500;
        }

        .sidebar .nav-link:hover {
            color: white;
            background-color: rgba(255, 255, 255, 0.05);
        }

        .sidebar .nav-link.active {
            background-color: var(--primary-gold) !important;
            color: white !important;
        }

        .main-wrapper {
            margin-left: 260px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            transition: all 0.3s;
        }

        .content-area {
            flex: 1;
            padding: 30px;
            width: 100%;
        }

        /* Header */
        .main-header {
            background: white;
            padding: 15px 30px;
            border-bottom: 1px solid #e5e7eb;
            position: sticky;
            top: 0;
            z-index: 990;
        }

        .main-footer {
            background: white;
            padding: 15px 30px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 0.9rem;
            color: #6b7280;
        }

        .stat-card-global {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1), 0 1px 2px rgba(0,0,0,0.06);
            border: 1px solid #f3f4f6;
            transition: transform 0.2s;
        }

        .stat-card-global:hover {
            transform: translateY(-2px);
        }

        .btn-gold {
            background-color: var(--primary-gold);
            color: white;
            border: none;
            font-weight: 600;
        }

        .btn-gold:hover {
            background-color: #b06914;
            color: white;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            body.sidebar-open .sidebar {
                transform: translateX(0);
            }

            .main-wrapper {
                margin-left: 0;
            }

            .sidebar-backdrop {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.4);
                z-index: 999;
            }

            body.sidebar-open .sidebar-backdrop {
                display: block;
            }
        }
    </style>
    @stack('styles')
</head>

<body>

    <!-- Sidebar Backdrop for Mobile -->
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <!-- Sidebar -->
    <nav class="sidebar py-4 d-flex flex-column justify-content-between">
        <div>
            <div class="px-4 mb-4 d-flex justify-content-between align-items-center">
                <h4 class="fw-bold m-0 text-white"><i class="fa-solid fa-scissors me-2" style="color: var(--primary-gold)"></i>Super Admin</h4>
                <button type="button" class="btn d-md-none text-white p-0" id="sidebarCloseBtn" aria-label="Tutup Menu Navigasi">
                    <i class="bi bi-x-lg" aria-hidden="true"></i>
                </button>
            </div>
            
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('super-admin.dashboard') ? 'active' : '' }}" href="{{ route('super-admin.dashboard') }}">
                        <i class="bi bi-speedometer2 me-2"></i> Dasbor Utama
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('super-admin.barbershops.*') ? 'active' : '' }}" href="{{ route('super-admin.barbershops.index') }}">
                        <i class="bi bi-shop me-2"></i> Kelola Tenant
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('super-admin.admins.*') ? 'active' : '' }}" href="{{ route('super-admin.admins.index') }}">
                        <i class="bi bi-people me-2"></i> Kelola Admin
                    </a>
                </li>
            </ul>
        </div>
        
        <div class="px-4">
            <div class="text-white-50 small mb-2">Portal Multi-Tenant</div>
            <a href="/" class="btn btn-sm btn-outline-light w-100 py-2" aria-label="Kembali ke Halaman Utama Publik"><i class="bi bi-house-door me-1" aria-hidden="true"></i> Ke Halaman Utama</a>
        </div>
    </nav>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Header -->
        <header class="main-header d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <button class="btn d-md-none p-0" id="sidebarToggleBtn" type="button" aria-label="Buka Menu Navigasi">
                    <i class="bi bi-list fs-3" aria-hidden="true"></i>
                </button>
                <h5 class="mb-0 fw-bold">@yield('title', 'Dasbor')</h5>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="d-none d-md-inline text-muted small"><i class="bi bi-person-circle me-1"></i> {{ auth()->user()->name }} (Super Admin)</span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger px-3 py-2" aria-label="Keluar dari Super Admin"><i class="bi bi-box-arrow-right me-1" aria-hidden="true"></i>Keluar</button>
                </form>
            </div>
        </header>

        <!-- Content Area -->
        <main class="content-area">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="main-footer">
            <span>&copy; {{ date('Y') }} Arga Home's Portal. Seluruh hak cipta dilindungi.</span>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('sidebarToggleBtn');
            const closeBtn = document.getElementById('sidebarCloseBtn');
            const backdrop = document.getElementById('sidebarBackdrop');

            function toggleSidebar() {
                document.body.classList.toggle('sidebar-open');
            }

            function closeSidebar() {
                document.body.classList.remove('sidebar-open');
            }

            if (toggleBtn) toggleBtn.addEventListener('click', toggleSidebar);
            if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
            if (backdrop) backdrop.addEventListener('click', closeSidebar);
        });
    </script>
    @stack('scripts')
</body>

</html>
