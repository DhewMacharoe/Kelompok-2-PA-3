@extends('admin.layouts.app')

@section('title', 'Dashboard Utama')

@section('content')
<div class="row g-4">
    <div class="col-xl-5">
        <div class="queue-card-main shadow-sm">
            <p class="text-uppercase small mb-1 opacity-75">Sedang Dilayani</p>
            <div class="queue-number">A02</div>
            <p class="mb-4 fs-5">Jappy Sirait</p>

            <div class="d-flex justify-content-center gap-3 mb-4">
                <button class="btn btn-primary px-4 fw-bold" style="background-color: var(--primary-blue); border:none;">Panggil</button>
                <button class="btn btn-danger px-4 fw-bold">Batalkan</button>
            </div>

            <div class="text-start mt-4 bg-white bg-opacity-10 p-3 rounded">
                <p class="text-center small mb-3 border-bottom border-secondary pb-2">Antrean Berikutnya</p>
                <div class="d-flex justify-content-between mb-2 px-2"><span>03</span> <span>Manu Yikwa</span></div>
                <div class="d-flex justify-content-between mb-2 px-2"><span>04</span> <span>Budi Doremi</span></div>
                <div class="text-center mt-3">
                    <a href="#" class="text-white-50 text-decoration-none small">Lihat Semua</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-7">
        <div class="row g-3">
            @php
                $stats = [
                    ['title' => 'Pengunjung Hari ini', 'val' => '12'],
                    ['title' => 'Menunggu', 'val' => '3'],
                    ['title' => 'Antrean dibatalkan', 'val' => '3'],
                    ['title' => 'Selesai Dilayani', 'val' => '20']
                ];
            @endphp

            @foreach($stats as $s)
            <div class="col-md-6">
                <div class="stat-card">
                    <div class="text-muted small fw-bold mb-2">{{ $s['title'] }}</div>
                    <div class="display-6 fw-bold text-dark">{{ $s['val'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
