@extends('admin.layouts.app')

@section('title', 'Layanan')

@section('header_title')
    <div class="header-title">Layanan</div>
@endsection

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@push('styles')
    @include('admin.galeri.style-index')
@endpush

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

        <a href="{{ route('admin.layanan.create') }}" class="btn-tambah shadow-sm">
            + Tambah
        </a>

        <div class="filter-bar" role="tablist" aria-label="Filter status layanan">
            <button type="button" class="filter-btn" data-filter="aktif" onclick="filterLayanan('aktif', this)">Aktif</button>
            <button type="button" class="filter-btn" data-filter="nonaktif" onclick="filterLayanan('nonaktif', this)">Nonaktif</button>
            <button type="button" class="filter-btn active" data-filter="all" onclick="filterLayanan('all', this)">Semua</button>
        </div>

        <div class="search-filter-wrap">
            <label for="layananSearch">Cari Layanan:</label>
            <input type="text" id="layananSearch" class="search-filter-input" placeholder="Masukkan nama layanan...">
            <button type="button" class="btn-reset-filter" onclick="resetLayananFilter()">Reset Pencarian</button>
        </div>

        <div class="table-container">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th style="width: 120px;">Status</th>
                        <th style="width: 300px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($layanans as $item)
                        <tr class="layanan-row" data-name="{{ strtolower($item->nama) }}"
                            data-status="{{ $item->is_active ? 'aktif' : 'nonaktif' }}"
                            data-description="{{ strtolower($item->deskripsi ?? '') }}">
                            <td data-label="Nama">
                                <div>
                                    <strong>{{ $item->nama }}</strong>
                                </div>
                            </td>
                            <td data-label="Status">
                                @if ($item->is_active)
                                    <span class="status-badge status-aktif">Aktif</span>
                                @else
                                    <span class="status-badge status-nonaktif">Nonaktif</span>
                                @endif
                            </td>
                            <td data-label="Action">
                                <div style="display: flex; gap: 5px; flex-wrap: wrap; justify-content: flex-end;">
                                    <button type="button" class="btn-action btn-view shadow-sm btn-view-layanan"
                                        data-nama="{{ $item->nama }}"
                                        data-harga="Rp {{ number_format($item->harga, 0, ',', '.') }}"
                                        data-estimasi="{{ $item->estimasi_waktu ?? '-' }}"
                                        data-status="{{ $item->is_active ? 'Aktif' : 'Nonaktif' }}"
                                        data-deskripsi="{{ str_replace(["\r", "\n"], ' ', e($item->deskripsi ?? 'Tidak ada deskripsi tambahan.')) }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#viewLayananModal" style="margin: 0;">
                                        View
                                    </button>

                                    <form action="{{ route('admin.layanan.toggleStatus', $item->id) }}" method="POST"
                                        class="form-toggle" data-nama="{{ $item->nama }}"
                                        data-status="{{ $item->is_active ? 'nonaktifkan' : 'aktifkan' }}"
                                        style="display: inline; margin: 0;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="button"
                                            class="btn-action btn-toggle-status shadow-sm btn-toggle-alert" style="margin: 0;">
                                            {{ $item->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>

                                    <a href="{{ route('admin.layanan.edit', $item->id) }}"
                                        class="btn-action btn-edit shadow-sm" style="margin: 0;">
                                        Edit
                                    </a>

                                    <button type="button" class="btn-action btn-hapus shadow-sm btn-delete-alert"
                                        data-id="{{ $item->id }}" data-nama="{{ $item->nama }}" style="margin: 0;">
                                        Hapus
                                    </button>

                                    <form id="delete-form-{{ $item->id }}"
                                        action="{{ route('admin.layanan.destroy', $item->id) }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="empty-row-row">
                            <td colspan="3" class="empty-row-cell" style="padding: 40px; color: #999;">
                                Belum ada data layanan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal View Layanan --}}
    <div class="modal fade" id="viewLayananModal" tabindex="-1" aria-labelledby="viewLayananModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow" style="border-radius: 12px; animation: slideDown 0.3s ease-out;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title" style="font-size: 18px; color: #2C3E50; font-weight: bold;" id="viewLayananModalLabel">
                        Detail Layanan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>

                <div class="modal-body">
                    <h6 id="detailNama" style="font-size: 16px; font-weight: bold; margin-bottom: 8px;"></h6>
                    <div style="margin-bottom: 8px;"><strong>Harga:</strong> <span id="detailHarga"></span></div>
                    <div style="margin-bottom: 8px;"><strong>Estimasi Waktu:</strong> <span id="detailEstimasi"></span></div>
                    <div style="margin-bottom: 8px;"><strong>Status:</strong> <span id="detailStatus"></span></div>
                    <p id="detailDeskripsi" style="color: #6b7280; font-size: 14px; margin: 0; white-space: pre-wrap;"></p>
                </div>

                <div class="modal-footer border-0 pt-0" style="display: flex; gap: 10px; justify-content: flex-end;">
                    <button type="button" class="btn-batal" data-bs-dismiss="modal" style="margin: 0; background-color: #6c757d;">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // === LOGIKA MODAL VIEW ===
        const detailNama = document.getElementById('detailNama');
        const detailHarga = document.getElementById('detailHarga');
        const detailEstimasi = document.getElementById('detailEstimasi');
        const detailStatus = document.getElementById('detailStatus');
        const detailDeskripsi = document.getElementById('detailDeskripsi');

        document.querySelectorAll('.btn-view-layanan').forEach(button => {
            button.addEventListener('click', () => {
                detailNama.textContent = button.dataset.nama;
                detailHarga.textContent = button.dataset.harga;
                detailEstimasi.textContent = button.dataset.estimasi;
                detailStatus.textContent = button.dataset.status;
                detailDeskripsi.textContent = button.dataset.deskripsi;
            });
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


        // === LOGIKA FILTER & SEARCH ===
        const searchInput = document.getElementById('layananSearch');
        const suggestionBox = document.getElementById('searchSuggestion');
        const rows = Array.from(document.querySelectorAll('.custom-table tbody tr'));
        
        let currentStatusFilter = 'all';

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
            if (!query || !suggestionBox) {
                if (suggestionBox) suggestionBox.textContent = '';
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
            const query = searchInput ? searchInput.value.trim().toLowerCase() : '';
            let visibleCount = 0;

            rows.forEach(row => {
                const statusMatch = currentStatusFilter === 'all' || row.dataset.status === currentStatusFilter;
                const matchesSearch = doesMatch(row, query);
                
                if (statusMatch && matchesSearch) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });
            updateSuggestion(query);
            if (!query && suggestionBox) suggestionBox.textContent = '';

            const emptyRow = document.querySelector('.empty-row-row');
            if (emptyRow) {
                if (visibleCount === 0 && rows.length > 0) {
                    emptyRow.style.display = '';
                    emptyRow.querySelector('td').innerHTML = 'Tidak ada layanan yang cocok dengan filter.';
                } else if (rows.length === 0) {
                    emptyRow.style.display = '';
                    emptyRow.querySelector('td').innerHTML = 'Belum ada data layanan.';
                } else {
                    emptyRow.style.display = 'none';
                }
            }
        }

        window.filterLayanan = function(status, buttonElement) {
            currentStatusFilter = status;

            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            buttonElement.classList.add('active');

            filterRows();
        };

        window.resetLayananFilter = function() {
            if (searchInput) {
                searchInput.value = '';
                filterRows();
            }
        };

        if (searchInput) searchInput.addEventListener('input', filterRows);
    </script>

    <div style="height:50px;"></div>
@endsection
