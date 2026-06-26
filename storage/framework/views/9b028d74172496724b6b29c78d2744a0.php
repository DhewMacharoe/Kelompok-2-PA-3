<?php $__env->startSection('title', 'Detail Pelanggan - ' . $user->name); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-4">
    <a href="<?php echo e(route('admin.moderasi.index')); ?>" class="btn btn-outline-secondary btn-sm px-3 mb-3">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
    </a>
    <div class="d-flex justify-content-between align-items-start">
        <div>
            <h4 class="fw-bold text-dark m-0"><?php echo e($user->name); ?></h4>
            <p class="text-muted small m-0">Detail profil, statistik, dan riwayat aktivitas moderasi pelanggan.</p>
        </div>
        <div class="d-flex gap-2">
            <?php if($user->is_blocked): ?>
                <form action="<?php echo e(route('admin.moderasi.unblock', $user->id)); ?>" method="POST" 
                      onsubmit="return confirm('Apakah Anda yakin ingin membuka blokir akun pelanggan ini?')">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-success fw-semibold px-4 shadow-sm">
                        <i class="bi bi-unlock-fill me-1"></i> Buka Blokir
                    </button>
                </form>
            <?php else: ?>
                <button type="button" class="btn btn-danger fw-semibold px-4 shadow-sm" 
                        data-bs-toggle="modal" data-bs-target="#blockModal">
                    <i class="bi bi-lock-fill me-1"></i> Blokir Akun
                </button>
            <?php endif; ?>

            <form action="<?php echo e(route('admin.moderasi.resetRisk', $user->id)); ?>" method="POST"
                  onsubmit="return confirm('Apakah Anda yakin ingin mereset indikator risiko pelanggan ini? Perhitungan risiko sebelumnya tidak akan dihitung kembali.')">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-warning fw-semibold px-3 shadow-sm text-dark">
                    <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Risiko
                </button>
            </form>
        </div>
    </div>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        <?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if($errors->any()): ?>
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo e($error); ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if($user->is_blocked): ?>
    <div class="alert alert-warning border-0 shadow-sm p-4 mb-4" role="alert" style="background-color: #FFF3CD; border-left: 5px solid #FFC107 !important;">
        <h5 class="alert-heading fw-bold text-dark mb-2"><i class="bi bi-exclamation-triangle-fill me-2"></i>Akun Sedang Ditangguhkan (Diblokir)</h5>
        <p class="m-0 text-dark">Pelanggan ini sedang diblokir dari sistem pemesanan. Pelanggan tidak dapat membuat booking atau mengambil antrean baru.</p>
        <hr>
        <p class="mb-0 small text-muted"><strong>Alasan Pemblokiran:</strong> <?php echo e($user->blocked_reason ?? 'Tidak ditentukan.'); ?></p>
        <p class="mb-0 small text-muted"><strong>Tanggal Diblokir:</strong> <?php echo e(\Carbon\Carbon::parse($user->blocked_at)->translatedFormat('d M Y, H:i')); ?></p>
    </div>
<?php endif; ?>

