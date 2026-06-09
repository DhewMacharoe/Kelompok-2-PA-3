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
                     data-ikon="{{ $layanan->ikon }}"
                     data-price="{{ number_format($layanan->harga, 0, ',', '.') }}">
                    {{-- Bagian gambar diganti dengan Icon --}}
                    <div class="icon-circle shadow-sm">
                        @if ($layanan->ikon === 'paint')
                            <i class="fas fa-paint-brush"></i>
                        @elseif ($layanan->ikon === 'face')
                            <i class="fas fa-smile"></i>
                        @else
                            <i class="fas fa-cut"></i>
                        @endif
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

    @include('pelanggan.partials.layanan-detail-modal')
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
                    const ikon = this.dataset.ikon;
                    modalName.textContent = this.dataset.name;
                    modalTime.innerHTML = '<i class="far fa-clock"></i> ' + this.dataset.time;
                    modalDescription.textContent = this.dataset.description;
                    modalPrice.textContent = 'Rp ' + this.dataset.price;

                    // Update modal icon
                    const modalIconWrapper = document.querySelector('.modal-image-wrapper');
                    if (modalIconWrapper) {
                        let iconClass = 'fas fa-cut';
                        if (ikon === 'paint') iconClass = 'fas fa-paint-brush';
                        if (ikon === 'face') iconClass = 'fas fa-smile';
                        modalIconWrapper.innerHTML = `<i class="${iconClass}"></i>`;
                    }

                    // Update href tombol Buat Antrean
                    if (btnBuatAntrean) {
                        btnBuatAntrean.href = antreanBaseUrl + '?layanan_id=' + layananId;
                    }

                    modalOverlay.classList.add('active');
                });
            });

            const modalBackBtn = document.getElementById('modalBackBtn');
            const modalBackBottomBtn = document.getElementById('modalBackBottomBtn');

            function handleBackOrClose() {
                const urlParams = new URLSearchParams(window.location.search);
                const fromAntrean = urlParams.get('from') === 'antrean';

                if (fromAntrean) {
                    if (document.referrer && document.referrer.includes('/antrean')) {
                        history.back();
                    } else {
                        window.location.href = "{{ route('antrean') }}";
                    }
                } else {
                    modalOverlay.classList.remove('active');
                    // Bersihkan URL query parameter tanpa reload
                    const cleanUrl = window.location.pathname;
                    window.history.replaceState({}, document.title, cleanUrl);
                }
            }

            if (modalBackBtn) {
                modalBackBtn.addEventListener('click', handleBackOrClose);
            }

            if (modalBackBottomBtn) {
                modalBackBottomBtn.addEventListener('click', handleBackOrClose);
            }

            if (modalCloseBtn) {
                modalCloseBtn.addEventListener('click', handleBackOrClose);
            }

            if (modalOverlay) {
                modalOverlay.addEventListener('click', function(event) {
                    if (event.target === modalOverlay) {
                        handleBackOrClose();
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
