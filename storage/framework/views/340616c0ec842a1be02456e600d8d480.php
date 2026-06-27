<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', $activeBarbershop->nama_brand ?? 'Arga Barbershop'); ?></title>
    <link rel="icon" type="image/png" href="<?php echo e(asset('favicon.png')); ?>?v=<?php echo e(time()); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/styles.css')); ?>">
    <!-- PWA Manifest & iOS Tags -->
    <link rel="manifest" href="<?php echo e(asset('manifest.json')); ?>">
    <meta name="theme-color" content="#fdfbf8">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="<?php echo e($activeBarbershop->nama_brand ?? 'Arga Barbershop'); ?>">
    <link class="apple-touch-icon" rel="apple-touch-icon" href="<?php echo e(isset($activeBarbershop) && $activeBarbershop->favicon ? asset($activeBarbershop->favicon) : asset('assets/images/logo.png')); ?>">
    <?php if(isset($activeBarbershop) && $activeBarbershop->warna_primer): ?>
    <style>
        :root {
            --accent-gold: <?php echo e($activeBarbershop->warna_primer); ?> !important;
            --gold: <?php echo e($activeBarbershop->warna_primer); ?> !important;
            --primary: <?php echo e($activeBarbershop->warna_primer); ?> !important;
        }
        .btn-primary, .bg-primary, .btn-submit, .btn-edit-profile, .btn-tambah {
            background-color: <?php echo e($activeBarbershop->warna_primer); ?> !important;
            border-color: <?php echo e($activeBarbershop->warna_primer); ?> !important;
        }
        .text-gold, .icon-gold, .text-primary {
            color: <?php echo e($activeBarbershop->warna_primer); ?> !important;
        }
    </style>
    <?php endif; ?>
    <?php echo $__env->yieldContent('head'); ?>
</head>

<body class="<?php echo $__env->yieldContent('body_class'); ?>">
    <div class="page-wrapper">

        <?php
            $hidePublicChrome = trim($__env->yieldContent('hide_public_chrome')) === '1';
        ?>

        <?php if (! ($hidePublicChrome)): ?>
            <header class="header">
                <?php echo $__env->yieldContent('header'); ?>
                <?php if(auth()->guard()->check()): ?>
                    <div class="header-actions-right">
                        <span class="header-greeting">Halo, <?php echo e(Auth::user()->username ?? Auth::user()->name); ?></span>
                        <?php if(auth()->user()->hasRole('admin')): ?>
                            <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-sm btn-primary">Dasbor Admin</a>
                        <?php else: ?>
                            <form action="<?php echo e(route('logout')); ?>" method="POST" style="display: inline;">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-sm btn-danger py-2 px-3" aria-label="Keluar dari Aplikasi">Keluar</button>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </header>

            <nav class="pub-nav">
                <ul class="pub-nav-list">
                    <li><a href="<?php echo e(url('/')); ?>" class="<?php echo e(Request::is('/') ? 'active' : ''); ?>">Home</a></li>
                    <li><a href="<?php echo e(url('layanan')); ?>" class="<?php echo e(Request::is('layanan') ? 'active' : ''); ?>">Layanan</a></li>
                    <li><a href="<?php echo e(url('antrean')); ?>" class="<?php echo e(Request::is('antrean') ? 'active' : ''); ?>">Antrean</a></li>
                    <li><a href="<?php echo e(url('rekomendasi')); ?>" class="<?php echo e(Request::is('rekomendasi') ? 'active' : ''); ?>">Gaya
                            Rambut</a></li>
                    <li><a href="<?php echo e(url('galeri')); ?>" class="<?php echo e(Request::is('galeri') ? 'active' : ''); ?>">Galeri</a></li>
                    <li><a href="<?php echo e(url('menu')); ?>" class="<?php echo e(Request::is('menu') ? 'active' : ''); ?>">Café</a></li>
                </ul>
            </nav>
        <?php endif; ?>

        <div class="main-content">
            <?php echo $__env->yieldContent('content'); ?>
        </div>

        <?php echo $__env->yieldContent('action_bar'); ?>

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
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html>
<?php /**PATH K:\Deploy-Argahomes\resources\views/layouts/public.blade.php ENDPATH**/ ?>