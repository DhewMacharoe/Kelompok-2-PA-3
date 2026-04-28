@extends('admin.layouts.app')

@section('title', 'Antrian')

@section('header_title')
    <div class="header-title">Riwayat Antrian</div>
@endsection

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* CSS Khusus Halaman Ini (Tetap sama seperti aslinya) */
        .main-container {
            padding: 20px;
            font-family: 'Inter', sans-serif;
        }

        /* Penampil Antrean Utama (Top Card) */
        .serving-display {
            background-color: #2C3E50;
            color: white;
            text-align: center;
            padding: 40px 20px;
            border-radius: 20px;
            margin-bottom: 24px;
        }

        .serving-display p {
            margin: 0;
            opacity: 0.8;
            font-size: 14px;
        }

        .serving-display .queue-number-big {
            font-size: 80px;
            font-weight: bold;
            margin: 10px 0;
            display: block;
        }

        .btn-group-serving {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }

        .btn-panggil {
            background-color: #2F80ED;
            color: white;
            border: none;
            padding: 10px 30px;
            border-radius: 8px;
            cursor: pointer;
        }

        .btn-batal {
            background-color: #EB5757;
            color: white;
            border: none;
            padding: 10px 30px;
            border-radius: 8px;
            cursor: pointer;
        }

        /* Tombol Tambah */
        .btn-tambah {
            background-color: #4CC779;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 20px;
            font-weight: 500;
            cursor: pointer;
        }

        .filter-bar {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 16px;
            align-items: center;
        }

        .filter-btn {
            border: 1px solid #dfe3e8;
            background: #fff;
            color: #2C3E50;
            padding: 10px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .filter-btn:hover {
            border-color: #2F80ED;
            color: #2F80ED;
        }

        .filter-btn.active {
            background: #2F80ED;
            border-color: #2F80ED;
            color: white;
        }

        .date-filter-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }

        .date-filter-wrap label {
            font-size: 14px;
            font-weight: 600;
            color: #2C3E50;
        }

        .date-filter-input {
            border: 1px solid #dfe3e8;
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 14px;
            min-width: 220px;
        }

        .btn-reset-filter {
            border: 1px solid #dfe3e8;
            background: #fff;
            color: #2C3E50;
            padding: 10px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
        }

        /* Styling Tabel */
        .table-container {
            background: white;
            border-radius: 12px;
            overflow-x: auto;
            overflow-y: hidden;
            -webkit-overflow-scrolling: touch;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .custom-table {
            width: 100%;
            min-width: 760px;
            border-collapse: collapse;
            text-align: center;
        }

        .custom-table thead {
            background-color: #2C3E50;
            color: white;
        }

        .custom-table th,
        .custom-table td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            white-space: nowrap;
        }

        .custom-table th:nth-child(2),
        .custom-table td:nth-child(2) {
            min-width: 170px;
            text-align: left;
            white-space: normal;
        }

        .row-highlight {
            background-color: #2196F3 !important;
            color: white !important;
        }

        .row-highlight td {
            border-color: transparent;
        }

        /* Status Badge */
        .status-text {
            font-weight: 500;
        }

        .action-link {
            color: #4a80da;
            text-decoration: none;
            font-weight: 600;
        }

        /* --- CSS BARU UNTUK CARD FORM (MODAL) --- */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .form-card {
            background: white;
            padding: 24px;
            border-radius: 12px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .form-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .form-card-header h3 {
            margin: 0;
            font-size: 18px;
            color: #2C3E50;
        }

        .btn-close {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #999;
        }

        .form-group {
            margin-bottom: 16px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            color: #333;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            box-sizing: border-box;
        }

        .form-control[multiple] {
            min-height: 130px;
        }

        .form-help {
            margin-top: 6px;
            font-size: 12px;
            color: #6b7280;
        }

        .form-error {
            margin-top: 6px;
            font-size: 12px;
            color: #d93025;
        }

        .error-box {
            background: #fff4f4;
            border: 1px solid #ffd8d8;
            color: #8a1c1c;
            border-radius: 8px;
            padding: 10px 12px;
            margin-bottom: 12px;
            font-size: 13px;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 24px;
        }

        .btn-submit {
            background-color: #2F80ED;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .main-container {
                padding: 12px;
            }

            .serving-display {
                border-radius: 14px;
                padding: 24px 14px;
            }

            .serving-display .queue-number-big {
                font-size: 58px;
                line-height: 1;
            }

            .btn-group-serving {
                width: 100%;
                gap: 8px;
            }

            .btn-group-serving button,
            .btn-tambah,
            .btn-reset-filter {
                width: 100%;
            }

            .filter-bar {
                gap: 8px;
            }

            .filter-btn {
                flex: 1 1 calc(50% - 8px);
                text-align: center;
                padding: 9px 10px;
            }

            .date-filter-wrap {
                align-items: stretch;
            }

            .date-filter-wrap label {
                width: 100%;
                margin-bottom: 0;
            }

            .date-filter-input,
            .btn-reset-filter {
                width: 100%;
                min-width: 0;
            }

            .table-container {
                overflow: visible;
                background: transparent;
                box-shadow: none;
            }

            .custom-table,
            .custom-table thead,
            .custom-table tbody,
            .custom-table tr,
            .custom-table td {
                display: block;
                width: 100%;
            }

            .custom-table {
                min-width: 0;
            }

            .custom-table thead {
                display: none;
            }

            .custom-table tbody {
                display: grid;
                gap: 10px;
            }

            .custom-table tr[data-status] {
                background: #fff;
                border: 1px solid #e9edf2;
                border-radius: 12px;
                padding: 10px 12px;
                box-shadow: 0 4px 10px rgba(15, 23, 42, 0.05);
            }

            .custom-table td {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                gap: 10px;
                padding: 9px 0;
                font-size: 13px;
                text-align: right;
                white-space: normal;
                border-bottom: 1px dashed #edf1f6;
            }

            .custom-table td::before {
                content: attr(data-label);
                font-weight: 600;
                color: #2C3E50;
                text-align: left;
                min-width: 120px;
            }

            .custom-table td:last-child {
                border-bottom: none;
                padding-bottom: 0;
            }

            .custom-table th:nth-child(2),
            .custom-table td:nth-child(2) {
                min-width: 0;
                text-align: right;
            }

            .row-highlight {
                background: #eaf4ff !important;
                color: #1f3552 !important;
                border-color: #bfd9ff !important;
            }

            .row-highlight td {
                border-color: #d8e8ff;
            }

            .custom-table tr.empty-row-row {
                border: none;
                background: transparent;
                padding: 0;
                box-shadow: none;
            }

            .custom-table td.empty-row-cell {
                display: block;
                text-align: center;
                border: 1px dashed #d8dee8;
                background: #fff;
                border-radius: 12px;
                padding: 20px 12px !important;
            }

            .custom-table td.empty-row-cell::before {
                content: none;
            }
        }
    </style>

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
            $current = $antrians->where('status', 'sedang dilayani')->first();
        @endphp

        <div class="serving-display">
            <p>Sedang dilayani</p>
            <span class="queue-number-big">{{ $current->nomor_antrian ?? '--' }}</span>
            <p style="font-size: 18px; font-weight: 500;">{{ $current->nama_pelanggan ?? 'Tidak ada antrean' }}</p>
            @if ($current)
                <div class="btn-group-serving">
                    <button type="button" class="btn-panggil shadow-sm queue-action-btn"
                        data-queue-id="{{ $current->id }}" data-queue-status="selesai"
                        data-loading-text="Menyelesaikan...">
                        Selesai
                    </button>
                    <button type="button" class="btn-batal shadow-sm queue-action-btn"
                        data-queue-id="{{ $current->id }}" data-queue-status="batal"
                        data-loading-text="Membatalkan...">
                        Batalkan
                    </button>
                </div>
            @else
                <p>Tidak ada antrean yang sedang dilayani saat ini.</p>
                <button type="button" class="btn-panggil shadow-sm" onclick="panggil()"
                    data-loading-text="Memanggil...">
                    panggil
                </button>
            @endif
        </div>

        <button onclick="toggleModal()" class="btn-tambah shadow-sm" data-loading-text="Membuka form...">
            + Tambah
        </button>

        <div class="filter-bar" role="tablist" aria-label="Filter status antrian">
            <button type="button" class="filter-btn active" data-filter="menunggu"
                onclick="filterAntrian('menunggu', this)">Menunggu</button>
            <button type="button" class="filter-btn" data-filter="selesai"
                onclick="filterAntrian('selesai', this)">Selesai</button>
            <button type="button" class="filter-btn" data-filter="batal"
                onclick="filterAntrian('batal', this)">Batal</button>
            <button type="button" class="filter-btn" data-filter="all" onclick="filterAntrian('all', this)">Semua</button>
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
                <tbody id="antrianTableBody">
                    @forelse($antrians as $item)
                        <tr class="{{ $item->status == 'sedang dilayani' ? 'row-highlight' : '' }}"
                            data-status="{{ $item->status }}"
                            data-date-created="{{ \Carbon\Carbon::parse($item->created_at)->toDateString() }}"
                            data-date-finished="{{ $item->waktu_selesai ? \Carbon\Carbon::parse($item->waktu_selesai)->toDateString() : '' }}">
                            <td data-label="Nomor Antrean">{{ $item->nomor_antrian }}</td>
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
                            <td colspan="5" class="empty-row-cell" style="padding: 40px; color: #999;">Belum ada riwayat antrian yang tercatat.
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

            <form id="formTambahAntrian" action="{{ route('admin.simpan-pelanggan') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nama_pelanggan">Nama Pelanggan</label>
                    <input type="text" id="nama_pelanggan" name="nama_pelanggan" class="form-control"
                        placeholder="Masukkan nama..." value="{{ old('nama_pelanggan') }}" required>
                    @error('nama_pelanggan')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="layanan_id1">Layanan 1 (wajib)</label>
                    <select id="layanan_id1" name="layanan_id1" class="form-control" required>
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

    <script>
        // === LOGIKA FILTER ===
        function filterAntrian(status, button) {
            const rows = document.querySelectorAll('#antrianTableBody tr[data-status]');
            const buttons = document.querySelectorAll('.filter-btn');
            const normalizedFilter = (status || '').toString().trim().toLowerCase();
            const selectedDate = document.getElementById('tanggalFilter')?.value || '';

            buttons.forEach((item) => item.classList.remove('active'));
            if (button) {
                button.classList.add('active');
            }

            rows.forEach((row) => {
                const rowStatus = (row.getAttribute('data-status') || '').toString().trim().toLowerCase();
                const rowDate = normalizedFilter === 'selesai' || normalizedFilter === 'batal' || normalizedFilter === 'all'
                    ? (row.getAttribute('data-date-finished') || row.getAttribute('data-date-created') || '')
                    : (row.getAttribute('data-date-created') || '');

                const matchesStatus = normalizedFilter === 'all' || rowStatus === normalizedFilter;
                const matchesDate = !selectedDate || rowDate === selectedDate || rowStatus === 'menunggu';
                const isVisible = matchesStatus && (normalizedFilter === 'menunggu' ? true : matchesDate);
                row.style.display = isVisible ? '' : 'none';
            });
        }

        function getTodayDateString() {
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        function resetTanggalFilter() {
            const tanggalInput = document.getElementById('tanggalFilter');
            if (tanggalInput) {
                tanggalInput.value = getTodayDateString();
            }

            const activeButton = document.querySelector('.filter-btn.active') || document.querySelector('.filter-btn[data-filter="menunggu"]');
            filterAntrian(activeButton?.dataset?.filter || 'menunggu', activeButton);
        }

        document.addEventListener('DOMContentLoaded', function() {
            if (window.Echo) {
                window.Echo.channel('Antrian-channel').listen('AntreanUpadate', () => {
                    window.location.reload();
                });

                window.Echo.channel('AntrianList-channel').listen('AntreanListUpdate', () => {
                    window.location.reload();
                });
            }

            const defaultButton = document.querySelector('.filter-btn[data-filter="menunggu"]');
            filterAntrian('menunggu', defaultButton);

            document.querySelectorAll('.queue-action-btn').forEach((button) => {
                button.addEventListener('click', function() {
                    const id = this.dataset.queueId;
                    const targetStatus = this.dataset.queueStatus;
                    if (id && targetStatus) {
                        ubahStatus(this, id, targetStatus);
                    }
                });
            });

            const tanggalFilter = document.getElementById('tanggalFilter');
            if (tanggalFilter) {
                tanggalFilter.value = getTodayDateString();
                tanggalFilter.addEventListener('change', function() {
                    const activeButton = document.querySelector('.filter-btn.active') || defaultButton;
                    filterAntrian(activeButton?.dataset?.filter || 'menunggu', activeButton);
                });
            }

            const layananSelect1 = document.getElementById('layanan_id1');
            const layananSelect2 = document.getElementById('layanan_id2');
            const layananHelp = document.getElementById('layanan-help');
            const formTambah = document.getElementById('formTambahAntrian');
            const hasFormErrors = !!document.querySelector('#modalTambah .error-box');

            function syncLayananDropdown() {
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
                    layananHelp.textContent = layananSelect2.value ?
                        'Dua layanan dipilih.' :
                        'Baru satu layanan dipilih. Layanan 2 bersifat opsional.';
                }
            }

            if (layananSelect1 && layananSelect2) {
                layananSelect1.addEventListener('change', syncLayananDropdown);
                layananSelect2.addEventListener('change', syncLayananDropdown);
                syncLayananDropdown();
            }

            // === PERUBAHAN SWEETALERT: Validasi Form ===
            if (formTambah) {
                formTambah.addEventListener('submit', function(event) {
                    if (!layananSelect1 || !layananSelect2) {
                        return;
                    }

                    if (!layananSelect1.value) {
                        event.preventDefault();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Peringatan',
                            text: 'Layanan 1 wajib dipilih.'
                        });
                        return;
                    }

                    if (layananSelect2.value && layananSelect2.value === layananSelect1.value) {
                        event.preventDefault();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Peringatan',
                            text: 'Layanan 1 dan layanan 2 tidak boleh sama.'
                        });
                    }
                });
            }

            if (hasFormErrors) {
                document.getElementById('modalTambah').style.display = 'flex';
            }
        });

        // === LOGIKA MODAL TAMBAH ===
        function toggleModal() {
            const modal = document.getElementById('modalTambah');
            if (modal.style.display === 'flex') {
                modal.style.display = 'none';
            } else {
                modal.style.display = 'flex';
            }
        }
        window.onclick = function(event) {
            const modal = document.getElementById('modalTambah');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // === PERUBAHAN SWEETALERT: Fungsi Panggil ===
        function panggil() {
            Swal.fire({
                title: 'Panggil Antrean?',
                text: "Sistem akan memanggil pelanggan selanjutnya.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#2F80ED',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Panggil',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Tampilkan loading saat fetch berjalan
                    Swal.fire({
                        title: 'Memproses...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    fetch("{{ route('admin.antrian.panggil') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Antrean berikutnya dipanggil!',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                window.location.reload();
                            });
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire('Gagal', 'Terjadi kesalahan saat memanggil antrean berikutnya.', 'error');
                        });
                }
            });
        }

        // === PERUBAHAN SWEETALERT: Fungsi Ubah Status ===
        function ubahStatus(button, id, targetStatus) {
            let swalConfig = {
                title: targetStatus === 'selesai' ? 'Selesaikan Antrean?' : 'Batalkan Antrean?',
                text: targetStatus === 'selesai' ? 'Tandai antrean ini sebagai selesai?' :
                    'Apakah Anda yakin ingin membatalkan antrean ini?',
                icon: targetStatus === 'selesai' ? 'question' : 'warning',
                showCancelButton: true,
                confirmButtonColor: targetStatus === 'selesai' ? '#4CC779' : '#EB5757',
                cancelButtonColor: '#6c757d',
                confirmButtonText: targetStatus === 'selesai' ? 'Ya, Selesai' : 'Ya, Batalkan',
                cancelButtonText: 'Kembali'
            };

            Swal.fire(swalConfig).then((result) => {
                if (result.isConfirmed) {
                    let originalText = button.innerHTML;
                    button.innerHTML = 'Memproses...';
                    button.disabled = true;

                    fetch(`/admin/antrian/${id}/ubah-status`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                status: targetStatus
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Status berhasil diubah menjadi: ' + targetStatus,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                window.location.reload();
                            });
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire('Gagal', 'Terjadi kesalahan saat mengubah status.', 'error');
                            button.innerHTML = originalText;
                            button.disabled = false;
                        });
                }
            });
        }
    </script>
@endsection
