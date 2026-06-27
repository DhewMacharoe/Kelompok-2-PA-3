@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Kartu Statistik Dasbor -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="stat-card shadow-sm border-0">
                <div class="mb-2 text-primary">
                    <i class="bi bi-people-fill fs-2"></i>
                </div>
                <h6 class="text-muted mb-1 small fw-bold text-uppercase" style="letter-spacing: 0.5px;">Total Menunggu</h6>
                <h3 class="fw-bold m-0 text-dark">{{ $statistikData[0] ?? 0 }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card shadow-sm border-0">
                <div class="mb-2 text-success">
                    <i class="bi bi-check-circle-fill fs-2"></i>
                </div>
                <h6 class="text-muted mb-1 small fw-bold text-uppercase" style="letter-spacing: 0.5px;">Total Selesai</h6>
                <h3 class="fw-bold m-0 text-dark">{{ $statistikData[1] ?? 0 }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card shadow-sm border-0">
                <div class="mb-2 text-danger">
                    <i class="bi bi-x-circle-fill fs-2"></i>
                </div>
                <h6 class="text-muted mb-1 small fw-bold text-uppercase" style="letter-spacing: 0.5px;">Total Batal</h6>
                <h3 class="fw-bold m-0 text-dark">{{ $statistikData[2] ?? 0 }}</h3>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-xl-5">
            <div class="queue-card-main shadow-sm">
                <p class="text-uppercase small mb-1 opacity-75">Sedang Dilayani</p>
                <div class="queue-number">
                    {{ $dipanggil ? $dipanggil->nomor_antrean_seq : '--' }}
                </div>
                <p class="mb-4 fs-5">{{ $dipanggil ? $dipanggil->nama_pelanggan : 'Tidak ada' }}</p>

                <div class="d-flex justify-content-center gap-3 mb-4">
                    @if ($dipanggil)
                        <button type="button" class="btn btn-success px-4 py-2 fw-bold shadow-sm btn-queue-action-dashboard d-inline-flex align-items-center gap-2"
                            style="background-color: #4CC779;" data-queue-id="{{ $dipanggil->id }}"
                            data-queue-status="selesai" aria-label="Selesaikan Antrean">
                            <i class="bi bi-check-circle-fill" aria-hidden="true"></i> Selesai
                        </button>
                        <button type="button" class="btn btn-danger px-4 py-2 fw-bold shadow-sm btn-queue-action-dashboard d-inline-flex align-items-center gap-2"
                            style="background-color: #EB5757;" data-queue-id="{{ $dipanggil->id }}"
                            data-queue-status="batal" aria-label="Batalkan Antrean">
                            <i class="bi bi-x-circle-fill" aria-hidden="true"></i> Batalkan
                        </button>
                    @else
                        @if (($jumlahMenungguHariIni ?? 0) > 0)
                            <button type="button" class="btn btn-primary px-4 py-2 fw-bold shadow-sm btn-call-dashboard d-inline-flex align-items-center gap-2"
                                style="background-color: var(--primary-blue); border:none;" aria-label="Panggil Antrean">
                                <i class="bi bi-megaphone-fill" aria-hidden="true"></i> Panggil
                            </button>
                        @else
                            <button type="button" class="btn btn-primary px-4 py-2 fw-bold shadow-sm d-inline-flex align-items-center gap-2" disabled aria-disabled="true"
                                style="background-color: var(--primary-blue); border:none; opacity: 0.65; cursor: not-allowed;" aria-label="Tidak ada antrean">
                                <i class="bi bi-megaphone-fill" aria-hidden="true"></i> Panggil
                            </button>
                        @endif
                    @endif
                </div>
                <div class="text-start mt-4 bg-white bg-opacity-10 p-3 rounded">
                    <p class="text-center small mb-3 border-bottom border-secondary pb-2 fw-semibold text-uppercase" style="letter-spacing: 0.5px;">Antrean Berikutnya</p>

                    @forelse ($antreanMenunggu as $item)
                        <div class="d-flex justify-content-between align-items-center mb-2 px-3 border border-white border-opacity-25 border-1 rounded bg-white bg-opacity-5"
                            style="height: 56px;">
                            <span class="fw-bold fs-5">{{ str_pad($item->nomor_antrean_seq, 2, '0', STR_PAD_LEFT) }}</span>
                            <span class="fw-semibold">{{ $item->nama_pelanggan }}</span>
                        </div>
                    @empty
                        <div class="text-center py-4 text-white-50">
                            <i class="bi bi-people-fill fs-3 mb-2 d-block opacity-50"></i>
                            <span class="small d-block">Tidak ada antrean berikutnya hari ini.</span>
                        </div>
                    @endforelse

                    <div class="text-center mt-3">
                        <a href="/admin/antrean" class="text-white-50 text-decoration-none small hover-underline"><i class="bi bi-arrow-right-short"></i> Lihat Semua Antrean</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-7">
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="text-muted fw-bold mb-3">Grafik Statistik Antrean Hari Ini</h6>
                            <canvas id="statistikChart" height="120"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
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

    <script type="application/json" id="statistik-data-json">@json($statistikData ?? [])</script>
    <script type="application/json" id="trend-labels-json">@json($trendLabels ?? [])</script>
    <script type="application/json" id="trend-data-json">@json($trendData ?? [])</script>

    @include('admin.script-dashboard')
@endpush
