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
    }

    /* Filter Bar */
    .filter-bar {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        align-items: center;
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
        text-transform: uppercase;
        letter-spacing: 0.08em;
        font-weight: 700;
    }

    .filter-btn {
        padding: 8px 16px;
        border-radius: 999px;
        border: 1px solid #d6d9dd;
        background: white;
        font-size: 12px;
        font-weight: 700;
        color: #444;
        text-transform: uppercase;
        cursor: pointer;
    }

    .filter-btn.active {
        background-color: #203857;
        color: white;
        border-color: #203857;
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

    .menu-table tbody tr:hover {
        background: #f8fafc;
    }

    .cell-menu {
        min-width: 240px;
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
    .btn-nonaktif,
    .btn-aktifkan,
    .btn-tambahkan {
        border: none;
        border-radius: 6px;
        padding: 8px 14px;
        font-size: 12px;
        cursor: pointer;
        font-weight: 700;
    }

    .btn-edit {
        background-color: #ffb400;
        color: #ffffff;
    }

    .btn-nonaktif {
        background-color: #d9534f;
        color: #ffffff;
    }

    .btn-aktifkan {
        background-color: #5cb85c;
        color: #ffffff;
    }

    .btn-tambahkan {
        background-color: #1b6cff;
        color: #ffffff;
    }

    .empty-row {
        text-align: center;
        color: #555;
        padding: 30px 0;
    }


</style>



<div class="main-container">
    @php
        $categories = $menus->pluck('kategori')->unique();
    @endphp

    <div class="top-bar">
        <div class="top-actions">
            <button class="btn-tambahkan" data-bs-toggle="modal" data-bs-target="#modalCreate">
                TAMBAHKAN +
            </button>
        </div>

        <div class="filter-bar">
            <div class="filter-group">
                <span class="filter-group-label">Status</span>
                <button type="button" class="filter-btn active" data-filter="all" data-filter-type="status">SEMUA</button>
                <button type="button" class="filter-btn" data-filter="active" data-filter-type="status">AKTIF</button>
                <button type="button" class="filter-btn" data-filter="inactive" data-filter-type="status">NONAKTIF</button>
            </div>
            <div class="filter-group">
                <span class="filter-group-label">Kategori</span>
                <button type="button" class="filter-btn active" data-filter="all" data-filter-type="category">SEMUA</button>
                @foreach($categories as $category)
                    <button type="button" class="filter-btn" data-filter="{{ $category }}" data-filter-type="category">{{ strtoupper($category) }}</button>
                @endforeach
            </div>
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
                            <button class="btn-edit" type="button" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $menu->id }}">EDIT</button>
                            <form action="{{ route('admin.menu.update', $menu->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="nama" value="{{ $menu->nama }}">
                                <input type="hidden" name="kategori" value="{{ $menu->kategori }}">
                                <input type="hidden" name="harga" value="{{ $menu->harga }}">
                                <input type="hidden" name="deskripsi" value="{{ $menu->deskripsi }}">
                                <input type="hidden" name="is_available" value="{{ $menu->is_available ? 0 : 1 }}">
                                @if($menu->is_available == 1)
                                    <button type="submit" class="btn-nonaktif">NONAKTIFKAN</button>
                                @else
                                    <button type="submit" class="btn-aktifkan">AKTIFKAN</button>
                                @endif
                            </form>
                            <form action="{{ route('admin.menu.destroy', $menu->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus menu ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-nonaktif" style="background-color: #6c757d;">HAPUS</button>
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
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterButtons = document.querySelectorAll('.filter-btn');
        const menuRows = document.querySelectorAll('.menu-row');
        const hargaMasks = document.querySelectorAll('.harga-mask');

        const statusButtons = document.querySelectorAll('[data-filter-type="status"]');
        const categoryButtons = document.querySelectorAll('[data-filter-type="category"]');
        let selectedStatus = 'all';
        let selectedCategory = 'all';

        function updateMenuVisibility() {
            menuRows.forEach((row) => {
                const rowStatus = row.dataset.status;
                const rowCategory = row.dataset.category;
                const statusMatch = selectedStatus === 'all' || selectedStatus === rowStatus;
                const categoryMatch = selectedCategory === 'all' || selectedCategory === rowCategory;
                row.style.display = statusMatch && categoryMatch ? '' : 'none';
            });
        }

        function setActiveButton(buttons, clickedButton) {
            buttons.forEach((btn) => btn.classList.remove('active'));
            clickedButton.classList.add('active');
        }

        statusButtons.forEach((button) => {
            button.addEventListener('click', function() {
                selectedStatus = this.dataset.filter;
                setActiveButton(statusButtons, this);
                updateMenuVisibility();
            });
        });

        categoryButtons.forEach((button) => {
            button.addEventListener('click', function() {
                selectedCategory = this.dataset.filter;
                setActiveButton(categoryButtons, this);
                updateMenuVisibility();
            });
        });

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
    });
</script>
@endpush
@endsection