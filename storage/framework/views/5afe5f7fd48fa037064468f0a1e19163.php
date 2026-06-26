<?php $__env->startSection('title', 'Edit Tenant'); ?>

<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="m-0 fw-bold text-dark"><i class="bi bi-pencil-square me-2 text-warning"></i>Edit Data Tenant</h5>
            </div>
            <div class="card-body p-4">
                <form action="<?php echo e(route('super-admin.barbershops.update', $barbershop->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    
                    <div class="mb-3">
                        <label for="nama" class="form-label fw-bold">Nama Tenant <span class="text-danger">*</span></label>
                        <input type="text" class="form-control <?php $__errorArgs = ['nama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="nama" name="nama" value="<?php echo e(old('nama', $barbershop->nama)); ?>" required placeholder="Contoh: Arga Barbershop atau Salon Cantik">
                        <?php $__errorArgs = ['nama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label fw-bold">Slug URL (Opsional)</label>
                        <input type="text" class="form-control <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="slug" name="slug" value="<?php echo e(old('slug', $barbershop->slug)); ?>" placeholder="Contoh: arga-balige (akan otomatis dibuat jika kosong)">
                        <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kategori" class="form-label fw-bold">Kategori Tenant <span class="text-danger">*</span></label>
                            <select class="form-select <?php $__errorArgs = ['kategori'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="kategori" name="kategori" required onchange="updateColorOptions()">
                                <option value="barbershop" <?php echo e(old('kategori', $barbershop->kategori) == 'barbershop' ? 'selected' : ''); ?>>Barbershop (Maskulin)</option>
                                <option value="salon" <?php echo e(old('kategori', $barbershop->kategori) == 'salon' ? 'selected' : ''); ?>>Salon (Feminim)</option>
                            </select>
                            <?php $__errorArgs = ['kategori'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Pilihan Warna Aksen Web <span class="text-danger">*</span></label>
                            <div id="color-options-container" class="d-flex flex-wrap gap-2 p-2 border rounded-3 bg-light" style="min-height: 40px; align-items: center;">
                                <!-- Will be populated dynamically by JS -->
                            </div>
                            <input type="hidden" name="warna_primer" id="warna_primer" value="<?php echo e(old('warna_primer', $barbershop->warna_primer ?? '#E8A53A')); ?>">
                            <?php $__errorArgs = ['warna_primer'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="telepon" class="form-label fw-bold">No. Telepon / WhatsApp</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['telepon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="telepon" name="telepon" value="<?php echo e(old('telepon', $barbershop->telepon)); ?>" placeholder="Contoh: 0821xxxxxxxx">
                            <?php $__errorArgs = ['telepon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold d-block">Status Keaktifan</label>
                            <div class="form-check form-switch pt-2">
                                <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" <?php echo e(old('is_active', $barbershop->is_active) ? 'checked' : ''); ?>>
                                <label class="form-check-label fw-bold text-muted" for="is_active">Aktif (Dapat diakses pelanggan)</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="latitude" class="form-label fw-bold">Latitude Lokasi</label>
                            <input type="number" step="any" class="form-control <?php $__errorArgs = ['latitude'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="latitude" name="latitude" value="<?php echo e(old('latitude', $barbershop->latitude)); ?>" placeholder="Contoh: 2.386130">
                            <?php $__errorArgs = ['latitude'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="longitude" class="form-label fw-bold">Longitude Lokasi</label>
                            <input type="number" step="any" class="form-control <?php $__errorArgs = ['longitude'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="longitude" name="longitude" value="<?php echo e(old('longitude', $barbershop->longitude)); ?>" placeholder="Contoh: 99.147852">
                            <?php $__errorArgs = ['longitude'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label fw-bold">Alamat Lengkap</label>
                        <textarea class="form-control <?php $__errorArgs = ['alamat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat lengkap tenant..."><?php echo e(old('alamat', $barbershop->alamat)); ?></textarea>
                        <?php $__errorArgs = ['alamat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="mb-4">
                        <label for="deskripsi" class="form-label fw-bold">Deskripsi Singkat</label>
                        <textarea class="form-control <?php $__errorArgs = ['deskripsi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="deskripsi" name="deskripsi" rows="3" placeholder="Deskripsikan layanan unggulan tenant..."><?php echo e(old('deskripsi', $barbershop->deskripsi)); ?></textarea>
                        <?php $__errorArgs = ['deskripsi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="<?php echo e(route('super-admin.barbershops.index')); ?>" class="btn btn-outline-secondary px-4">Batal</a>
                        <button type="submit" class="btn btn-gold px-4">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    const colors = {
        barbershop: [
            { name: 'Emas (Gold)', hex: '#E8A53A' },
            { name: 'Biru (Vibrant Blue)', hex: '#0578FB' },
            { name: 'Hijau (Teal Mint)', hex: '#10B981' }
        ],
        salon: [
            { name: 'Merah Muda (Rose Pink)', hex: '#EC4899' },
            { name: 'Ungu (Violet Purple)', hex: '#A78BFA' },
            { name: 'Oranye (Coral Peach)', hex: '#F97316' },
            { name: 'Magenta (Orchid)', hex: '#E040FB' }
        ]
    };

    function updateColorOptions() {
        const kategori = document.getElementById('kategori').value;
        const container = document.getElementById('color-options-container');
        const inputWarna = document.getElementById('warna_primer');
        
        container.innerHTML = '';
        
        const options = colors[kategori] || [];
        
        let selectedHex = inputWarna.value.toUpperCase();
        const matchesOption = options.some(opt => opt.hex.toUpperCase() === selectedHex);
        if (!matchesOption && options.length > 0) {
            selectedHex = options[0].hex;
            inputWarna.value = selectedHex;
        }
        
        options.forEach(opt => {
            const isSelected = opt.hex.toUpperCase() === selectedHex.toUpperCase();
            const swatch = document.createElement('div');
            swatch.className = `d-flex align-items-center gap-1 px-2 py-1 border rounded-2 color-swatch-item ${isSelected ? 'border-primary bg-white shadow-sm' : 'border-secondary-subtle bg-white'}`;
            swatch.style.cursor = 'pointer';
            swatch.style.transition = 'all 0.15s';
            swatch.style.borderWidth = isSelected ? '2px' : '1px';
            swatch.onclick = () => selectColor(opt.hex, swatch);
            
            swatch.innerHTML = `
                <span style="display:inline-block; width: 14px; height: 14px; border-radius: 50%; background-color: ${opt.hex}; border: 1px solid rgba(0,0,0,0.15);"></span>
                <span class="fw-semibold text-dark" style="font-size: 0.75rem;">${opt.name}</span>
            `;
            
            container.appendChild(swatch);
        });
    }

    function selectColor(hex, element) {
        document.getElementById('warna_primer').value = hex;
        document.querySelectorAll('.color-swatch-item').forEach(el => {
            el.classList.remove('border-primary', 'shadow-sm');
            el.classList.add('border-secondary-subtle');
            el.style.borderWidth = '1px';
        });
        element.classList.remove('border-secondary-subtle');
        element.classList.add('border-primary', 'shadow-sm');
        element.style.borderWidth = '2px';
    }

    document.addEventListener('DOMContentLoaded', () => {
        updateColorOptions();
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.super_admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH K:\Deploy-Argahomes\resources\views/super_admin/barbershops/edit.blade.php ENDPATH**/ ?>