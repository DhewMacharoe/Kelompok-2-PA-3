@extends('pelanggan.layouts.app')

@section('title', 'Antrean')

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

        <div class="app-card" data-logged-in-username="{{ auth()->check() ? auth()->user()->username : '' }}">
            <div class="row g-0">

                <div class="col-md-5">
                    <div class="header-section">
                        <div class="text-gold"> {{ $dipanggil ? 'SEDANG DILAYANI' : '' }}</div>
                        <div class="active-number-box">
                            <p class="active-number" id="antrean-nomor">
                                {{ $dipanggil ? $dipanggil->nomor_antrean : ' ‎  ' }}</p>
                        </div>
                        <div class="active-name" id = "antrean-nama">
                            {{ $dipanggil ? $dipanggil->nama_pelanggan : 'Kursi Pangkas Kosong' }}
                        </div>
                        <div class="active-name" id = "antrean-status">{{ $dipanggil ? $dipanggil->status : '' }}
                        </div>
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="right-panel">

                        @auth
                            @if ($antreanSayaAktif)
                                <div class="my-queue-card" id="my-queue-card">
                                    <div class="my-queue-header">
                                        <h3 class="my-queue-title">Nomor Antrean Anda</h3>
                                        <div class="my-queue-number" id="my-queue-number">{{ $antreanSayaAktif->nomor_antrean }}
                                        </div>
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
                                            <span class="my-queue-status-chip"
                                                id="my-queue-status-chip">{{ strtoupper($antreanSayaAktif->status) }}</span>
                                        </div>
                                    </div>

                                    @if ($antreanSayaAktif->status === 'menunggu')
                                        <div id="my-queue-cancel-action">
                                            <form action="{{ route('antrean.cancel') }}" method="POST"
                                                onsubmit="return confirm('Batalkan antrean Anda?');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" id="btn-cancel-my-queue" class="btn-cancel-my-queue"
                                                    data-loading-text="Membatalkan..." @disabled($antreanSayaAktif->status === 'sedang dilayani')>
                                                    Batalkan Antrean Saya
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        @endauth

                        <div class="queue-section">
                            <div class="section-title">Urutan Antrean</div>


                            <div class="queue-list-container">
                                @if ($data_antrean && count($data_antrean) > 0)
                                    @foreach ($data_antrean as $antrean)
                                        <div
                                            class="queue-card {{ $antreanSayaAktif && $antreanSayaAktif->id === $antrean->id ? 'my-queue-highlight' : '' }}">
                                            <div class="queue-number-box">{{ $antrean->nomor_antrean }}</div>
                                            <div class="queue-info">
                                                <p class="queue-name">{{ $antrean->nama_pelanggan }}</p>
                                                <p class="queue-time">{{ $antrean->created_at->format('H:i') }}</p>
                                            </div>
                                            <div>
                                                @if ($antreanSayaAktif && $antreanSayaAktif->id === $antrean->id)
                                                    <span class="badge-mine">ANTREAN SAYA</span>
                                                @endif
                                                <span class="badge-waiting">MENUNGGU</span>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center mt-4 mb-4 text-muted">Tidak Ada Antrean Saat Ini <br> Silahkan Ambil Antrean Anda</div>
                                @endif

                            </div>
                        </div>

                        <div class="footer-section">
                            @auth
                                @if (!$punyaAntreanAktif)
                                    <button class="btn btn-add-queue" data-bs-toggle="modal"
                                        data-bs-target="#modalTambahAntrean"
                                        data-loading-text="Membuka form..." style="width: 100%;">
                                        Tambah Antrean
                                    </button>
                                @endif
                            @else
                                <div class="guest-queue-hint">
                                    <p>Pergi ke kasir untuk mengambil antrean atau login menggunakan Google <br> <a
                                            href="{{ route('login.user') }}">Klik disini untuk login</a></p>
                                </div>
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
                        <div class="mb-3" style="display: none;">
                            <input type="text" id="nama_pelanggan" value="{{ auth()->user()->username ?? '' }}" readonly>
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
                                        <div class="service-name">{{ $layanan->nama }}</div>
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
