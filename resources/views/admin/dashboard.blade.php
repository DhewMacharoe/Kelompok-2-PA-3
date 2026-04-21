@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="row g-4">
        <div class="col-xl-5">
            <div class="queue-card-main shadow-sm">
                <p class="text-uppercase small mb-1 opacity-75">Sedang Dilayani</p>
                <div class="queue-number">
                    {{ $dipanggil ? substr($dipanggil->nomor_antrian, -2) : '--' }}
                </div>
                <p class="mb-4 fs-5">{{ $dipanggil ? $dipanggil->nama_pelanggan : 'Tidak ada' }}</p>

                <div class="d-flex justify-content-center gap-3 mb-4">
                    @if ($dipanggil)
                        <button type="button" class="btn btn-success px-4 fw-bold shadow-sm"
                            onclick="ubahStatus(this, {{ $dipanggil->id }}, 'selesai')">
                            Selesai
                        </button>
                        <button type="button" class="btn btn-danger px-4 fw-bold shadow-sm"
                            onclick="ubahStatus(this, {{ $dipanggil->id }}, 'batal')">
                            Batalkan
                        </button>
                    @else
                        <button type="button" class="btn btn-primary px-4 fw-bold shadow-sm"
                            style="background-color: var(--primary-blue); border:none;" onclick="panggil()">
                            Panggil
                        </button>
                    @endif
                </div>
                <div class="text-start mt-4 bg-white bg-opacity-10 p-3 rounded">
                    <p class="text-center small mb-3 border-bottom border-secondary pb-2">Antrean Berikutnya</p>

                    @foreach ($antrianMenunggu as $item)
                        <div class="d-flex justify-content-between align-items-center mb-2 px-2 border border-white border-1 rounded"
                            style="height: 62px;">
                            <span>{{ substr($item->nomor_antrian, -2) }}</span>
                            <span>{{ $item->nama_pelanggan }}</span>
                        </div>
                    @endforeach

                    <div class="text-center mt-3">
                        <a href="/admin/antrian" class="text-white-50 text-decoration-none small">Lihat Semua Antrian</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-7">
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="text-muted fw-bold mb-3">Grafik Statistik Antrean Hari Ini</h6>
                            <canvas id="statistikChart" height="120"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h6 class="text-muted fw-bold mb-3">Tren Pengunjung 7 Hari Terakhir</h6>
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

    @php
        use App\Models\Antrian;
        use Carbon\Carbon;

        $hariIni = Carbon::today();
        $dataStatus = Antrian::whereDate('created_at', $hariIni)
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $statistikData = [$dataStatus['menunggu'] ?? 0, $dataStatus['selesai'] ?? 0, $dataStatus['batal'] ?? 0];

        $trendLabels = [];
        $trendData = [];
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = Carbon::today()->subDays($i);
            $trendLabels[] = $tanggal->translatedFormat('l');
            $trendData[] = Antrian::whereDate('created_at', $tanggal)->count();
        }
    @endphp

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ... (Grafik 1 & Grafik 2 tetap sama seperti sebelumnya, tidak saya ubah) ...
            const canvasStatistik = document.getElementById('statistikChart');
            if (canvasStatistik) {
                const ctx1 = canvasStatistik.getContext('2d');
                const chartDataBar = @json($statistikData);
                new Chart(ctx1, {
                    type: 'bar',
                    data: {
                        labels: ['Menunggu', 'Selesai', 'Batal'],
                        datasets: [{
                            label: 'Jumlah Orang',
                            data: chartDataBar,
                            backgroundColor: [
                                'rgba(54, 162, 235, 0.6)',
                                'rgba(39, 174, 96, 0.6)',
                                'rgba(255, 99, 132, 0.6)'
                            ],
                            borderColor: [
                                'rgba(54, 162, 235, 1)',
                                'rgba(39, 174, 96, 1)',
                                'rgba(255, 99, 132, 1)'
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
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            }

            const canvasTrend = document.getElementById('trendChart');
            if (canvasTrend) {
                const ctx2 = canvasTrend.getContext('2d');
                const labelsLine = @json($trendLabels);
                const chartDataLine = @json($trendData);
                new Chart(ctx2, {
                    type: 'line',
                    data: {
                        labels: labelsLine,
                        datasets: [{
                            label: 'Total Pengunjung',
                            data: chartDataLine,
                            borderColor: 'rgba(47, 128, 237, 1)',
                            backgroundColor: 'rgba(47, 128, 237, 0.1)',
                            borderWidth: 3,
                            pointBackgroundColor: 'rgba(47, 128, 237, 1)',
                            pointRadius: 4,
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            }
        });

        // === FUNGSI JAVASCRIPT BARU UNTUK TOMBOL ===

        function panggil() {
            fetch("{{ route('admin.antrian.panggil') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                })
                .then(response => response.json())
                .then(data => {
                    alert('Antrean berikutnya dipanggil!');
                    window.location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memanggil antrean berikutnya.');
                });
        }

        function ubahStatus(button, id, targetStatus) {
            let originalText = button.innerHTML;
            button.innerHTML = 'Memproses...';
            button.disabled = true;

            fetch(`/admin/antrian/${id}/ubah-status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        status: targetStatus
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    alert('Status berhasil diubah menjadi: ' + targetStatus);
                    window.location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengubah status.');
                    button.innerHTML = originalText;
                    button.disabled = false;
                });
        }
    </script>
@endpush
