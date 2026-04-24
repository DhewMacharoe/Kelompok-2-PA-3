@extends('pelanggan.layouts.app')

@section('title', 'Dashboard - Arga\'s Home')

@push('styles')

    @include('pelanggan.homepage.style-index')
@endpush

@include('pelanggan.homepage.style-index')


@section('content')
    <section class="hero d-flex justify-content-center align-items-center px-3">
        <div class="card queue-card shadow-lg border-0">
            <div class="bg-gold text-white p-3 d-flex align-items-center justify-content-center gap-3">
                <i class="fas fa-users fs-1"></i>
                <div>
                    <h5 class="mb-0 fs-6">Posisi Antrian Saat Ini</h5>
                    <p class="mb-0 small opacity-75">jumlah Antrian : {{ $jumlahAntrian }}</p>
                </div>
            </div>
            <div class="card-body text-center py-4">
                @if ($antrian)
                    <div class="text-uppercase small text-muted mb-2">Nomor aktif</div>
                    <h2 class="mb-2 fw-bold text-dark" id="antrian-nomor" style="letter-spacing: 3px;">
                        {{ $antrian->nomor_antrian }}</h2>
                    <div class="d-inline-flex align-items-center px-3 py-2 rounded-pill bg-light text-dark fw-semibold mb-3"
                        id="antrian-status">
                        {{ $antrian->status === 'sedang dilayani' ? 'Sedang dilayani' : ucfirst($antrian->status) }}
                    </div>
                    <p class="mb-0 text-muted">{{ $antrian->nama_pelanggan }}</p>
                @else
                    <p class="mb-0 text-muted">Belum ada pelanggan yang sedang dilayani</p>
                @endif
            </div>
        </div>
    </section>
    <div class="container py-5">

        <h2 class="text-center mb-5 text-uppercase text-dark fw-light">
            ARGA'S <span class="text-gold fw-bold">Home</span>
        </h2>

        <div class="row text-center mb-5 g-4">
            <div class="col-6 col-md-3">
                <a href="{{ route('antrian') }}" class="text-decoration-none text-dark fw-bold menu-item d-block">
                    <div class="icon-circle shadow-sm"><i class="fas fa-id-card"></i></div>
                    Antrian Barbershop
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('galeri') }}" class="text-decoration-none text-dark fw-bold menu-item d-block">
                    <div class="icon-circle shadow-sm"><i class="fas fa-images"></i></div>
                    Galeri
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('pelanggan.layanan') }}" class="text-decoration-none text-dark fw-bold menu-item d-block">
                    <div class="icon-circle shadow-sm"><i class="fas fa-cut"></i></div>
                    Layanan Barber
                </a>
            </div>
            <div class="col-6 col-md-3">
                <a href="{{ route('menu') }}" class="text-decoration-none text-dark fw-bold menu-item d-block">
                    <div class="icon-circle shadow-sm"><i class="fas fa-coffee"></i></div>
                    Menu Coffee
                </a>
            </div>
        </div>

        <h4 class="border-gold-left ps-2 mb-4 fw-bold">Jenis Model Rambut Lainnya</h4>

        <div class="row g-3">
            @foreach ($layanans as $layanan)
            <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                <div class="card haircut-card shadow-sm border-0 h-100">

                    <img src="https://images.unsplash.com/photo-1621605815971-fbc98d665033?q=80&w=600"
                        class="card-img-top haircut-img" alt="Buzz Cut">
                    <div class="card-body p-2 text-center">
                        <h6 class="card-title text-muted mb-1" style="font-size: 0.9rem;">{{ $layanan->nama }}</h6>
                        <p class="card-text fw-bold text-dark mb-0">{{ $layanan->harga }}</p>
                    </div>
                </div>
            </div>

            @endforeach

            </div>
        </div>
    </div>
@endsection
@push('scripts')
    @push('scripts')
        <script type="module">
            document.addEventListener('DOMContentLoaded', function() {

                window.Echo.channel('Antrian-channel')
                    .listen('AntreanUpadate', (e) => {

                        console.log('DATA MASUK:', e);

                        let antrian = e.antrean;

                        // Update nomor antrian
                        let nomorEl = document.getElementById('antrian-nomor');
                        if (nomorEl) {
                            nomorEl.textContent = antrian.nomor_antrian;
                        }

                        // Update status
                        let statusEl = document.getElementById('antrian-status');
                        if (statusEl) {
                            statusEl.textContent = antrian.status.toUpperCase();
                        }
                    });
            });
        </script>
    @endpush
