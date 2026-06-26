<?php $__env->startSection('title', 'Kelola Admin Tenant'); ?>

<?php $__env->startSection('content'); ?>
<div class="card shadow-sm border-0 rounded-3">
    <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
        <h5 class="m-0 fw-bold text-dark"><i class="bi bi-people me-2"></i>Daftar Admin Tenant</h5>
        <a href="<?php echo e(route('super-admin.admins.create')); ?>" class="btn btn-sm btn-gold px-3"><i class="bi bi-plus-lg me-1"></i>Tambah Admin</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-4 py-3" style="width: 50px;">ID</th>
                        <th class="py-3">Nama Lengkap</th>
                        <th class="py-3">Username</th>
                        <th class="py-3">Email</th>
                        <th class="py-3">Mengelola Tenant</th>
                        <th class="py-3 text-end px-4" style="width: 250px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $admins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $adm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="px-4 fw-bold text-muted"><?php echo e($adm->id); ?></td>
                            <td class="fw-bold text-dark"><?php echo e($adm->name); ?></td>
                            <td><span class="badge bg-secondary bg-opacity-10 text-secondary font-monospace"><?php echo e($adm->username); ?></span></td>
                            <td><?php echo e($adm->email); ?></td>
                            <td>
                                <?php if($adm->barbershop): ?>
                                    <div class="fw-bold text-primary"><?php echo e($adm->barbershop->nama); ?></div>
                                    <div class="text-muted small">ID Tenant: <?php echo e($adm->barbershop->id); ?></div>
                                <?php else: ?>
                                    <span class="text-danger fw-bold"><i class="bi bi-exclamation-circle me-1"></i>Belum terikat</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end px-4">
                                <div class="d-inline-flex gap-2">
                                    <a href="<?php echo e(route('super-admin.admins.edit', $adm->id)); ?>" class="btn btn-sm btn-outline-secondary px-2">
                                        <i class="bi bi-pencil me-1"></i>Edit
                                    </a>
                                    <form action="<?php echo e(route('super-admin.admins.destroy', $adm->id)); ?>" method="POST" class="d-inline m-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus admin ini?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger px-2">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-people fs-1 d-block mb-3"></i>
                                Belum ada admin tenant terdaftar.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.super_admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH K:\Deploy-Argahomes\resources\views/super_admin/admins/index.blade.php ENDPATH**/ ?>