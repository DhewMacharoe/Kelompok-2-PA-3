@extends('admin.layouts.app')

@section('title', 'Antrean')

@section('header_title')
<div class="header-title">Riwayat Antrean</div>
@endsection

@push('styles')
@include('admin.antrean.style-index')
@endpush

@section('content')
<div class="main-container">
    @if (session('success'))
    <div id="flash-success" data-message="{{ session('success') }}" hidden></div>
    @endif

    @if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const flashSuccess = document.getElementById('flash-success');
            if (flashSuccess && flashSuccess.dataset.message) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: flashSuccess.dataset.message,
                    confirmButtonText: 'OK'
                });
            }
        });
    </script>
    @endif

    <div class="serving-display">
        <p>Sedang dilayani</p>
        <span class="queue-number-big">{{ $currentServing->nomor_antrean_seq ?? '--' }}</span>
        <p style="font-size: 18px; font-weight: 500;">{{ $currentServing->nama_pelanggan ?? 'Tidak ada antrean' }}</p>
        @if ($currentServing)
        <p style="font-size: 14px; color: {{ $activeDesign->warna_primer ?? '#e8a53a' }}; margin-bottom: 15px;">Durasi: <span id="stopwatch-dipanggil" data-start="{{ $currentServing->updated_at->timestamp * 1000 }}" style="font-weight: bold; color: {{ $activeDesign->warna_primer ?? '#e8a53a' }}; font-family: monospace; font-size: 16px;">00:00:00</span></p>
        <div class="btn-group-serving">
            <button type="button" class="btn-panggil shadow-sm queue-action-btn" data-queue-id="{{ $currentServing->id }}"
                data-queue-status="selesai" data-loading-text="Menyelesaikan...">
                Selesai
            </button>
            <button type="button" class="btn-batal shadow-sm queue-action-btn" data-queue-id="{{ $currentServing->id }}"
                data-queue-status="batal" data-loading-text="Membatalkan...">
                Batalkan
            </button>
        </div>
        @else
        <p>Tidak ada antrean yang sedang dilayani saat ini.</p>
        @if (($jumlahMenungguHariIni ?? 0) > 0)
            <button type="button" class="btn-panggil shadow-sm" onclick="panggil()" data-loading-text="Memanggil...">
                Panggil
            </button>
        @else
            <button type="button" class="btn-panggil shadow-sm" disabled aria-disabled="true"
                data-loading-text="Memanggil..." style="opacity: 0.65; cursor: not-allowed;">
                Panggil
            </button>
        @endif
        @endif
    </div>

    @if (\App\Models\Antrean::isOperationalHour())
        <button onclick="toggleModal()" class="btn-tambah shadow-sm" data-loading-text="Membuka form...">
            + Tambah
        </button>
    @else
        <button class="btn-tambah shadow-sm" disabled style="opacity: 0.6; cursor: not-allowed;" title="Di luar jam operasional">
            + Tambah (Tutup)
        </button>
    @endif

    <form class="antrean-filter-form" method="GET" action="{{ route('admin.antrean') }}">
        <input type="hidden" name="status" id="statusFilterInput" value="{{ $selectedStatus ?? 'all' }}">

        <div class="filter-bar" role="tablist" aria-label="Filter status antrean">
            <button type="button"
                class="filter-btn {{ ($selectedStatus ?? 'all') === 'menunggu' ? 'active' : '' }}"
                data-filter="menunggu" onclick="submitAntreanFilter('menunggu')">Menunggu</button>
            <button type="button"
                class="filter-btn {{ ($selectedStatus ?? 'all') === 'selesai' ? 'active' : '' }}"
                data-filter="selesai" onclick="submitAntreanFilter('selesai')">Selesai</button>
            <button type="button"
                class="filter-btn {{ ($selectedStatus ?? 'all') === 'batal' ? 'active' : '' }}"
                data-filter="batal" onclick="submitAntreanFilter('batal')">Batal</button>
            <button type="button"
                class="filter-btn {{ ($selectedStatus ?? 'all') === 'all' ? 'active' : '' }}"
                data-filter="all" onclick="submitAntreanFilter('all')">Semua</button>
        </div>

        <div class="date-filter-wrap">
            <label for="tanggalFilter">Filter tanggal:</label>
            <input type="date" id="tanggalFilter" name="tanggal" class="date-filter-input"
                value="{{ $selectedTanggal ?? '' }}">
            <button type="button" class="btn-reset-filter" onclick="resetTanggalFilter()">Reset Tanggal</button>
        </div>
    </form>

    @php
        $walkInAntreans = $antreans->where('is_booking', false);
        $bookingAntreans = $antreans->where('is_booking', true);
    @endphp

    <div class="table-container">
        <h3 style="margin-top: 0; margin-bottom: 15px; font-size: 1.1rem; color: #333; padding-bottom: 10px; border-bottom: 2px solid #eaeaea;">
            <i class="fas fa-walking" style="color: #e8a53a; margin-right: 8px;"></i> Antrean Langsung (Walk-in)
        </h3>
        @if (($selectedStatus ?? 'all') === 'menunggu')
        <div style="margin-bottom: 15px; display: flex; justify-content: flex-start;">
            <button type="button" class="btn-batal shadow-sm" id="btnBatalMasal" style="display: none; padding: 8px 16px;">
                Batalkan Terpilih (<span id="countTerpilih">0</span>)
            </button>
        </div>
        @endif
        <table class="custom-table">
            <thead>
                <tr>
                    @if (($selectedStatus ?? 'all') === 'menunggu')
                    <th style="width: 40px; text-align: center;"><input type="checkbox" id="selectAllQueues" class="select-all-queues"></th>
                    @endif
                    <th>Nomor Antrean</th>
                    <th>Nama</th>
                    <th>Tanggal Masuk</th>
                    <th>Jam Kedatangan</th>
                    <th>Status</th>
                    @if (($selectedStatus ?? 'all') === 'menunggu')
                    <th>Aksi</th>
                    @endif
                    @if (($selectedStatus ?? 'all') === 'batal')
                    <th>Alasan Dibatalkan</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($walkInAntreans as $item)
                <tr class="{{ $item->status == 'sedang dilayani' ? 'row-highlight' : '' }}"
                    data-status="{{ $item->status }}"
                    data-date-created="{{ \Carbon\Carbon::parse($item->created_at)->toDateString() }}"
                    data-date-finished="{{ $item->waktu_selesai ? \Carbon\Carbon::parse($item->waktu_selesai)->toDateString() : '' }}">
                    @if (($selectedStatus ?? 'all') === 'menunggu')
                    <td style="text-align: center;">
                        @if ($item->status === 'menunggu')
                        <input type="checkbox" class="queue-checkbox" value="{{ $item->id }}">
                        @endif
                    </td>
                    @endif
                    <td data-label="Nomor Antrean">{{ $item->nomor_antrean_seq }}</td>
                    <td data-label="Nama">{{ $item->nama_pelanggan }}</td>
                    <td data-label="Tanggal Masuk">
                        {{ \Carbon\Carbon::parse($item->waktu_masuk)->translatedFormat('d M Y') }}
                    </td>
                    <td data-label="Jam Kedatangan">
                        {{ \Carbon\Carbon::parse($item->waktu_masuk)->format('H:i') }} WIB
                    </td>
                    <td data-label="Status">
                        <span class="status-text">
                            {{ $item->status == 'sedang dilayani' ? 'Sedang Dilayani' : ucfirst($item->status) }}
                        </span>
                    </td>
                    @if (($selectedStatus ?? 'all') === 'menunggu')
                    <td data-label="Aksi">
                        <button type="button" class="btn-batal queue-action-btn"
                            data-queue-id="{{ $item->id }}" data-queue-status="batal"
                            data-loading-text="Membatalkan...">
                            Batalkan
                        </button>
                    </td>
                    @endif
                    @if (($selectedStatus ?? 'all') === 'batal')
                    <td data-label="Alasan Dibatalkan">
                        {{ $item->alasan_batal ?? '-' }}
                    </td>
                    @endif
                </tr>
                @empty
                <tr class="empty-row-row">
                    @php
                        $colspan = 5;
                        if (($selectedStatus ?? 'all') === 'menunggu') {
                            $colspan = 7;
                        } elseif (($selectedStatus ?? 'all') === 'batal') {
                            $colspan = 6;
                        }
                    @endphp
                    <td colspan="{{ $colspan }}" class="empty-row-cell" style="padding: 40px; color: #999;">Tidak ada antrean walk-in pada filter ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="table-container" style="margin-top: 30px;">
        <h3 style="margin-top: 0; margin-bottom: 15px; font-size: 1.1rem; color: #333; padding-bottom: 10px; border-bottom: 2px solid #eaeaea;">
            <i class="far fa-calendar-check" style="color: #17a2b8; margin-right: 8px;"></i> Antrean Booking (Reservasi)
        </h3>
        <table class="custom-table">
            <thead>
                <tr>
                    @if (($selectedStatus ?? 'all') === 'menunggu')
                    <th style="width: 40px; text-align: center;"><input type="checkbox" id="selectAllBookingQueues" class="select-all-queues"></th>
                    @endif
                    <th>Nomor Antrean</th>
                    <th>Nama</th>
                    <th>Tanggal Booking</th>
                    <th>Jam Booking</th>
                    <th>Status</th>
                    @if (($selectedStatus ?? 'all') === 'menunggu')
                    <th>Aksi</th>
                    @endif
                    @if (($selectedStatus ?? 'all') === 'batal')
                    <th>Alasan Dibatalkan</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($bookingAntreans as $item)
                <tr class="{{ $item->status == 'sedang dilayani' ? 'row-highlight' : '' }}"
                    data-status="{{ $item->status }}">
                    @if (($selectedStatus ?? 'all') === 'menunggu')
                    <td style="text-align: center;">
                        @if ($item->status === 'menunggu')
                        <input type="checkbox" class="queue-checkbox" value="{{ $item->id }}">
                        @endif
                    </td>
                    @endif
                    <td data-label="Nomor Antrean">{{ $item->nomor_antrean_seq }}</td>
                    <td data-label="Nama">{{ $item->nama_pelanggan }}</td>
                    <td data-label="Tanggal Booking">
                        <span style="color: #17a2b8; font-weight: bold;">{{ \Carbon\Carbon::parse($item->tanggal_booking)->translatedFormat('d M Y') }}</span>
                    </td>
                    <td data-label="Jam Booking">
                        <span style="color: #17a2b8; font-weight: bold;">{{ \Carbon\Carbon::parse($item->waktu_booking)->format('H:i') }} WIB</span>
                    </td>
                    <td data-label="Status">
                        <span class="status-text">
                            {{ $item->status == 'sedang dilayani' ? 'Sedang Dilayani' : ucfirst($item->status) }}
                        </span>
                    </td>
                    @if (($selectedStatus ?? 'all') === 'menunggu')
                    <td data-label="Aksi">
                        <button type="button" class="btn-batal queue-action-btn"
                            data-queue-id="{{ $item->id }}" data-queue-status="batal"
                            data-loading-text="Membatalkan...">
                            Batalkan
                        </button>
                    </td>
                    @endif
                    @if (($selectedStatus ?? 'all') === 'batal')
                    <td data-label="Alasan Dibatalkan">
                        {{ $item->alasan_batal ?? '-' }}
                    </td>
                    @endif
                </tr>
                @empty
                <tr class="empty-row-row">
                    @php
                        $colspan = 5;
                        if (($selectedStatus ?? 'all') === 'menunggu') {
                            $colspan = 7;
                        } elseif (($selectedStatus ?? 'all') === 'batal') {
                            $colspan = 6;
                        }
                    @endphp
                    <td colspan="{{ $colspan }}" class="empty-row-cell" style="padding: 40px; color: #999;">Tidak ada antrean booking pada filter ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div id="modalTambah" class="modal-overlay">
    <div class="form-card">
        <div class="form-card-header">
            <h3>Tambah Antrean Baru</h3>
            <button onclick="toggleModal()" class="btn-close">&times;</button>
        </div>

        @if ($errors->any())
        <div class="error-box">
            <strong>Data belum valid:</strong>
            <ul style="margin: 6px 0 0 16px; padding: 0;">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form id="formTambahAntrean" action="{{ route('admin.simpan-pelanggan') }}" method="POST" novalidate>
            @csrf
            <div class="form-group">
                <input type="text" id="nama_pelanggan" name="nama_pelanggan" class="form-control"
                    placeholder="Masukkan nama..." value="{{ old('nama_pelanggan') }}" required
                    oninvalid="this.setCustomValidity('Harap isi nama terlebih dahulu')"
                    oninput="this.setCustomValidity('')">
                @error('nama_pelanggan')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="layanan_id1">Layanan 1 (wajib)</label>
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
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="layanan_id2">Layanan 2 (opsional)</label>
                <select id="layanan_id2" name="layanan_id2" class="form-control">
                    <option value="">Pilih layanan 2</option>
                    @foreach ($layananAktif as $layanan)
                    <option value="{{ $layanan->id }}" @selected((string) $layanan->id === (string) old('layanan_id2'))>
                        {{ $layanan->nama }}
                    </option>
                    @endforeach
                </select>
                <div class="form-help" id="layanan-help">Pilih layanan kedua jika dibutuhkan, dan tidak boleh sama
                    dengan layanan 1.</div>
                @error('layanan_id2')
                <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <button type="button" class="btn-batal" onclick="toggleModal()">Batal</button>
                <button type="submit" class="btn-submit" data-loading-text="Menyimpan...">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div style="height:50px;"></div>


@endsection

@push('scripts')
@include('admin.antrean.script-index')
@endpush