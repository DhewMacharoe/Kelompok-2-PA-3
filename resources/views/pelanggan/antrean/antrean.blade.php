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

    $jumlahAntrean = \App\Models\Antrean::whereDate('created_at', \Carbon\Carbon::today())->where('status', 'menunggu')->count();
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

        <div class="app-card mx-auto" style="max-width: 600px; background: transparent; box-shadow: none;"
            data-logged-in-username="{{ auth()->check() ? auth()->user()->username : '' }}"
            data-queue-latitude="{{ $queueLocation['latitude'] ?? '' }}"
            data-queue-longitude="{{ $queueLocation['longitude'] ?? '' }}"
            data-queue-radius="{{ $queueLocation['radius_meters'] ?? 100 }}">
            
            <!-- Header Section -->
            @if ($dipanggil)
                <div class="header-section mb-4" style="background-color: #1a1a1a; border-radius: 16px; padding: 30px 20px; text-align: center; position: relative; overflow: hidden; margin-top: 20px;">
                    <div class="header-content position-relative" style="z-index: 1;">
                        <h3 class="text-white fw-bold mb-1" style="font-size: 1.5rem;">Sedang Melayani No. <span id="antrean-nomor">{{ $dipanggil->nomor_antrean_seq }}</span></h3>
                        <p class="text-secondary mb-4" style="font-size: 0.9rem;">Pelanggan sedang dalam proses layanan</p>
                        
                        <div class="row text-center border-top border-secondary pt-3 mt-2" style="border-color: #333 !important;">
                            <div class="col-4 border-end border-secondary" style="border-color: #333 !important;">
                                <p class="text-secondary mb-1" style="font-size: 0.75rem;">Sisa Menunggu</p>
                                <h5 class="text-white fw-bold mb-0">{{ $jumlahAntrean }}</h5>
                            </div>
                            <div class="col-4 border-end border-secondary" style="border-color: #333 !important;">
                                <p class="text-secondary mb-1" style="font-size: 0.75rem;">Status Saat Ini</p>
                                <h5 class="fw-bold mb-0" style="color: #e8a53a; font-size: 0.85rem;" id="antrean-status">{{ ucfirst($dipanggil->status) }}</h5>
                            </div>
                            <div class="col-4">
                                <p class="text-secondary mb-1" style="font-size: 0.75rem;">Sedang Dilayani</p>
                                <h5 class="fw-bold mb-0" style="color: #e8a53a; font-size: 0.85rem;" id="antrean-nama">{{ $dipanggil->nama_pelanggan }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="header-section mb-4" style="background-color: #1a1a1a; background-image: url('{{ asset('assets/images/barber-bg.jpg') }}'); background-size: cover; background-position: center; border-radius: 16px; padding: 30px 20px; text-align: center; position: relative; overflow: hidden; margin-top: 20px;">
                    <div style="position: absolute; inset: 0; background: rgba(26, 26, 26, 0.85);"></div>
                    <div class="header-content position-relative" style="z-index: 1;">
                        <div class="mb-3">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 60px; height: 60px; background: rgba(232, 165, 58, 0.2); border: 1px solid #e8a53a;">
                                <i class="fas fa-chair" style="color: #e8a53a; font-size: 1.5rem;"></i>
                            </div>
                        </div>
                        <h3 class="text-white fw-bold mb-1" style="font-size: 1.5rem;">Belum Ada yang Dilayani</h3>
                        <p class="text-secondary mb-4" style="font-size: 0.9rem;">Menunggu pemilik barbershop memanggil antrean</p>
                        
                        <div class="row text-center border-top border-secondary pt-3 mt-2" style="border-color: #444 !important;">
                            <div class="col-4 border-end border-secondary" style="border-color: #444 !important;">
                                <p class="text-secondary mb-1" style="font-size: 0.75rem;">Total Antrean</p>
                                <h5 class="text-white fw-bold mb-0">{{ $jumlahAntrean }}</h5>
                            </div>
                            <div class="col-4 border-end border-secondary" style="border-color: #444 !important;">
                                <p class="text-secondary mb-1" style="font-size: 0.75rem;">Status Saat Ini</p>
                                <h5 class="fw-bold mb-0" style="color: #e8a53a; font-size: 0.85rem;">Menunggu Panggilan</h5>
                            </div>
                            <div class="col-4">
                                <p class="text-secondary mb-1" style="font-size: 0.75rem;">Sedang Dilayani</p>
                                <h5 class="fw-bold mb-0" style="color: #e8a53a; font-size: 0.85rem;">Belum Ada</h5>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- User Status Card -->
            @auth
                @if ($antreanSayaAktif)
                    <div class="card shadow-sm mb-4" style="border: 1px solid #f5d39a !important; border-radius: 16px; background-color: #ffffff;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="d-flex align-items-center justify-content-center rounded-circle me-3" style="width: 45px; height: 45px; border: 2px solid #e8a53a; background: #fffcf5;">
                                    <i class="far fa-user" style="color: #e8a53a; font-size: 1.2rem;"></i>
                                </div>
                                <h5 class="fw-bold mb-0">Antrean Anda Aktif</h5>
                            </div>
                            
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small">Nomor Antrean Anda</span>
                                <span class="fw-bold" id="my-queue-number">{{ $antreanSayaAktif->nomor_antrean_seq }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small">Posisi Saat Ini</span>
                                <span class="fw-bold" id="my-queue-position">{{ $antreanSayaAktif->status === 'menunggu' ? str_pad((string) ($posisiAntreanSaya ?? 0), 2, '0', STR_PAD_LEFT) : '-' }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small">Layanan</span>
                                <span class="fw-bold text-end" id="my-queue-services">{{ $antreanSayaAktif->layanan1?->nama ?? '-' }}{{ $antreanSayaAktif->layanan2 ? ' + ' . $antreanSayaAktif->layanan2->nama : '' }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3 border-bottom pb-3">
                                <span class="text-muted small">Status</span>
                                <span class="fw-bold" style="color: #e8a53a;" id="my-queue-status-chip">{{ strtoupper($antreanSayaAktif->status) }}</span>
                            </div>
                            
                            @if ($antreanSayaAktif->status === 'menunggu')
                            <div class="alert mb-4 p-3" style="background-color: #fff8eb; border: 1px solid #f5d39a; border-radius: 8px;">
                                <div class="d-flex gap-2">
                                    <i class="fas fa-info-circle mt-1" style="color: #e8a53a;"></i>
                                    <p class="mb-0 small" style="color: #8c6a28; line-height: 1.4;">Saat ini No. {{ $dipanggil ? $dipanggil->nomor_antrean_seq : '-' }} sedang dilayani. Anda akan dipanggil setelah layanan selesai.</p>
                                </div>
                            </div>
                            
                            <div id="my-queue-cancel-action">
                                <form action="{{ route('antrean.cancel') }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="button" id="btn-cancel-my-queue" class="btn w-100 fw-bold" style="border: 2px solid #e8a53a; color: #e8a53a; border-radius: 10px; padding: 12px; background: transparent;" data-loading-text="Membatalkan...">
                                        Batalkan Antrean Saya
                                    </button>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                @endif
            @else
                <div class="card shadow-sm mb-4" style="border: 1px solid #eaeaea; border-radius: 16px; background-color: #ffffff;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="d-flex align-items-center justify-content-center rounded-circle me-3" style="width: 45px; height: 45px; background: #f0f0f0;">
                                <i class="far fa-user" style="color: #888; font-size: 1.2rem;"></i>
                            </div>
                            <h5 class="fw-bold mb-0">Anda belum login</h5>
                        </div>
                        
                        <p class="text-muted small mb-4" style="line-height: 1.5;">Silakan login terlebih dahulu untuk mengambil dan melihat detail antrean pribadi Anda. Jika belum memiliki akun, antrean juga dapat ditambahkan melalui pemilik barber.</p>
                        
                        <a href="{{ route('login.user') }}" class="btn w-100 fw-bold mb-2 text-white" style="background-color: #e8a53a; border-radius: 10px; padding: 12px;">Login Sekarang</a>
                    </div>
                </div>
            @endauth

            <!-- Queue List Section -->
            <div class="d-flex justify-content-between align-items-center mb-3 mt-4 px-1">
                <h6 class="fw-bold mb-0 text-dark">{{ $antreanSayaAktif ? 'Status Antrean Saat Ini' : 'Urutan Antrean' }}</h6>
                @if ($antreanSayaAktif)
                    <span class="text-muted small">Lihat antrean yang sedang aktif</span>
                @endif
            </div>

            <div class="queue-list-container mb-4" style="max-height: 260px; overflow-y: auto; padding-right: 5px;">
                @if ($data_antrean && count($data_antrean) > 0)
                    @foreach ($data_antrean as $antrean)
                        <div class="card shadow-sm mb-2 {{ $antreanSayaAktif && $antreanSayaAktif->id === $antrean->id ? 'border-success border-2' : 'border-0' }}" style="background: #ffffff; border-radius: 12px;">
                            <div class="card-body p-3 d-flex align-items-center">
                                <div class="d-flex align-items-center justify-content-center text-white fw-bold me-3" style="width: 50px; height: 50px; background-color: #1a1a1a; font-size: 1.1rem; border-radius: 10px;">
                                    {{ $antrean->nomor_antrean_seq }}
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-1 text-dark" style="font-size: 0.95rem;">{{ $antrean->nama_pelanggan }}</h6>
                                    <p class="text-muted mb-0" style="font-size: 0.75rem;"><i class="far fa-clock me-1"></i> {{ $antrean->created_at->format('H:i') }}</p>
                                </div>
                                <div>
                                    @if ($antreanSayaAktif && $antreanSayaAktif->id === $antrean->id)
                                        <span class="badge" style="border: 1px solid #198754; color: #198754; background: #e8f7ef; padding: 6px 12px; border-radius: 20px; font-weight: 700; font-size: 0.65rem; letter-spacing: 0.5px;">ANTREAN SAYA</span>
                                    @else
                                        @if ($antrean->status == 'sedang dilayani')
                                            <span class="badge" style="border: 1px solid #e8a53a; color: #e8a53a; background: #fffaf0; padding: 6px 12px; border-radius: 20px; font-weight: 700; font-size: 0.65rem; letter-spacing: 0.5px;">SEDANG DILAYANI</span>
                                        @else
                                            <span class="badge" style="border: 1px solid #e8a53a; color: #e8a53a; background: #fffaf0; padding: 6px 12px; border-radius: 20px; font-weight: 700; font-size: 0.65rem; letter-spacing: 0.5px;">MENUNGGU</span>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-5">
                        <i class="far fa-folder-open mb-3" style="font-size: 2.5rem; color: #ccc;"></i>
                        <p class="text-muted fw-medium">Belum ada antrean saat ini.</p>
                    </div>
                @endif
            </div>

            <!-- Action Buttons -->
            @auth
                @if (!$punyaAntreanAktif)
                    @if (\App\Models\Antrean::isOperationalHour())
                        <div class="d-grid gap-3 mb-4">
                            <button class="btn btn-add-queue fw-bold text-white shadow-sm" data-bs-toggle="modal"
                                data-bs-target="#modalTambahAntrean"
                                data-loading-text="Membuka form..." style="background-color: #e8a53a; border-radius: 12px; padding: 14px 20px; font-size: 1rem;">
                                Tambah Antrean
                            </button>
                        </div>
                    @else
                        <button class="btn fw-bold text-white mb-4 shadow-sm w-100" disabled
                            style="background-color: #999; border-radius: 12px; padding: 14px 20px; font-size: 1rem; cursor: not-allowed;" title="Di luar jam operasional">
                            Antrean Tutup
                        </button>
                    @endif
                @endif
            @endauth

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
                                            <a href="{{ route('pelanggan.layanan') }}?id={{ $layanan->id }}&open=true&from=antrean" onclick="event.stopPropagation()" class="text-decoration-none detail-layanan-link" style="color: #17a2b8;" title="Lihat Detail">
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
