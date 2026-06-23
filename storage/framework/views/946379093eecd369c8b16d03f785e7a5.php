<?php $__env->startSection('title', 'Edit Layanan'); ?>

<?php $__env->startSection('header_title'); ?>
    <div class="header-title">Edit Layanan</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="content-header">
    <h2 style="margin-left: 20px; margin-top: 20px;">Edit Layanan</h2>
</div>

<div class="content-body">
    <div class="card shadow-sm mx-auto" style="max-width: 720px;">
        <div class="card-body">
            <form action="<?php echo e(route('admin.layanan.update', $layanan->id)); ?>" method="POST" enctype="multipart/form-data">
                <?php echo method_field('PUT'); ?>
                <?php echo $__env->make('admin.layanan._form', ['layanan' => $layanan], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\s6\pa 3\pa_3v3\Kelompok-2-PA-3\resources\views\admin\layanan\edit.blade.php ENDPATH**/ ?>