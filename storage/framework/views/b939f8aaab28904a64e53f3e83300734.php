<?php $__env->startSection('title', 'Design Web'); ?>

<?php $__env->startSection('header_title'); ?>
    <div class="header-title">Design Web</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .profile-card {
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.06);
        border: none;
        overflow: hidden;
        background-color: #ffffff;
    }
    .profile-header {
        background: linear-gradient(135deg, #1e1e24 0%, <?php echo e($barbershop->warna_primer ?? '#e8a53a'); ?> 100%);
        padding: 40px 30px;
        color: #fff;
        position: relative;
    }
    .brand-logo-container {
        width: 100px;
        height: 100px;
        background: #fff;
        border-radius: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 20px rgba(0,0,0,0.12);
        border: 4px solid rgba(255, 255, 255, 0.25);
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .brand-logo-container:hover {
        transform: scale(1.05) rotate(2deg);
        box-shadow: 0 12px 24px rgba(0,0,0,0.18);
    }
    .brand-logo-container img {
        max-width: 85%;
        max-height: 85%;
        object-fit: contain;
    }
    .info-card {
        border-radius: 12px;
        border: 1px solid #eef2f5;
        background-color: #ffffff;
        transition: all 0.3s ease;
    }
    .info-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.03);
    }
    .info-label {
        font-weight: 700;
        color: #8c98a5;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
    }
    .info-value {
        color: #2b2c3a;
        font-size: 1rem;
        font-weight: 550;
    }
    .btn-edit-profile {
        background-color: #ffffff;
        color: #2b2c3a;
        border: none;
        padding: 12px 24px;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    .btn-edit-profile:hover {
        background-color: <?php echo e($barbershop->warna_primer ?? '#e8a53a'); ?>;
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }
    .social-card {
        border-radius: 12px;
        border: none;
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    .social-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.05);
    }
    .social-icon-box {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 46px;
        height: 46px;
        border-radius: 12px;
        font-size: 1.3rem;
        color: white;
    }
    .text-muted-white {
        color: rgba(255, 255, 255, 0.8);
    }
    .custom-nav-tabs {
        border-bottom: 2px solid #f0f2f5;
        gap: 10px;
    }
    .custom-nav-tabs .nav-link {
        border: none;
        color: #6c757d;
        font-weight: 600;
        padding: 12px 20px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    .custom-nav-tabs .nav-link:hover {
        background-color: #f8f9fa;
        color: #343a40;
    }
    .custom-nav-tabs .nav-link.active {
        background-color: <?php echo e($barbershop->warna_primer ?? '#e8a53a'); ?>15;
        color: <?php echo e($barbershop->warna_primer ?? '#e8a53a'); ?>;
        border-bottom: none;
    }
    .hero-preview-card {
        border-radius: 14px;
        border: none;
        box-shadow: 0 4px 15px rgba(0,0,0,0.04);
        overflow: hidden;
        transition: all 0.3s ease;
    }
    .hero-preview-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    }
    .hero-preview-banner {
        height: 160px;
        background-size: cover;
        background-position: center;
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: end;
        padding: 20px;
    }
    .hero-preview-banner::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.75) 100%);
        z-index: 1;
    }
    .hero-preview-content {
        position: relative;
        z-index: 2;
        color: #ffffff;
    }
    .color-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 12px;
        background-color: #f8f9fa;
        border-radius: 30px;
        border: 1px solid #eef2f5;
        font-family: monospace;
        font-weight: 600;
        font-size: 0.9rem;
    }
    .map-container {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        border: 1px solid #eef2f5;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="main-container pb-5">
    <?php if(session('success')): ?>
        <div id="flash-success" data-message="<?php echo e(session('success')); ?>" hidden></div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const flashSuccess = document.getElementById('flash-success');
                if (flashSuccess && flashSuccess.dataset.message) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: flashSuccess.dataset.message,
                        confirmButtonText: 'OK'
                    });
                }
            });
        </script>
    <?php endif; ?>

    <div class="profile-card mx-auto mt-4" style="max-width: 900px;">
        <!-- Profile Header -->
        <div class="profile-header d-flex align-items-center justify-content-between flex-wrap gap-4">
            <div class="d-flex align-items-center gap-4 flex-wrap">
                <div class="brand-logo-container">
                    <?php if($barbershop->favicon): ?>
                        <img src="<?php echo e(asset($barbershop->favicon)); ?>" alt="Favicon">
                    <?php else: ?>
                        <img src="<?php echo e(asset('assets/images/logo.png')); ?>" alt="Default Logo">
                    <?php endif; ?>
                </div>
                <div>
                    <span class="badge mb-2 px-3 py-2 text-uppercase rounded-pill fw-bold" style="background-color: rgba(255, 255, 255, 0.2); font-size: 0.75rem; letter-spacing: 1px;">CMS Mode</span>
                    <h2 class="mb-1 style-brand-name text-white fw-bold" style="margin: 0;"><?php echo e($barbershop->nama_brand); ?></h2>
                    <p class="mb-0 text-muted-white" style="font-size: 0.95rem; font-style: italic;"><?php echo e($barbershop->slogan ?? 'Barber, Coffee & Food'); ?></p>
                </div>
            </div>
            <div>
                <a href="<?php echo e(route('admin.barbershop.edit', $barbershop->id)); ?>" class="btn-edit-profile">
                    <i class="fas fa-edit text-primary-color"></i> Edit Desain Web
                </a>
            </div>
        </div>

        <div class="p-4">
            <!-- Tabs Navigation -->
            <ul class="nav nav-tabs custom-nav-tabs mb-4" id="designTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab" aria-controls="general" aria-selected="true">
                        <i class="fas fa-info-circle me-2"></i>Profil & Tampilan
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="hero-tab" data-bs-toggle="tab" data-bs-target="#hero" type="button" role="tab" aria-controls="hero" aria-selected="false">
                        <i class="fas fa-image me-2"></i>Hero Banner Halaman
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">
                        <i class="fas fa-map-marked-alt me-2"></i>Kontak & Lokasi
                    </button>
                </li>
            </ul>

            <!-- Tabs Content -->
            <div class="tab-content" id="designTabContent">
                
                <!-- Tab 1: Profil & Tampilan -->
                <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="info-card p-3 mb-3">
                                <div class="info-label mb-1"><i class="bi bi-tag-fill text-primary me-1"></i> Nama Brand / Judul Web</div>
                                <div class="info-value fw-bold"><?php echo e($barbershop->nama_brand); ?></div>
                            </div>
                            
                            <div class="info-card p-3 mb-3">
                                <div class="info-label mb-1"><i class="bi bi-chat-quote-fill text-primary me-1"></i> Slogan / Tagline Brand</div>
                                <div class="info-value"><em><?php echo e($barbershop->slogan ?? 'Barber, Coffee & Food'); ?></em></div>
                            </div>

                            <div class="info-card p-3">
                                <div class="info-label mb-1"><i class="bi bi-envelope-fill text-primary me-1"></i> Email Kontak</div>
                                <div class="info-value"><?php echo e($barbershop->email); ?></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-card p-3 mb-3">
                                <div class="info-label mb-1"><i class="bi bi-palette-fill text-primary me-1"></i> Warna Dasar / Aksen Web</div>
                                <div class="info-value mt-1">
                                    <div class="color-pill">
                                        <span style="display: inline-block; width: 18px; height: 18px; border-radius: 50%; background-color: <?php echo e($barbershop->warna_primer ?? '#e8a53a'); ?>; border: 1px solid rgba(0,0,0,0.1);"></span>
                                        <span><?php echo e($barbershop->warna_primer ?? '#e8a53a'); ?></span>
                                    </div>
                                </div>
                            </div>

                            <div class="info-card p-3">
                                <div class="info-label mb-1"><i class="bi bi-geo-alt-fill text-primary me-1"></i> Alamat Lengkap</div>
                                <div class="info-value" style="line-height: 1.6; font-size: 0.95rem;"><?php echo e($barbershop->alaamat); ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab 2: Hero Banner Halaman -->
                <div class="tab-pane fade" id="hero" role="tabpanel" aria-labelledby="hero-tab">
                    <div class="row g-4">
                        <!-- Hero Beranda -->
                        <div class="col-md-6">
                            <div class="hero-preview-card card h-100">
                                <div class="hero-preview-banner" style="background-image: url('<?php echo e($barbershop->gambar_hero ? asset($barbershop->gambar_hero) : 'https://images.unsplash.com/photo-1585747860715-2ba37e788b70?q=80&w=600&auto=format&fit=cover'); ?>');">
                                    <div class="hero-preview-content">
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle mb-1 rounded-pill">Home Hero</span>
                                        <h5 class="fw-bold mb-0 text-white text-truncate"><?php echo e($barbershop->nama_brand); ?></h5>
                                        <p class="small mb-0 text-white-50 text-truncate" style="font-size: 0.75rem;"><?php echo e($barbershop->slogan); ?></p>
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <div class="info-label mb-1">Deskripsi Hero Beranda</div>
                                    <p class="text-secondary small mb-3 text-clamp" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 38px; line-height: 1.4;">
                                        <?php echo e($barbershop->deskripsi_hero ?? 'Tempat pangkas rambut premium dengan layanan walk-in queue. Dapatkan pengalaman grooming terbaik!'); ?>

                                    </p>
                                    <div class="border-top pt-2 d-flex justify-content-between align-items-center">
                                        <span class="text-muted small">Gambar Latar</span>
                                        <?php if($barbershop->gambar_hero): ?>
                                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2.5">Kustom</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill px-2.5">Default (Unsplash)</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hero Layanan -->
                        <div class="col-md-6">
                            <div class="hero-preview-card card h-100">
                                <div class="hero-preview-banner" style="background-image: url('<?php echo e($barbershop->gambar_hero_layanan ? asset($barbershop->gambar_hero_layanan) : 'https://images.unsplash.com/photo-1621605815971-fbc98d665033?q=80&w=600&auto=format&fit=cover'); ?>');">
                                    <div class="hero-preview-content">
                                        <span class="badge bg-info-subtle text-info border border-info-subtle mb-1 rounded-pill">Services Hero</span>
                                        <h5 class="fw-bold mb-0 text-white text-truncate"><?php echo e($barbershop->judul_hero_layanan); ?></h5>
                                        <p class="small mb-0 text-white-50 text-truncate" style="font-size: 0.75rem;"><?php echo e($barbershop->deskripsi_hero_layanan); ?></p>
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <div class="info-label mb-1">Judul & Deskripsi</div>
                                    <p class="text-secondary small mb-3 text-clamp" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 38px; line-height: 1.4;">
                                        <strong><?php echo e($barbershop->judul_hero_layanan); ?></strong> — <?php echo e($barbershop->deskripsi_hero_layanan); ?>

                                    </p>
                                    <div class="border-top pt-2 d-flex justify-content-between align-items-center">
                                        <span class="text-muted small">Gambar Latar</span>
                                        <?php if($barbershop->gambar_hero_layanan): ?>
                                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2.5">Kustom</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill px-2.5">Default (Unsplash)</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hero Galeri -->
                        <div class="col-md-6">
                            <div class="hero-preview-card card h-100">
                                <div class="hero-preview-banner" style="background-image: url('<?php echo e($barbershop->gambar_hero_galeri ? asset($barbershop->gambar_hero_galeri) : 'https://images.unsplash.com/photo-1503951914875-452162b0f3f1?q=80&w=600&auto=format&fit=cover'); ?>');">
                                    <div class="hero-preview-content">
                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle mb-1 rounded-pill">Gallery Hero</span>
                                        <h5 class="fw-bold mb-0 text-white text-truncate"><?php echo e($barbershop->judul_hero_galeri); ?></h5>
                                        <p class="small mb-0 text-white-50 text-truncate" style="font-size: 0.75rem;"><?php echo e($barbershop->deskripsi_hero_galeri); ?></p>
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <div class="info-label mb-1">Judul & Deskripsi</div>
                                    <p class="text-secondary small mb-3 text-clamp" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 38px; line-height: 1.4;">
                                        <strong><?php echo e($barbershop->judul_hero_galeri); ?></strong> — <?php echo e($barbershop->deskripsi_hero_galeri); ?>

                                    </p>
                                    <div class="border-top pt-2 d-flex justify-content-between align-items-center">
                                        <span class="text-muted small">Gambar Latar</span>
                                        <?php if($barbershop->gambar_hero_galeri): ?>
                                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2.5">Kustom</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill px-2.5">Default (Assets)</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>

                <!-- Tab 3: Kontak & Peta Lokasi -->
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    <div class="row g-4">
                        <!-- Media Sosial & Kontak -->
                        <div class="col-md-5">
                            <h5 class="mb-3 fw-bold text-dark" style="font-size: 1.1rem;">Sosial Media & Kontak</h5>
                            
                            <!-- WhatsApp -->
                            <div class="social-card card p-3 mb-3 bg-light border-0">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="social-icon-box bg-success">
                                        <i class="fab fa-whatsapp"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted small fw-bold">WhatsApp</div>
                                        <div class="info-value mt-0.5"><?php echo e($barbershop->kontak['whatsapp'] ?? '-'); ?></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Instagram -->
                            <div class="social-card card p-3 mb-3 bg-light border-0">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="social-icon-box" style="background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);">
                                        <i class="fab fa-instagram"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted small fw-bold">Instagram</div>
                                        <?php if(isset($barbershop->kontak['instagram']) && !empty($barbershop->kontak['instagram'])): ?>
                                            <div class="info-value mt-0.5"><a href="<?php echo e($barbershop->kontak['instagram']); ?>" target="_blank" class="text-decoration-none fw-semibold" style="color: <?php echo e($barbershop->warna_primer ?? '#e8a53a'); ?>;">Buka Instagram <i class="fas fa-external-link-alt ms-1 small"></i></a></div>
                                        <?php else: ?>
                                            <div class="info-value mt-0.5">-</div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Facebook -->
                            <div class="social-card card p-3 bg-light border-0">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="social-icon-box bg-primary">
                                        <i class="fab fa-facebook-f"></i>
                                    </div>
                                    <div>
                                        <div class="text-muted small fw-bold">Facebook</div>
                                        <?php if(isset($barbershop->kontak['facebook']) && !empty($barbershop->kontak['facebook'])): ?>
                                            <div class="info-value mt-0.5"><a href="<?php echo e($barbershop->kontak['facebook']); ?>" target="_blank" class="text-decoration-none fw-semibold" style="color: <?php echo e($barbershop->warna_primer ?? '#e8a53a'); ?>;">Buka Facebook <i class="fas fa-external-link-alt ms-1 small"></i></a></div>
                                        <?php else: ?>
                                            <div class="info-value mt-0.5">-</div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Google Maps Preview -->
                        <div class="col-md-7 border-start ps-md-4" style="border-color: #f0f2f5 !important;">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="m-0 fw-bold text-dark" style="font-size: 1.1rem;">Google Maps Sematan</h5>
                                <?php if(isset($barbershop->kontak['link_map']) && !empty($barbershop->kontak['link_map'])): ?>
                                    <a href="<?php echo e($barbershop->kontak['link_map']); ?>" target="_blank" class="btn btn-sm btn-outline-secondary rounded-pill px-3" style="font-size: 0.8rem;">
                                        <i class="fas fa-map-marked-alt me-1"></i> Tautan Peta
                                    </a>
                                <?php endif; ?>
                            </div>

                            <?php if(isset($barbershop->kontak['map_embed']) && !empty($barbershop->kontak['map_embed'])): ?>
                                <div class="map-container">
                                    <iframe 
                                        src="<?php echo e($barbershop->kontak['map_embed']); ?>" 
                                        width="100%" 
                                        height="260" 
                                        style="border:0; display: block;" 
                                        allowfullscreen="" 
                                        loading="lazy" 
                                        referrerpolicy="no-referrer-when-downgrade">
                                    </iframe>
                                </div>
                            <?php else: ?>
                                <div class="card p-5 text-center text-muted border-dashed bg-light rounded-3" style="border: 2px dashed #dee2e6;">
                                    <i class="fas fa-map-marker-alt fa-3x mb-3 text-secondary-50 opacity-50"></i>
                                    <h6 class="fw-bold m-0">Peta belum disematkan</h6>
                                    <p class="small text-secondary m-0 mt-1">Sematkan URL embed Google Maps pada form edit untuk melihat peta di sini.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div style="height:40px;"></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\s6\pa 3\pa_3v3\Kelompok-2-PA-3\resources\views\admin\barbershop\index.blade.php ENDPATH**/ ?>