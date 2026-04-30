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
                        <div class="text-gold">SEDANG DILAYANI</div>
                        <div class="active-number-box">
                            <p class="active-number" id="antrean-nomor">
                                {{ $dipanggil ? $dipanggil->nomor_antrean : ' ‎  ' }}</p>
                        </div>
                        <div class="active-name" id = "antrean-nama">
                            {{ $dipanggil ? $dipanggil->nama_pelanggan : 'Tidak ada antrean' }}
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
                            <div class="section-title">URUTAN antrean</div>


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
                                    <div class="text-center mt-4 mb-4 text-muted">Tidak ada antrean</div>
                                @endif

                            </div>
                        </div>

                        <div class="footer-section">
                            @auth
                                @if (!$punyaAntreanAktif)
                                    <button class="btn btn-add-queue" data-bs-toggle="offcanvas"
                                        data-bs-target="#offcanvasTambahAntrean" aria-controls="offcanvasTambahAntrean"
                                        data-loading-text="Membuka form..." style="width: 100%;">
                                        Tambah Antrean
                                    </button>
                                @endif
                            @else
                                <div class="guest-queue-hint">
                                    <p>Pergi ke kasir untuk mengambil antrean atau login menggunakan Google.klik <a
                                            href="{{ route('login.user') }}">disini untuk login</a></p>
                                </div>
                            @endauth
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasTambahAntrean"
        aria-labelledby="offcanvasTambahAntreanLabel"
        style="height: auto; border-top-left-radius: 20px; border-top-right-radius: 20px; box-shadow: 0 -4px 10px rgba(0,0,0,0.1);">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title fw-bold" id="offcanvasTambahAntreanLabel">Tambah Antrean</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body">
            <form id="formTambahAntreanPelanggan" action="{{ route('antrean.store') }}" method="POST">
                @csrf
                <div class="mb-4" style="display: none;">
                    <label for="nama_pelanggan" class="form-label text-muted">Nama Pelanggan</label>
                    <input type="text" class="form-control form-control-lg" id="nama_pelanggan"
                        value="{{ auth()->user()->username ?? '' }}" readonly>
                    <small class="text-muted">Nama otomatis diambil dari akun yang sedang login.</small>
                </div>
                <div class="mb-4">
                    <label for="layanan_id1" class="form-label text-muted">Layanan 1 (wajib)</label>
                    <select id="layanan_id1" name="layanan_id1" class="form-control" required
                        oninvalid="this.setCustomValidity('Harap pilih minimal 1 layanan')"
                        oninput="this.setCustomValidity('')">
                        <option value="">Pilih layanan 1</option>
                        @foreach ($layananAktif as $layanan)
                            <option value="{{ $layanan->id }}" @selected((string) $layanan->id === (string) old('layanan_id1'))>
                                {{ $layanan->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('layanan_id1')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="layanan_id2" class="form-label text-muted">Layanan 2 (opsional)</label>
                    <select id="layanan_id2" name="layanan_id2" class="form-control form-control-lg">
                        <option value="">Pilih layanan 2</option>
                        @foreach ($layananAktif as $layanan)
                            <option value="{{ $layanan->id }}" @selected((string) $layanan->id === (string) old('layanan_id2'))>{{ $layanan->nama }}
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted" id="layanan-help-pelanggan">Layanan 2 tidak boleh sama dengan layanan
                        1.</small>
                    @error('layanan_id2')
                        <small class="text-danger d-block">{{ $message }}</small>
                    @enderror
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-submit-bottom btn-lg"
                        data-loading-text="Mengambil antrean...">Tambah</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
    @include('pelanggan.antrean.script-index')
@endpush
