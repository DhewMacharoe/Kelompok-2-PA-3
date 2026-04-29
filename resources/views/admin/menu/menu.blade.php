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
        gap: 10px;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #ccc;
    }

    .filter-btn {
        padding: 6px 15px;
        border-radius: 5px;
        border: 1px solid #adb5bd;
        background: white;
        font-size: 12px;
        font-weight: bold;
        color: #6c757d;
        text-transform: uppercase;
    }

    .filter-btn.active {
        background-color: #337ab7;
        color: white;
        border-color: #337ab7;
    }

    /* Grid Menu */
    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 20px;
    }

    /* Card Styling */
    .menu-card,
    .add-card {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        border: 1px solid #ddd;
    }

    .menu-card-body {
        display: flex;
        padding: 15px;
        gap: 15px;
    }

    .menu-img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 8px;
    }

    .menu-info {
        flex: 1;
    }

    .menu-title {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 5px;
        color: #333;
    }

    .menu-price {
        font-size: 14px;
        color: #d4a017;
        /* Warna emas/coklat gelap */
        font-weight: bold;
        margin-bottom: 8px;
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

    /* Footer Card & Tombol */
    .menu-card-footer {
        display: flex;
        align-items: center;
        padding: 10px 15px;
        background-color: #f9f8f3;
        /* Warna krem muda sesuai gambar */
        gap: 10px;
    }

    .action-btn {
        padding: 5px 12px;
        border: none;
        border-radius: 4px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 11px;
        font-weight: bold;
        transition: opacity 0.2s ease;
    }

    .action-btn:hover {
        opacity: 0.86;
    }

    .action-btn-detail {
        background-color: #337ab7;
    }

    .action-btn-edit {
        background-color: #ffc107;
        color: #1f2937;
    }

    .action-btn-toggle-off {
        background-color: #d9534f;
    }

    .action-btn-toggle-on {
        background-color: #5cb85c;
    }

    .action-btn-delete {
        background-color: #7f1d1d;
    }

    .menu-loading-btn.is-loading {
        position: relative;
        color: transparent !important;
        pointer-events: none;
    }

    .menu-loading-btn.is-loading::after {
        content: '';
        position: absolute;
        width: 14px;
        height: 14px;
        border: 2px solid rgba(255, 255, 255, 0.65);
        border-top-color: rgba(255, 255, 255, 1);
        border-radius: 50%;
        animation: menuSpin 0.75s linear infinite;
    }

    .btn.btn-warning.menu-loading-btn.is-loading::after,
    .btn.btn-success.menu-loading-btn.is-loading::after,
    .btn.btn-secondary.menu-loading-btn.is-loading::after {
        border-color: rgba(17, 24, 39, 0.25);
        border-top-color: rgba(17, 24, 39, 0.95);
    }

    @keyframes menuSpin {
        to {
            transform: rotate(360deg);
        }
    }

    /* Card Tambah Menu */
    .add-card {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 150px;
        background-color: #f9f8f3;
        border: 1px solid #ddd;
    }

    .btn-tambahkan {
        background-color: #5cb85c;
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 5px;
        font-weight: bold;
        font-size: 12px;
    }

    .menu-detail-description {
        overflow-wrap: anywhere;
        word-break: break-word;
        white-space: pre-wrap;
    }
</style>



<div class="main-container">
    <div class="filter-bar">
        <button type="button" class="filter-btn active" data-filter="all">SEMUA</button>
        <button type="button" class="filter-btn" data-filter="active">AKTIF</button>
        <button type="button" class="filter-btn" data-filter="inactive">NONAKTIF</button>
    </div>

    <div class="menu-grid">

        @foreach ($menus as $menu)
        <div class="menu-card" data-status="{{ $menu->is_available ? 'active' : 'inactive' }}">
            <div class="menu-card-body">

                {{-- FOTO --}}
                @if($menu->foto)
                @php
                    // Sementara: dukung URL eksternal jika foto berupa link API gambar.
                    // <img src="{{ asset('images/' . $menu->foto) }}" class="menu-img">
                    $fotoMenu = \Illuminate\Support\Str::startsWith($menu->foto, ['http://', 'https://'])
                        ? $menu->foto
                        : asset('images/' . $menu->foto);
                @endphp
                <img src="{{ $fotoMenu }}" class="menu-img">
                @else
                <img src="https://via.placeholder.com/65" class="menu-img">
                @endif

                <div class="menu-info">
                    <h3 class="menu-title">{{ $menu->nama }}</h3>

                    <p class="menu-price">
                        Rp {{ number_format($menu->harga, 0, ',', '.') }}
                    </p>

                    {{-- STATUS --}}
                    @if($menu->is_available == 1)
                    <span class="badge-aktif">AKTIF</span>
                    @else
                    <span class="badge-aktif" style="background:#fdecea;color:#b71c1c;border-color:#f5c6cb;">
                        NONAKTIF
                    </span>
                    @endif
                </div>
            </div>

            <div class="menu-card-footer">

                {{-- DETAIL --}}
                <button type="button" class="action-btn action-btn-detail"
                    data-bs-toggle="modal"
                    data-bs-target="#modalDetail{{ $menu->id }}"
                    title="Detail"
                    aria-label="Lihat detail menu {{ $menu->nama }}">
                    DETAIL
                </button>

                {{-- EDIT --}}
                <button type="button" class="action-btn action-btn-edit"
                    data-bs-toggle="modal"
                    data-bs-target="#modalEdit{{ $menu->id }}"
                    title="Edit"
                    aria-label="Edit menu {{ $menu->nama }}">
                    EDIT
                </button>

                {{-- TOGGLE STATUS --}}
                <form id="toggle-form-{{ $menu->id }}" action="{{ route('admin.menu.update', $menu->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="nama" value="{{ $menu->nama }}">
                    <input type="hidden" name="harga" value="{{ $menu->harga }}">
                    <input type="hidden" name="deskripsi" value="{{ $menu->deskripsi }}">
                    <input type="hidden" name="is_available" value="{{ $menu->is_available ? 0 : 1 }}">

                    @if($menu->is_available)
                    <button type="button"
                        class="action-btn action-btn-toggle-off btn-open-confirm"
                        data-confirm-form="toggle-form-{{ $menu->id }}"
                        data-confirm-message="Yakin ingin menonaktifkan menu ini?"
                        title="Nonaktifkan"
                        aria-label="Nonaktifkan menu {{ $menu->nama }}">
                        NONAKTIFKAN
                    </button>
                    @else
                    <button type="submit"
                        class="action-btn action-btn-toggle-on menu-loading-btn"
                        data-loading-text="Mengaktifkan..."
                        title="Aktifkan"
                        aria-label="Aktifkan menu {{ $menu->nama }}">
                        AKTIFKAN
                    </button>
                    @endif
                </form>

                {{-- HAPUS --}}
                <form id="delete-form-{{ $menu->id }}" action="{{ route('admin.menu.destroy', $menu->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button"
                        class="action-btn action-btn-delete btn-open-confirm"
                        data-confirm-form="delete-form-{{ $menu->id }}"
                        data-confirm-message="Yakin ingin menghapus menu ini? Data tidak bisa dikembalikan."
                        title="Hapus"
                        aria-label="Hapus menu {{ $menu->nama }}">
                        HAPUS
                    </button>
                </form>

            </div>

            <!-- Modal Detail -->
            <div class="modal fade" id="modalDetail{{ $menu->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5>Detail Menu</h5>
                        </div>

                        <div class="modal-body">
                            @if($menu->foto)
                            @php
                                $fotoDetail = \Illuminate\Support\Str::startsWith($menu->foto, ['http://', 'https://'])
                                    ? $menu->foto
                                    : asset('images/' . $menu->foto);
                            @endphp
                            <img src="{{ $fotoDetail }}" class="img-fluid rounded mb-3" alt="Foto {{ $menu->nama }}">
                            @endif

                            <p class="mb-1"><strong>Nama:</strong> {{ $menu->nama }}</p>
                            <p class="mb-1"><strong>Harga:</strong> Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                            <p class="mb-1"><strong>Status:</strong> {{ $menu->is_available ? 'Aktif' : 'Nonaktif' }}</p>
                            <p class="mb-0 menu-detail-description"><strong>Deskripsi:</strong> {{ $menu->deskripsi ?: '-' }}</p>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Edit -->
            <div class="modal fade" id="modalEdit{{ $menu->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('admin.menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="modal-content">
                            <div class="modal-header">
                                <h5>Edit Menu</h5>
                            </div>

                            <div class="modal-body">
                                <input type="text" name="nama" value="{{ $menu->nama }}" class="form-control mb-2" required>
                                <input type="text" id="harga_mask_edit_{{ $menu->id }}" class="form-control mb-2 harga-mask"
                                    data-target="harga_raw_edit_{{ $menu->id }}"
                                    value="Rp.{{ number_format($menu->harga, 0, ',', '.') }}" placeholder="Rp.0" required>
                                <input type="hidden" name="harga" id="harga_raw_edit_{{ $menu->id }}"
                                    value="{{ $menu->harga }}">
                                <textarea name="deskripsi" class="form-control mb-2">{{ $menu->deskripsi }}</textarea>

                                <input type="file" name="foto" class="form-control mb-2">

                                <select name="is_available" class="form-control" required>
                                    <option value="1" {{ $menu->is_available ? 'selected' : '' }}>Tersedia</option>
                                    <option value="0" {{ !$menu->is_available ? 'selected' : '' }}>Tidak</option>
                                </select>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-warning menu-loading-btn" data-loading-text="Mengupdate...">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach


        {{-- TAMBAH MENU --}}
        <div class="add-card">
            <button class="btn-tambahkan" data-bs-toggle="modal" data-bs-target="#modalCreate">
                TAMBAHKAN +
            </button>
        </div>

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
                        <input type="text" name="nama" placeholder="Nama" class="form-control mb-2">
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterButtons = document.querySelectorAll('.filter-btn');
        const menuCards = document.querySelectorAll('.menu-card');
        const hargaMasks = document.querySelectorAll('.harga-mask');
        const confirmButtons = document.querySelectorAll('.btn-open-confirm');
        const confirmMessageEl = document.getElementById('konfirmasiAksiMessage');
        const confirmSubmitBtn = document.getElementById('btnKonfirmasiAksi');
        const confirmModalElement = document.getElementById('modalKonfirmasiAksi');
        const confirmModal = confirmModalElement ? new bootstrap.Modal(confirmModalElement) : null;
        let activeConfirmForm = null;

        filterButtons.forEach((button) => {
            button.addEventListener('click', function() {
                const selectedFilter = this.dataset.filter;

                filterButtons.forEach((btn) => btn.classList.remove('active'));
                this.classList.add('active');

                menuCards.forEach((card) => {
                    const cardStatus = card.dataset.status;
                    const shouldShow = selectedFilter === 'all' || selectedFilter === cardStatus;
                    card.style.display = shouldShow ? '' : 'none';
                });
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
    });
</script>
@endpush
@endsection