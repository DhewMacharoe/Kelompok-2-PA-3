@extends('pelanggan.layouts.app')

@section('title', 'Antrian')

@push('styles')
    @include('pelanggan.antrian.style-index')
    <style>
        /* CSS untuk membuat antrian bisa di-scroll */
        .queue-list-container {
            max-height: 400px;
            overflow-y: auto;
            overflow-x: hidden;
            padding-right: 10px;
        }

        .queue-list-container::-webkit-scrollbar {
            width: 6px;
        }
        .queue-list-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        .queue-list-container::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }
        .queue-list-container::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* Modifikasi sedikit untuk tombol di offcanvas agar sesuai tema */
        .btn-submit-bottom {
            background-color: #0d6efd; /* Sesuaikan warna dengan tema Anda */
            color: white;
            padding: 10px;
            font-weight: bold;
            border-radius: 8px;
        }

        .my-queue-card {
            margin: 20px 30px 0;
            background: linear-gradient(135deg, #fffdf6 0%, #fff8e8 100%);
            border: 1px solid #e8d7ad;
            border-radius: 14px;
            box-shadow: 0 8px 20px rgba(112, 86, 35, 0.12);
            padding: 16px 18px;
        }

        .my-queue-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
        }

        .my-queue-title {
            font-size: 1.05rem;
            font-weight: 800;
            color: #2e2a1f;
            margin: 0;
        }

        .my-queue-number {
            background: #1b1b1b;
            color: #ffffff;
            border-radius: 10px;
            min-width: 58px;
            text-align: center;
            padding: 6px 12px;
            font-size: 1.25rem;
            font-weight: 800;
        }

        .my-queue-meta {
            border-top: 1px solid #e7dcc2;
            padding-top: 10px;
            margin-bottom: 12px;
        }

        .my-queue-meta-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 6px;
            gap: 14px;
        }

        .my-queue-meta-label {
            color: #777067;
            font-weight: 600;
        }

        .my-queue-meta-value {
            color: #2e2a1f;
            font-weight: 700;
            text-align: right;
        }

        .my-queue-status-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.4px;
            padding: 4px 10px;
            border-radius: 999px;
            text-transform: uppercase;
            border: 1px solid #d3c4a0;
            color: #7a5b1c;
            background: #fff6dd;
        }

        .btn-cancel-my-queue {
            border: 1px solid #d9534f;
            background: #d9534f;
            color: #ffffff;
            width: 100%;
            border-radius: 10px;
            font-weight: 700;
            padding: 9px 12px;
        }

        .btn-cancel-my-queue:hover {
            background: #c6423e;
            border-color: #c6423e;
            color: #ffffff;
        }

        .queue-card.my-queue-highlight {
            border: 1px solid #d8bd79;
            box-shadow: 0 4px 14px rgba(201, 156, 62, 0.2);
            background: #fffaf0;
        }

        .badge-mine {
            border: 1px solid #1f6f43;
            color: #1f6f43;
            background-color: #e8f7ef;
            font-size: 0.68rem;
            padding: 5px 10px;
            border-radius: 20px;
            font-weight: 700;
            letter-spacing: 0.4px;
            margin-right: 6px;
        }

        .guest-queue-hint {
            border: 1px dashed #d8bd79;
            background: linear-gradient(135deg, #fffdf7 0%, #fff6e4 100%);
            border-radius: 12px;
            padding: 14px 16px;
            text-align: center;
        }

        .guest-queue-hint p {
            margin: 0;
            color: #4a3f2b;
            font-weight: 600;
            line-height: 1.45;
        }

        @media (max-width: 991.98px) {
            .app-card {
                margin: 24px auto;
            }

            .header-section {
                padding: 42px 20px;
                min-height: 280px;
            }

            .active-number {
                font-size: 4rem;
            }

            .queue-section {
                padding: 24px;
            }

            .footer-section {
                padding: 16px 24px 24px;
            }

            .my-queue-card {
                margin: 16px 24px 0;
            }
        }

        @media (max-width: 767.98px) {
            .app-card {
                margin: 16px auto;
                border-radius: 12px;
            }

            .header-section {
                padding: 28px 16px;
                min-height: auto;
            }

            .text-gold {
                margin-bottom: 12px;
            }

            .active-number-box {
                padding: 10px 28px;
                margin: 12px 0;
            }

            .active-number {
                font-size: 3rem;
            }

            .active-name {
                font-size: 0.95rem;
                letter-spacing: 1px;
                margin-top: 12px;
                word-break: break-word;
            }

            .queue-section {
                padding: 16px;
            }

            .section-title {
                margin-bottom: 16px;
            }

            .queue-list-container {
                max-height: 320px;
                padding-right: 6px;
            }

            .queue-card {
                flex-wrap: wrap;
                gap: 10px;
                align-items: flex-start;
            }

            .queue-number-box {
                width: 44px;
                height: 44px;
                font-size: 1rem;
            }

            .queue-info {
                margin-left: 10px;
                min-width: 0;
                flex: 1 1 auto;
            }

            .queue-name {
                font-size: 0.95rem;
                overflow-wrap: anywhere;
            }

            .queue-time {
                font-size: 0.75rem;
            }

            .badge-waiting,
            .badge-mine {
                font-size: 0.65rem;
                padding: 4px 8px;
            }

            .footer-section {
                padding: 12px 16px 16px;
            }

            .my-queue-card {
                margin: 12px 16px 0;
                padding: 14px;
            }

            .my-queue-header {
                align-items: flex-start;
            }

            .my-queue-number {
                font-size: 1.1rem;
                min-width: 52px;
                padding: 6px 10px;
            }

            .my-queue-meta-row {
                align-items: flex-start;
                flex-direction: column;
                gap: 4px;
            }

            .my-queue-meta-value {
                text-align: left;
                overflow-wrap: anywhere;
            }

            .offcanvas.offcanvas-bottom {
                max-height: 88vh;
            }

            .offcanvas .offcanvas-body {
                overflow-y: auto;
            }
        }

        @media (max-width: 420px) {
            .active-number {
                font-size: 2.6rem;
            }

            .my-queue-title {
                font-size: 0.95rem;
            }
        }
    </style>
@endpush

@section('content')

<div class="container px-3">
    @if (session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger mt-3">{{ session('error') }}</div>
    @endif

    <div class="app-card">
        <div class="row g-0">

            <div class="col-md-5">
                <div class="header-section">
                    <div class="text-gold">SEDANG DILAYANI</div>
                    <div class="active-number-box">
                        <p class="active-number" id="antrian-nomor">{{ $dipanggil ? $dipanggil->nomor_antrian : '0' }}</p>
                    </div>
                    <div class="active-name" id = "antrian-nama">{{ $dipanggil ? $dipanggil->nama_pelanggan : 'Tidak ada antrian' }}
                    </div>
                    <div class="active-name" id = "antrian-status">{{ $dipanggil ? $dipanggil->status : '' }}
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <div class="right-panel">

                    @auth
                        @if($antrianSayaAktif)
                            <div class="my-queue-card">
                                <div class="my-queue-header">
                                    <h3 class="my-queue-title">Nomor Antrean Anda</h3>
                                    <div class="my-queue-number">{{ $antrianSayaAktif->nomor_antrian }}</div>
                                </div>

                                <div class="my-queue-meta">
                                    <div class="my-queue-meta-row">
                                        <span class="my-queue-meta-label">Posisi</span>
                                        <span class="my-queue-meta-value">
                                            {{ $antrianSayaAktif->status === 'menunggu' ? str_pad((string) ($posisiAntrianSaya ?? 0), 2, '0', STR_PAD_LEFT) : '-' }}
                                        </span>
                                    </div>
                                    <div class="my-queue-meta-row">
                                        <span class="my-queue-meta-label">Layanan</span>
                                        <span class="my-queue-meta-value">
                                            {{ $antrianSayaAktif->layanan1?->nama ?? '-' }}{{ $antrianSayaAktif->layanan2 ? ' + ' . $antrianSayaAktif->layanan2->nama : '' }}
                                        </span>
                                    </div>
                                    <div class="my-queue-meta-row">
                                        <span class="my-queue-meta-label">Status</span>
                                        <span class="my-queue-status-chip">{{ strtoupper($antrianSayaAktif->status) }}</span>
                                    </div>
                                </div>

                                @if(in_array($antrianSayaAktif->status, ['menunggu', 'sedang dilayani']))
                                    <form action="{{ route('antrian.cancel') }}" method="POST" onsubmit="return confirm('Batalkan antrean Anda?');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn-cancel-my-queue" data-loading-text="Membatalkan...">Batalkan Antrean Saya</button>
                                    </form>
                                @endif
                            </div>
                        @endif
                    @endauth

                    <div class="queue-section">
                        <div class="section-title">URUTAN ANTRIAN</div>


                        <div class="queue-list-container">
                            @if ($data_antrian && count($data_antrian) > 0)
                                @foreach ($data_antrian as $antrian)
                                <div class="queue-card {{ $antrianSayaAktif && $antrianSayaAktif->id === $antrian->id ? 'my-queue-highlight' : '' }}">
                                    <div class="queue-number-box">{{ $antrian->nomor_antrian }}</div>
                                    <div class="queue-info">
                                        <p class="queue-name">{{ $antrian->nama_pelanggan }}</p>
                                        <p class="queue-time">(({{ $antrian->created_at->format('H:i') }}))</p>
                                    </div>
                                    <div>
                                        @if($antrianSayaAktif && $antrianSayaAktif->id === $antrian->id)
                                            <span class="badge-mine">ANTREAN SAYA</span>
                                        @endif
                                        <span class="badge-waiting">MENUNGGU</span>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="text-center mt-4 mb-4 text-muted">Tidak ada antrian</div>
                            @endif

                        </div>
                    </div>

                    <div class="footer-section">
                        @auth
                            @if(!$punyaAntrianAktif)
                                <button class="btn btn-add-queue" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTambahAntrean" aria-controls="offcanvasTambahAntrean" data-loading-text="Membuka form..." style="width: 100%;">
                                    Tambah Antrean
                                </button>
                            @endif
                        @else
                            <div class="guest-queue-hint">
                                <p>Pergi ke kasir untuk mengambil antrian atau login menggunakan Google.klik <a href="{{ route('login.user') }}">disini untuk login</a></p>
                            </div>
                        @endauth
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasTambahAntrean" aria-labelledby="offcanvasTambahAntreanLabel" style="height: auto; border-top-left-radius: 20px; border-top-right-radius: 20px; box-shadow: 0 -4px 10px rgba(0,0,0,0.1);">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title fw-bold" id="offcanvasTambahAntreanLabel">Tambah Antrean</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>

  <div class="offcanvas-body">
      <form id="formTambahAntrianPelanggan" action="{{ route('antrian.store') }}" method="POST">
          @csrf
          <div class="mb-4" style="display: none;">
              <label for="nama_pelanggan" class="form-label text-muted">Nama Pelanggan</label>
              <input type="text" class="form-control form-control-lg" id="nama_pelanggan" value="{{ auth()->user()->username ?? '' }}" readonly>
              <small class="text-muted">Nama otomatis diambil dari akun yang sedang login.</small>
          </div>
          <div class="mb-4">
              <label for="layanan_id1" class="form-label text-muted">Layanan 1 (wajib)</label>
              <select id="layanan_id1" name="layanan_id1" class="form-control form-control-lg" required>
                  <option value="">Pilih layanan 1</option>
                  @foreach ($layananAktif as $layanan)
                      <option value="{{ $layanan->id }}" @selected((string) $layanan->id === (string) old('layanan_id1'))>{{ $layanan->nama }}</option>
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
                      <option value="{{ $layanan->id }}" @selected((string) $layanan->id === (string) old('layanan_id2'))>{{ $layanan->nama }}</option>
                  @endforeach
              </select>
              <small class="text-muted" id="layanan-help-pelanggan">Layanan 2 tidak boleh sama dengan layanan 1.</small>
              @error('layanan_id2')
                  <small class="text-danger d-block">{{ $message }}</small>
              @enderror
          </div>
          <div class="d-grid">
              <button type="submit" class="btn btn-submit-bottom btn-lg" data-loading-text="Mengambil antrean...">Tambah</button>
          </div>
      </form>
  </div>
</div>

@endsection

@push('scripts')
<script type="module">

    function formatJam(datetime) {
    const date = new Date(datetime);
    return date.toLocaleTimeString('id-ID', {
        hour: '2-digit',
        minute: '2-digit'
    });
    }
    document.addEventListener('DOMContentLoaded', function () {
        console.log('Echo script loaded');

        const loggedInUsername = @json(auth()->check() ? auth()->user()->username : null);

        const layananSelect1 = document.getElementById('layanan_id1');
        const layananSelect2 = document.getElementById('layanan_id2');
        const layananHelp = document.getElementById('layanan-help-pelanggan');
        const formTambahPelanggan = document.getElementById('formTambahAntrianPelanggan');

        function syncLayananDropdownPelanggan() {
            if (!layananSelect1 || !layananSelect2) {
                return;
            }

            const selectedLayanan1 = layananSelect1.value;

            Array.from(layananSelect2.options).forEach(option => {
                if (!option.value) {
                    return;
                }

                const isSameAsLayanan1 = selectedLayanan1 !== '' && option.value === selectedLayanan1;
                option.disabled = isSameAsLayanan1;
                option.hidden = isSameAsLayanan1;
            });

            if (layananSelect2.value && layananSelect2.value === selectedLayanan1) {
                layananSelect2.value = '';
            }

            if (layananHelp) {
                layananHelp.textContent = layananSelect2.value
                    ? 'Dua layanan dipilih.'
                    : 'Layanan 2 opsional dan tidak boleh sama dengan layanan 1.';
            }
        }

        if (layananSelect1 && layananSelect2) {
            layananSelect1.addEventListener('change', syncLayananDropdownPelanggan);
            layananSelect2.addEventListener('change', syncLayananDropdownPelanggan);
            syncLayananDropdownPelanggan();
        }

        if (formTambahPelanggan) {
            formTambahPelanggan.addEventListener('submit', function (event) {
                if (!layananSelect1 || !layananSelect2) {
                    return;
                }

                if (!layananSelect1.value) {
                    event.preventDefault();
                    alert('Layanan 1 wajib dipilih.');
                    return;
                }

                if (layananSelect2.value && layananSelect2.value === layananSelect1.value) {
                    event.preventDefault();
                    alert('Layanan 1 dan layanan 2 tidak boleh sama.');
                }
            });
        }

        if (typeof window.Echo === 'undefined') {
            console.error('window.Echo is not defined');
            return;
        }

        console.log('Echo is available');

        try {
            const channel = window.Echo.channel('AntrianList-channel');
            console.log('Channel created:', channel);

            channel.listen('AntreanListUpdate', (e) => {
            console.log('Antrian list updated:', e);

            const antreanList = (e.antreanList || []).filter(item =>
                String(item.status || '').toLowerCase() === 'menunggu'
            );
            const queueListContainer = document.querySelector('.queue-list-container');

            // Kosongkan isi lama
            queueListContainer.innerHTML = '';

            if (antreanList.length > 0) {
                antreanList.forEach(item => {
                    const isMyQueue = loggedInUsername && item.nama_pelanggan === loggedInUsername;
                    queueListContainer.innerHTML += `
                        <div class="queue-card ${isMyQueue ? 'my-queue-highlight' : ''}">
                            <div class="queue-number-box">${item.nomor_antrian}</div>
                            <div class="queue-info">
                                <p class="queue-name">${item.nama_pelanggan}</p>
                                <p class="queue-time">(${formatJam(item.created_at)})</p>
                            </div>
                            <div>${isMyQueue ? '<span class="badge-mine">ANTREAN SAYA</span>' : ''}<span class="badge-waiting">MENUNGGU</span></div>
                        </div>
                    `;
                });
            } else {
                queueListContainer.innerHTML = `
                    <div class="text-center mt-4 mb-4 text-muted">Tidak ada antrian</div>
                `;
            }
        });
        } catch (error) {
            console.error('Terjadi kesalahan saat inisialisasi Echo:', error);
        }

        window.Echo.channel('Antrian-channel').listen('AntreanUpadate', (e) => {

                    console.log('DATA MASUK:', e);

                    let antrian = e.antrean;

                    // Update nomor antrian
                    let nomorEl = document.getElementById('antrian-nomor');
                    if (nomorEl) {
                        nomorEl.textContent = antrian.nomor_antrian;
                    }

                    // Update status
                    let statusEl = document.getElementById('antrian-status');
                    if (statusEl) {
                        statusEl.textContent = antrian.status.toUpperCase();
                    }

                    let namaEl = document.getElementById('antrian-nama');
                    if (namaEl) {
                        namaEl.textContent = antrian.nama_pelanggan;}
                });


    });



</script>
@endpush
