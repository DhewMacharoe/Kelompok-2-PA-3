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
                {{-- PASANG ID DI SINI agar bisa ditemukan oleh JavaScript --}}
                <div class="layanan-card" id="layanan-{{ $layanan->id }}">
                    <div class="layanan-card-image">
                        @if ($layanan->foto)
                            @php
                                // Sementara: dukung URL eksternal dari seeder API gambar.
                                // <img src="{{ asset('images/' . $layanan->foto) }}" alt="{{ $layanan->nama }}">
                                $fotoLayanan = \Illuminate\Support\Str::startsWith($layanan->foto, ['http://', 'https://'])
                                    ? $layanan->foto
                                    : asset('images/' . $layanan->foto);
                            @endphp
                            <img src="{{ $fotoLayanan }}" alt="{{ $layanan->nama }}">
                        @else
                            <img src="https://via.placeholder.com/1200x800?text=No+Image" alt="{{ $layanan->nama }}">
                        @endif
                    </div>
                    <div class="layanan-card-body">
                        <h4>{{ $layanan->nama }}</h4>
                        <p class="layanan-desc">{{ $layanan->deskripsi }}</p>
                        <p class="layanan-time">⏱ {{ $layanan->estimasi_waktu }} menit</p>
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
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const targetId = urlParams.get('id');

            if (targetId) {
                const targetElement = document.getElementById('layanan-' + targetId);

                if (targetElement) {
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
        });
    </script>
@endpush
