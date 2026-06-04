@extends('pelanggan.layouts.app')

@section('title', 'Antrean')

@php
    $defaultConfig = config('queue_location.location', []);
    try {
        $latitude = \App\Models\Setting::get('queue_latitude', $defaultConfig['latitude'] ?? 2.33758);
        $longitude = \App\Models\Setting::get('queue_longitude', $defaultConfig['longitude'] ?? 99.079255);
        $radius = \App\Models\Setting::get('queue_radius_meters', $defaultConfig['radius_meters'] ?? 100);
        $queueLocation = [
            'latitude' => (float) $latitude,
            'longitude' => (float) $longitude,
            'radius_meters' => (int) $radius,
        ];
    } catch (\Exception $e) {
        $queueLocation = $defaultConfig;
    }
@endphp

@push('styles')
    @include('pelanggan.antrean.style-index')
@endpush

@section('content')

    <div class="container px-3">
        @if (session('success'))
            <div class="alert alert-success mt-3">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger mt-3">{{ session('error') }}</div>
        @endif

        <div class="app-card"
            data-logged-in-username="{{ auth()->check() ? auth()->user()->username : '' }}"
            data-queue-latitude="{{ $queueLocation['latitude'] ?? '' }}"
            data-queue-longitude="{{ $queueLocation['longitude'] ?? '' }}"
            data-queue-radius="{{ $queueLocation['radius_meters'] ?? 100 }}">
            
            <!-- Banner Sedang Dilayani (Full Width at Top) -->
            <div class="header-section text-center position-relative overflow-hidden py-5 px-3">
                <div class="header-overlay"></div>
                <div class="header-content z-index-2 w-100">
                    <!-- Icon Microphone in Gold circle -->
                    <div class="active-icon-wrapper mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center text-white bg-dark shadow-sm">
                        <i class="fas fa-microphone-alt" style="font-size: 1.8rem; color: #cc7c1b;"></i>
                    </div>
                    
                    <!-- Main status text -->
                    <h2 class="active-title text-white fw-bold mb-1" id="antrean-nama">
                        {{ $dipanggil ? $dipanggil->nama_pelanggan : 'Belum Ada yang Dilayani' }}
                    </h2>
                    <p class="active-subtitle text-secondary small mb-4" id="antrean-status-sub">
                        {{ $dipanggil ? 'Sedang berada di kursi pangkas.' : 'Menunggu pemilik barbershop memanggil antrean' }}
                    </p>
                    
                    <!-- Echo hidden status field -->
                    <span id="antrean-status" class="d-none">{{ $dipanggil ? $dipanggil->status : '' }}</span>
                    
                    <div class="header-divider-container mb-4 d-flex align-items-center justify-content-center gap-3">
                        <span class="header-divider-line"></span>
                    </div>
                    
                    <!-- 3 Stats Columns -->
                    <div class="row g-3 justify-content-center text-center">
                        <div class="col-4">
                            <span class="stat-label text-muted d-block small mb-1">Total Antrean</span>
                            <strong class="stat-val text-gold-accent fs-3 d-block" id="total-antrean-val">{{ count($data_antrean) }}</strong>
                        </div>
                        <div class="col-4 border-start border-secondary">
                            <span class="stat-label text-muted d-block small mb-1">Status Saat Ini</span>
                            <strong class="stat-val text-gold-accent fs-5 d-block" id="status-antrean-val">
                                @auth
                                    {{ $antreanSayaAktif ? ucfirst($antreanSayaAktif->status) : 'Tidak Mengantre' }}
                                @else
                                    Belum Login
                                @endauth
                            </strong>
                        </div>
                        <div class="col-4 border-start border-secondary">
                            <span class="stat-label text-muted d-block small mb-1">Sedang Dilayani</span>
                            <strong class="stat-val text-gold-accent fs-5 d-block" id="antrean-nomor">
                                {{ $dipanggil ? $dipanggil->nomor_antrean_seq : 'Belum Ada' }}
                            </strong>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Body Panel -->
            <div class="right-panel">
                <div class="queue-section">
                    
                    @guest
                        <!-- Guest Login Card -->
                        <div class="guest-login-card p-4 rounded shadow-sm border bg-white mb-4 d-flex gap-3 align-items-start">
                            <div class="guest-user-icon rounded-circle bg-light d-flex align-items-center justify-content-center border" style="width: 54px; height: 54px; flex-shrink: 0; border-color: #eef1f5 !important;">
                                <i class="far fa-user" style="font-size: 1.4rem; color: #cc7c1b;"></i>
                            </div>
                            <div class="w-100 text-start">
                                <h5 class="fw-bold text-dark mb-1" style="font-size: 1.1rem;">Anda belum login</h5>
                                <p class="text-secondary small mb-3" style="line-height: 1.45;">
                                    Silakan login terlebih dahulu untuk mengambil dan melihat detail antrean pribadi Anda. Jika belum memiliki akun, antrean juga dapat ditambahkan melalui pemilik barber.
                                </p>
                                <div class="d-flex flex-column gap-2">
                                    <a href="{{ route('login.user') }}" class="btn btn-gold-accent text-white fw-bold py-2.5" style="border-radius: 8px; font-size: 0.88rem; letter-spacing: 0.2px;">
                                        Login Sekarang
                                    </a>
                                    <button class="btn btn-outline-gold fw-bold py-2.5" data-bs-toggle="modal" data-bs-target="#modalTambahAntrean" style="border-radius: 8px; font-size: 0.88rem; border-color: #cc7c1b; color: #cc7c1b; background: transparent; transition: all 0.25s ease;">
                                        Tambah lewat Pemilik Barber
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endguest

                    @auth
                        @if ($antreanSayaAktif)
                            <div class="my-queue-card mb-4" id="my-queue-card">
                                <div class="my-queue-header">
                                    <h3 class="my-queue-title">Nomor Antrean Anda</h3>
                                    <div class="my-queue-number" id="my-queue-number">{{ $antreanSayaAktif->nomor_antrean_seq }}</div>
                                </div>

                                <div class="my-queue-meta">
                                    <div class="my-queue-meta-row">
                                        <span class="my-queue-meta-label">Posisi</span>
                                        <span class="my-queue-meta-value" id="my-queue-position">
                                            {{ $antreanSayaAktif->status === 'menunggu' ? str_pad((string) ($posisiAntreanSaya ?? 0), 2, '0', STR_PAD_LEFT) : '-' }}
                                        </span>
                                    </div>
                                    <div class="my-queue-meta-row">
                                        <span class="my-queue-meta-label">Layanan</span>
                                        <span class="my-queue-meta-value" id="my-queue-services">
                                            {{ $antreanSayaAktif->layanan1?->nama ?? '-' }}{{ $antreanSayaAktif->layanan2 ? ' + ' . $antreanSayaAktif->layanan2->nama : '' }}
                                        </span>
                                    </div>
                                    <div class="my-queue-meta-row">
                                        <span class="my-queue-meta-label">Status</span>
                                        <span class="my-queue-status-chip" id="my-queue-status-chip">{{ strtoupper($antreanSayaAktif->status) }}</span>
                                    </div>
                                </div>

                                @if ($antreanSayaAktif->status === 'menunggu')
                                    <div id="my-queue-cancel-action">
                                        <form action="{{ route('antrean.cancel') }}" method="POST" onsubmit="return confirm('Batalkan antrean Anda?');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" id="btn-cancel-my-queue" class="btn-cancel-my-queue" data-loading-text="Membatalkan..." @disabled($antreanSayaAktif->status === 'sedang dilayani')>
                                                Batalkan Antrean Saya
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        @endif
                    @endauth

                    <div class="queue-section-header d-flex align-items-center gap-2 mb-3">
                        <i class="far fa-clipboard text-gold-accent" style="font-size: 1.15rem;"></i>
                        <div class="fw-bold text-dark" style="font-size: 1.05rem;">Urutan Antrean</div>
                    </div>
                    <p class="text-secondary small mb-3">Lihat daftar pelanggan yang sedang menunggu</p>

                    <div class="queue-list-container">
                        @if ($data_antrean && count($data_antrean) > 0)
                            @foreach ($data_antrean as $antrean)
                                <div class="queue-card {{ $antreanSayaAktif && $antreanSayaAktif->id === $antrean->id ? 'my-queue-highlight' : '' }} d-flex justify-content-between align-items-center p-3 mb-2 rounded border bg-white shadow-sm">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="queue-number-box d-flex align-items-center justify-content-center fw-bold text-white bg-dark rounded" style="width: 44px; height: 44px; font-size: 1.1rem;">
                                            {{ $antrean->nomor_antrean_seq }}
                                        </div>
                                        <div class="queue-info text-start">
                                            <p class="queue-name fw-bold text-dark mb-0">{{ $antrean->nama_pelanggan }}</p>
                                            <p class="queue-time text-secondary small mb-0">{{ $antrean->created_at->format('H:i') }}</p>
                                        </div>
                                    </div>
                                    <div class="queue-badges">
                                        @if ($antreanSayaAktif && $antreanSayaAktif->id === $antrean->id)
                                            <span class="badge-mine me-2">ANTREAN SAYA</span>
                                        @endif
                                        <span class="badge-waiting">MENUNGGU</span>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center mt-4 mb-4 text-muted">
                                Tidak Ada Antrean Saat Ini <br> Silahkan Ambil Antrean Anda
                            </div>
                        @endif
                    </div>

                    <div class="footer-section px-0 pt-3">
                        @auth
                            @if (!$punyaAntreanAktif)
                                <button class="btn btn-gold-accent text-white fw-bold py-2.5 w-100" data-bs-toggle="modal" data-bs-target="#modalTambahAntrean" data-loading-text="Membuka form..." style="border-radius: 8px; font-size: 0.9rem;">
                                    Tambah Antrean
                                </button>
                            @endif
                        @endauth
                    </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Antrean -->
    <div class="modal fade modal-tambah-antrean" id="modalTambahAntrean" tabindex="-1" aria-labelledby="modalTambahAntreanLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahAntreanLabel">Pilih Layanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form id="formTambahAntreanPelanggan" action="{{ route('antrean.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_latitude" id="user_latitude">
                        <input type="hidden" name="user_longitude" id="user_longitude">
                        <div class="mb-3" style="display: none;">
                            <input type="text" id="nama_pelanggan" value="{{ auth()->user()->username ?? '' }}" readonly>
                        </div>

                        <div class="queue-location-preview">
                            <div class="queue-location-preview-header">
                                <div>
                                    <div class="queue-location-kicker">Visual posisi antrean</div>
                                    <div class="queue-location-title">Anda harus berada di dalam area ini</div>
                                </div>
                                <span class="queue-location-status" id="queue-location-status">Menunggu GPS</span>
                            </div>

                            <div class="queue-location-map" id="queue-location-map" role="img" aria-label="Peta posisi antrean">
                                <div class="queue-location-map-empty" id="queue-location-map-empty">Memuat peta lokasi...</div>
                            </div>

                            <div class="queue-location-footer">
                                <div class="queue-location-stat">
                                    <span class="queue-location-stat-label">Jarak Anda</span>
                                    <strong class="queue-location-stat-value" id="queue-location-distance">-</strong>
                                </div>
                                <div class="queue-location-stat">
                                    <span class="queue-location-stat-label">Radius izin</span>
                                    <strong class="queue-location-stat-value">{{ number_format((int) ($queueLocation['radius_meters'] ?? 100), 0, ',', '.') }} m</strong>
                                </div>
                            </div>

                            <div class="queue-location-helper" id="queue-location-helper">
                                Aktifkan GPS untuk melihat posisi Anda terhadap titik antrean.
                            </div>
                        </div>

                        <!-- Hidden Selects to keep backend working -->
                        <select id="layanan_id1" name="layanan_id1" class="d-none" required>
                            <option value="">Pilih layanan 1</option>
                            @foreach ($layananAktif as $layanan)
                                <option value="{{ $layanan->id }}" data-nama="{{ $layanan->nama }}" data-harga="{{ $layanan->harga }}" data-waktu="{{ $layanan->estimasi_waktu }}">{{ $layanan->nama }}</option>
                            @endforeach
                        </select>
                        <select id="layanan_id2" name="layanan_id2" class="d-none">
                            <option value="">Pilih layanan 2</option>
                            @foreach ($layananAktif as $layanan)
                                <option value="{{ $layanan->id }}" data-nama="{{ $layanan->nama }}" data-harga="{{ $layanan->harga }}" data-waktu="{{ $layanan->estimasi_waktu }}">{{ $layanan->nama }}</option>
                            @endforeach
                        </select>

                        <!-- Step 1: Grid Layanan -->
                        <div id="step-layanan" class="step-container active">
                            <div class="service-grid">
                                @foreach ($layananAktif as $layanan)
                                    <div class="service-card" data-id="{{ $layanan->id }}" onclick="selectService({{ $layanan->id }})">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="service-name">{{ $layanan->nama }}</div>
                                            <a href="{{ route('pelanggan.layanan') }}?id={{ $layanan->id }}&open=true" onclick="event.stopPropagation()" class="text-decoration-none" style="color: #17a2b8;" title="Lihat Detail">
                                                <i class="fas fa-info-circle" style="font-size: 1.1rem;"></i>
                                            </a>
                                        </div>
                                        <div class="service-meta">
                                            <span><i class="far fa-clock"></i> {{ $layanan->estimasi_waktu }}</span>
                                            <span class="service-price">Rp{{ number_format($layanan->harga, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Step 2: Review Pilihan -->
                        <div id="step-review" class="step-container">
                            <div class="review-section">
                                <div class="review-title">Layanan Terpilih</div>
                                <div id="selected-services-container">
                                    <!-- Diisi oleh JS -->
                                </div>
                                <button type="button" class="btn-add-more mt-2" id="btn-add-more-service" onclick="showServiceGrid()">
                                    + Tambah Layanan Lain (Maks 2)
                                </button>
                            </div>
                            <div id="lokasi-feedback" class="alert alert-danger d-none" role="alert"></div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-submit-bottom btn-lg" id="btn-submit-antrean" data-loading-text="Mengambil antrean...">Ambil Antrean</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    @include('pelanggan.antrean.script-index')
@endpush