<div class="row g-4">
    <!-- Kolom Kiri: Informasi Profil & Statistik -->
    <div class="col-lg-4">
        <!-- Card Profil -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4 text-center">
                <div class="mb-3 d-inline-block bg-primary bg-opacity-10 text-primary rounded-circle p-3">
                    <i class="bi bi-person-fill fs-1"></i>
                </div>
                <h5 class="fw-bold mb-1"><?php echo e($user->name); ?></h5>
                <span class="badge bg-secondary mb-3">Customer</span>
                
                <div class="text-start border-top pt-3">
                    <div class="mb-2">
                        <label class="text-muted small d-block">Username</label>
                        <span class="fw-semibold text-dark">&#64;<?php echo e($user->username ?? '-'); ?></span>
                    </div>
                    <div class="mb-2">
                        <label class="text-muted small d-block">Email</label>
                        <span class="fw-semibold text-dark"><?php echo e($user->email); ?></span>
                    </div>
                    <div class="mb-2">
                        <label class="text-muted small d-block">WhatsApp</label>
                        <span class="fw-semibold text-dark"><?php echo e($user->no_whatsapp ?? '-'); ?></span>
                    </div>
                    <div>
                        <label class="text-muted small d-block">Tanggal Registrasi</label>
                        <span class="fw-semibold text-dark"><?php echo e($user->created_at ? $user->created_at->translatedFormat('d F Y') : '-'); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Statistik Risiko -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                <h5 class="fw-bold m-0 text-dark">Statistik Moderasi</h5>
            </div>
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-4 bg-light p-3 rounded">
                    <div>
                        <span class="text-muted small d-block">Tingkat Risiko</span>
                        <h5 class="fw-bold m-0">
                            <?php $risk = $user->riskLevel(); ?>
                            <?php if($risk === 'high'): ?>
                                <span class="text-danger"><i class="bi bi-exclamation-triangle-fill"></i> Risiko Tinggi</span>
                            <?php elseif($risk === 'medium'): ?>
                                <span class="text-warning"><i class="bi bi-exclamation-circle-fill"></i> Risiko Sedang</span>
                            <?php else: ?>
                                <span class="text-success"><i class="bi bi-check-circle-fill"></i> Risiko Rendah</span>
                            <?php endif; ?>
                        </h5>
                    </div>
                    <div>
                        <?php if($risk === 'high'): ?>
                            <span class="badge rounded-circle bg-danger p-3" style="width: 15px; height: 15px; display: inline-block;"></span>
                        <?php elseif($risk === 'medium'): ?>
                            <span class="badge rounded-circle bg-warning p-3" style="width: 15px; height: 15px; display: inline-block;"></span>
                        <?php else: ?>
                            <span class="badge rounded-circle bg-success p-3" style="width: 15px; height: 15px; display: inline-block;"></span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted small">Total Booking</span>
                        <span class="fw-bold text-dark"><?php echo e($user->totalBookings()); ?></span>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted small">Batal oleh Pelanggan</span>
                        <span class="fw-bold text-danger"><?php echo e($user->customerCancellationsCount()); ?></span>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted small">Tidak Hadir / No-Show</span>
                        <span class="fw-bold text-danger"><?php echo e($user->noShowsCount()); ?></span>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted small">Persentase Pembatalan</span>
                        <span class="fw-bold text-dark"><?php echo e($user->cancellationPercentage()); ?>%</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <?php $pct = $user->cancellationPercentage(); ?>
                        <div class="progress-bar <?php if($pct >= 50): ?> bg-danger <?php elseif($pct >= 20): ?> bg-warning <?php else: ?> bg-success <?php endif; ?>" 
                             role="progressbar" style="width: <?php echo e($pct); ?>%" aria-valuenow="<?php echo e($pct); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                
                <?php if($user->reset_risk_at): ?>
                    <div class="mt-3 border-top pt-3 text-muted" style="font-size: 0.75rem;">
                        <i class="bi bi-clock-history"></i> Risiko terakhir di-reset pada:<br>
                        <strong><?php echo e(\Carbon\Carbon::parse($user->reset_risk_at)->translatedFormat('d M Y, H:i')); ?></strong>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Tab Riwayat & Moderasi -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <!-- Nav Tabs -->
                <ul class="nav nav-tabs border-bottom mb-4" id="moderasiTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-bold" id="booking-tab" data-bs-toggle="tab" 
                                data-bs-target="#booking-content" type="button" role="tab" 
                                aria-controls="booking-content" aria-selected="true">
                            Riwayat Booking & Antrean
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold" id="history-tab" data-bs-toggle="tab" 
                                data-bs-target="#history-content" type="button" role="tab" 
                                aria-controls="history-content" aria-selected="false">
                            Riwayat Tindakan Moderasi
                        </button>
                    </li>
                </ul>

                <!-- Tab Contents -->
                <div class="tab-content" id="moderasiTabsContent">
                    <!-- Tab Booking -->
                    <div class="tab-pane fade show active" id="booking-content" role="tabpanel" aria-labelledby="booking-tab">
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" class="py-2.5">No. Antrean</th>
                                        <th scope="col" class="py-2.5">Tipe</th>
                                        <th scope="col" class="py-2.5">Tanggal/Waktu</th>
                                        <th scope="col" class="py-2.5">Layanan</th>
                                        <th scope="col" class="py-2.5">Status Booking</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <?php
                                            $layananList = $booking->layananUntukRekap();
                                        ?>
                                        <tr>
                                            <td class="fw-bold text-dark">
                                                <?php echo e(str_pad($booking->nomor_antrean_seq, 2, '0', STR_PAD_LEFT)); ?>

                                            </td>
                                            <td>
                                                <?php if($booking->is_booking): ?>
                                                    <span class="badge bg-primary-subtle text-primary">Booking</span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary-subtle text-secondary">Walk-in</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($booking->is_booking): ?>
                                                    <div class="small fw-semibold text-dark"><?php echo e(\Carbon\Carbon::parse($booking->tanggal_booking)->translatedFormat('d M Y')); ?></div>
                                                    <div class="small text-muted"><?php echo e(\Carbon\Carbon::parse($booking->waktu_booking)->format('H:i')); ?> WIB</div>
                                                <?php else: ?>
                                                    <div class="small fw-semibold text-dark"><?php echo e(\Carbon\Carbon::parse($booking->waktu_masuk)->translatedFormat('d M Y')); ?></div>
                                                    <div class="small text-muted"><?php echo e(\Carbon\Carbon::parse($booking->waktu_masuk)->format('H:i')); ?> WIB</div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <ul class="list-unstyled m-0 p-0" style="font-size: 0.85rem;">
                                                    <?php $__currentLoopData = $layananList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lay): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li>• <?php echo e($lay->nama); ?></li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            </td>
                                            <td>
                                                <?php if($booking->status === 'selesai'): ?>
                                                    <span class="badge bg-success-subtle text-success"><i class="bi bi-check-circle-fill me-1"></i>Selesai</span>
                                                <?php elseif($booking->status === 'sedang dilayani'): ?>
                                                    <span class="badge bg-warning-subtle text-warning"><i class="bi bi-hourglass-split me-1"></i>Sedang Berlangsung</span>
                                                <?php elseif($booking->status === 'menunggu'): ?>
                                                    <span class="badge bg-info-subtle text-info"><i class="bi bi-clock me-1"></i>Menunggu</span>
                                                <?php elseif($booking->status === 'batal'): ?>
                                                    <?php if($booking->batal_oleh === 'pelanggan'): ?>
                                                        <span class="badge bg-danger-subtle text-danger" data-bs-toggle="tooltip" title="Alasan: <?php echo e($booking->alasan_batal ?? '-'); ?>">
                                                            <i class="bi bi-x-circle-fill me-1"></i>Dibatalkan Pelanggan
                                                        </span>
                                                    <?php elseif($booking->batal_oleh === 'salon'): ?>
                                                        <span class="badge bg-secondary-subtle text-dark" data-bs-toggle="tooltip" title="Alasan: <?php echo e($booking->alasan_batal ?? '-'); ?>">
                                                            <i class="bi bi-x-circle-fill me-1"></i>Dibatalkan Salon
                                                        </span>
                                                    <?php elseif($booking->batal_oleh === 'no_show'): ?>
                                                        <span class="badge bg-danger text-white" data-bs-toggle="tooltip" title="Alasan: <?php echo e($booking->alasan_batal ?? '-'); ?>">
                                                            <i class="bi bi-person-x-fill me-1"></i>Tidak Hadir (No-Show)
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger-subtle text-danger" data-bs-toggle="tooltip" title="Alasan: <?php echo e($booking->alasan_batal ?? '-'); ?>">
                                                            <i class="bi bi-x-circle-fill me-1"></i>Dibatalkan
                                                        </span>
                                                    <?php endif; ?>
                                                    <?php if($booking->alasan_batal): ?>
                                                        <div class="small text-muted mt-1" style="font-size: 0.75rem;">Ket: "<?php echo e($booking->alasan_batal); ?>"</div>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted">
                                                Belum ada riwayat antrean atau booking.
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tab Tindakan Moderasi -->
                    <div class="tab-pane fade" id="history-content" role="tabpanel" aria-labelledby="history-tab">
                        <div class="timeline">
                            <?php $__empty_1 = true; $__currentLoopData = $histories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="p-3 mb-3 border rounded shadow-sm">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="fw-bold m-0 text-dark">
                                            <?php if($history->action === 'block'): ?>
                                                <span class="text-danger"><i class="bi bi-lock-fill"></i> Akun Diblokir</span>
                                            <?php elseif($history->action === 'unblock'): ?>
                                                <span class="text-success"><i class="bi bi-unlock-fill"></i> Blokir Dibuka</span>
                                            <?php elseif($history->action === 'reset_risk'): ?>
                                                <span class="text-warning"><i class="bi bi-arrow-counterclockwise"></i> Risiko Di-reset</span>
                                            <?php else: ?>
                                                <span class="text-secondary"><?php echo e($history->action); ?></span>
                                            <?php endif; ?>
                                        </h6>
                                        <small class="text-muted">
                                            <?php echo e(\Carbon\Carbon::parse($history->created_at)->translatedFormat('d M Y, H:i')); ?>

                                        </small>
                                    </div>
                                    <p class="m-0 small text-dark mb-2"><strong>Keterangan / Catatan:</strong> <?php echo e($history->reason ?? '-'); ?></p>
                                    <div class="text-muted" style="font-size: 0.75rem;">
                                        <i class="bi bi-person-badge-fill"></i> Oleh Admin: <strong><?php echo e($history->admin->name ?? 'System'); ?></strong> (&#64;<?php echo e($history->admin->username ?? 'admin'); ?>)
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="text-center py-4 text-muted">
                                    Belum ada catatan tindakan moderasi untuk pelanggan ini.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Form Pemblokiran -->
<div class="modal fade" id="blockModal" tabindex="-1" aria-labelledby="blockModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="<?php echo e(route('admin.moderasi.block', $user->id)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-dark" id="blockModalLabel">Blokir Akun Pelanggan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted small">Masukkan alasan pemblokiran akun. Pelanggan akan melihat alasan ini pada halaman booking mereka dan tidak dapat memesan jadwal baru.</p>
                    <div class="mb-3">
                        <label for="reason" class="form-label fw-semibold text-dark">Alasan Pemblokiran</label>
                        <textarea class="form-control" id="reason" name="reason" rows="4" 
                                  placeholder="Misal: Pembatalan booking berulang lebih dari 3 kali dalam seminggu." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger px-4">
                        <i class="bi bi-lock-fill"></i> Blokir Sekarang
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH K:\Deploy-Argahomes\resources\views/admin/moderasi/show.blade.php ENDPATH**/ ?>