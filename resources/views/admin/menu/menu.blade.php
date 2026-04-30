@extends('admin.layouts.app')

@section('title', 'Menu Cafe')

@section('header_title')
<div class="header-title">Menu Kafe</div>
@endsection

@section('content')
<style>
    /* Layout Utama */
    .main-container {
        padding: 20px;
        background-color: #f4f4f4;
        min-height: 100vh;
        font-family: 'Inter', sans-serif;
    }

    /* Filter Bar */
    .filter-bar {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        align-items: center;
         margin-bottom: 24px;

    }

    .filter-group {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: center;

    }

    .filter-group-label {
        font-size: 12px;
        color: #6c757d;
        /* text-transform: uppercase; */
        letter-spacing: 0.08em;
        font-weight: 700;
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

        /* text-transform: uppercase; */
    }

    .filter-btn.active {
        background-color: #2F80ED;
        color: white;
        border-color: #337ab7;
    }

    /* Grid Menu */
    .top-bar {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 20px;
        align-items: center;
    }

    .top-left {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        align-items: flex-end;
    }

    .top-field {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .top-field label {
        font-size: 12px;
        font-weight: 700;
        color: #34465d;
    }

    .top-field input,
    .top-field select {
        min-width: 220px;
        max-width: 320px;
        padding: 10px 14px;
        border: 1px solid #dfe3e8;
        border-radius: 12px;
        background: #ffffff;
        color: #2c3e50;
        font-size: 14px;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
    }

    .select-wrapper {
        position: relative;
        display: inline-block;
        width: 100%;
    }

    .select-wrapper select {
        padding-right: 40px;
    }

    .select-icon {
        position: absolute;
        top: 50%;
        right: 14px;
        transform: translateY(-50%);
        pointer-events: none;
        color: #6c757d;
        font-size: 0.95rem;
    }

    .top-field input::placeholder {
        color: #9aa3b4;
    }

    .top-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        align-items: center;
    }

    .table-container {
        width: 100%;
        overflow-x: auto;
    }

    .menu-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #ddd;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
    }

    .menu-table th,
    .menu-table td {
        padding: 14px 16px;
        text-align: left;
        border-bottom: 1px solid #f1f1f1;
    }

    .menu-table thead th {
        background: #203857;
        color: #fff;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        border-bottom: 2px solid #152538;
    }

    /* Badge Aktif */
    .badge-aktif {
        background-color: #e8f5e9;
        color: #2e7d32;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 10px;
        font-weight: bold;
        border: 1px solid #c8e6c9;
    }

    .menu-row-item {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .menu-row-img {
        width: 56px;
        height: 56px;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid #e6e6e6;
    }

    .menu-desc {
        margin: 4px 0 0;
        color: #777;
        font-size: 13px;
        max-width: 320px;
    }

    .badge-nonaktif {
        background-color: #fdecea;
        color: #a7211c;
        padding: 4px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        border: 1px solid #f5c6cb;
    }

    .action-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .btn-edit,
    .btn-toggle,
    .btn-delete,
    .btn-tambahkan,
    .btn-view {
        border: none;
        border-radius: 6px;
        padding: 8px 14px;
        font-size: 12px;
        cursor: pointer;
        font-weight: 700;
        transition: background-color 0.2s ease;
    }

    .btn-view {
        background-color: #6c757d;
        color: #ffffff;
    }

    .btn-toggle {
        background-color: #f0ad4e;
        color: #ffffff;
    }

    .btn-edit {
        background-color: #0d6efd;
        color: #ffffff;
    }

    .btn-delete {
        background-color: #dc3545;
        color: #ffffff;
    }

    .btn-tambahkan {
        background-color: #4CC779;
        color: #ffffff;
    }

    .btn-view:hover,
    .btn-toggle:hover,
    .btn-edit:hover,
    .btn-delete:hover,
    .btn-tambahkan:hover {
        opacity: 0.9;
    }

    .empty-row {
        text-align: center;
        color: #555;
        padding: 30px 0;
    }

    .detail-modal {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.45);
        z-index: 1050;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    .detail-modal.show {
        display: flex;
    }

    .detail-modal-card {
        width: 100%;
        max-width: 520px;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 18px 60px rgba(0, 0, 0, 0.16);
        overflow: hidden;
        position: relative;
    }

    .detail-modal-close {
        position: absolute;
        top: 16px;
        right: 16px;
        background: transparent;
        border: none;
        font-size: 1.6rem;
        line-height: 1;
        cursor: pointer;
        color: #495057;
    }

    .detail-modal-header {
        border-bottom: 1px solid #e9ecef;
        padding: 24px;
    }

    .detail-modal-header h2 {
        margin: 0;
        font-size: 1.25rem;
        color: #203857;
    }

    .detail-modal-body {
        padding: 24px;
        display: grid;
        gap: 16px;
        color: #36454f;
        font-size: 14px;
    }

    .detail-modal-item {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        padding: 12px 16px;
        background: #f8f9fa;
        border-radius: 10px;
    }

    .detail-modal-desc {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 16px;
    }


</style>



<div class="main-container">
    <div class="top-bar">
        <div class="top-left">
            <div class="top-field">
                <label for="menuStatusFilter">Status</label>
                <div class="select-wrapper">
                    <select id="menuStatusFilter" class="form-control">
                        <option value="all">Semua</option>
                        <option value="active">Aktif</option>
                        <option value="inactive">Nonaktif</option>
                    </select>
                    <span class="select-icon"><i class="bi bi-chevron-down"></i></span>
                </div>
            </div>
            <div class="top-field search-field">
                <label for="menuSearch">Cari Menu</label>
                <input id="menuSearch" type="text" class="form-control" placeholder="Ketik nama menu...">
            </div>
        </div>
        <div class="top-actions">
            <button type="button" class="btn-tambahkan" data-bs-toggle="modal" data-bs-target="#modalCreate"><i class="bi bi-plus-lg me-2"></i>Tambahkan Menu</button>
        </div>
    </div>

    <div class="table-container">
        <table class="menu-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Menu</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($menus as $index => $menu)
                    <tr class="menu-row" data-status="{{ $menu->is_available ? 'active' : 'inactive' }}" data-category="{{ $menu->kategori }}">
                        <td>{{ $index + 1 }}</td>
                        <td class="cell-menu">
                            <div class="menu-row-item">
                                @if($menu->foto)
                                    @php
                                        $fotoMenu = \Illuminate\Support\Str::startsWith($menu->foto, ['http://', 'https://'])
                                            ? $menu->foto
                                            : asset('images/' . $menu->foto);
                                    @endphp
                                    <img src="{{ $fotoMenu }}" class="menu-row-img">
                                @else
                                    <img src="https://via.placeholder.com/65" class="menu-row-img">
                                @endif
                                <div>
                                    <div class="menu-title">{{ $menu->nama }}</div>
                                    <p class="menu-desc">{{ \Illuminate\Support\Str::limit($menu->deskripsi, 60) }}</p>
                                </div>
                            </div>
                        </td>
                        <td>{{ $menu->kategori }}</td>
                        <td class="menu-price">Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                        <td>
                            @if($menu->is_available == 1)
                                <span class="badge-aktif">AKTIF</span>
                            @else
                                <span class="badge-nonaktif">NONAKTIF</span>
                            @endif
                        </td>
                        <td class="action-buttons">
                            <button type="button" class="btn-view"
                                data-nama="{{ $menu->nama }}"
                                data-foto="{{ $menu->foto ? (\Illuminate\Support\Str::startsWith($menu->foto, ['http://', 'https://']) ? $menu->foto : asset('images/' . $menu->foto)) : '' }}"
                                data-kategori="{{ $menu->kategori }}"
                                data-harga="Rp {{ number_format($menu->harga, 0, ',', '.') }}"
                                data-status="{{ $menu->is_available == 1 ? 'Aktif' : 'Nonaktif' }}"
                                data-deskripsi="{{ str_replace(["\r", "\n"], ' ', e($menu->deskripsi ?? 'Tidak ada deskripsi.')) }}">View</button>
                            <button class="btn-edit" type="button" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $menu->id }}">EDIT</button>
                            <form action="{{ route('admin.menu.update', $menu->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="nama" value="{{ $menu->nama }}">
                                <input type="hidden" name="kategori" value="{{ $menu->kategori }}">
                                <input type="hidden" name="harga" value="{{ $menu->harga }}">
                                <input type="hidden" name="deskripsi" value="{{ $menu->deskripsi }}">
                                <input type="hidden" name="is_available" value="{{ $menu->is_available ? 0 : 1 }}">
                                <button type="submit" class="btn-toggle">{{ $menu->is_available == 1 ? 'NONAKTIFKAN' : 'AKTIFKAN' }}</button>
                            </form>
                            <form action="{{ route('admin.menu.destroy', $menu->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus menu ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">HAPUS</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty-row">Tidak ada menu tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal Create -->
    <div class="modal fade" id="modalCreate" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Tambah Menu</h5>
                    </div>

                    <div class="modal-body">
                        <input type="text" name="nama" placeholder="Nama" class="form-control mb-2" required>
                        <select name="kategori" class="form-control mb-2" required>
                            <option value="">Pilih Kategori</option>
                            <option value="Makanan">Makanan</option>
                            <option value="Minuman">Minuman</option>
                        </select>
                        <input type="text" id="harga_mask_create" class="form-control mb-2 harga-mask"
                            data-target="harga_raw_create" placeholder="Rp.0" required>
                        <input type="hidden" name="harga" id="harga_raw_create">
                        <textarea name="deskripsi" class="form-control mb-2"></textarea>
                        <input type="file" name="foto" class="form-control mb-2">

                        <select name="is_available" class="form-control">
                            <option value="1">Tersedia</option>
                            <option value="0">Tidak</option>
                        </select>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success menu-loading-btn" data-loading-text="Menyimpan...">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Konfirmasi Aksi -->
    <div class="modal fade" id="modalKonfirmasiAksi" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="konfirmasiAksiMessage">
                    Yakin ingin melanjutkan aksi ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger menu-loading-btn" id="btnKonfirmasiAksi">Ya, Lanjutkan</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="detailModal" class="detail-modal">
    <div class="detail-modal-card">
        <button id="detailClose" class="detail-modal-close">&times;</button>
        <div class="detail-modal-header">
            <div>
                <h2 id="detailNama">Nama Menu</h2>
                <p id="detailLabel" style="margin-top: 8px; color: #556673;">Detail lengkap menu cafe.</p>
            </div>
        </div>
        <div class="detail-modal-body">
            <div class="detail-modal-item"><strong>Kategori</strong> <span id="detailKategori">-</span></div>
            <div class="detail-modal-item"><strong>Harga</strong> <span id="detailHarga">-</span></div>
            <div class="detail-modal-item"><strong>Status</strong> <span id="detailStatus">-</span></div>
            <div class="detail-modal-desc"><strong>Deskripsi:</strong>
                <p id="detailDeskripsi" style="margin-top: 8px;">-</p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuStatusFilter = document.getElementById('menuStatusFilter');
        const menuSearchInput = document.getElementById('menuSearch');
        const menuRows = document.querySelectorAll('.menu-row');
        const hargaMasks = document.querySelectorAll('.harga-mask');
        const confirmButtons = document.querySelectorAll('.btn-open-confirm');
        const confirmMessageEl = document.getElementById('konfirmasiAksiMessage');
        const confirmSubmitBtn = document.getElementById('btnKonfirmasiAksi');
        const confirmModalElement = document.getElementById('modalKonfirmasiAksi');
        const confirmModal = confirmModalElement ? new bootstrap.Modal(confirmModalElement) : null;
        let activeConfirmForm = null;
        let selectedStatus = 'all';
        let searchQuery = '';

        function updateMenuVisibility() {
            const query = searchQuery.trim().toLowerCase();
            menuRows.forEach((row) => {
                const rowStatus = row.dataset.status;
                const statusMatch = selectedStatus === 'all' || selectedStatus === rowStatus;
                const rowName = row.querySelector('.menu-title')?.textContent.toLowerCase() || '';
                const rowDesc = row.querySelector('.menu-desc')?.textContent.toLowerCase() || '';
                const searchMatch = !query || rowName.includes(query) || rowDesc.includes(query);
                row.style.display = statusMatch && searchMatch ? '' : 'none';
            });
        }

        if (menuStatusFilter) {
            menuStatusFilter.addEventListener('change', function() {
                selectedStatus = this.value;
                updateMenuVisibility();
            });
        }

        if (menuSearchInput) {
            menuSearchInput.addEventListener('input', function() {
                searchQuery = this.value;
                updateMenuVisibility();
            });
        }

        function formatRupiah(angka) {
            const numberString = angka.replace(/[^\d]/g, '');
            if (!numberString) {
                return '';
            }

            const sisa = numberString.length % 3;
            let rupiah = numberString.substr(0, sisa);
            const ribuan = numberString.substr(sisa).match(/\d{3}/g);

            if (ribuan) {
                const separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            return 'Rp.' + rupiah;
        }

        hargaMasks.forEach((input) => {
            const targetId = input.dataset.target;
            const rawInput = document.getElementById(targetId);

            if (!rawInput) {
                return;
            }

            if (rawInput.value) {
                input.value = formatRupiah(rawInput.value.toString());
            }

            input.addEventListener('input', function() {
                const numericValue = this.value.replace(/[^\d]/g, '');
                rawInput.value = numericValue;
                this.value = formatRupiah(numericValue);
            });
        });

        confirmButtons.forEach((button) => {
            button.addEventListener('click', function() {
                const formId = this.dataset.confirmForm;
                const message = this.dataset.confirmMessage || 'Yakin ingin melanjutkan aksi ini?';
                const targetForm = formId ? document.getElementById(formId) : null;

                if (!targetForm || !confirmModal) {
                    return;
                }

                activeConfirmForm = targetForm;
                confirmMessageEl.textContent = message;
                confirmModal.show();
            });
        });

        if (confirmSubmitBtn) {
            confirmSubmitBtn.addEventListener('click', function() {
                if (!activeConfirmForm) {
                    return;
                }

                this.classList.add('is-loading');
                this.disabled = true;
                activeConfirmForm.submit();
            });
        }

        if (confirmModalElement) {
            confirmModalElement.addEventListener('hidden.bs.modal', function() {
                activeConfirmForm = null;
                if (confirmSubmitBtn) {
                    confirmSubmitBtn.classList.remove('is-loading');
                    confirmSubmitBtn.disabled = false;
                }
            });
        }

        const menuForms = document.querySelectorAll('.main-container form');
        menuForms.forEach((form) => {
            form.addEventListener('submit', function(event) {
                const submitter = event.submitter;
                if (!submitter || !submitter.classList.contains('menu-loading-btn')) {
                    return;
                }

                submitter.classList.add('is-loading');
            });
        });

        const detailModal = document.getElementById('detailModal');
        const detailClose = document.getElementById('detailClose');
        const detailNama = document.getElementById('detailNama');
        const detailKategori = document.getElementById('detailKategori');
        const detailHarga = document.getElementById('detailHarga');
        const detailStatus = document.getElementById('detailStatus');
        const detailDeskripsi = document.getElementById('detailDeskripsi');

        document.querySelectorAll('.btn-view').forEach((button) => {
            button.addEventListener('click', function() {
                detailNama.textContent = this.dataset.nama;
                detailKategori.textContent = this.dataset.kategori;
                detailHarga.textContent = this.dataset.harga;
                detailStatus.textContent = this.dataset.status;
                detailDeskripsi.textContent = this.dataset.deskripsi;
                detailModal.classList.add('show');
            });
        });

        if (detailClose) {
            detailClose.addEventListener('click', function() {
                detailModal.classList.remove('show');
            });
        }

        if (detailModal) {
            detailModal.addEventListener('click', function(event) {
                if (event.target === detailModal) {
                    detailModal.classList.remove('show');
                }
            });
        }
    });
</script>
@endpush
@endsection
