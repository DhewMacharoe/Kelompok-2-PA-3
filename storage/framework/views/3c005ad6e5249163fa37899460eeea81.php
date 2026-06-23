<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', $activeBarbershop->nama_brand ?? 'Admin Barbershop'); ?></title>
    <link rel="icon" type="image/png" href="<?php echo e(isset($activeBarbershop) && $activeBarbershop->favicon ? asset($activeBarbershop->favicon) : asset('favicon.png')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/styles.css')); ?>">
    <!-- PWA Manifest & iOS Tags -->
    <link rel="manifest" href="<?php echo e(asset('manifest.json')); ?>">
    <meta name="theme-color" content="#fdfbf8">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="<?php echo e($activeBarbershop->nama_brand ?? 'Arga Barbershop'); ?>">
    <link class="apple-touch-icon" rel="apple-touch-icon" href="<?php echo e(isset($activeBarbershop) && $activeBarbershop->favicon ? asset($activeBarbershop->favicon) : asset('assets/images/logo.png')); ?>">
</head>

<body>
    <div class="page-wrapper">

        <header class="header">
            <button class="header-back" onclick="window.location='<?php echo e(url('/')); ?>'">← Dasbor</button>
            <div class="header-title"><?php echo $__env->yieldContent('header_title', 'Kelola Barbershop'); ?></div>
            <div style="width:80px;"></div>
            <?php echo $__env->yieldContent('header_right'); ?>
        </header>

        <nav class="admin-nav">
            <ul class="admin-nav-list">
                <li><a href="<?php echo e(url('dashboard')); ?>"
                        class="<?php echo e(Request::is('dashboard') ? 'active' : ''); ?>">Dasbor</a></li>
                <li><a href="<?php echo e(url('admin/antrean')); ?>"
                        class="<?php echo e(Request::is('admin/antrean') ? 'active' : ''); ?>">Antrean</a></li>
                <li><a href="<?php echo e(url('admin/layanan')); ?>"
                        class="<?php echo e(Request::is('admin/layanan') ? 'active' : ''); ?>">Layanan</a></li>
                <li><a href="<?php echo e(route('admin.galeri')); ?>"
                        class="<?php echo e(Request::is('admin/galeri') ? 'active' : ''); ?>">Galeri</a></li>
                <li><a href="<?php echo e(url('admin/menu')); ?>" class="<?php echo e(Request::is('admin/menu') ? 'active' : ''); ?>">Menu
                        Kafe</a></li>
                <li><a href="<?php echo e(url('admin/rekap')); ?>"
                        class="<?php echo e(Request::is('admin/rekap') ? 'active' : ''); ?>">Rekap</a></li>
            </ul>
        </nav>

        <div class="main-content">
            <?php echo $__env->yieldContent('content'); ?>
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
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html>
<?php /**PATH D:\s6\pa 3\pa_3v3\Kelompok-2-PA-3\resources\views\layouts\admin.blade.php ENDPATH**/ ?>