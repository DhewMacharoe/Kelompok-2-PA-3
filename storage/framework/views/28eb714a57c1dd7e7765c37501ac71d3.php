<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
    <!-- Kartu Statistik Dasbor -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="stat-card shadow-sm border-0">
                <div class="mb-2 text-primary">
                    <i class="bi bi-people-fill fs-2"></i>
                </div>
                <h6 class="text-muted mb-1 small fw-bold text-uppercase" style="letter-spacing: 0.5px;">Total Menunggu</h6>
                <h3 class="fw-bold m-0 text-dark"><?php echo e($statistikData[0] ?? 0); ?></h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card shadow-sm border-0">
                <div class="mb-2 text-success">
                    <i class="bi bi-check-circle-fill fs-2"></i>
                </div>
                <h6 class="text-muted mb-1 small fw-bold text-uppercase" style="letter-spacing: 0.5px;">Total Selesai</h6>
                <h3 class="fw-bold m-0 text-dark"><?php echo e($statistikData[1] ?? 0); ?></h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card shadow-sm border-0">
                <div class="mb-2 text-danger">
                    <i class="bi bi-x-circle-fill fs-2"></i>
                </div>
                <h6 class="text-muted mb-1 small fw-bold text-uppercase" style="letter-spacing: 0.5px;">Total Batal</h6>
                <h3 class="fw-bold m-0 text-dark"><?php echo e($statistikData[2] ?? 0); ?></h3>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-xl-5">
            <div class="queue-card-main shadow-sm">
                <p class="text-uppercase small mb-1 opacity-75">Sedang Dilayani</p>
                <div class="queue-number">
                    <?php echo e($dipanggil ? $dipanggil->nomor_antrean_seq : '--'); ?>

                </div>
                <p class="mb-4 fs-5"><?php echo e($dipanggil ? $dipanggil->nama_pelanggan : 'Tidak ada'); ?></p>

                <div class="d-flex justify-content-center gap-3 mb-4">
                    <?php if($dipanggil): ?>
                        <button type="button" class="btn btn-success px-4 fw-bold shadow-sm btn-queue-action-dashboard d-inline-flex align-items-center gap-2"
                            style="background-color: #4CC779;" data-queue-id="<?php echo e($dipanggil->id); ?>"
                            data-queue-status="selesai">
                            <i class="bi bi-check-circle-fill"></i> Selesai
                        </button>
                        <button type="button" class="btn btn-danger px-4 fw-bold shadow-sm btn-queue-action-dashboard d-inline-flex align-items-center gap-2"
                            style="background-color: #EB5757;" data-queue-id="<?php echo e($dipanggil->id); ?>"
                            data-queue-status="batal">
                            <i class="bi bi-x-circle-fill"></i> Batalkan
                        </button>
                    <?php else: ?>
                        <?php if(($jumlahMenungguHariIni ?? 0) > 0): ?>
                            <button type="button" class="btn btn-primary px-4 fw-bold shadow-sm btn-call-dashboard d-inline-flex align-items-center gap-2"
                                style="background-color: var(--primary-blue); border:none;">
                                <i class="bi bi-megaphone-fill"></i> Panggil
                            </button>
                        <?php else: ?>
                            <button type="button" class="btn btn-primary px-4 fw-bold shadow-sm d-inline-flex align-items-center gap-2" disabled aria-disabled="true"
                                style="background-color: var(--primary-blue); border:none; opacity: 0.65; cursor: not-allowed;">
                                <i class="bi bi-megaphone-fill"></i> Panggil
                            </button>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <div class="text-start mt-4 bg-white bg-opacity-10 p-3 rounded">
                    <p class="text-center small mb-3 border-bottom border-secondary pb-2 fw-semibold text-uppercase" style="letter-spacing: 0.5px;">Antrean Berikutnya</p>

                    <?php $__empty_1 = true; $__currentLoopData = $antreanMenunggu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="d-flex justify-content-between align-items-center mb-2 px-3 border border-white border-opacity-25 border-1 rounded bg-white bg-opacity-5"
                            style="height: 56px;">
                            <span class="fw-bold fs-5"><?php echo e(str_pad($item->nomor_antrean_seq, 2, '0', STR_PAD_LEFT)); ?></span>
                            <span class="fw-semibold"><?php echo e($item->nama_pelanggan); ?></span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-center py-4 text-white-50">
                            <i class="bi bi-people-fill fs-3 mb-2 d-block opacity-50"></i>
                            <span class="small d-block">Tidak ada antrean berikutnya hari ini.</span>
                        </div>
                    <?php endif; ?>

                    <div class="text-center mt-3">
                        <a href="/admin/antrean" class="text-white-50 text-decoration-none small hover-underline"><i class="bi bi-arrow-right-short"></i> Lihat Semua Antrean</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-7">
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="text-muted fw-bold mb-3">Grafik Statistik Antrean Hari Ini</h6>
                            <canvas id="statistikChart" height="120"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="text-muted fw-bold mb-3">Tren Pengunjung 7 Hari Terakhir</h6>
                            <canvas id="trendChart" height="120"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="application/json" id="statistik-data-json"><?php echo json_encode($statistikData ?? [], 15, 512) ?></script>
    <script type="application/json" id="trend-labels-json"><?php echo json_encode($trendLabels ?? [], 15, 512) ?></script>
    <script type="application/json" id="trend-data-json"><?php echo json_encode($trendData ?? [], 15, 512) ?></script>

    <?php echo $__env->make('admin.script-dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH K:\Deploy-Argahomes\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>