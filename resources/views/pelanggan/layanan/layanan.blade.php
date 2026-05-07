@extends('pelanggan.layouts.app')

@section('title', 'Layanan')

@push('styles')
    @include('pelanggan.layanan.styles')
    @include('pelanggan.homepage.style-index')
@endpush

{{-- Hapus loop kosong yang ada di sini sebelumnya --}}

@section('content')
    <section class="layanan-hero">
        <div class="layanan-hero-overlay">
            <div class="layanan-hero-text">
                <h1>Daftar Layanan</h1>
                <p>Lihat pilihan layanan yang tersedia beserta harga dan estimasi waktunya.</p>
            </div>
        </div>
    </section>

    <section class="layanan-content">
        <div class="layanan-grid">
            @forelse($layanans as $layanan)
                <div class="layanan-card" id="layanan-{{ $layanan->id }}" style="cursor: pointer;"
                     data-id="{{ $layanan->id }}"
                     data-name="{{ $layanan->nama }}"
                     data-description="{{ e($layanan->deskripsi ?? 'Tidak ada deskripsi.') }}"
                     data-time="{{ $layanan->estimasi_waktu }}"
                     data-price="{{ number_format($layanan->harga, 0, ',', '.') }}">
                    {{-- Bagian gambar diganti dengan Icon --}}
                    <div class="icon-circle shadow-sm">
                        <i class="fas fa-cut"></i>
                    </div>
                    
                    <div class="layanan-card-body">
                        <h4>{{ $layanan->nama }}</h4>
                        <p class="layanan-desc">{{ $layanan->deskripsi }}</p>
                        <p class="layanan-time"><i class="far fa-clock"></i> {{ $layanan->estimasi_waktu }}</p>
                        <p class="layanan-price">Rp{{ number_format($layanan->harga, 0, ',', '.') }}</p>
                    </div>
                </div>
            @empty
                <div class="layanan-empty">
                    <p>Maaf, saat ini belum ada layanan yang tersedia.</p>
                </div>
            @endforelse
        </div>
    </section>

    <div class="modal-overlay" id="layananDetailModal">
        <div class="modal-card">
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
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Modal detail popup untuk Layanan
            const modalOverlay = document.getElementById('layananDetailModal');
            const modalCloseBtn = document.getElementById('modalCloseBtn');
            const modalName = document.getElementById('modalLayananName');
            const modalTime = document.getElementById('modalLayananTime');
            const modalDescription = document.getElementById('modalLayananDescription');
            const modalPrice = document.getElementById('modalLayananPrice');

            const btnBuatAntrean = document.getElementById('btnBuatAntreanDariLayanan');
            const antreanBaseUrl = "{{ route('antrean') }}";

            document.querySelectorAll('.layanan-card').forEach(item => {
                item.addEventListener('click', function() {
                    const layananId = this.dataset.id;
                    modalName.textContent = this.dataset.name;
                    modalTime.innerHTML = '<i class="far fa-clock"></i> ' + this.dataset.time;
                    modalDescription.textContent = this.dataset.description;
                    modalPrice.textContent = 'Rp ' + this.dataset.price;

                    // Update href tombol Buat Antrean
                    if (btnBuatAntrean) {
                        btnBuatAntrean.href = antreanBaseUrl + '?layanan_id=' + layananId;
                    }

                    modalOverlay.classList.add('active');
                });
            });

            if (modalCloseBtn) {
                modalCloseBtn.addEventListener('click', function() {
                    modalOverlay.classList.remove('active');
                });
            }

            if (modalOverlay) {
                modalOverlay.addEventListener('click', function(event) {
                    if (event.target === modalOverlay) {
                        modalOverlay.classList.remove('active');
                    }
                });
            }

            const urlParams = new URLSearchParams(window.location.search);
            const targetId = urlParams.get('id');

            if (targetId) {
                const targetElement = document.getElementById('layanan-' + targetId);

                if (targetElement) {
                    const openModal = urlParams.get('open');
                    
                    if (openModal === 'true') {
                        // Langsung buka modal
                        setTimeout(() => {
                            targetElement.click();
                        }, 100);
                    } else {
                        // Beri sedikit jeda agar browser selesai merender layout
                        setTimeout(() => {
                            targetElement.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });

                            // Efek highlight
                            targetElement.style.transition = 'all 0.5s ease';
                            targetElement.style.boxShadow = '0 0 20px rgba(212, 175, 55, 0.8)';
                            targetElement.style.transform = 'scale(1.05)';
                            targetElement.style.zIndex = '10';

                            // Kembalikan ke normal setelah 3 detik
                            setTimeout(() => {
                                targetElement.style.boxShadow = '';
                                targetElement.style.transform = '';
                                targetElement.style.zIndex = '';
                            }, 3000);
                        }, 300);
                    }
                }
            }
        });
    </script>
@endpush
