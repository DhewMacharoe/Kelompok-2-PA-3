@extends('layouts.public')

@section('title', 'Layanan')

@section('content')
<div class="layanan-page">

    {{-- HERO / HEADER --}}
    <section class="layanan-hero">
        <div class="hero-overlay">
            <div class="hero-content">
                <h1>LAYANAN ARGA'S HOME</h1>
                <p>Lihat daftar layanan barbershop dan menu kafe yang tersedia</p>
            </div>
        </div>
    </section>

    {{-- FILTER --}}
    <section class="layanan-container">
        <div class="filter-box">
            <button class="filter-btn active" data-filter="all">Semua</button>
            <button class="filter-btn" data-filter="barber">Barber</button>
            <button class="filter-btn" data-filter="kafe">Kafe</button>
        </div>

        {{-- SECTION BARBER --}}
        <div class="kategori-section" data-kategori="barber">
            <h2 class="section-title">BARBER</h2>

            <div class="layanan-grid">
                @forelse($barber as $item)
                    <div class="layanan-card">
                        <div class="layanan-img">
                            @if($item->foto)
                                <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama }}">
                            @else
                                <div class="img-placeholder">IMG</div>
                            @endif
                        </div>

                        <div class="layanan-body">
                            <h3>{{ $item->nama }}</h3>

                            <div class="layanan-info">
                                <span>🕒 {{ $item->estimasi_waktu ?: 'Menyesuaikan' }}</span>
                            </div>

                            @if($item->deskripsi)
                                <p class="layanan-desc">{{ $item->deskripsi }}</p>
                            @endif

                            <div class="layanan-price">
                                Rp{{ number_format($item->harga, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="empty-text">Belum ada layanan barber yang aktif.</p>
                @endforelse
            </div>
        </div>

        {{-- SECTION KAFE --}}
        <div class="kategori-section" data-kategori="kafe">
            <h2 class="section-title">KAFE</h2>

            <div class="layanan-grid">
                @forelse($kafe as $item)
                    <div class="layanan-card">
                        <div class="layanan-img">
                            @if($item->foto)
                                <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama }}">
                            @else
                                <div class="img-placeholder">IMG</div>
                            @endif
                        </div>

                        <div class="layanan-body">
                            <h3>{{ $item->nama }}</h3>

                            <div class="layanan-info">
                                <span>☕ {{ $item->estimasi_waktu ?: 'Siap saji' }}</span>
                            </div>

                            @if($item->deskripsi)
                                <p class="layanan-desc">{{ $item->deskripsi }}</p>
                            @endif

                            <div class="layanan-price">
                                Rp{{ number_format($item->harga, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="empty-text">Belum ada menu kafe yang aktif.</p>
                @endforelse
            </div>
        </div>
    </section>
</div>

<style>
    .layanan-page {
        background: #f5f5f5;
        min-height: 100vh;
    }

    .layanan-hero {
        background: linear-gradient(rgba(0,0,0,.65), rgba(0,0,0,.65)),
                    url('{{ asset("images/barber-bg.jpg") }}');
        background-size: cover;
        background-position: center;
        padding: 70px 20px 50px;
        text-align: center;
        color: white;
    }

    .hero-content h1 {
        margin: 0;
        font-size: 34px;
        font-weight: 800;
        letter-spacing: 1px;
    }

    .hero-content p {
        margin-top: 12px;
        font-size: 16px;
        opacity: .9;
    }

    .layanan-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 30px 20px 60px;
    }

    .filter-box {
        display: flex;
        justify-content: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 35px;
    }

    .filter-btn {
        border: none;
        background: white;
        padding: 10px 20px;
        border-radius: 999px;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(0,0,0,.08);
        transition: .2s;
    }

    .filter-btn.active,
    .filter-btn:hover {
        background: #c8a96b;
        color: white;
    }

    .kategori-section {
        margin-bottom: 45px;
    }

    .section-title {
        text-align: center;
        font-size: 28px;
        font-weight: 800;
        margin-bottom: 24px;
        color: #222;
    }

    .layanan-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 22px;
    }

    .layanan-card {
        background: white;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(0,0,0,.08);
        transition: .2s;
    }

    .layanan-card:hover {
        transform: translateY(-4px);
    }

    .layanan-img {
        width: 100%;
        height: 210px;
        background: #ddd;
    }

    .layanan-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .img-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #666;
        font-weight: bold;
    }

    .layanan-body {
        padding: 16px;
    }

    .layanan-body h3 {
        margin: 0 0 10px;
        font-size: 20px;
        color: #222;
    }

    .layanan-info {
        font-size: 14px;
        color: #666;
        margin-bottom: 10px;
    }

    .layanan-desc {
        font-size: 14px;
        color: #555;
        line-height: 1.5;
        margin-bottom: 12px;
    }

    .layanan-price {
        font-size: 22px;
        font-weight: 800;
        color: #c8a96b;
    }

    .empty-text {
        text-align: center;
        color: #777;
        font-style: italic;
    }

    @media (max-width: 768px) {
        .hero-content h1 {
            font-size: 24px;
        }

        .hero-content p {
            font-size: 14px;
        }

        .layanan-img {
            height: 180px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('.filter-btn');
        const sections = document.querySelectorAll('.kategori-section');

        buttons.forEach(button => {
            button.addEventListener('click', function () {
                const filter = this.dataset.filter;

                buttons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                sections.forEach(section => {
                    if (filter === 'all' || section.dataset.kategori === filter) {
                        section.style.display = 'block';
                    } else {
                        section.style.display = 'none';
                    }
                });
            });
        });
    });
</script>
@endsection