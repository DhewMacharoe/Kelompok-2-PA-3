@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="row g-4">
        <div class="col-xl-5">
            <div class="queue-card-main shadow-sm">
                <p class="text-uppercase small mb-1 opacity-75">Sedang Dilayani</p>
                <div class="queue-number">
                    {{ $dipanggil ? substr($dipanggil->nomor_antrean, -2) : '--' }}
                </div>
                <p class="mb-4 fs-5">{{ $dipanggil ? $dipanggil->nama_pelanggan : 'Tidak ada' }}</p>

                <div class="d-flex justify-content-center gap-3 mb-4">
                    @if ($dipanggil)
                        <button type="button" class="btn btn-success px-4 fw-bold shadow-sm" style="background-color: #4CC779;"
                            onclick="ubahStatus(this, {{ $dipanggil->id }}, 'selesai')">
                            Selesai
                        </button>
                        <button type="button" class="btn btn-danger px-4 fw-bold shadow-sm" style="background-color: #EB5757;"
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

                    @foreach ($antreanMenunggu as $item)
                        <div class="d-flex justify-content-between align-items-center mb-2 px-2 border border-white border-1 rounded"
                            style="height: 62px;">
                            <span>{{ substr($item->nomor_antrean, -2) }}</span>
                            <span>{{ $item->nama_pelanggan }}</span>
                        </div>
                    @endforeach

                    <div class="text-center mt-3">
                        <a href="/admin/antrean" class="text-white-50 text-decoration-none small">Lihat Semua Antrean</a>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @php
        $hariIni = \Carbon\Carbon::today();
        $dataStatus = \App\Models\Antrean::whereDate('created_at', $hariIni)
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $statistikData = [$dataStatus['menunggu'] ?? 0, $dataStatus['selesai'] ?? 0, $dataStatus['batal'] ?? 0];

        $trendLabels = [];
        $trendData = [];
        for ($i = 6; $i >= 0; $i--) {
            $tanggal = \Carbon\Carbon::today()->subDays($i);
            $trendLabels[] = $tanggal->translatedFormat('l');
            $trendData[] = \App\Models\Antrean::whereDate('created_at', $tanggal)->count();
        }
    @endphp

    @include('admin.script-dashboard')
@endpush
