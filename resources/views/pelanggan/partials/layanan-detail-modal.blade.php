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
                <button type="button" class="btn-back-bottom" id="modalBackBottomBtn">
                    <i class="fas fa-arrow-left"></i> Kembali
                </button>
                <div class="modal-footer-right">
                    <span class="modal-price" id="modalLayananPrice"></span>
                    @auth
                        @if ($punyaAntreanAktif)
                            <span class="btn-buat-antrean-layanan disabled" title="Anda sudah memiliki antrean aktif">
                                <i class="fas fa-ticket-alt"></i> Sudah Ada Antrean
                            </span>
                        @else
                            <a href="#" id="btnBuatAntreanDariLayanan" class="btn-buat-antrean-layanan">
                                <i class="fas fa-ticket-alt"></i> Buat Antrean
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login.user') }}" class="btn-buat-antrean-layanan">
                            <i class="fas fa-sign-in-alt"></i> Login untuk Antrean
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
