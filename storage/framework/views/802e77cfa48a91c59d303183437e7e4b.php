<header class="main-header d-flex justify-content-between align-items-center">

    <div class="d-flex align-items-center gap-3" style="min-width: 0; flex: 1; margin-right: 15px;">
        <button class="btn d-md-none p-1 flex-shrink-0" id="mobileSidebarToggle" type="button" aria-label="Buka menu">
            <i class="bi bi-list fs-4"></i>
        </button>
        <h5 class="mb-0 fw-bold text-truncate" style="font-size: 1.1rem; min-width: 0; flex: 1;"><?php echo $__env->yieldContent('title', 'Dashboard'); ?></h5>
    </div>
    <div class="ms-auto d-flex align-items-center gap-2 gap-sm-3 flex-shrink-0">
        <div class="d-flex flex-column text-end d-none d-sm-flex" style="line-height: 1.2;">
            <span class="text-muted" style="font-size: 0.75rem;">Masuk sebagai:</span>
            <span class="fw-bold text-primary" style="font-size: 0.85rem;">Admin <?php echo e($activeBarbershop->nama_brand ?? 'Barbershop'); ?></span>
        </div>
        <img src="https://ui-avatars.com/api/?name=Admin&background=0578FB&color=fff" class="rounded-circle" width="35" alt="Profile">
        <form action="<?php echo e(route('admin.logout')); ?>" method="POST" class="d-inline">
            <?php echo csrf_field(); ?>
            <button type="submit" aria-label="Keluar dari sistem"
                style="padding: 10px 16px; background: #dc3545; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: 600; line-height: 1; transition: background 0.2s;">
                Keluar
            </button>
        </form>
    </div>

</header>
<?php /**PATH K:\Deploy-Argahomes\resources\views/admin/layouts/header.blade.php ENDPATH**/ ?>