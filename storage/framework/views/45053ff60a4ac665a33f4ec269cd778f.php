<nav class="sidebar shadow py-4">
    <div class="px-4 mb-4">
        <div class="d-flex justify-content-end d-md-none mb-2">
            <button type="button" class="btn btn-sm btn-outline-light" id="mobileSidebarClose" aria-label="Tutup menu">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <h4 class="fw-bold m-0 text-white" style="font-size: 1.15rem; letter-spacing: -0.01em;">
            <span style="color: var(--primary-blue)"><?php echo e($activeBarbershop->nama_brand ?? 'Barbershop'); ?></span>
        </h4>
        <div class="mt-2 small text-white-50" style="font-size: 0.75rem;">
            <i class="bi bi-shield-lock-fill text-success"></i> Panel Admin
        </div>
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link <?php echo e(request()->is('admin/dashboard') ? 'active' : ''); ?>" href="/admin/dashboard">
                <i class="bi bi-speedometer2"></i> Dasbor
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo e(request()->is('admin/antrean*') ? 'active' : ''); ?>" href="/admin/antrean">
                <i class="bi bi-people"></i> Antrean
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo e(request()->is('admin/moderasi*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.moderasi.index')); ?>">
                <i class="bi bi-shield-exclamation"></i> Moderasi Pelanggan
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo e(request()->is('admin/galeri*') ? 'active' : ''); ?>"
                href="<?php echo e(route('admin.galeri.index')); ?>">
                <i class="bi bi-images"></i> Galeri
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo e(request()->is('admin/layanan*') ? 'active' : ''); ?>" href="/admin/layanan">
                <i class="bi bi-gear"></i> Layanan
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?php echo e(request()->routeIs('admin.lokasi.index') ? 'active' : ''); ?>" href="<?php echo e(route('admin.lokasi.index')); ?>">
                <i class="bi bi-geo-alt"></i> Jam & Lokasi
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo e(request()->is('admin/barbershop*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.barbershop.index')); ?>">
                <i class="bi bi-palette"></i> barbershop Web
            </a>
        </li>
    </ul>
</nav>
<?php /**PATH K:\Deploy-Argahomes\resources\views/admin/layouts/sidebar.blade.php ENDPATH**/ ?>