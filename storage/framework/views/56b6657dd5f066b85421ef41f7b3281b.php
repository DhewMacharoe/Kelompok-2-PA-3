<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Dashboard'); ?> - <?php echo e($activeBarbershop->nama_brand ?? 'Antrean App'); ?></title>
    <!-- Favicon and Touch Icons -->
    <link rel="icon" type="image/png" href="<?php echo e(asset('favicon.png')); ?>?v=<?php echo e(time()); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- PWA Manifest & iOS Tags -->
    <link rel="manifest" href="<?php echo e(asset('manifest.json')); ?>">
    <meta name="theme-color" content="#fdfbf8">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="<?php echo e($activeBarbershop->nama_brand ?? 'Arga Barbershop Admin'); ?>">
    <link rel="apple-touch-icon" href="<?php echo e(isset($activeBarbershop) && $activeBarbershop->favicon ? asset($activeBarbershop->favicon) : asset('assets/images/logo.png')); ?>">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/js/app.js']); ?>

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

        .sidebar-shell {
            position: relative;
            z-index: 1045;
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
            min-width: 0;
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
            position: sticky;
            top: 0;
            z-index: 1030;
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

        .sidebar-backdrop {
            display: none;
        }

        .content-area .table-container,
        .content-area .table-responsive,
        .content-area table {
            max-width: 100%;
        }

        .content-area .table-container,
        .content-area .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        @media (max-width: 768px) {
            .row.g-0 {
                flex-wrap: nowrap;
            }

            .sidebar-shell {
                position: fixed;
                top: 0;
                left: 0;
                width: 280px;
                max-width: 82vw;
                height: 100vh;
                transform: translateX(-100%);
                transition: transform 0.25s ease;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
            }

            body.sidebar-open .sidebar-shell {
                transform: translateX(0);
            }

            .sidebar {
                min-height: 100vh;
                height: 100vh;
                overflow-y: auto;
            }

            .sidebar-backdrop {
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.35);
                z-index: 1040;
            }

            body.sidebar-open .sidebar-backdrop {
                display: block;
            }

            .main-wrapper {
                width: 100%;
                margin-left: 0;
            }

            .main-header {
                padding: 12px 14px;
            }

            .content-area {
                padding: 14px;
            }

            .main-footer {
                padding: 12px;
                font-size: 0.82rem;
            }
        }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>

<body>

    <?php if(auth()->check() && auth()->user()->hasRole('super_admin') && session()->has('current_barbershop_id')): ?>
        <div class="bg-danger text-white text-center py-2 px-3 fw-bold sticky-top d-flex justify-content-between align-items-center" style="z-index: 1100; font-size: 0.9rem;">
            <div>
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                Mode Super Admin: Anda sedang mengelola tenant <strong><?php echo e(session('current_barbershop_nama')); ?></strong> (ID: <?php echo e(session('current_barbershop_id')); ?>).
            </div>
            <div>
                <a href="<?php echo e(route('super-admin.switch-tenant', 'clear')); ?>" class="btn btn-sm btn-warning fw-bold text-dark px-3" style="font-size: 0.8rem;">
                    <i class="bi bi-box-arrow-left me-1"></i>Kembali ke Super Admin
                </a>
            </div>
        </div>
    <?php endif; ?>

    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-md-3 col-lg-2 sidebar-shell" id="adminSidebarShell">
                <?php echo $__env->make('admin.layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>

            <button type="button" class="sidebar-backdrop border-0 p-0 w-100" id="adminSidebarBackdrop" aria-label="Tutup menu"></button>

            <div class="col-md-9 col-lg-10 main-wrapper">
                <?php echo $__env->make('admin.layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                <main class="content-area" role="main">
                    <?php echo $__env->yieldContent('content'); ?>
                </main>

                <?php echo $__env->make('admin.layouts.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        </div>
    </div>
    <?php echo $__env->yieldPushContent('scripts'); ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButton = document.getElementById('mobileSidebarToggle');
            const closeButton = document.getElementById('mobileSidebarClose');
            const backdrop = document.getElementById('adminSidebarBackdrop');
            const sidebarLinks = document.querySelectorAll('#adminSidebarShell .nav-link');

            function closeSidebar() {
                document.body.classList.remove('sidebar-open');
            }

            function toggleSidebar() {
                document.body.classList.toggle('sidebar-open');
            }

            if (toggleButton) {
                toggleButton.addEventListener('click', toggleSidebar);
            }

            if (closeButton) {
                closeButton.addEventListener('click', closeSidebar);
            }

            if (backdrop) {
                backdrop.addEventListener('click', closeSidebar);
            }

            sidebarLinks.forEach(function(link) {
                link.addEventListener('click', closeSidebar);
            });

            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    closeSidebar();
                }
            });
        });
    </script>

    <!-- Global Loading Button Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form');

            forms.forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (event.defaultPrevented) {
                        return;
                    }

                    const submitButtons = form.querySelectorAll('button[type="submit"]');

                    submitButtons.forEach(function(button) {
                        if (!button.closest('.sidebar') && !button.closest('.navbar') && !button.closest('nav')) {
                            const originalText = button.textContent.trim();
                            const loadingText = button.dataset.loadingText || 'Memproses...';

                            button.disabled = true;
                            button.textContent = loadingText;
                            button.dataset.originalText = originalText;
                        }
                    });
                });
            });
        });
    </script>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- PWA Service Worker Registration -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js').then(function(registration) {
                    console.log('ServiceWorker registered from admin/app layout:', registration.scope);
                    
                    registration.addEventListener('updatefound', () => {
                        const newWorker = registration.installing;
                        if (newWorker) {
                            newWorker.addEventListener('statechange', () => {
                                if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                                    if (typeof Swal !== 'undefined') {
                                        Swal.fire({
                                            title: 'Pembaruan Tersedia!',
                                            text: 'Versi baru dasbor admin telah diunduh. Silakan muat ulang halaman untuk menggunakan fitur terbaru.',
                                            icon: 'info',
                                            showCancelButton: true,
                                            confirmButtonColor: '#0578FB',
                                            cancelButtonColor: '#6c757d',
                                            confirmButtonText: 'Muat Ulang',
                                            cancelButtonText: 'Nanti'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.reload();
                                            }
                                        });
                                    } else {
                                        if (confirm('Versi baru dasbor admin tersedia. Muat ulang sekarang?')) {
                                            window.location.reload();
                                        }
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
</body>

</html>
<?php /**PATH K:\Deploy-Argahomes\resources\views/admin/layouts/app.blade.php ENDPATH**/ ?>