<?php $__env->startSection('title', 'Edit Profil'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card overflow-hidden">
                <div class="card-header text-center text-white py-4" style="background-color: var(--hero-bg); border-bottom: 3px solid var(--accent-gold);">
                    <h4 class="mb-0 fw-bold" style="color: var(--accent-gold);">Profil Saya</h4>
                </div>
                <div class="card-body p-4 p-md-5">

                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo e(session('error')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo e(route('profile.update')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary">Email</label>
                            <input type="email" class="form-control form-control-lg bg-light" 
                                value="<?php echo e($user->email); ?>" readonly disabled>
                            <div class="form-text mt-1">Email Anda terhubung dengan Firebase dan tidak dapat diubah.</div>
                        </div>

                        <div class="mb-4">
                            <label for="username" class="form-label fw-bold text-secondary">Username</label>
                            <input type="text" class="form-control form-control-lg <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                id="username" name="username" value="<?php echo e(old('username', $user->username)); ?>" 
                                placeholder="Masukkan username baru..." required readonly>
                            <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback">
                                    <?php echo e($message); ?>

                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-4">
                            <label for="no_whatsapp" class="form-label fw-bold text-secondary">Nomor WhatsApp</label>
                            <input type="text" class="form-control form-control-lg <?php $__errorArgs = ['no_whatsapp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                id="no_whatsapp" name="no_whatsapp" value="<?php echo e(old('no_whatsapp', $user->no_whatsapp)); ?>" 
                                placeholder="Contoh: 081234567890" pattern="^08[0-9]{8,13}$" required readonly>
                            <div class="form-text">Digunakan untuk menerima notifikasi antrean secara real-time.</div>
                            <?php $__errorArgs = ['no_whatsapp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback">
                                    <?php echo e($message); ?>

                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="d-grid gap-2 mt-5" id="action-buttons">
                            <button type="button" id="btn-edit" class="btn btn-secondary btn-lg fw-bold">
                                <i class="fas fa-edit me-2"></i>Ubah Profil
                            </button>
                            <button type="submit" id="btn-save" class="btn btn-gold btn-lg fw-bold d-none">
                                Simpan Perubahan
                            </button>
                            <button type="button" id="btn-cancel" class="btn btn-danger btn-lg fw-bold d-none">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnEdit = document.getElementById('btn-edit');
        const btnSave = document.getElementById('btn-save');
        const btnCancel = document.getElementById('btn-cancel');
        const usernameInput = document.getElementById('username');
        const whatsappInput = document.getElementById('no_whatsapp');
        const originalUsername = usernameInput.value;
        const originalWhatsapp = whatsappInput.value;

        <?php if($errors->has('username') || $errors->has('no_whatsapp')): ?>
            enableEditMode();
        <?php endif; ?>

        btnEdit.addEventListener('click', function() {
            enableEditMode();
            usernameInput.focus();
        });

        btnCancel.addEventListener('click', function() {
            disableEditMode();
            usernameInput.value = originalUsername;
            whatsappInput.value = originalWhatsapp;
        });

        function enableEditMode() {
            usernameInput.removeAttribute('readonly');
            whatsappInput.removeAttribute('readonly');
            btnEdit.classList.add('d-none');
            btnSave.classList.remove('d-none');
            btnCancel.classList.remove('d-none');
        }

        function disableEditMode() {
            usernameInput.setAttribute('readonly', 'true');
            whatsappInput.setAttribute('readonly', 'true');
            btnEdit.classList.remove('d-none');
            btnSave.classList.add('d-none');
            btnCancel.classList.add('d-none');
            usernameInput.classList.remove('is-invalid');
            whatsappInput.classList.remove('is-invalid');
            const feedbacks = document.querySelectorAll('.invalid-feedback');
            feedbacks.forEach(f => f.style.display = 'none');
        }
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('pelanggan.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\s6\pa 3\pa_3v3\Kelompok-2-PA-3\resources\views\pelanggan\profile\edit.blade.php ENDPATH**/ ?>