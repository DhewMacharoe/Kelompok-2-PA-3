@extends('admin.layouts.app')

@section('title', 'Layanan')

@section('header_title')
    <div class="header-title">Layanan</div>
@endsection

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .main-container {
            padding: 20px;
            font-family: 'Inter', sans-serif;
            max-width: 1180px;
            margin: 0 auto;
        }

        .btn-tambah {
            background-color: #4CC779;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            margin: 0;
            font-weight: 500;
            cursor: pointer;
        }

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
            min-width: 720px;
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

        .custom-table th:first-child,
        .custom-table td:first-child {
            min-width: 220px;
            text-align: left;
            white-space: normal;
        }

        .status-text {
            font-weight: 500;
        }

        .action-link {
            color: #4a80da;
            text-decoration: none;
            font-weight: 600;
        }

        .badge-active {
            background-color: #4CC779;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
        }

        .badge-inactive {
            background-color: #EB5757;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
        }

        .table-thumb {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            white-space: nowrap;
        }

        .btn-primary {
            background-color: #2F80ED;
            color: white;
        }

        .btn-secondary {
            background-color: #7B7F88;
            color: white;
        }

        .btn-warning {
            background-color: #F39C12;
            color: white;
        }

        .btn-success {
            background-color: #4CC779;
            color: white;
        }

        .btn-danger {
            background-color: #EB5757;
            color: white;
        }

        .empty-row {
            padding: 40px;
            color: #999;
        }

        .detail-modal {
            display: none;
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.6);
            justify-content: center;
            align-items: center;
            z-index: 9999;
            padding: 20px;
        }

        .detail-modal.show {
            display: flex;
        }

        .detail-modal-card {
            width: 100%;
            max-width: 780px;
            background: white;
            border-radius: 20px;
            padding: 24px;
            position: relative;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .detail-modal-close {
            position: absolute;
            top: 18px;
            right: 18px;
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #556673;
        }

        .detail-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 24px;
        }

        .detail-modal-img {
            width: 260px;
            height: 260px;
            border-radius: 18px;
            background-color: #f5f7fb;
            background-position: center;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #8b97a6;
            font-weight: 600;
            text-align: center;
            padding: 20px;
        }

        .detail-modal-body {
            display: grid;
            gap: 16px;
        }

        .detail-modal-item {
            display: flex;
            justify-content: space-between;
            padding: 16px;
            border-radius: 12px;
            background-color: #f9fbff;
            border: 1px solid #e7ecf6;
        }

        .detail-modal-item strong {
            color: #2C3E50;
        }

        .detail-modal-desc {
            padding: 16px;
            border-radius: 12px;
            background-color: #f9fbff;
            border: 1px solid #e7ecf6;
            color: #556673;
            line-height: 1.7;
        }

        @media (max-width: 768px) {
            .main-container {
                padding: 12px;
            }

            #statusFilter,
            #searchInput {
                min-width: 0 !important;
                width: 100%;
            }

            .btn-tambah {
                width: 100%;
                text-align: center;
            }

            #searchSuggestion {
                font-size: 0.85rem;
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

            .custom-table tr[data-name] {
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
                min-width: 92px;
            }

            .custom-table th:first-child,
            .custom-table td:first-child {
                min-width: 0;
                text-align: right;
            }

            .custom-table td.action-buttons {
                display: block;
                text-align: left;
                border-bottom: none;
                padding-bottom: 0;
            }

            .custom-table td.action-buttons::before {
                display: block;
                margin-bottom: 8px;
            }

            .custom-table td.action-buttons button,
            .custom-table td.action-buttons a,
            .custom-table td.action-buttons form {
                margin: 0 6px 6px 0;
                vertical-align: top;
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

            .btn {
                font-size: 12px;
                padding: 6px 8px;
            }

            .detail-modal {
                padding: 10px;
            }

            .detail-modal-card {
                padding: 16px;
                border-radius: 14px;
            }

            .detail-modal-img {
                width: 100%;
                height: 210px;
                border-radius: 12px;
            }

            .detail-modal-item {
                gap: 10px;
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>

    <div class="main-container">
        @if (session('success'))
            <div id="flash-success" data-message="{{ session('success') }}" hidden></div>
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

        <div
            style="display: flex; flex-wrap: wrap; gap: 12px; align-items: flex-end; justify-content: space-between; margin-bottom: 8px;">
            <div style="display: flex; flex-wrap: wrap; gap: 12px; align-items: flex-end; flex: 1; min-width: 320px;">
                <div>
                    <label for="statusFilter"
                        style="font-weight: 600; color: #2C3E50; display:block; margin-bottom:6px;">Status</label>
                    <select id="statusFilter"
                        style="padding: 10px 12px; border-radius: 8px; border: 1px solid #ddd; min-width: 160px;">
                        <option value="" {{ empty($status) ? 'selected' : '' }}>Semua</option>
                        <option value="aktif" {{ ($status ?? '') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ ($status ?? '') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
                <div style="min-width: 240px; flex: 1;">
                    <label for="searchInput"
                        style="font-weight: 600; color: #2C3E50; display:block; margin-bottom:6px;">Cari Layanan</label>
                    <input id="searchInput" type="text" placeholder="Ketik nama layanan..."
                        style="width:100%; padding: 10px 12px; border-radius: 8px; border: 1px solid #ddd;">
                </div>
            </div>

            <div style="display: flex; align-items: flex-end;">
                <a href="{{ route('admin.layanan.create') }}" class="btn-tambah shadow-sm" style="white-space: nowrap;">+
                    Tambah</a>
            </div>
        </div>

        <div id="searchSuggestion" style="margin-bottom: 16px; color: #4d648d; font-size: 0.95rem;"></div>

        <div class="table-container">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($layanans as $item)
                        <tr data-name="{{ strtolower($item->nama) }}"
                            data-status="{{ $item->is_active ? 'aktif' : 'nonaktif' }}"
                            data-description="{{ strtolower($item->deskripsi ?? '') }}">
                            <td data-label="Nama">{{ $item->nama }}</td>
                            <td data-label="Status">
                                @if ($item->is_active)
                                    <span class="badge badge-active">Aktif</span>
                                @else
                                    <span class="badge badge-inactive">Nonaktif</span>
                                @endif
                            </td>
                            <td data-label="Action" class="action-buttons">
                                <button type="button" class="btn btn-secondary btn-sm btn-view"
                                    data-nama="{{ $item->nama }}"
                                    data-harga="Rp {{ number_format($item->harga, 0, ',', '.') }}"
                                    data-estimasi="{{ $item->estimasi_waktu ?? '-' }}"
                                    data-status="{{ $item->is_active ? 'Aktif' : 'Nonaktif' }}"
                                    data-deskripsi="{{ str_replace(["\r", "\n"], ' ', e($item->deskripsi ?? 'Tidak ada deskripsi tambahan.')) }}">View</button>

                                <form action="{{ route('admin.layanan.toggleStatus', $item->id) }}" method="POST"
                                    class="form-toggle" data-nama="{{ $item->nama }}"
                                    data-status="{{ $item->is_active ? 'nonaktifkan' : 'aktifkan' }}"
                                    style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="button"
                                        class="btn {{ $item->is_active ? 'btn-warning' : 'btn-success' }} btn-sm btn-toggle-alert">
                                        {{ $item->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>
                                </form>

                                <a href="{{ route('admin.layanan.edit', $item->id) }}"
                                    class="btn btn-primary btn-sm">Edit</a>

                                <button type="button" class="btn btn-danger btn-sm btn-delete-alert"
                                    data-id="{{ $item->id }}" data-nama="{{ $item->nama }}">Hapus</button>

                                <form id="delete-form-{{ $item->id }}"
                                    action="{{ route('admin.layanan.destroy', $item->id) }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr class="empty-row-row">
                            <td colspan="3" class="empty-row empty-row-cell">Belum ada data layanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="detailModal" class="detail-modal">
        <div class="detail-modal-card">
            <button id="detailClose" class="detail-modal-close">&times;</button>
            <div class="detail-modal-header">
                <div>
                    <h2 id="detailNama">Nama Layanan</h2>
                    <p id="detailLabel" style="margin-top: 8px; color: #556673;">Detail lengkap layanan barbershop.</p>
                </div>
            </div>
            <div class="detail-modal-body">
                <div class="detail-modal-item"><strong>Harga</strong> <span id="detailHarga">-</span></div>
                <div class="detail-modal-item"><strong>Estimasi Waktu</strong> <span id="detailEstimasi">-</span></div>
                <div class="detail-modal-item"><strong>Status</strong> <span id="detailStatus">-</span></div>
                <div class="detail-modal-desc"><strong>Deskripsi:</strong>
                    <p id="detailDeskripsi" style="margin-top: 8px;">-</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // === LOGIKA MODAL VIEW ===
        const modal = document.getElementById('detailModal');
        const detailImg = document.getElementById('detailImg');
        const detailNama = document.getElementById('detailNama');
        const detailHarga = document.getElementById('detailHarga');
        const detailEstimasi = document.getElementById('detailEstimasi');
        const detailStatus = document.getElementById('detailStatus');
        const detailDeskripsi = document.getElementById('detailDeskripsi');
        const detailClose = document.getElementById('detailClose');

        document.querySelectorAll('.btn-view').forEach(button => {
            button.addEventListener('click', () => {
                detailNama.textContent = button.dataset.nama;
                detailHarga.textContent = button.dataset.harga;
                detailEstimasi.textContent = button.dataset.estimasi;
                detailStatus.textContent = button.dataset.status;
                detailDeskripsi.textContent = button.dataset.deskripsi;
                modal.classList.add('show');
            });
        });

        detailClose.addEventListener('click', () => modal.classList.remove('show'));
        modal.addEventListener('click', event => {
            if (event.target === modal) modal.classList.remove('show');
        });


        // === LOGIKA SWEETALERT2 UNTUK AKSI BUTTON ===

        // 1. Konfirmasi Ubah Status
        document.querySelectorAll('.btn-toggle-alert').forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('form');
                const nama = form.dataset.nama;
                const statusAction = form.dataset.status; // "aktifkan" atau "nonaktifkan"

                Swal.fire({
                    title: 'Konfirmasi Perubahan',
                    text: `Apakah Anda yakin ingin ${statusAction} layanan "${nama}"?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: statusAction === 'aktifkan' ? '#198754' : '#f39c12',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: `Ya, ${statusAction}`,
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Submit form jika disetujui
                    }
                });
            });
        });

        // 2. Konfirmasi Hapus Data
        document.querySelectorAll('.btn-delete-alert').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                const nama = this.dataset.nama;

                Swal.fire({
                    title: 'Hapus Layanan?',
                    text: `Apakah Anda yakin ingin menghapus layanan "${nama}"? Data yang dihapus tidak dapat dikembalikan.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jalankan form hidden yang sesuai dengan ID
                        document.getElementById(`delete-form-${id}`).submit();
                    }
                });
            });
        });


        // === LOGIKA FILTER & SEARCH (Tetap Sama) ===
        const categoryFilter = document.getElementById('categoryFilter'); // (Asumsi ada, atau skip jika error)
        const statusFilter = document.getElementById('statusFilter');
        const searchInput = document.getElementById('searchInput');
        const suggestionBox = document.getElementById('searchSuggestion');
        const rows = Array.from(document.querySelectorAll('tbody tr'));

        function levenshtein(a, b) {
            const matrix = Array.from({
                length: b.length + 1
            }, () => []);
            for (let i = 0; i <= b.length; i++) matrix[i][0] = i;
            for (let j = 0; j <= a.length; j++) matrix[0][j] = j;
            for (let i = 1; i <= b.length; i++) {
                for (let j = 1; j <= a.length; j++) {
                    matrix[i][j] = Math.min(
                        matrix[i - 1][j] + 1,
                        matrix[i][j - 1] + 1,
                        matrix[i - 1][j - 1] + (a[j - 1] === b[i - 1] ? 0 : 1)
                    );
                }
            }
            return matrix[b.length][a.length];
        }

        function similarity(a, b) {
            if (!a || !b) return 0;
            const dist = levenshtein(a, b);
            return 1 - dist / Math.max(a.length, b.length);
        }

        function doesMatch(row, query) {
            const name = row.dataset.name;
            const description = row.dataset.description;
            if (!query) return true;
            if (name.includes(query) || description.includes(query)) return true;
            if (query.length <= 2) return name.startsWith(query);

            const fields = [name, description];
            return fields.some(field => similarity(field, query) >= 0.72);
        }

        function updateSuggestion(query) {
            if (!query) {
                suggestionBox.textContent = '';
                return;
            }
            const scores = rows.map(row => ({
                    name: row.dataset.name,
                    score: similarity(row.dataset.name, query)
                }))
                .filter(item => item.score > 0.35)
                .sort((a, b) => b.score - a.score)
                .slice(0, 4)
                .map(item => item.name);

            if (scores.length && rows.some(row => doesMatch(row, query))) {
                suggestionBox.textContent = '';
                return;
            }
            if (scores.length) {
                const suggestions = scores.map(name => `<strong>${name}</strong>`).join(', ');
                suggestionBox.innerHTML = `Mungkin Anda maksud: ${suggestions}`;
            } else {
                suggestionBox.textContent = 'Tidak ditemukan hasil. Coba kata lain.';
            }
        }

        function filterRows() {
            const status = statusFilter ? statusFilter.value.toLowerCase() : '';
            const query = searchInput ? searchInput.value.trim().toLowerCase() : '';

            rows.forEach(row => {
                const matchesStatus = !status || row.dataset.status === status;
                const matchesSearch = doesMatch(row, query);
                row.style.display = (matchesStatus && matchesSearch) ? '' : 'none';
            });
            updateSuggestion(query);
            if (!query) suggestionBox.textContent = '';
        }

        if (statusFilter) statusFilter.addEventListener('change', filterRows);
        if (searchInput) searchInput.addEventListener('input', filterRows);
    </script>

    <div style="height:50px;"></div>
@endsection
