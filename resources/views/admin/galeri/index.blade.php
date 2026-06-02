@extends('admin.layouts.app')

@section('title', 'Galeri')

@section('header_title')
<div class="header-title">Galeri</div>
@endsection

@push('styles')
@include('admin.galeri.style-index')
@endpush

@section('content')
<div class="main-container">
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <a href="{{ route('admin.galeri.create') }}" class="btn-tambah shadow-sm">
        + Tambah
    </a>

    <div class="filter-bar" role="tablist" aria-label="Filter status galeri">
        <button type="button" class="filter-btn" data-filter="aktif" onclick="filterGaleri('aktif', this)">Aktif</button>
        <button type="button" class="filter-btn" data-filter="nonaktif" onclick="filterGaleri('nonaktif', this)">Nonaktif</button>
        <button type="button" class="filter-btn active" data-filter="all" onclick="filterGaleri('all', this)">Semua</button>
    </div>

    <div class="search-filter-wrap">
        <label for="judulFilter">Cari Judul:</label>
        <input type="text" id="judulFilter" class="search-filter-input" placeholder="Masukkan judul galeri...">
        <button type="button" class="btn-reset-filter" onclick="resetJudulFilter()">Reset Pencarian</button>
    </div>

    <div class="table-container">
        <table class="custom-table">
            <thead>
                <tr>
                    <th class="table-column-photo">Foto</th>
                    <th>Judul</th>
                    <th class="table-column-status">Status</th>
                    <th class="table-column-action">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($galeris as $galeri)
                <tr class="galeri-row" data-status="{{ $galeri->is_active ? 'aktif' : 'nonaktif' }}">
                    <td data-label="Foto">
                            <img src="{{ \Illuminate\Support\Str::startsWith($galeri->gambar, ['http://', 'https://']) ? $galeri->gambar : asset('images/' . $galeri->gambar) }}"
                            alt="{{ $galeri->judul }}"
                            class="preview-image-thumb">
                    </td>

                    <td data-label="Judul">
                        <div>
                            <strong>{{ $galeri->judul }}</strong>
                        </div>
                    </td>

                    <td data-label="Status">
                        @if($galeri->is_active)
                        <span class="status-badge status-aktif">Aktif</span>
                        @else
                        <span class="status-badge status-nonaktif">Nonaktif</span>
                        @endif
                    </td>

                    <td data-label="Aksi">
                        <div class="action-cluster-end">
                            <button type="button" class="btn-action btn-view shadow-sm btn-view-galeri"
                                data-judul="{{ $galeri->judul }}"
                                data-deskripsi="{{ $galeri->deskripsi }}"
                                data-gambar="{{ \Illuminate\Support\Str::startsWith($galeri->gambar, ['http://', 'https://']) ? $galeri->gambar : asset('images/' . $galeri->gambar) }}"
                                data-bs-toggle="modal"
                                data-bs-target="#viewGaleriModal">
                                Lihat
                            </button>

                            <form action="{{ route('admin.galeri.toggleStatus', $galeri) }}"
                                method="POST"
                                class="action-inline-form">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="btn-action btn-toggle-status shadow-sm action-reset"
                                    data-loading-text="Memproses...">
                                    {{ $galeri->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>

                            <a href="{{ route('admin.galeri.edit', $galeri) }}"
                                class="btn-action btn-edit shadow-sm action-reset">
                                Ubah
                            </a>

                            <button type="button"
                                class="btn-action btn-hapus shadow-sm btn-delete-galeri"
                                data-action="{{ route('admin.galeri.destroy', $galeri) }}"
                                data-judul="{{ $galeri->judul }}"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteGaleriModal">
                                Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr class="empty-row-row">
                    <td colspan="4" class="empty-row-cell table-empty-cell">
                        Belum ada foto galeri.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal View Galeri --}}
<div class="modal fade" id="viewGaleriModal" tabindex="-1" aria-labelledby="viewGaleriModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow modal-shell-animated">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title modal-title-strong" id="viewGaleriModalLabel">
                    Detail Galeri
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <div class="modal-body">
                <img id="viewGaleriImage" src="" alt="Pratinjau galeri" class="preview-image-fit mb-3">
                <h6 id="viewGaleriTitle" class="modal-subtitle-strong"></h6>
                <p id="viewGaleriDesc" class="modal-description-muted"></p>
            </div>

            <div class="modal-footer border-0 pt-0 modal-footer-end">
                <button type="button" class="btn-batal modal-button-muted" data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Konfirmasi Hapus Galeri --}}
