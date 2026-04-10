@extends('admin.layouts.app')

@section('title', 'Dashboard Utama')

@section('content')
<div class="row g-4">
    <div class="col-xl-5">
        <div class="queue-card-main shadow-sm">
            <p class="text-uppercase small mb-1 opacity-75">Sedang Dilayani</p>
            <div class="queue-number">A02</div>
            <p class="mb-4 fs-5">{{ $dipanggil ? $dipanggil->nama_pelanggan : 'Tidak ada' }}</p>
            <div class="d-flex justify-content-center gap-3 mb-4">
                <button class="btn btn-primary px-4 fw-bold" style="background-color: var(--primary-blue); border:none;">Panggil</button>
                <button class="btn btn-danger px-4 fw-bold">Batalkan</button>
            </div>

            <div class="text-start mt-4 bg-white bg-opacity-10 p-3 rounded">
                <p class="text-center small mb-3 border-bottom border-secondary pb-2">Antrean Berikutnya</p>

                @foreach ($antrianMenunggu as $item)
                <div class="d-flex justify-content-between align-items-center mb-2 px-2 border border-white border-1 rounded" style="height: 62px;">
                    <span>03</span>
                    <span>{{ $item->nama_pelanggan }}</span>
                </div>
                @endforeach

                <div class="text-center mt-3">
                    <a href="/admin/antrian" class="text-white-50 text-decoration-none small">Lihat Semua</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-7">


        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="text-muted fw-bold mb-3">Grafik Statistik Antrean Hari Ini </h6>
                        <canvas id="statistikChart" height="120"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="text-muted fw-bold mb-3">Tren Pengunjung 7 Hari Terakhir </h6>
                        <canvas id="trendChart" height="120"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // === GRAFIK 1: BAR CHART (Statistik Hari Ini) ===
    const canvasStatistik = document.getElementById('statistikChart');
    if (canvasStatistik) {
        const ctx1 = canvasStatistik.getContext('2d');
        const chartDataBar = @json($statistikData);


        console.log("Data Grafik:", chartDataBar);

        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: 'Jumlah Orang',
                    data: chartDataBar,
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(75, 192, 192, 0.6)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 5 }
                    }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });
    }

    // === GRAFIK 2: LINE CHART (Tren 7 Hari Terakhir) ===
    const canvasTrend = document.getElementById('trendChart');
    if (canvasTrend) {
        const ctx2 = canvasTrend.getContext('2d');
        const labelsLine = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        const chartDataLine = [12, 19, 15, 25, 22, 40, 35]; // Data dummy

        new Chart(ctx2, {
            type: 'line',
            data: {
                labels: labelsLine,
                datasets: [{
                    label: 'Total Pengunjung',
                    data: chartDataLine,
                    borderColor: 'rgba(47, 128, 237, 1)', // Warna biru
                    backgroundColor: 'rgba(47, 128, 237, 0.1)', // Warna fill biru transparan
                    borderWidth: 3,
                    pointBackgroundColor: 'rgba(47, 128, 237, 1)',
                    pointRadius: 4,
                    fill: true, // Mengisi area bawah garis
                    tension: 0.4 // Melengkungkan garis
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 10 }
                    }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });
    }
});
</script>
@endpush
