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

    $jumlahAntrean = isset($data_antrean) ? $data_antrean->count() : 0;
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

        @if (auth()->check() && auth()->user()->is_blocked)
            <div class="alert alert-danger mt-3 p-4 border-0 shadow-sm" role="alert" style="background-color: #F8D7DA; border-left: 5px solid #DC3545 !important;">
                <h5 class="alert-heading text-dark fw-bold mb-2"><i class="bi bi-exclamation-triangle-fill me-2 text-danger"></i>Akun Ditangguhkan (Diblokir)</h5>
                <p class="m-0 text-dark">Mohon maaf, akun Anda sedang ditangguhkan oleh moderator.</p>
                <hr class="border-danger opacity-25">
                <p class="mb-1 text-muted"><strong>Alasan Pemblokiran:</strong> {{ auth()->user()->blocked_reason ?? 'Pelanggaran ketentuan sistem.' }}</p>
                <p class="mb-0 text-muted"><strong>Tanggal Diblokir:</strong> {{ \Carbon\Carbon::parse(auth()->user()->blocked_at)->translatedFormat('d M Y, H:i') }} WIB</p>
                <p class="mt-2 mb-0 fw-semibold text-dark" style="font-size: 0.9rem;">Anda tidak dapat melakukan pemesanan antrean baru atau booking jadwal hingga pemblokiran dibuka.</p>
            </div>
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

                        <div class="header-stats-row text-center">
                            <div class="header-stat-col">
                                <p class="text-secondary mb-1" style="font-size: 0.75rem;">Sisa Menunggu</p>
                                <h5 class="text-white fw-bold mb-0">{{ $jumlahAntrean }}</h5>
                            </div>
                            <div class="header-stat-col">
                                <p class="text-secondary mb-1" style="font-size: 0.75rem;">Status Saat Ini</p>
                                <h5 class="fw-bold mb-0" style="color: {{ $activeBarbershop->warna_primer ?? '#e8a53a' }}; font-size: 0.85rem;" id="antrean-status">{{ ucfirst($dipanggil->status) }}</h5>
                            </div>
                            <div class="header-stat-col">
                                <p class="text-secondary mb-1" style="font-size: 0.75rem;">Sedang Dilayani</p>
                                <h5 class="fw-bold mb-0" style="color: {{ $activeBarbershop->warna_primer ?? '#e8a53a' }}; font-size: 0.85rem;" id="antrean-nama">{{ $dipanggil->nama_pelanggan }}</h5>
                            </div>
                        </div>
                        <div class="mt-3 py-2 text-center" style="background: {{ $activeBarbershop->warna_primer ?? '#e8a53a' }}1a; border-radius: 8px; border: 1px dashed {{ $activeBarbershop->warna_primer ?? '#e8a53a' }}4d;">
                            <p class="text-secondary mb-1" style="font-size: 0.75rem;">Durasi Pelayanan Berjalan <span class="ms-1" style="color: #a0a0a0;">(Est: {{ $dipanggil->total_estimasi_waktu }} mnt)</span></p>
                            <h4 class="fw-bold mb-0" style="color: {{ $activeBarbershop->warna_primer ?? '#e8a53a' }}; letter-spacing: 2px;" id="stopwatch-dipanggil" data-start="{{ $dipanggil->updated_at->timestamp * 1000 }}">00:00:00</h4>
                        </div>
                    </div>
                </div>
            @else
                <div class="header-section mb-4" style="background-color: #1a1a1a; background-image: url('{{ asset('assets/images/barber-bg.jpg') }}'); background-size: cover; background-position: center; border-radius: 16px; padding: 30px 20px; text-align: center; position: relative; overflow: hidden; margin-top: 20px;">
                    <div style="position: absolute; inset: 0; background: rgba(26, 26, 26, 0.85);"></div>
                    <div class="header-content position-relative" style="z-index: 1;">
                        <div class="mb-3">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle" style="width: 60px; height: 60px; background: {{ $activeBarbershop->warna_primer ?? '#e8a53a' }}33; border: 1px solid {{ $activeBarbershop->warna_primer ?? '#e8a53a' }};">
                                <i class="fas fa-chair" style="color: {{ $activeBarbershop->warna_primer ?? '#e8a53a' }}; font-size: 1.5rem;"></i>
                            </div>
                        </div>
                        <h3 class="text-white fw-bold mb-1" style="font-size: 1.5rem;">Belum Ada yang Dilayani</h3>
                        <p class="text-secondary mb-4" style="font-size: 0.9rem;">Menunggu pemilik barbershop memanggil antrean</p>

                        <div class="header-stats-row text-center">
                            <div class="header-stat-col">
                                <p class="text-secondary mb-1" style="font-size: 0.75rem;">Total Antrean</p>
                                <h5 class="text-white fw-bold mb-0">{{ $jumlahAntrean }}</h5>
                            </div>
                            <div class="header-stat-col">
                                <p class="text-secondary mb-1" style="font-size: 0.75rem;">Status Saat Ini</p>
                                <h5 class="fw-bold mb-0" style="color: {{ $activeBarbershop->warna_primer ?? '#e8a53a' }}; font-size: 0.85rem;">Menunggu Panggilan</h5>
                            </div>
                            <div class="header-stat-col">
                                <p class="text-secondary mb-1" style="font-size: 0.75rem;">Sedang Dilayani</p>
                                <h5 class="fw-bold mb-0" style="color: {{ $activeBarbershop->warna_primer ?? '#e8a53a' }}; font-size: 0.85rem;">Belum Ada</h5>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- User Status Card -->
            @auth
                @if ($antreanSayaAktif)
                    <div class="card shadow-sm mb-4" style="border: 1px solid {{ $activeBarbershop->warna_primer ?? '#e8a53a' }}80 !important; border-radius: 16px; background-color: #ffffff;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="d-flex align-items-center justify-content-center rounded-circle me-3" style="width: 45px; height: 45px; border: 2px solid {{ $activeBarbershop->warna_primer ?? '#e8a53a' }}; background: #fffcf5;">
                                    <i class="far fa-user" style="color: {{ $activeBarbershop->warna_primer ?? '#e8a53a' }}; font-size: 1.2rem;"></i>
                                </div>
                                <h5 class="fw-bold mb-0">Antrean Anda Aktif</h5>
                            </div>

                            @if($antreanSayaAktif->is_booking)
                            <div class="row mb-2 align-items-center">
                                <div class="col-6">
                                    <span class="text-muted small">Jadwal Booking</span>
                                </div>
                                <div class="col-6 text-end">
                                    <span class="fw-bold text-primary" style="font-size: 0.9rem;">{{ \Carbon\Carbon::parse($antreanSayaAktif->tanggal_booking)->format('d M Y') }} ({{ \Carbon\Carbon::parse($antreanSayaAktif->waktu_booking)->format('H:i') }})</span>
                                </div>
                            </div>
                            @endif
                            @if($antreanSayaAktif->barbershop)
                            <div class="row mb-2 align-items-center">
                                <div class="col-6">
                                    <span class="text-muted small">Cabang Barbershop</span>
                                </div>
                                <div class="col-6 text-end">
                                    <span class="fw-bold text-dark" style="font-size: 0.9rem;">{{ $antreanSayaAktif->barbershop->nama }}</span>
                                </div>
                            </div>
                            @endif
                            <div class="row mb-2 align-items-center">
                                <div class="col-6">
                                    <span class="text-muted small">Nomor Antrean Anda</span>
                                </div>
                                <div class="col-6 text-end">
                                    <span class="fw-bold" id="my-queue-number">{{ $antreanSayaAktif->nomor_antrean_seq }}</span>
                                </div>
                            </div>
                            <div class="row mb-2 align-items-center">
                                <div class="col-6">
                                    <span class="text-muted small">Posisi Saat Ini</span>
                                </div>
                                <div class="col-6 text-end">
                                    <span class="fw-bold" id="my-queue-position">{{ $antreanSayaAktif->status === 'menunggu' ? str_pad((string) ($posisiAntreanSaya ?? 0), 2, '0', STR_PAD_LEFT) : '-' }}</span>
                                </div>
                            </div>
                            <div class="row mb-2 align-items-center">
                                <div class="col-4">
                                    <span class="text-muted small">Layanan</span>
                                </div>
                                <div class="col-8 text-end">
                                    <span class="fw-bold text-end d-block" id="my-queue-services" style="font-size: 0.9rem; word-break: break-word;">{{ $antreanSayaAktif->layanan1?->nama ?? '-' }}{{ $antreanSayaAktif->layanan2 ? ' + ' . $antreanSayaAktif->layanan2->nama : '' }}</span>
                                </div>
                            </div>
                            <div class="row mb-3 border-bottom pb-3 align-items-center">
                                <div class="col-6">
                                    <span class="text-muted small">Status</span>
                                </div>
                                <div class="col-6 text-end">
                                    <span class="fw-bold" style="color: {{ $activeBarbershop->warna_primer ?? '#e8a53a' }};" id="my-queue-status-chip">{{ strtoupper($antreanSayaAktif->status) }}</span>
                                </div>
                            </div>

                            @if ($antreanSayaAktif->status === 'menunggu')
                            <div class="alert mb-4 p-3" style="background-color: {{ $activeBarbershop->warna_primer ?? '#e8a53a' }}14; border: 1px solid {{ $activeBarbershop->warna_primer ?? '#e8a53a' }}4d; border-radius: 8px;">
                                <div class="d-flex gap-2">
                                    <i class="fas fa-info-circle mt-1" style="color: {{ $activeBarbershop->warna_primer ?? '#e8a53a' }};"></i>
                                    <div>
                                        <p class="mb-1 small fw-bold" style="color: {{ $activeBarbershop->warna_primer ?? '#e8a53a' }};">Estimasi Waktu Pelayanan Anda: {{ $antreanSayaAktif->total_estimasi_waktu }} mnt</p>
                                        @if($antreanSayaAktif->is_booking && \Carbon\Carbon::parse($antreanSayaAktif->tanggal_booking)->isFuture() && !\Carbon\Carbon::parse($antreanSayaAktif->tanggal_booking)->isToday())
                                            <p class="mb-0 small text-muted" style="line-height: 1.4;">Silakan datang pada tanggal {{ \Carbon\Carbon::parse($antreanSayaAktif->tanggal_booking)->format('d M Y') }} jam {{ \Carbon\Carbon::parse($antreanSayaAktif->waktu_booking)->format('H:i') }} sesuai jadwal booking Anda.</p>
                                        @else
                                            <p class="mb-0 small text-muted" style="line-height: 1.4;">Saat ini No. {{ $dipanggil ? $dipanggil->nomor_antrean_seq : '-' }} sedang dilayani. Anda akan dipanggil setelah layanan selesai.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div id="my-queue-cancel-action">
                                <form action="{{ route('antrean.cancel') }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="button" id="btn-cancel-my-queue" class="btn w-100 fw-bold" style="border: 2px solid {{ $activeBarbershop->warna_primer ?? '#e8a53a' }}; color: {{ $activeBarbershop->warna_primer ?? '#e8a53a' }}; border-radius: 10px; padding: 12px; background: transparent;" data-loading-text="Membatalkan...">
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

                        <a href="{{ route('login.user') }}" class="btn btn-gold w-100 fw-bold mb-2" style="border-radius: 10px; padding: 12px;">Login Sekarang</a>
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
                                <div class="d-flex align-items-center justify-content-center text-white fw-bold me-3 flex-shrink-0" style="width: 50px; height: 50px; background-color: #1a1a1a; font-size: 1.1rem; border-radius: 10px;">
                                    {{ $antrean->nomor_antrean_seq }}
                                </div>
                                <div class="flex-grow-1 min-w-0">
                                    <h6 class="fw-bold mb-1 text-dark text-truncate" style="font-size: 0.95rem;">{{ $antrean->nama_pelanggan }}</h6>
                                    @if($antrean->is_booking)
                                        <p class="text-muted mb-0" style="font-size: 0.75rem;"><span class="text-nowrap text-primary fw-bold"><i class="far fa-calendar-alt me-1"></i> Booking: {{ \Carbon\Carbon::parse($antrean->tanggal_booking)->format('d M') }} ({{ \Carbon\Carbon::parse($antrean->waktu_booking)->format('H:i') }})</span> <span class="ms-2 text-nowrap"><i class="fas fa-hourglass-half me-1"></i> Est: {{ $antrean->total_estimasi_waktu }} mnt</span></p>
                                    @else
                                        <p class="text-muted mb-0" style="font-size: 0.75rem;"><span class="text-nowrap"><i class="far fa-clock me-1"></i> Masuk: {{ $antrean->created_at->format('H:i') }}</span> <span class="ms-2 text-nowrap"><i class="fas fa-hourglass-half me-1"></i> Est: {{ $antrean->total_estimasi_waktu }} mnt</span></p>
                                    @endif
                                </div>
                                <div class="flex-shrink-0 ms-2">
                                    @if ($antreanSayaAktif && $antreanSayaAktif->id === $antrean->id)
                                        <span class="badge" style="border: 1px solid #198754; color: #198754; background: #e8f7ef; padding: 6px 12px; border-radius: 20px; font-weight: 700; font-size: 0.65rem; letter-spacing: 0.5px;">ANTREAN SAYA</span>
                                    @else
                                        @if ($antrean->status == 'sedang dilayani')
                                            <span class="badge" style="border: 1px solid {{ $activeBarbershop->warna_primer ?? '#e8a53a' }}; color: {{ $activeBarbershop->warna_primer ?? '#e8a53a' }}; background: #fffaf0; padding: 6px 12px; border-radius: 20px; font-weight: 700; font-size: 0.65rem; letter-spacing: 0.5px;">SEDANG DILAYANI</span>
                                        @else
                                            <span class="badge" style="border: 1px solid {{ $activeBarbershop->warna_primer ?? '#e8a53a' }}; color: {{ $activeBarbershop->warna_primer ?? '#e8a53a' }}; background: #fffaf0; padding: 6px 12px; border-radius: 20px; font-weight: 700; font-size: 0.65rem; letter-spacing: 0.5px;">MENUNGGU</span>
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
                    @php
                        $isOperationalHour = \App\Models\Antrean::isOperationalHour();
                        $isBookingEnabledGlobal = ($isBookingEnabled ?? '1') === '1';
                    @endphp
                    @if ($isOperationalHour || $isBookingEnabledGlobal)
                        <div class="d-grid gap-3 mb-4">
                            @if (auth()->user()->hasRole('admin'))
                                <button class="btn btn-disabled w-100 fw-bold shadow-sm" disabled
                                    style="border-radius: 12px; padding: 14px 20px; font-size: 1rem;" title="Admin tidak dapat mengambil antrean">
                                    Tambah Antrean
                                </button>
                            @else
                                <button class="btn btn-gold w-100 btn-add-queue fw-bold shadow-sm" data-bs-toggle="modal"
                                    data-bs-target="#modalTambahAntrean"
                                    data-loading-text="Membuka form..." style="border-radius: 12px; padding: 14px 20px; font-size: 1rem;">
                                    {{ $isOperationalHour ? 'Tambah Antrean' : 'Booking Antrean' }}
                                </button>
                            @endif
                        </div>
                    @else
                        <button class="btn btn-disabled w-100 fw-bold mb-4 shadow-sm" disabled
                            style="border-radius: 12px; padding: 14px 20px; font-size: 1rem;" title="Di luar jam operasional">
                            Antrean Tutup
                        </button>
                    @endif
                @else
                    @if (!$antreanSayaAktif)
                        <div class="d-grid gap-3 mb-4">
                            <button class="btn btn-disabled w-100 fw-bold shadow-sm" disabled
                                style="border-radius: 12px; padding: 14px 20px; font-size: 1rem;" title="Anda memiliki antrean aktif di cabang lain">
                                Punya Antrean di barbershop Lain
                            </button>
                        </div>
                    @endif
                @endif
            @endauth

        </div>
    </div>

    <!-- Modal Tambah Antrean -->
    <div class="modal fade modal-tambah-antrean" id="modalTambahAntrean" tabindex="-1" aria-labelledby="modalTambahAntreanLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
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
                                <option value="{{ $layanan->id }}" data-nama="{{ $layanan->nama }}" data-harga="{{ $layanan->harga }}" data-waktu="{{ $layanan->estimasi_waktu }}" data-deskripsi="{{ $layanan->deskripsi }}">{{ $layanan->nama }}</option>
                            @endforeach
                        </select>
                        <select id="layanan_id2" name="layanan_id2" class="d-none">
                            <option value="">Pilih layanan 2</option>
                            @foreach ($layananAktif as $layanan)
                                <option value="{{ $layanan->id }}" data-nama="{{ $layanan->nama }}" data-harga="{{ $layanan->harga }}" data-waktu="{{ $layanan->estimasi_waktu }}" data-deskripsi="{{ $layanan->deskripsi }}">{{ $layanan->nama }}</option>
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
                                <div class="review-title">Tipe Antrean</div>
                                @if(($isBookingEnabled ?? '1') === '1')
                                <div class="mb-3">
                                    <div class="form-check form-switch mb-2">
                                        @php
                                            $isOperationalHour = \App\Models\Antrean::isOperationalHour();
                                        @endphp
                                        <input class="form-check-input" type="checkbox" role="switch" id="is_booking_toggle" name="is_booking" value="1" {{ !$isOperationalHour ? 'checked disabled' : '' }}>
                                        @if(!$isOperationalHour)
                                            <input type="hidden" name="is_booking" value="1">
                                        @endif
                                        <label class="form-check-label fw-bold text-dark" for="is_booking_toggle">Booking Jadwal Ke Depan</label>
                                    </div>
                                    <p class="small text-muted mb-0" id="booking-desc-text">
                                        {{ !$isOperationalHour ? 'Sistem akan mencari waktu kosong berdasarkan durasi layanan.' : 'Mendaftar untuk antrean langsung saat ini juga (Walk-in).' }}
                                    </p>
                                    @if(!$isOperationalHour)
                                        <div class="alert alert-warning small mt-2 p-2"><i class="fas fa-info-circle me-1"></i> Antrean langsung (Walk-in) sedang tutup. Anda hanya dapat melakukan booking jadwal.</div>
                                    @endif
                                </div>
                                @else
                                    @if(!\App\Models\Antrean::isOperationalHour())
                                        <div class="alert alert-warning small mt-2 p-2"><i class="fas fa-info-circle me-1"></i> Antrean tutup dan fitur booking sedang dinonaktifkan.</div>
                                    @endif
                                @endif

                                <div id="booking-fields-container" style="display: none; background: #fdfbf8; border: 1px solid #e8a53a; border-radius: 8px; padding: 15px; margin-bottom: 15px;">
                                    <div class="mb-3">
                                        <label for="tanggal_booking" class="form-label small fw-bold">Pilih Tanggal</label>
                                        <input type="date" class="form-control" id="tanggal_booking" name="tanggal_booking" min="{{ date('Y-m-d') }}" max="{{ date('Y-m-d', strtotime('+7 days')) }}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small fw-bold">Pilih Waktu (Jadwal Tersedia)</label>
                                        <div id="available-slots-container" class="d-flex flex-wrap gap-2" style="max-height: 180px; overflow-y: auto; padding-right: 5px;">
                                            <span class="text-muted small">Pilih tanggal terlebih dahulu.</span>
                                        </div>
                                        <input type="hidden" id="waktu_booking" name="waktu_booking" disabled>
                                    </div>
                                </div>

                                <div class="review-title mt-3">Layanan Terpilih</div>
                                <div id="selected-services-container">
                                    <!-- Diisi oleh JS -->
                                </div>
                                <button type="button" class="btn-add-more mt-2" id="btn-add-more-service" onclick="showServiceGrid()">
                                    + Tambah Layanan Lain (Maks 2)
                                </button>
                            </div>
                            <div id="lokasi-feedback" class="alert alert-danger d-none" role="alert"></div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-submit-bottom btn-lg" id="btn-submit-antrean" 
                                    data-loading-text="Mengambil antrean..."
                                    @if(auth()->check() && auth()->user()->is_blocked) disabled style="opacity: 0.6; cursor: not-allowed; background-color: #6c757d; border-color: #6c757d;" @endif>
                                    @if(auth()->check() && auth()->user()->is_blocked)
                                        Sesi Booking Terkunci (Diblokir)
                                    @else
                                        Ambil Antrean
                                    @endif
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        window.barberIncompatibilities = @json($incompatibilities);

        let layanans = @json($layananAktif);
        let packageMap = @json($packageMap);

        window.barberLayananList = layanans.map(l => {
            if (packageMap[l.id]) {
                l.included_service_ids = packageMap[l.id];
            }
            return l;
        });
    </script>
    @include('pelanggan.antrean.script-index')
@endpush
