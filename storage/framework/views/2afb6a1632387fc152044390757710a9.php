<div class="modal-overlay" id="layananDetailModal">
    <div class="modal-card">
        <button class="modal-back" id="modalBackBtn" title="Kembali">
            <i class="fas fa-arrow-left"></i>
        </button>
        <button class="modal-close" id="modalCloseBtn">×</button>
        <div class="modal-image-wrapper" style="display:flex; justify-content:center; align-items:center; background:#f5f2ed; font-size:80px; color:#c9a24f; height: 260px;">
            <i class="fas fa-cut"></i>
        </div>
        <div class="modal-content">
            <h3 id="modalLayananName"></h3>
            <p class="modal-category" id="modalLayananTime"></p>
            <p class="modal-description" id="modalLayananDescription"></p>
            <div class="modal-footer">
                <span class="modal-price" id="modalLayananPrice"></span>
                <?php if(auth()->guard()->check()): ?>
                    <?php if($punyaAntreanAktif): ?>
                        <span class="btn-buat-antrean-layanan disabled" title="Anda sudah memiliki antrean aktif">
                            <i class="fas fa-ticket-alt"></i> Sudah Ada Antrean
                        </span>
                    <?php else: ?>
                        <a href="#" id="btnBuatAntreanDariLayanan" class="btn-buat-antrean-layanan">
                            <i class="fas fa-ticket-alt"></i> Buat Antrean
                        </a>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="<?php echo e(route('login.user')); ?>" class="btn-buat-antrean-layanan">
                        <i class="fas fa-sign-in-alt"></i> Login untuk Antrean
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php /**PATH D:\s6\pa 3\pa_3v3\Kelompok-2-PA-3\resources\views\pelanggan\partials\layanan-detail-modal.blade.php ENDPATH**/ ?>