@extends('admin.layouts.app')

@section('title', 'Antrean')

@section('header_title')
    <div class="header-title">Riwayat Antrean</div>
@endsection

@push('styles')
    @include('admin.antrean.style-index')
@endpush

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                            title: 'Berhasil!',
                            text: flashSuccess.dataset.message,
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                });
            </script>
        @endif

        @php
            $current = $antreans->where('status', 'sedang dilayani')->first();
        @endphp

        <div class="serving-display">
            <p>Sedang dilayani</p>
            <span class="queue-number-big">{{ $current->nomor_antrean ?? '--' }}</span>
            <p style="font-size: 18px; font-weight: 500;">{{ $current->nama_pelanggan ?? 'Tidak ada antrean' }}</p>
            @if ($current)
                <div class="btn-group-serving">
                    <button type="button" class="btn-panggil shadow-sm queue-action-btn" data-queue-id="{{ $current->id }}"
                        data-queue-status="selesai" data-loading-text="Menyelesaikan...">
                        Selesai
                    </button>
                    <button type="button" class="btn-batal shadow-sm queue-action-btn" data-queue-id="{{ $current->id }}"
                        data-queue-status="batal" data-loading-text="Membatalkan...">
                        Batalkan
                    </button>
                </div>
            @else
                <p>Tidak ada antrean yang sedang dilayani saat ini.</p>
                <button type="button" class="btn-panggil shadow-sm" onclick="panggil()" data-loading-text="Memanggil...">
                    Panggil
                </button>
            @endif
        </div>

        <button onclick="toggleModal()" class="btn-tambah shadow-sm" data-loading-text="Membuka form...">
            + Tambah
        </button>

        <div class="filter-bar" role="tablist" aria-label="Filter status antrean">
            <button type="button" class="filter-btn active" data-filter="menunggu"
                onclick="filterAntrean('menunggu', this)">Menunggu</button>
            <button type="button" class="filter-btn" data-filter="selesai"
                onclick="filterAntrean('selesai', this)">Selesai</button>
            <button type="button" class="filter-btn" data-filter="batal"
                onclick="filterAntrean('batal', this)">Batal</button>
            <button type="button" class="filter-btn" data-filter="all" onclick="filterAntrean('all', this)">Semua</button>
        </div>

        <div class="date-filter-wrap">
            <label for="tanggalFilter">Filter tanggal:</label>
            <input type="date" id="tanggalFilter" class="date-filter-input">
            <button type="button" class="btn-reset-filter" onclick="resetTanggalFilter()">Reset Tanggal</button>
        </div>

        <div class="table-container">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Nomor Antrean</th>
                        <th>Nama</th>
                        <th>Tanggal Masuk</th>
                        <th>Jam Kedatangan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="antreanTableBody">
                    @forelse($antreans as $item)
                        <tr class="{{ $item->status == 'sedang dilayani' ? 'row-highlight' : '' }}"
                            data-status="{{ $item->status }}"
                            data-date-created="{{ \Carbon\Carbon::parse($item->created_at)->toDateString() }}"
                            data-date-finished="{{ $item->waktu_selesai ? \Carbon\Carbon::parse($item->waktu_selesai)->toDateString() : '' }}">
                            <td data-label="Nomor Antrean">{{ $item->nomor_antrean }}</td>
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
                        </tr>
                    @empty
                        <tr class="empty-row-row">
                            <td colspan="5" class="empty-row-cell" style="padding: 40px; color: #999;">Belum ada riwayat
                                antrean yang tercatat.
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
