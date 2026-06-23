<?php $__env->startSection('title', 'Edit Design Web'); ?>

<?php $__env->startSection('header_title'); ?>
    <div class="header-title">Edit Design Web</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .form-card {
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.06);
        border: none;
        overflow: hidden;
        background-color: #ffffff;
    }
    .form-header {
        background: linear-gradient(135deg, #1e1e24 0%, <?php echo e($barbershop->warna_primer ?? '#e8a53a'); ?> 100%);
        padding: 25px 30px;
        color: #fff;
    }
    .form-label { 
        font-weight: 600; 
        color: #495057; 
        font-size: 0.9rem;
    }
    .form-control { 
        border-radius: 8px; 
        padding: 10px 15px; 
        border: 1px solid #ced4da; 
        transition: all 0.3s ease;
    }
    .form-control:focus { 
        border-color: <?php echo e($barbershop->warna_primer ?? '#e8a53a'); ?>; 
        box-shadow: 0 0 0 0.25rem <?php echo e($barbershop->warna_primer ?? '#e8a53a'); ?>25; 
    }
    .input-group-text {
        border-radius: 8px 0 0 8px;
    }
    .input-group > .form-control {
        border-radius: 0 8px 8px 0;
    }
    .custom-pills .nav-link {
        border-radius: 10px;
        padding: 12px 20px;
        font-weight: 600;
        color: #495057;
        background-color: #f8f9fa;
        transition: all 0.3s ease;
        border: 1px solid #eef2f5;
    }
    .custom-pills .nav-link:hover {
        background-color: #eef2f5;
    }
    .custom-pills .nav-link.active {
        background-color: <?php echo e($barbershop->warna_primer ?? '#e8a53a'); ?>;
        color: white;
        box-shadow: 0 4px 12px <?php echo e(($barbershop->warna_primer ?? '#e8a53a')); ?>30;
        border-color: <?php echo e($barbershop->warna_primer ?? '#e8a53a'); ?>;
    }
    .hero-config-card {
        border-radius: 12px;
        border: 1px solid #eef2f5;
        background-color: #ffffff;
        transition: all 0.3s ease;
    }
    .hero-config-card:hover {
        box-shadow: 0 6px 18px rgba(0,0,0,0.03);
    }
    .btn-submit { 
        background-color: <?php echo e($barbershop->warna_primer ?? '#e8a53a'); ?>; 
        color: white; 
        border: none; 
        padding: 12px 28px; 
        border-radius: 10px; 
        font-weight: 600; 
        transition: all 0.3s ease; 
        box-shadow: 0 4px 12px <?php echo e(($barbershop->warna_primer ?? '#e8a53a')); ?>30;
    }
    .btn-submit:hover { 
        background-color: <?php echo e($barbershop->warna_primer ?? '#e8a53a'); ?>e6; 
        color: white; 
        transform: translateY(-2px);
        box-shadow: 0 6px 16px <?php echo e(($barbershop->warna_primer ?? '#e8a53a')); ?>40;
    }
    .btn-cancel { 
        background-color: #f8f9fa; 
        color: #495057; 
        border: 1px solid #ced4da; 
        padding: 12px 28px; 
        border-radius: 10px; 
        font-weight: 600; 
        text-decoration: none; 
        display: inline-block; 
        transition: all 0.3s ease; 
    }
    .btn-cancel:hover { 
        background-color: #eef2f5; 
        color: #2b2c3a; 
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="content-body pb-5">
    <div class="form-card card mx-auto mt-4" style="max-width: 850px;">
        <div class="form-header">
            <h4 class="mb-1 fw-bold text-white"><i class="fas fa-magic me-2"></i>Edit Desain & Profil Web</h4>
            <p class="mb-0 text-white-50 small">Sesuaikan tampilan, teks spanduk hero, kontak, dan maps website Anda.</p>
        </div>

        <div class="card-body p-4">
            <form action="<?php echo e(route('admin.barbershop.update', $barbershop->id)); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <!-- Tabs Form Navigation -->
                <ul class="nav nav-pills custom-pills row g-2 mb-4" id="editTabs" role="tablist">
                    <li class="nav-item col-md-4" role="presentation">
                        <button class="nav-link w-100 active text-truncate" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-pane" type="button" role="tab" aria-controls="profile-pane" aria-selected="true">
                            <i class="fas fa-id-card me-2"></i>1. Profil & Warna
                        </button>
                    </li>
                    <li class="nav-item col-md-4" role="presentation">
                        <button class="nav-link w-100 text-truncate" id="heroes-tab" data-bs-toggle="tab" data-bs-target="#heroes-pane" type="button" role="tab" aria-controls="heroes-pane" aria-selected="false">
                            <i class="fas fa-images me-2"></i>2. Hero Halaman
                        </button>
                    </li>
                    <li class="nav-item col-md-4" role="presentation">
                        <button class="nav-link w-100 text-truncate" id="contacts-tab" data-bs-toggle="tab" data-bs-target="#contacts-pane" type="button" role="tab" aria-controls="contacts-pane" aria-selected="false">
                            <i class="fas fa-map-marked-alt me-2"></i>3. Kontak & Peta
                        </button>
                    </li>
                </ul>

                <!-- Tabs Form Content -->
                <div class="tab-content" id="editTabsContent">

                    <!-- Tab 1: Profil & Warna -->
                    <div class="tab-pane fade show active" id="profile-pane" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label for="nama_brand" class="form-label">Nama Brand / Judul Web <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?php $__errorArgs = ['nama_brand'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="nama_brand" name="nama_brand" value="<?php echo e(old('nama_brand', $barbershop->nama_brand)); ?>" required placeholder="Contoh: Arga Home's">
                                <?php $__errorArgs = ['nama_brand'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="slogan" class="form-label">Slogan / Tagline Brand <span class="text-danger">*</span></label>
                                <input type="text" class="form-control <?php $__errorArgs = ['slogan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="slogan" name="slogan" value="<?php echo e(old('slogan', $barbershop->slogan)); ?>" required placeholder="Contoh: Barber, Coffee & Food">
                                <?php $__errorArgs = ['slogan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-12 mb-3">
                                <label for="favicon" class="form-label">Favicon / Logo Brand</label>
                                <div class="row align-items-center g-3">
                                    <div class="col-auto">
                                        <?php if($barbershop->favicon): ?>
                                            <img src="<?php echo e(asset($barbershop->favicon)); ?>" alt="Favicon" class="img-thumbnail rounded shadow-sm" style="max-height: 55px; max-width: 55px; object-fit: contain; padding: 2px;">
                                        <?php else: ?>
                                            <img src="<?php echo e(asset('assets/images/logo.png')); ?>" alt="Logo" class="img-thumbnail rounded shadow-sm" style="max-height: 55px; max-width: 55px; object-fit: contain; padding: 2px;">
                                        <?php endif; ?>
                                    </div>
                                    <div class="col">
                                        <input type="file" class="form-control <?php $__errorArgs = ['favicon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="favicon" name="favicon" accept="image/*">
                                        <small class="text-muted d-block mt-1">Format: JPG, PNG, GIF, SVG, ICO. Maks 2MB. Biarkan kosong jika tidak diubah.</small>
                                    </div>
                                </div>
                                <?php $__errorArgs = ['favicon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback d-block mt-1"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Kontak <span class="text-danger">*</span></label>
                                <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="email" name="email" value="<?php echo e(old('email', $barbershop->email)); ?>" required placeholder="info@argahomes.com">
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                             <div class="col-md-6 mb-3">
                                <div class="card p-3 bg-light border-0 h-100 d-flex flex-column justify-content-center">
                                    <label class="form-label mb-2 fw-semibold">Warna Dasar / Aksen Web</label>
                                    <div id="color-options-container" class="d-flex flex-wrap gap-2 p-2 border rounded-3 bg-white" style="min-height: 40px; align-items: center;">
                                        <!-- Prepopulated by JS -->
                                    </div>
                                    <input type="hidden" name="warna_primer" id="warna_primer" value="<?php echo e(old('warna_primer', $barbershop->warna_primer ?? '#E8A53A')); ?>">
                                    <span class="text-muted mt-2" style="font-size: 0.75rem;">
                                        Pilihan warna kontras tinggi yang disesuaikan dengan kategori <strong><?php echo e($barbershop->kategori === 'barbershop' ? 'Barbershop' : 'Salon'); ?></strong>.
                                    </span>
                                    <?php $__errorArgs = ['warna_primer'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback d-block mt-1"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <label for="alaamat" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                                <textarea class="form-control <?php $__errorArgs = ['alaamat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="alaamat" name="alaamat" rows="3" required placeholder="Jl.P.Siantar Km 2, Tampubolon, Balige..."><?php echo e(old('alaamat', $barbershop->alaamat)); ?></textarea>
                                <?php $__errorArgs = ['alaamat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>


                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="button" class="btn btn-primary next-tab-btn px-4 py-2 fw-semibold" style="background-color: <?php echo e($barbershop->warna_primer ?? '#e8a53a'); ?>; border: none;" data-next="#heroes-tab">
                                Lanjut ke Hero Halaman <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Tab 2: Hero Halaman -->
                    <div class="tab-pane fade" id="heroes-pane" role="tabpanel" aria-labelledby="heroes-tab">
                        
                        <!-- 1. Hero Beranda -->
                        <div class="hero-config-card p-3 mb-4">
                            <h6 class="fw-bold mb-3 d-flex align-items-center gap-2 text-dark border-bottom pb-2">
                                <i class="fas fa-home text-muted"></i> Hero Halaman Beranda (Home)
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-7">
                                    <label for="deskripsi_hero" class="form-label">Deskripsi Hero Beranda <span class="text-danger">*</span></label>
                                    <textarea class="form-control <?php $__errorArgs = ['deskripsi_hero'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="deskripsi_hero" name="deskripsi_hero" rows="4" required placeholder="Tulis deskripsi selamat datang untuk halaman utama..."><?php echo e(old('deskripsi_hero', $barbershop->deskripsi_hero)); ?></textarea>
                                    <small class="text-muted d-block mt-1">Deskripsi ini akan ditampilkan pada area spanduk beranda (hero) dan bagian footer.</small>
                                    <?php $__errorArgs = ['deskripsi_hero'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label">Gambar Hero Beranda</label>
                                    <?php if($barbershop->gambar_hero): ?>
                                        <div class="mb-2">
                                            <img src="<?php echo e(asset($barbershop->gambar_hero)); ?>" alt="Current Hero" class="img-thumbnail rounded shadow-sm" style="max-height: 80px; object-fit: cover; width: 100%;">
                                        </div>
                                    <?php endif; ?>
                                    <input type="file" class="form-control form-control-sm <?php $__errorArgs = ['gambar_hero'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="gambar_hero" name="gambar_hero" accept="image/*">
                                    <small class="text-muted">Format: JPG, PNG, GIF, SVG. Maks 2MB.</small>
                                    <?php $__errorArgs = ['gambar_hero'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Hero Layanan -->
                        <div class="hero-config-card p-3 mb-4">
                            <h6 class="fw-bold mb-3 d-flex align-items-center gap-2 text-dark border-bottom pb-2">
                                <i class="fas fa-concierge-bell text-muted"></i> Hero Halaman Daftar Layanan
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-7">
                                    <div class="mb-3">
                                        <label for="judul_hero_layanan" class="form-label">Judul Hero Layanan <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['judul_hero_layanan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="judul_hero_layanan" name="judul_hero_layanan" value="<?php echo e(old('judul_hero_layanan', $barbershop->judul_hero_layanan)); ?>" required placeholder="Contoh: Daftar Layanan">
                                        <?php $__errorArgs = ['judul_hero_layanan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <div>
                                        <label for="deskripsi_hero_layanan" class="form-label">Deskripsi Hero Layanan <span class="text-danger">*</span></label>
                                        <textarea class="form-control <?php $__errorArgs = ['deskripsi_hero_layanan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="deskripsi_hero_layanan" name="deskripsi_hero_layanan" rows="2" required placeholder="Lihat pilihan layanan yang tersedia..."><?php echo e(old('deskripsi_hero_layanan', $barbershop->deskripsi_hero_layanan)); ?></textarea>
                                        <?php $__errorArgs = ['deskripsi_hero_layanan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label">Gambar Hero Layanan</label>
                                    <?php if($barbershop->gambar_hero_layanan): ?>
                                        <div class="mb-2">
                                            <img src="<?php echo e(asset($barbershop->gambar_hero_layanan)); ?>" alt="Current Services Hero" class="img-thumbnail rounded shadow-sm" style="max-height: 80px; object-fit: cover; width: 100%;">
                                        </div>
                                    <?php endif; ?>
                                    <input type="file" class="form-control form-control-sm <?php $__errorArgs = ['gambar_hero_layanan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="gambar_hero_layanan" name="gambar_hero_layanan" accept="image/*">
                                    <small class="text-muted">Format: JPG, PNG, GIF, SVG. Maks 2MB.</small>
                                    <?php $__errorArgs = ['gambar_hero_layanan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Hero Galeri -->
                        <div class="hero-config-card p-3 mb-4">
                            <h6 class="fw-bold mb-3 d-flex align-items-center gap-2 text-dark border-bottom pb-2">
                                <i class="fas fa-images text-muted"></i> Hero Halaman Galeri
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-7">
                                    <div class="mb-3">
                                        <label for="judul_hero_galeri" class="form-label">Judul Hero Galeri <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['judul_hero_galeri'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="judul_hero_galeri" name="judul_hero_galeri" value="<?php echo e(old('judul_hero_galeri', $barbershop->judul_hero_galeri)); ?>" required placeholder="Contoh: Galeri Kami">
                                        <?php $__errorArgs = ['judul_hero_galeri'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <div>
                                        <label for="deskripsi_hero_galeri" class="form-label">Deskripsi Hero Galeri <span class="text-danger">*</span></label>
                                        <textarea class="form-control <?php $__errorArgs = ['deskripsi_hero_galeri'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="deskripsi_hero_galeri" name="deskripsi_hero_galeri" rows="2" required placeholder="Lihat suasana barbershop kami..."><?php echo e(old('deskripsi_hero_galeri', $barbershop->deskripsi_hero_galeri)); ?></textarea>
                                        <?php $__errorArgs = ['deskripsi_hero_galeri'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label">Gambar Hero Galeri</label>
                                    <?php if($barbershop->gambar_hero_galeri): ?>
                                        <div class="mb-2">
                                            <img src="<?php echo e(asset($barbershop->gambar_hero_galeri)); ?>" alt="Current Gallery Hero" class="img-thumbnail rounded shadow-sm" style="max-height: 80px; object-fit: cover; width: 100%;">
                                        </div>
                                    <?php endif; ?>
                                    <input type="file" class="form-control form-control-sm <?php $__errorArgs = ['gambar_hero_galeri'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="gambar_hero_galeri" name="gambar_hero_galeri" accept="image/*">
                                    <small class="text-muted">Format: JPG, PNG, GIF, SVG. Maks 2MB.</small>
                                    <?php $__errorArgs = ['gambar_hero_galeri'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>



                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-outline-secondary px-4 py-2 fw-semibold next-tab-btn" data-next="#profile-tab">
                                <i class="fas fa-arrow-left me-2"></i> Sebelumnya
                            </button>
                            <button type="button" class="btn btn-primary px-4 py-2 fw-semibold next-tab-btn" style="background-color: <?php echo e($barbershop->warna_primer ?? '#e8a53a'); ?>; border: none;" data-next="#contacts-tab">
                                Lanjut ke Kontak & Peta <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Tab 3: Kontak & Peta -->
                    <div class="tab-pane fade" id="contacts-pane" role="tabpanel" aria-labelledby="contacts-tab">
                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label for="whatsapp" class="form-label">Nomor WhatsApp</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-success text-white border-0" style="width: 45px; justify-content: center;"><i class="fab fa-whatsapp"></i></span>
                                    <input type="text" class="form-control <?php $__errorArgs = ['whatsapp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="whatsapp" name="whatsapp" value="<?php echo e(old('whatsapp', $barbershop->kontak['whatsapp'] ?? '')); ?>" placeholder="Contoh: 0821-6789-3019">
                                </div>
                                <?php $__errorArgs = ['whatsapp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="instagram" class="form-label">Link Instagram (Opsional)</label>
                                <div class="input-group">
                                    <span class="input-group-text text-white border-0" style="background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%); width: 45px; justify-content: center;"><i class="fab fa-instagram"></i></span>
                                    <input type="url" class="form-control <?php $__errorArgs = ['instagram'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="instagram" name="instagram" value="<?php echo e(old('instagram', $barbershop->kontak['instagram'] ?? '')); ?>" placeholder="https://instagram.com/akun">
                                </div>
                                <?php $__errorArgs = ['instagram'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="facebook" class="form-label">Link Facebook (Opsional)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white border-0" style="width: 45px; justify-content: center;"><i class="fab fa-facebook-f"></i></span>
                                    <input type="url" class="form-control <?php $__errorArgs = ['facebook'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="facebook" name="facebook" value="<?php echo e(old('facebook', $barbershop->kontak['facebook'] ?? '')); ?>" placeholder="https://facebook.com/halaman">
                                </div>
                                <?php $__errorArgs = ['facebook'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="link_map" class="form-label">Link Google Maps (Tombol Navigasi)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-danger text-white border-0" style="width: 45px; justify-content: center;"><i class="fas fa-map-marker-alt"></i></span>
                                    <input type="url" class="form-control <?php $__errorArgs = ['link_map'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="link_map" name="link_map" value="<?php echo e(old('link_map', $barbershop->kontak['link_map'] ?? '')); ?>" placeholder="https://maps.app.goo.gl/xyz">
                                </div>
                                <small class="text-muted d-block mt-1">Link ini digunakan pada tombol rute navigasi Google Maps di footer website konsumen.</small>
                                <?php $__errorArgs = ['link_map'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="map_embed" class="form-label">URL Embed Peta (Iframe Preview)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-secondary text-white border-0" style="width: 45px; justify-content: center;"><i class="fas fa-code"></i></span>
                                    <textarea class="form-control <?php $__errorArgs = ['map_embed'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="map_embed" name="map_embed" rows="3" placeholder="Contoh: https://www.google.com/maps/embed?pb=..."><?php echo e(old('map_embed', $barbershop->kontak['map_embed'] ?? '')); ?></textarea>
                                </div>
                                <small class="text-muted d-block mt-1">Cara mendapatkan: Buka Google Maps > Bagikan > Sematkan Peta > Salin URL di dalam parameter <code>src="..."</code> saja.</small>
                                <?php $__errorArgs = ['map_embed'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-outline-secondary px-4 py-2 fw-semibold next-tab-btn" data-next="#heroes-tab">
                                <i class="fas fa-arrow-left me-2"></i> Sebelumnya
                            </button>
                            <div class="d-flex gap-2">
                                <a href="<?php echo e(route('admin.barbershop.index')); ?>" class="btn-cancel px-4 py-2">Batal</a>
                                <button type="submit" class="btn-submit">Simpan Perubahan</button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle Next / Previous tab buttons
        document.querySelectorAll('.next-tab-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const targetTabId = this.dataset.next;
                const nextTabEl = document.querySelector(targetTabId);
                if (nextTabEl) {
                    const tabTrigger = new bootstrap.Tab(nextTabEl);
                    tabTrigger.show();
                    window.scrollTo({ top: 100, behavior: 'smooth' });
                }
            });
        });

        // Handle HTML5 validation across hidden tabs
        document.addEventListener('invalid', function(e) {
            const invalidField = e.target;
            if(!invalidField.closest('form')) return;

            const tabPane = invalidField.closest('.tab-pane');
            if (tabPane && !tabPane.classList.contains('show')) {
                e.preventDefault(); // Prevent browser error "invalid form control is not focusable"
                const targetTabBtn = document.querySelector('button[data-bs-target="#' + tabPane.id + '"]');
                if (targetTabBtn) {
                    const tab = new bootstrap.Tab(targetTabBtn);
                    tab.show();
                    setTimeout(() => {
                        invalidField.focus();
                        invalidField.reportValidity();
                    }, 200);
                }
            }
        }, true);

        // Predefined color choices by category
        const colors = {
            barbershop: [
                { name: 'Emas (Gold)', hex: '#E8A53A' },
                { name: 'Biru (Vibrant Blue)', hex: '#0578FB' },
                { name: 'Hijau (Teal Mint)', hex: '#10B981' }
            ],
            salon: [
                { name: 'Merah Muda (Rose Pink)', hex: '#EC4899' },
                { name: 'Ungu (Violet Purple)', hex: '#A78BFA' },
                { name: 'Oranye (Coral Peach)', hex: '#F97316' },
                { name: 'Magenta (Orchid)', hex: '#E040FB' }
            ]
        };

        const kategori = '<?php echo e($barbershop->kategori ?? "barbershop"); ?>';
        const container = document.getElementById('color-options-container');
        const inputWarna = document.getElementById('warna_primer');
        
        if (container && inputWarna) {
            const options = colors[kategori] || [];
            let selectedHex = inputWarna.value.toUpperCase();
            
            const matchesOption = options.some(opt => opt.hex.toUpperCase() === selectedHex);
            if (!matchesOption && options.length > 0) {
                selectedHex = options[0].hex;
                inputWarna.value = selectedHex;
            }
            
            options.forEach(opt => {
                const isSelected = opt.hex.toUpperCase() === selectedHex.toUpperCase();
                const swatch = document.createElement('div');
                swatch.className = `d-flex align-items-center gap-1 px-2 py-1 border rounded-2 color-swatch-item ${isSelected ? 'border-primary bg-white shadow-sm' : 'border-secondary-subtle bg-white'}`;
                swatch.style.cursor = 'pointer';
                swatch.style.transition = 'all 0.15s';
                swatch.style.borderWidth = isSelected ? '2px' : '1px';
                
                swatch.onclick = () => {
                    inputWarna.value = opt.hex;
                    document.querySelectorAll('.color-swatch-item').forEach(el => {
                        el.classList.remove('border-primary', 'shadow-sm');
                        el.classList.add('border-secondary-subtle');
                        el.style.borderWidth = '1px';
                    });
                    swatch.classList.remove('border-secondary-subtle');
                    swatch.classList.add('border-primary', 'shadow-sm');
                    swatch.style.borderWidth = '2px';
                };
                
                swatch.innerHTML = `
                    <span style="display:inline-block; width: 14px; height: 14px; border-radius: 50%; background-color: ${opt.hex}; border: 1px solid rgba(0,0,0,0.15);"></span>
                    <span class="fw-semibold text-dark" style="font-size: 0.75rem;">${opt.name}</span>
                `;
                
                container.appendChild(swatch);
            });
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\s6\pa 3\pa_3v3\Kelompok-2-PA-3\resources\views\admin\barbershop\edit.blade.php ENDPATH**/ ?>