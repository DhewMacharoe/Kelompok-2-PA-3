<?php $__env->startSection('title', isset($activeBarbershop) && $activeBarbershop->nama_brand ? 'Dasbor - ' . $activeBarbershop->nama_brand : "Dasbor - Arga Home's"); ?>

<?php $__env->startPush('styles'); ?>
<?php echo $__env->make('pelanggan.homepage.style-index', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('pelanggan.layanan.styles', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<!-- Hero Section -->
<section class="hero d-flex flex-column justify-content-center align-items-center px-3 text-center position-relative">
    <div class="hero-overlay"></div>
    <div class="hero-content z-index-2 w-100">
        <h6 class="hero-subtitle mb-2">SELAMAT DATANG DI</h6>
        <h1 class="hero-title mb-3"><?php echo e(strtoupper($activeBarbershop->nama_brand ?? "ARGA HOME'S")); ?></h1>
        <div class="hero-divider-container mb-3 d-flex align-items-center justify-content-center gap-3">
            <span class="hero-divider-line"></span>
            <span class="hero-divider-text"><?php echo e($activeDesign->slogan ?? 'Barber, Coffee & Food'); ?></span>
            <span class="hero-divider-line"></span>
        </div>
        <p class="hero-desc mx-auto mb-4">
            <?php echo e($activeDesign->deskripsi_hero ?? 'Tempat pangkas rambut premium dengan layanan walk-in queue. Dapatkan pengalaman grooming terbaik!'); ?>

        </p>
        <a href="<?php echo e(route('antrean')); ?>" class="btn hero-cta-btn px-4 py-2.5 fw-semibold shadow-sm">
            <i class="fas fa-users me-2"></i>Ambil Antrean
        </a>
    </div>
</section>

<!-- Main Container -->
<div class="container py-4 px-3">

    <!-- Queue Status Card / Row -->
    <div class="card queue-status-card border-0 shadow-sm mb-5">
        <div class="card-body p-0">
            <div class="row g-0 align-items-stretch">
                <!-- Col 1: Antrean Menunggu -->
                <div class="col-6 col-md-4 p-4 d-flex align-items-center gap-3 queue-info-section">
                    <div class="queue-icon-circle flex-shrink-0 shadow-sm" style="background-color: #fffcf5; border: 1px solid <?php echo e($activeBarbershop->warna_primer ?? '#e8a53a'); ?>;">
                        <i class="fas fa-users" style="color: <?php echo e($activeBarbershop->warna_primer ?? '#e8a53a'); ?>;"></i>
                    </div>
                    <div class="queue-info-details">
                        <h6 class="mb-1 text-dark fw-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">Antrean Menunggu</h6>
                        <p class="mb-1 small text-secondary">Jumlah pelanggan dalam antrean</p>
                        <h4 class="mb-0 queue-large-val"><?php echo e($jumlahAntrean); ?> orang</h4>
                    </div>
                </div>

                <!-- Col 2: Sedang Dilayani -->
                <div class="col-6 col-md-3 p-4 d-flex align-items-center gap-3 queue-info-section border-start-md">
                    <div class="queue-icon-circle flex-shrink-0 shadow-sm" style="background-color: #fffcf5; border: 1px solid <?php echo e($activeBarbershop->warna_primer ?? '#e8a53a'); ?>;">
                        <i class="fas fa-chair" style="color: <?php echo e($activeBarbershop->warna_primer ?? '#e8a53a'); ?>;"></i>
                    </div>
                    <div class="queue-info-details">
                        <h6 class="mb-1 text-dark fw-bold" style="font-size: 0.8rem; letter-spacing: 0.5px;">Sedang Melayani Nomor</h6>
                        <h4 class="mb-0 queue-large-val-gold" id="antrean-nomor">
                            <?php echo e($antrean ? $antrean->nomor_antrean_seq : 'Belum Ada'); ?>

                        </h4>
                    </div>
                </div>

                <!-- Col 3: Status Pelayanan -->
                <div class="col-12 col-md-5 p-3 border-start-md d-flex">
                    <div class="status-pelayanan-box p-3 rounded border w-100 bg-white d-flex flex-column justify-content-center">
                        <?php if(auth()->check() && isset($antreanSayaAktif) && $antreanSayaAktif): ?>
                            <?php if($antreanSayaAktif->barbershop_id !== $activeBarbershop->id): ?>
                                <a href="<?php echo e(route('profile.index')); ?>" class="btn w-100 text-white fw-bold mb-2 py-2.5 d-flex align-items-center justify-content-center gap-2" style="background-color: #6c757d; font-size: 0.88rem; border-radius: 8px; letter-spacing: 0.2px;">
                                    <i class="fas fa-exclamation-circle"></i> Antrean di Cabang Lain
                                </a>
                            <?php elseif($antreanSayaAktif->is_booking): ?>
                                <a href="<?php echo e(route('profile.index')); ?>" class="btn btn-gold-accent w-100 text-white fw-bold mb-2 py-2.5 d-flex align-items-center justify-content-center gap-2" style="font-size: 0.88rem; border-radius: 8px; letter-spacing: 0.2px;">
                                    <i class="fas fa-calendar-check"></i> Cek Booking Anda
                                </a>
                            <?php else: ?>
                                <a href="<?php echo e(route('antrean')); ?>" class="btn btn-gold-accent w-100 text-white fw-bold mb-2 py-2.5 d-flex align-items-center justify-content-center gap-2" id="antrean-status" style="font-size: 0.88rem; border-radius: 8px; letter-spacing: 0.2px;">
                                    <i class="fas fa-ticket-alt"></i> Cek Detail Antrean
                                </a>
                            <?php endif; ?>
                        <?php else: ?>
                        <a href="<?php echo e(route('antrean')); ?>" class="btn btn-gold-accent w-100 text-white fw-bold mb-2 py-2.5 d-flex align-items-center justify-content-center gap-2" id="antrean-status" style="font-size: 0.88rem; border-radius: 8px; letter-spacing: 0.2px;">
                            <i class="fas fa-ticket-alt"></i> Cek Detail Antrean
                        </a>
                        <?php endif; ?>
                        <div class="text-center mt-2">
                            <?php if(auth()->check() && isset($antreanSayaAktif) && $antreanSayaAktif): ?>
                                <?php if($antreanSayaAktif->barbershop_id !== $activeBarbershop->id): ?>
                                    <span class="text-secondary small d-block mb-1" style="font-size: 0.72rem; letter-spacing: 0.2px;">Anda memiliki antrean/booking di cabang lain</span>
                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                        <a href="<?php echo e(route('profile.index')); ?>" class="fw-bold text-decoration-none" style="color: <?php echo e($activeBarbershop->warna_primer ?? '#e8a53a'); ?>; font-size: 0.85rem;">Lihat di Profil <i class="fas fa-arrow-right"></i></a>
                                    </div>
                                <?php elseif($antreanSayaAktif->status === 'sedang dilayani'): ?>
                                    <span class="text-secondary small d-block mb-1" style="font-size: 0.72rem; letter-spacing: 0.2px;">Durasi Pelayanan Anda</span>
                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                        <strong id="stopwatch-dipanggil" data-start="<?php echo e($antreanSayaAktif->updated_at->timestamp * 1000); ?>" style="color: <?php echo e($activeBarbershop->warna_primer ?? '#e8a53a'); ?>; font-family: monospace; font-size: 1.1rem; letter-spacing: 0.5px;">00:00:00</strong>
                                        <span class="text-muted text-nowrap" style="font-size: 0.75rem;">| <i class="fas fa-hourglass-half ms-1 me-1"></i> Est: <?php echo e($antreanSayaAktif->total_estimasi_waktu); ?> mnt</span>
                                    </div>
                                <?php else: ?>
                                    <span class="text-secondary small d-block mb-1" style="font-size: 0.72rem; letter-spacing: 0.2px;">Waktu Antrean Anda</span>
                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                        <span class="text-muted" style="font-size: 0.75rem;"><span class="text-nowrap">Masuk: <?php echo e($antreanSayaAktif->created_at->format('H:i')); ?></span> | <span class="text-nowrap"><i class="fas fa-hourglass-half me-1"></i> Est: <?php echo e($antreanSayaAktif->total_estimasi_waktu); ?> mnt</span></span>
                                    </div>
                                <?php endif; ?>
                            <?php elseif($antrean): ?>
                                <span class="text-secondary small d-block mb-1" style="font-size: 0.72rem; letter-spacing: 0.2px;">Durasi Pelayanan Berjalan</span>
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <strong id="stopwatch-dipanggil" data-start="<?php echo e($antrean->updated_at->timestamp * 1000); ?>" style="color: <?php echo e($activeBarbershop->warna_primer ?? '#e8a53a'); ?>; font-family: monospace; font-size: 1.1rem; letter-spacing: 0.5px;">00:00:00</strong>
                                    <span class="text-muted text-nowrap" style="font-size: 0.75rem;">| <i class="fas fa-hourglass-half ms-1 me-1"></i> Est: <?php echo e($antrean->total_estimasi_waktu); ?> mnt</span>
                                </div>
                            <?php else: ?>
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <span class="text-muted" style="font-size: 0.75rem;">Belum ada antrean berjalan.</span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Menu Grid -->
    <div class="row g-3 mb-5 text-center justify-content-center">
        <div class="col-6 col-md-3">
            <a href="<?php echo e(route('antrean')); ?>" class="text-decoration-none menu-grid-item d-block h-100">
                <div class="menu-grid-card p-3 rounded shadow-sm border bg-white transition-hover h-100 d-flex flex-column align-items-center justify-content-center">
                    <i class="far fa-address-card menu-grid-icon"></i>
                    <div class="menu-grid-text">Antrean</div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="<?php echo e(route('pelanggan.layanan')); ?>" class="text-decoration-none menu-grid-item d-block h-100">
                <div class="menu-grid-card p-3 rounded shadow-sm border bg-white transition-hover h-100 d-flex flex-column align-items-center justify-content-center">
                    <i class="fas fa-cut menu-grid-icon"></i>
                    <div class="menu-grid-text">Layanan</div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="<?php echo e(route('galeri')); ?>" class="text-decoration-none menu-grid-item d-block h-100">
                <div class="menu-grid-card p-3 rounded shadow-sm border bg-white transition-hover h-100 d-flex flex-column align-items-center justify-content-center">
                    <i class="far fa-image menu-grid-icon"></i>
                    <div class="menu-grid-text">Galeri</div>
                </div>
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="<?php echo e(auth()->check() ? route('profile.index') : route('login.user')); ?>" class="text-decoration-none menu-grid-item d-block h-100">
                <div class="menu-grid-card p-3 rounded shadow-sm border bg-white transition-hover h-100 d-flex flex-column align-items-center justify-content-center">
                    <i class="far fa-user menu-grid-icon"></i>
                    <div class="menu-grid-text">Profil & Booking</div>
                </div>
            </a>
        </div>
    </div>

    <!-- Layanan yang Ditawarkan Section -->
    <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
        <h4 class="section-title ps-1 mb-0 fw-bold d-flex align-items-center gap-2">
            <i class="fas fa-star text-gold-accent"></i> Layanan yang Ditawarkan
        </h4>
        <a href="<?php echo e(route('pelanggan.layanan')); ?>" class="text-decoration-none text-gold-accent fw-bold small link-hover-effect">
            Lihat Semua Layanan <i class="fas fa-arrow-right ms-1"></i>
        </a>
    </div>

    <?php
    $count = $layanans->count();

    if ($count <= 3) {
        $selectedLayanans=$layanans;
        } else {
        $first=$layanans->first();
        $last = $layanans->last();

        $midIndex = (int) floor($count / 2);
        $middle = $layanans->slice($midIndex, 1);

        $selectedLayanans = collect([$first])
        ->merge($middle)
        ->push($last);
        }
        ?>

        <div class="row g-3 mb-5">
            <?php $__currentLoopData = $selectedLayanans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $layanan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-12 col-md-6 col-lg-4">
                <div role="button" tabindex="0" class="layanan-card-trigger text-decoration-none d-block h-100"
                    id="layanan-<?php echo e($layanan->id); ?>"
                    data-id="<?php echo e($layanan->id); ?>"
                    data-name="<?php echo e($layanan->nama); ?>"
                    data-description="<?php echo e(e($layanan->deskripsi ?? 'Tidak ada deskripsi.')); ?>"
                    data-time="<?php echo e($layanan->estimasi_waktu); ?>"
                    data-ikon="<?php echo e($layanan->ikon); ?>"
                    data-price="<?php echo e(number_format($layanan->harga, 0, ',', '.')); ?>">
                    <div class="service-custom-card p-3 rounded shadow-sm border bg-white transition-hover h-100 d-flex gap-3 align-items-start">
                        <div class="service-icon-wrapper rounded-circle flex-shrink-0 d-flex align-items-center justify-content-center text-white bg-dark shadow-sm">
                            <?php if($layanan->ikon === 'paint'): ?>
                            <i class="fas fa-paint-brush"></i>
                            <?php elseif($layanan->ikon === 'face'): ?>
                            <i class="fas fa-smile"></i>
                            <?php else: ?>
                            <i class="fas fa-cut"></i>
                            <?php endif; ?>
                        </div>
                        <div class="service-details-wrapper text-start d-flex flex-column justify-content-between h-100 w-100">
                            <div>
                                <h6 class="service-title-text mb-1 fw-bold text-dark"><?php echo e($layanan->nama); ?></h6>
                                <div class="service-meta-text text-secondary small d-flex align-items-center gap-1 mb-2">
                                    <i class="far fa-clock text-gold-accent"></i> <?php echo e($layanan->estimasi_waktu ?? '-'); ?> menit
                                </div>
                                <?php if($layanan->deskripsi): ?>
                                <p class="service-desc mb-2 text-muted small">
                                    <?php echo e($layanan->deskripsi); ?>

                                </p>
                                <?php endif; ?>
                            </div>
                            <div class="service-price-text fw-bold text-gold-accent mt-1">
                                Rp<?php echo e(number_format($layanan->harga, 0, ',', '.')); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>


</div>

<?php echo $__env->make('pelanggan.partials.layanan-detail-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<?php echo $__env->make('pelanggan.homepage.script-index', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('pelanggan.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\s6\pa 3\pa_3v3\Kelompok-2-PA-3\resources\views/pelanggan/homepage/homepage.blade.php ENDPATH**/ ?>