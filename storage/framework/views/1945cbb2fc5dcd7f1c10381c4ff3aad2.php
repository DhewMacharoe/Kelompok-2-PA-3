<header class="main-header d-flex justify-content-between align-items-center">

    <div class="d-flex align-items-center gap-3">
        <button class="btn d-md-none p-1" id="mobileSidebarToggle" type="button" aria-label="Buka menu">
            <i class="bi bi-list fs-4"></i>
        </button>
        <h5 class="mb-0 fw-bold text-truncate"><?php echo $__env->yieldContent('title', 'Dashboard'); ?></h5>
    </div>
    <div class="ms-auto d-flex align-items-center gap-3">
        <div class="d-flex flex-column text-end d-none d-sm-flex" style="line-height: 1.2;">
            <span class="text-muted" style="font-size: 0.75rem;">Masuk sebagai:</span>
            <span class="fw-bold text-primary" style="font-size: 0.85rem;">Admin <?php echo e($activeBarbershop->nama_brand ?? 'Barbershop'); ?></span>
        </div>
        <img src="https://ui-avatars.com/api/?name=Admin&background=0578FB&color=fff" class="rounded-circle" width="35" alt="Profile">
        <form action="<?php echo e(route('admin.logout')); ?>" method="POST" class="d-inline">
            <?php echo csrf_field(); ?>
            <button type="submit"
                style="padding: 6px 10px; background: #dc3545; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 12px; line-height: 1;">
                Keluar
            </button>
        </form>
    </div>

</header>
<?php /**PATH D:\s6\pa 3\pa_3v3\Kelompok-2-PA-3\resources\views\admin\layouts\header.blade.php ENDPATH**/ ?>