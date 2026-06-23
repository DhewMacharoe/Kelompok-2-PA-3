<?php $__env->startSection('body_class', 'auth-page auth-page--public'); ?>
<?php $__env->startSection('hide_public_chrome', '1'); ?>

<?php $__env->startSection('head'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/arga-auth.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('title', isset($activeBarbershop) && $activeBarbershop->nama_brand ? 'Lengkapi Profil - ' . $activeBarbershop->nama_brand : "Lengkapi Profil - Arga Home's"); ?>

<?php $__env->startSection('content'); ?>
    <div class="auth-shell auth-shell--public">
        <div class="auth-card auth-card--compact">
            <div class="auth-form">
                <div class="auth-form-inner">
                    <div class="auth-kicker">Langkah terakhir</div>
                    <h2 class="auth-section-title">Lengkapi profil Anda</h2>
                    <?php if(session('error')): ?>
                        <div class="auth-alert auth-alert--error small text-start">
                            <?php echo e(session('error')); ?>

                        </div>
                    <?php endif; ?>

                    <?php if($errors->any()): ?>
                        <div class="auth-alert auth-alert--error small text-start">
                            <?php echo e($errors->first()); ?>

                        </div>
                    <?php endif; ?>

                    <form action="<?php echo e(route('set.username.post')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="auth-input-group">
                            <label for="username" class="auth-label">Username</label>
                            <input type="text" id="username" name="username" required class="auth-input"
                                placeholder="Masukkan username" value="<?php echo e(old('username', auth()->user()->username)); ?>" minlength="3" maxlength="20"
                                pattern="[A-Za-z0-9_ ]+" title="Hanya menggunakan huruf, angka, underscore dan spasi. Maksimal 20 karakter.">
                        </div>

                        <div class="auth-input-group">
                            <label for="no_whatsapp" class="auth-label">Nomor WhatsApp</label>
                            <input type="text" id="no_whatsapp" name="no_whatsapp" required class="auth-input"
                                placeholder="Contoh: 081234567890" value="<?php echo e(old('no_whatsapp', auth()->user()->no_whatsapp)); ?>"
                                pattern="^08[0-9]{8,13}$" title="Format nomor WhatsApp tidak valid (harus diawali 08 dan berisi 10-15 angka).">
                            <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">Digunakan untuk mengirimkan notifikasi antrean.</small>
                        </div>

                        <button type="submit" class="auth-button auth-button--google mt-3">Simpan Profil</button>
                    </form>

                    <p class="auth-footer-copy mb-0">Setelah disimpan, Anda akan diarahkan kembali ke halaman utama Arga
                        Home's.</p>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\s6\pa 3\pa_3v3\Kelompok-2-PA-3\resources\views\auth\set_username.blade.php ENDPATH**/ ?>