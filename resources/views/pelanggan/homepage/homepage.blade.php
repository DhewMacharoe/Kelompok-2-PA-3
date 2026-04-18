@extends('pelanggan.layouts.app')

@section('title', 'Dashboard - Arga\'s Home')

@push('styles')
<style>
    /* Styling khusus yang tidak ada di utilitas default Bootstrap */
    .hero {
        background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1585747860715-2ba37e788b70?q=80&w=1474&auto=format&fit=crop');
        background-size: cover;
        background-position: center;
        height: 280px;
    }

    .queue-card {
        width: 100%;
        max-width: 380px;
        border-radius: 12px;
        overflow: hidden;
    }

    /* Warna Kustom Barbershop */
    .bg-gold { background-color: #c5a059; }
    .text-gold { color: #c5a059; }
    .border-gold-left { border-left: 4px solid #c5a059; }

    /* Ikon Menu */
    .icon-circle {
        background: #1a1a1a;
        color: #fff;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 10px;
        font-size: 1.5rem;
        transition: transform 0.2s;
    }
    .menu-item { font-size: 0.85rem; }
    .menu-item:hover .icon-circle { transform: translateY(-5px); }

    /* Kustomisasi Card Gaya Rambut agar lebih estetik */
    .haircut-card {
        border-radius: 12px;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .haircut-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
    .haircut-img {
        height: 140px; /* Tinggi gambar diperkecil */
        object-fit: cover;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }
</style>
@endpush

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
            <h2 class="mb-0 fw-bold text-dark" id="antrian-nomor" style="letter-spacing: 3px;">{{ $antrian ? $antrian->nomor_antrian : 'Tidak ada antrian' }}</h2>
            <h2 class="mb-0 fw-bold text-dark" id="antrian-status" style="letter-spacing: 3px;">{{ $antrian?->status ?? 'Tidak ada antrian' }}</h2>

        </div>
    </div>
</section>

<div class="container py-5">

    <h2 class="text-center mb-5 text-uppercase text-dark fw-light">
        ARGA'S <span class="text-gold fw-bold">Home</span>
    </h2>

    <div class="row text-center mb-5 g-4">
        <div class="col-6 col-md-3">
            <a href="#" class="text-decoration-none text-dark fw-bold menu-item d-block">
                <div class="icon-circle shadow-sm"><i class="fas fa-id-card"></i></div>
                Antrian Barbershop
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="#" class="text-decoration-none text-dark fw-bold menu-item d-block">
                <div class="icon-circle shadow-sm"><i class="fas fa-images"></i></div>
                Galeri
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="#" class="text-decoration-none text-dark fw-bold menu-item d-block">
                <div class="icon-circle shadow-sm"><i class="fas fa-cut"></i></div>
                Layanan Barber
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="#" class="text-decoration-none text-dark fw-bold menu-item d-block">
                <div class="icon-circle shadow-sm"><i class="fas fa-coffee"></i></div>
                Menu Coffee
            </a>
        </div>
    </div>

    <h4 class="border-gold-left ps-2 mb-4 fw-bold">Jenis Model Rambut Lainnya</h4>

    <div class="row g-3"> <div class="col-6 col-md-4 col-lg-3 col-xl-2">
            <div class="card haircut-card shadow-sm border-0 h-100">
                <img src="https://images.unsplash.com/photo-1621605815971-fbc98d665033?q=80&w=600" class="card-img-top haircut-img" alt="Buzz Cut">
                <div class="card-body p-2 text-center"> <h6 class="card-title text-muted mb-1" style="font-size: 0.9rem;">Buzz Cut</h6>
                    <p class="card-text fw-bold text-dark mb-0">Rp 50.000</p>
                </div>
            </div>
        </div>

            <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                <div class="card haircut-card shadow-sm border-0 h-100">
                    <img src="https://images.unsplash.com/photo-1599351431202-1e0f0137899a?q=80&w=600" class="card-img-top haircut-img" alt="Undercut">
                    <div class="card-body p-2 text-center">
                        <h6 class="card-title text-muted mb-1" style="font-size: 0.9rem;">Undercut</h6>
                        <p class="card-text fw-bold text-dark mb-0">Rp 50.000</p>
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection
@push('scripts')
    <script type="module">
        document.addEventListener('DOMContentLoaded', function () {

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

