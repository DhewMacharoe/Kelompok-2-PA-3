<?php $__env->startSection('title', 'Layanan'); ?>

<?php $__env->startPush('styles'); ?>
    <?php echo $__env->make('pelanggan.layanan.styles', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('pelanggan.homepage.style-index', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopPush(); ?>



<?php $__env->startSection('content'); ?>
    <section class="layanan-hero">
        <div class="layanan-hero-overlay">
            <div class="layanan-hero-text">
                <h1><?php echo e($activeDesign->judul_hero_layanan ?? 'Daftar Layanan'); ?></h1>
                <p><?php echo e($activeDesign->deskripsi_hero_layanan ?? 'Lihat pilihan layanan yang tersedia beserta harga dan estimasi waktunya.'); ?></p>
            </div>
        </div>
    </section>

    <section class="layanan-content">
        <div class="layanan-grid">
            <?php $__empty_1 = true; $__currentLoopData = $layanans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $layanan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="layanan-card" id="layanan-<?php echo e($layanan->id); ?>" style="cursor: pointer;"
                     data-id="<?php echo e($layanan->id); ?>"
                     data-name="<?php echo e($layanan->nama); ?>"
                     data-description="<?php echo e(e($layanan->deskripsi ?? 'Tidak ada deskripsi.')); ?>"
                     data-time="<?php echo e($layanan->estimasi_waktu); ?>"
                     data-ikon="<?php echo e($layanan->ikon); ?>"
                     data-price="<?php echo e(number_format($layanan->harga, 0, ',', '.')); ?>">
                    
                    <div class="icon-circle shadow-sm">
                        <?php if($layanan->ikon === 'paint'): ?>
                            <i class="fas fa-paint-brush"></i>
                        <?php elseif($layanan->ikon === 'face'): ?>
                            <i class="fas fa-smile"></i>
                        <?php else: ?>
                            <i class="fas fa-cut"></i>
                        <?php endif; ?>
                    </div>
                    
                    <div class="layanan-card-body">
                        <h4><?php echo e($layanan->nama); ?></h4>
                        <p class="layanan-desc"><?php echo e($layanan->deskripsi); ?></p>
                        <p class="layanan-time"><i class="far fa-clock"></i> <?php echo e($layanan->estimasi_waktu ? $layanan->estimasi_waktu . ' Menit' : '-'); ?></p>
                        <p class="layanan-price">Rp<?php echo e(number_format($layanan->harga, 0, ',', '.')); ?></p>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="layanan-empty">
                    <p>Maaf, saat ini belum ada layanan yang tersedia.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php echo $__env->make('pelanggan.partials.layanan-detail-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Modal detail popup untuk Layanan
            const modalOverlay = document.getElementById('layananDetailModal');
            const modalCloseBtn = document.getElementById('modalCloseBtn');
            const modalName = document.getElementById('modalLayananName');
            const modalTime = document.getElementById('modalLayananTime');
            const modalDescription = document.getElementById('modalLayananDescription');
            const modalPrice = document.getElementById('modalLayananPrice');

            const btnBuatAntrean = document.getElementById('btnBuatAntreanDariLayanan');
            const antreanBaseUrl = "<?php echo e(route('antrean')); ?>";

            document.querySelectorAll('.layanan-card').forEach(item => {
                item.addEventListener('click', function() {
                    const layananId = this.dataset.id;
                    const ikon = this.dataset.ikon;
                    modalName.textContent = this.dataset.name;
                    modalTime.innerHTML = '<i class="far fa-clock"></i> ' + (this.dataset.time ? this.dataset.time + ' Menit' : '-');
                    modalDescription.textContent = this.dataset.description;
                    modalPrice.textContent = 'Rp ' + this.dataset.price;

                    // Update modal icon
                    const modalIconWrapper = document.querySelector('.modal-image-wrapper');
                    if (modalIconWrapper) {
                        let iconClass = 'fas fa-cut';
                        if (ikon === 'paint') iconClass = 'fas fa-paint-brush';
                        if (ikon === 'face') iconClass = 'fas fa-smile';
                        modalIconWrapper.innerHTML = `<i class="${iconClass}"></i>`;
                    }

                    // Update href tombol Buat Antrean
                    if (btnBuatAntrean) {
                        btnBuatAntrean.href = antreanBaseUrl + '?layanan_id=' + layananId;
                    }

                    modalOverlay.classList.add('active');
                });
            });

            const modalBackBtn = document.getElementById('modalBackBtn');
            const modalBackBottomBtn = document.getElementById('modalBackBottomBtn');

            function handleBackOrClose() {
                const urlParams = new URLSearchParams(window.location.search);
                const fromAntrean = urlParams.get('from') === 'antrean';

                if (fromAntrean) {
                    if (document.referrer && document.referrer.includes('/antrean')) {
                        history.back();
                    } else {
                        window.location.href = "<?php echo e(route('antrean')); ?>";
                    }
                } else {
                    modalOverlay.classList.remove('active');
                    // Bersihkan URL query parameter tanpa reload
                    const cleanUrl = window.location.pathname;
                    window.history.replaceState({}, document.title, cleanUrl);
                }
            }

            if (modalBackBtn) {
                modalBackBtn.addEventListener('click', handleBackOrClose);
            }

            if (modalBackBottomBtn) {
                modalBackBottomBtn.addEventListener('click', handleBackOrClose);
            }

            if (modalCloseBtn) {
                modalCloseBtn.addEventListener('click', handleBackOrClose);
            }

            if (modalOverlay) {
                modalOverlay.addEventListener('click', function(event) {
                    if (event.target === modalOverlay) {
                        handleBackOrClose();
                    }
                });
            }

            const urlParams = new URLSearchParams(window.location.search);
            const targetId = urlParams.get('id');

            if (targetId) {
                const targetElement = document.getElementById('layanan-' + targetId);

                if (targetElement) {
                    const openModal = urlParams.get('open');
                    
                    if (openModal === 'true') {
                        // Langsung buka modal
                        setTimeout(() => {
                            targetElement.click();
                        }, 100);
                    } else {
                        // Beri sedikit jeda agar browser selesai merender layout
                        setTimeout(() => {
                            targetElement.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });

                            // Efek highlight
                            targetElement.style.transition = 'all 0.5s ease';
                            targetElement.style.boxShadow = '0 0 20px rgba(212, 175, 55, 0.8)';
                            targetElement.style.transform = 'scale(1.05)';
                            targetElement.style.zIndex = '10';

                            // Kembalikan ke normal setelah 3 detik
                            setTimeout(() => {
                                targetElement.style.boxShadow = '';
                                targetElement.style.transform = '';
                                targetElement.style.zIndex = '';
                            }, 3000);
                        }, 300);
                    }
                }
            }
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('pelanggan.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\s6\pa 3\pa_3v3\Kelompok-2-PA-3\resources\views\pelanggan\layanan\layanan.blade.php ENDPATH**/ ?>