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
                    <th style="width: 160px;">Foto</th>
                    <th>Judul</th>
                    <th style="width: 120px;">Status</th>
                    <th style="width: 300px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($galeris as $galeri)
                <tr class="galeri-row" data-status="{{ $galeri->is_active ? 'aktif' : 'nonaktif' }}">
                    <td data-label="Foto">
                        <img src="{{ \Illuminate\Support\Str::startsWith($galeri->gambar, ['http://', 'https://']) ? $galeri->gambar : asset('images/' . $galeri->gambar) }}"
                            alt="{{ $galeri->judul }}"
                            style="width: 120px; height: 80px; object-fit: cover; border-radius: 8px;">
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

                    <td data-label="Action">
                        <div style="display: flex; gap: 5px; flex-wrap: wrap; justify-content: flex-end;">
                            <button type="button" class="btn-action btn-view shadow-sm btn-view-galeri"
                                data-judul="{{ $galeri->judul }}"
                                data-deskripsi="{{ $galeri->deskripsi }}"
                                data-gambar="{{ \Illuminate\Support\Str::startsWith($galeri->gambar, ['http://', 'https://']) ? $galeri->gambar : asset('images/' . $galeri->gambar) }}"
                                data-bs-toggle="modal"
                                data-bs-target="#viewGaleriModal" style="margin: 0;">
                                View
                            </button>

                            <form action="{{ route('admin.galeri.toggleStatus', $galeri) }}"
                                method="POST"
                                style="display: inline; margin: 0;">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="btn-action btn-toggle-status shadow-sm"
                                    data-loading-text="Memproses..." style="margin: 0;">
                                    {{ $galeri->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>

                            <a href="{{ route('admin.galeri.edit', $galeri) }}"
                                class="btn-action btn-edit shadow-sm" style="margin: 0;">
                                Edit
                            </a>

                            <button type="button"
                                class="btn-action btn-hapus shadow-sm btn-delete-galeri"
                                data-action="{{ route('admin.galeri.destroy', $galeri) }}"
                                data-judul="{{ $galeri->judul }}"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteGaleriModal" style="margin: 0;">
                                Hapus
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr class="empty-row-row">
                    <td colspan="4" class="empty-row-cell" style="padding: 40px; color: #999;">
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
        <div class="modal-content border-0 shadow" style="border-radius: 12px; animation: slideDown 0.3s ease-out;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title" style="font-size: 18px; color: #2C3E50; font-weight: bold;" id="viewGaleriModalLabel">
                    Detail Galeri
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <div class="modal-body">
                <img id="viewGaleriImage" src="" alt="Galeri Image" style="width: 100%; border-radius: 8px; margin-bottom: 16px; object-fit: cover;">
                <h6 id="viewGaleriTitle" style="font-size: 16px; font-weight: bold; margin-bottom: 8px;"></h6>
                <p id="viewGaleriDesc" style="color: #6b7280; font-size: 14px; margin: 0; white-space: pre-wrap;"></p>
            </div>

            <div class="modal-footer border-0 pt-0" style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" class="btn-batal" data-bs-dismiss="modal" style="margin: 0; background-color: #6c757d;">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Konfirmasi Hapus Galeri --}}
<div class="modal fade" id="deleteGaleriModal" tabindex="-1" aria-labelledby="deleteGaleriModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 12px; animation: slideDown 0.3s ease-out;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title" style="font-size: 18px; color: #2C3E50; font-weight: bold;" id="deleteGaleriModalLabel">
                    Hapus Foto Galeri?
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <div class="modal-body">
                <p style="margin-bottom: 8px; color: #333;">
                    Foto galeri <strong id="deleteGaleriTitle">ini</strong> akan dihapus secara permanen.
                </p>
                <p style="color: #6b7280; font-size: 14px; margin: 0;">
                    Foto yang sudah dihapus tidak akan tampil lagi di halaman pelanggan.
                </p>
            </div>

            <div class="modal-footer border-0 pt-0" style="display: flex; gap: 10px;">
                <button type="button" class="btn-batal" data-bs-dismiss="modal" style="margin: 0;">
                    Batal
                </button>

                <form id="deleteGaleriForm" method="POST" style="margin: 0;">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn-submit" style="background-color: #EB5757; color: white;" data-loading-text="Menghapus...">
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