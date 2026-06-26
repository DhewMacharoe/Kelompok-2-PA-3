<?php $__env->startSection('title', 'Galeri'); ?>

<?php $__env->startSection('content'); ?>

<?php echo $__env->make('pelanggan.galeri.style-index', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<section class="galeri-hero">
    <div class="galeri-hero-overlay">
        <div class="galeri-hero-text">
            <h1>Galeri <?php echo e($activeBarbershop->nama_brand ?? "Arga Home's"); ?></h1>
            <p>
                Lihat suasana barbershop, hasil potongan rambut, dan area coffee
                di <?php echo e($activeBarbershop->nama_brand ?? "Arga Home's"); ?> sebelum datang ke tempat.
            </p>
        </div>
    </div>
</section>

<section class="galeri-content">
    <div class="galeri-section-header">
        <h2>Galeri <?php echo e($activeBarbershop->nama_brand ?? "Arga Home's"); ?></h2>
        <div class="galeri-line"></div>
    </div>

    <?php if($galeris->count() > 0): ?>
        <div class="galeri-grid">
            <?php $__currentLoopData = $galeris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $galeri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="galeri-card">
                    <div class="galeri-card-image">
                            <img src="<?php echo e(\Illuminate\Support\Str::startsWith($galeri->gambar, ['http://', 'https://']) ? $galeri->gambar : asset('images/' . $galeri->gambar)); ?>"
                             alt="<?php echo e($galeri->judul); ?>">
                    </div>

                    <div class="galeri-card-body">
                        <h3><?php echo e($galeri->judul); ?></h3>

                        <?php if($galeri->deskripsi): ?>
                            <p><?php echo e($galeri->deskripsi); ?></p>
                        <?php else: ?>
                            <p>Dokumentasi visual <?php echo e($activeBarbershop->nama_brand ?? "Arga Home's"); ?> Barber, Coffee & Food.</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php else: ?>
        <div class="galeri-empty">
            <h3>Belum Ada Foto Galeri</h3>
            <p>Foto galeri akan ditampilkan setelah pemilik menambahkan data dari halaman admin.</p>
        </div>
    <?php endif; ?>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('pelanggan.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH K:\Deploy-Argahomes\resources\views/pelanggan/galeri/galeri.blade.php ENDPATH**/ ?>