<div class="modal fade" id="deleteGaleriModal" tabindex="-1" aria-labelledby="deleteGaleriModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow modal-shell-animated">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title modal-title-strong" id="deleteGaleriModalLabel">
                    Hapus Foto Galeri?
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <div class="modal-body">
                <p class="detail-row modal-text-dark">
                    Foto galeri <strong id="deleteGaleriTitle">ini</strong> akan dihapus secara permanen.
                </p>
                <p class="modal-description-muted">
                    Foto yang sudah dihapus tidak akan tampil lagi di halaman pelanggan.
                </p>
            </div>

            <div class="modal-footer border-0 pt-0 modal-footer-tight">
                <button type="button" class="btn-batal action-reset" data-bs-dismiss="modal">
                    Batal
                </button>

                <form id="deleteGaleriForm" method="POST" class="action-reset">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn-submit modal-button-danger" data-loading-text="Menghapus...">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Delete Modal Logic
        const deleteButtons = document.querySelectorAll('.btn-delete-galeri');
        const deleteForm = document.getElementById('deleteGaleriForm');
        const deleteTitle = document.getElementById('deleteGaleriTitle');

        deleteButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                const action = this.getAttribute('data-action');
                const judul = this.getAttribute('data-judul');

                deleteForm.setAttribute('action', action);
                deleteTitle.textContent = judul;
            });
        });

        // View Modal Logic
        const viewButtons = document.querySelectorAll('.btn-view-galeri');
        const viewImage = document.getElementById('viewGaleriImage');
        const viewTitle = document.getElementById('viewGaleriTitle');
        const viewDesc = document.getElementById('viewGaleriDesc');

        viewButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                const judul = this.getAttribute('data-judul');
                const deskripsi = this.getAttribute('data-deskripsi');
                const gambar = this.getAttribute('data-gambar');

                viewTitle.textContent = judul;
                viewDesc.textContent = deskripsi || 'Tidak ada deskripsi.';
                viewImage.setAttribute('src', gambar);
            });
        });

        // Filter and Search Logic
        const filterInput = document.getElementById('judulFilter');

        if (filterInput) {
            filterInput.addEventListener('input', function() {
                applyFilters();
            });
        }
    });

    let currentStatusFilter = 'all';

    function filterGaleri(status, buttonElement) {
        currentStatusFilter = status;

        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        buttonElement.classList.add('active');

        applyFilters();
    }

    function resetJudulFilter() {
        const filterInput = document.getElementById('judulFilter');
        if (filterInput) {
            filterInput.value = '';
            applyFilters();
        }
    }

    function applyFilters() {
        const rows = document.querySelectorAll('.custom-table tbody tr.galeri-row');
        const searchInput = document.getElementById('judulFilter');
        const searchQuery = searchInput ? searchInput.value.toLowerCase() : '';
        let visibleCount = 0;

        rows.forEach(row => {
            const status = row.getAttribute('data-status');
            const titleElement = row.querySelector('td[data-label="Judul"] strong');
            const title = titleElement ? titleElement.textContent.toLowerCase() : '';

            const matchStatus = currentStatusFilter === 'all' || status === currentStatusFilter;
            const matchSearch = title.includes(searchQuery);

            if (matchStatus && matchSearch) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        const emptyRow = document.querySelector('.empty-row-row');
        if (emptyRow) {
            if (visibleCount === 0 && rows.length > 0) {
                // If there are rows but all are hidden by filter, show the empty row message
                // but change the text
                emptyRow.style.display = '';
                emptyRow.querySelector('td').innerHTML = 'Tidak ada galeri yang cocok dengan filter.';
            } else if (rows.length === 0) {
                // Keep the default empty message if really no data
                emptyRow.style.display = '';
            } else {
                emptyRow.style.display = 'none';
            }
        }
    }
</script>
@endsection