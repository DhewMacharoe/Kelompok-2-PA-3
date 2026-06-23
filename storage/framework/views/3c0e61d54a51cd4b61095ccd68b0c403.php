<?php $__env->startSection('title', 'Edit Galeri'); ?>

<?php $__env->startSection('content'); ?>
<div class="content-header">
    <h2>Edit Galeri</h2>
</div>

<div class="content-body">
    <div class="card shadow-sm mx-auto" style="max-width: 720px;">
        <div class="card-body">

            <form action="<?php echo e(route('admin.galeri.update', $galeri)); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="mb-3">
                    <label class="form-label">Judul Galeri</label>
                    <input type="text"
                           name="judul"
                           class="form-control"
                           value="<?php echo e(old('judul', $galeri->judul)); ?>"
                           placeholder="Contoh: Suasana Arga Home's"
                           required>

                    <?php $__errorArgs = ['judul'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <small class="text-danger"><?php echo e($message); ?></small>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi"
                              class="form-control"
                              rows="4"
                              placeholder="Contoh: Dokumentasi suasana barbershop dan coffee."><?php echo e(old('deskripsi', $galeri->deskripsi)); ?></textarea>

                    <?php $__errorArgs = ['deskripsi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <small class="text-danger"><?php echo e($message); ?></small>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-3">
                    <label class="form-label">Gambar Galeri</label>
                    <input type="file"
                           name="gambar"
                           id="gambarInput"
                           class="form-control"
                           accept="image/*">

                    <small class="text-muted">
                        Kosongkan jika tidak ingin mengganti gambar.
                    </small>

                    <?php $__errorArgs = ['gambar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <small class="text-danger d-block"><?php echo e($message); ?></small>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <?php if($galeri->gambar): ?>
                    <div class="mb-3">
                        <label class="form-label">Preview Gambar Saat Ini</label>
                        <br>
                        <img id="previewGambar"
                                src="<?php echo e(\Illuminate\Support\Str::startsWith($galeri->gambar, ['http://', 'https://']) ? $galeri->gambar : asset('images/' . $galeri->gambar)); ?>"
                             alt="<?php echo e($galeri->judul); ?>"
                             style="width: 180px; height: 120px; object-fit: cover; border-radius: 8px;">
                    </div>
                <?php endif; ?>

                <div class="mb-4">
                    <label class="form-label">Status</label>
                    <select name="is_active" class="form-control" required>
                        <option value="1" <?php echo e(old('is_active', $galeri->is_active) == 1 ? 'selected' : ''); ?>>
                            Aktif
                        </option>
                        <option value="0" <?php echo e(old('is_active', $galeri->is_active) == 0 ? 'selected' : ''); ?>>
                            Nonaktif
                        </option>
                    </select>

                    <?php $__errorArgs = ['is_active'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <small class="text-danger"><?php echo e($message); ?></small>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="<?php echo e(route('admin.galeri.index')); ?>" class="btn btn-danger">
                        Batal
                    </a>

                    <button type="submit" class="btn btn-primary" data-loading-text="Menyimpan...">
                        Simpan
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const gambarInput = document.getElementById('gambarInput');
        const previewGambar = document.getElementById('previewGambar');

        if (gambarInput && previewGambar) {
            gambarInput.addEventListener('change', function (event) {
                const file = event.target.files[0];

                if (file) {
                    previewGambar.src = URL.createObjectURL(file);
                }
            });
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\s6\pa 3\pa_3v3\Kelompok-2-PA-3\resources\views\admin\galeri\edit.blade.php ENDPATH**/ ?>