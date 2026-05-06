    @extends('admin.layouts.app')

    @section('title', 'Menu Cafe')

    @section('header_title')
    <div class="header-title">Menu Kafe</div>
    @endsection

    @section('content')
    @push('styles')
        @include('admin.menu.style-index')
    @endpush

    <div class="main-container">

        <button type="button" class="btn-tambah shadow-sm" data-bs-toggle="modal" data-bs-target="#modalCreate">
            + Tambah
        </button>

        <div class="filter-bar" role="tablist" aria-label="Filter status menu">
            <button type="button" class="filter-btn" data-filter="active" onclick="filterMenu('active', this)">Aktif</button>
            <button type="button" class="filter-btn" data-filter="inactive" onclick="filterMenu('inactive', this)">Nonaktif</button>
            <button type="button" class="filter-btn active" data-filter="all" onclick="filterMenu('all', this)">Semua</button>
        </div>

        <div class="search-filter-wrap">
            <label for="menuSearch">Cari Menu:</label>
            <input type="text" id="menuSearch" class="search-filter-input" placeholder="Masukkan nama menu...">
            <button type="button" class="btn-reset-filter" onclick="resetMenuFilter()">Reset Pencarian</button>
        </div>

        <div class="table-container">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th style="width: 120px;">Status</th>
                        <th style="width: 300px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($menus as $index => $menu)
                    <tr class="menu-row" data-name="{{ strtolower($menu->nama) }}" data-status="{{ $menu->is_available ? 'active' : 'inactive' }}" data-category="{{ $menu->kategori }}">
                        <td data-label="Nama">
                            <div>
                                <strong>{{ $menu->nama }}</strong>
                            </div>
                        </td>
                        <td data-label="Status">
                            @if($menu->is_available == 1)
                            <span class="status-badge status-aktif">Aktif</span>
                            @else
                            <span class="status-badge status-nonaktif">Nonaktif</span>
                            @endif
                        </td>
                        <td data-label="Aksi">
                            <div style="display: flex; gap: 5px; flex-wrap: wrap; justify-content: flex-end;">
                                <button type="button" class="btn-action btn-view shadow-sm btn-view-menu"
                                    data-nama="{{ $menu->nama }}"
                                    data-foto="{{ $menu->foto ? (\Illuminate\Support\Str::startsWith($menu->foto, ['http://', 'https://']) ? $menu->foto : asset('images/' . $menu->foto)) : '' }}"
                                    data-kategori="{{ $menu->kategori }}"
                                    data-harga="Rp {{ number_format($menu->harga, 0, ',', '.') }}"
                                    data-status="{{ $menu->is_available == 1 ? 'Aktif' : 'Nonaktif' }}"
                                    data-deskripsi="{{ str_replace(["\r", "\n"], ' ', e($menu->deskripsi ?? 'Tidak ada deskripsi.')) }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#viewMenuModal" style="margin: 0;">
                                    View
                                </button>

                                <form action="{{ route('admin.menu.update', $menu->id) }}" method="POST" style="display: inline; margin: 0;">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="nama" value="{{ $menu->nama }}">
                                    <input type="hidden" name="kategori" value="{{ $menu->kategori }}">
                                    <input type="hidden" name="harga" value="{{ $menu->harga }}">
                                    <input type="hidden" name="deskripsi" value="{{ $menu->deskripsi }}">
                                    <input type="hidden" name="is_available" value="{{ $menu->is_available ? 0 : 1 }}">
                                    <button type="submit" class="btn-action btn-toggle-status shadow-sm menu-loading-btn" style="margin: 0;">
                                        {{ $menu->is_available == 1 ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>
                                </form>

                                <button type="button" class="btn-action btn-edit shadow-sm" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $menu->id }}" style="margin: 0;">
                                    Edit
                                </button>

                                <form action="{{ route('admin.menu.destroy', $menu->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus menu ini?');" style="display: inline; margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-hapus shadow-sm menu-loading-btn" style="margin: 0;">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr class="empty-row-row">
                        <td colspan="3" class="empty-row-cell" style="padding: 40px; color: #999;">
                            Tidak ada menu tersedia.
                        </td>
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
                            <button type="submit" class="btn-submit menu-loading-btn" data-loading-text="Menyimpan...">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @foreach ($menus as $menu)
        <div class="modal fade" id="modalEdit{{ $menu->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('admin.menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="modal-content">
                        <div class="modal-header">
                            <h5>Edit Menu</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <input type="text" name="nama" class="form-control mb-2" value="{{ $menu->nama }}" required>

                            <select name="kategori" class="form-control mb-2" required>
                                <option value="Makanan" @selected($menu->kategori === 'Makanan')>Makanan</option>
                                <option value="Minuman" @selected($menu->kategori === 'Minuman')>Minuman</option>
                            </select>

                            <input type="text" id="harga_mask_edit_{{ $menu->id }}" class="form-control mb-2 harga-mask"
                                data-target="harga_raw_edit_{{ $menu->id }}" placeholder="Rp.0" required>
                            <input type="hidden" name="harga" id="harga_raw_edit_{{ $menu->id }}" value="{{ $menu->harga }}">

                            <textarea name="deskripsi" class="form-control mb-2">{{ $menu->deskripsi }}</textarea>

                            @if (!empty($menu->foto))
                            @php
                                $previewFotoMenu = \Illuminate\Support\Str::startsWith($menu->foto, ['http://', 'https://'])
                                    ? $menu->foto
                                    : asset('images/' . $menu->foto);
                            @endphp
                            <div class="mb-2">
                                <label class="form-label">Gambar Saat Ini</label>
                                <img src="{{ $previewFotoMenu }}" alt="Preview menu {{ $menu->nama }}"
                                    style="width: 100%; max-height: 180px; object-fit: cover; border-radius: 8px; border: 1px solid #e5e7eb;">
                            </div>
                            @endif

                            <input type="file" name="foto" class="form-control mb-2">

                            <select name="is_available" class="form-control" required>
                                <option value="1" @selected((int) $menu->is_available === 1)>Tersedia</option>
                                <option value="0" @selected((int) $menu->is_available === 0)>Tidak</option>
                            </select>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn-batal" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn-submit menu-loading-btn" data-loading-text="Menyimpan...">Simpan Perubahan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @endforeach

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
                        <button type="button" class="btn-batal" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn-submit menu-loading-btn" id="btnKonfirmasiAksi">Ya, Lanjutkan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal View Menu --}}
    <div class="modal fade" id="viewMenuModal" tabindex="-1" aria-labelledby="viewMenuModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow" style="border-radius: 12px; animation: slideDown 0.3s ease-out;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title" style="font-size: 18px; color: #2C3E50; font-weight: bold;" id="viewMenuModalLabel">
                        Detail Menu
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>

                <div class="modal-body">
                    <img id="detailImg" src="" alt="Menu Image" style="width: 100%; border-radius: 8px; margin-bottom: 16px; object-fit: cover; display: none;">
                    <h6 id="detailNama" style="font-size: 16px; font-weight: bold; margin-bottom: 8px;"></h6>
                    <div style="margin-bottom: 8px;"><strong>Kategori:</strong> <span id="detailKategori"></span></div>
                    <div style="margin-bottom: 8px;"><strong>Harga:</strong> <span id="detailHarga"></span></div>
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
                let visibleCount = 0;
                menuRows.forEach((row) => {
                    const rowStatus = row.dataset.status;
                    const statusMatch = selectedStatus === 'all' || selectedStatus === rowStatus;

                    const titleElement = row.querySelector('td[data-label="Nama"]');
                    const rowName = titleElement ? titleElement.textContent.toLowerCase() : '';

                    const searchMatch = !query || rowName.includes(query);

                    if (statusMatch && searchMatch) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                const emptyRow = document.querySelector('.empty-row-row');
                if (emptyRow) {
                    if (visibleCount === 0 && menuRows.length > 0) {
                        emptyRow.style.display = '';
                        emptyRow.querySelector('td').innerHTML = 'Tidak ada menu yang cocok dengan filter.';
                    } else if (menuRows.length === 0) {
                        emptyRow.style.display = '';
                        emptyRow.querySelector('td').innerHTML = 'Tidak ada menu tersedia.';
                    } else {
                        emptyRow.style.display = 'none';
                    }
                }
            }

            window.filterMenu = function(status, buttonElement) {
                selectedStatus = status;

                document.querySelectorAll('.filter-btn').forEach(btn => {
                    btn.classList.remove('active');
                });
                buttonElement.classList.add('active');

                updateMenuVisibility();
            };

            window.resetMenuFilter = function() {
                if (menuSearchInput) {
                    menuSearchInput.value = '';
                    searchQuery = '';
                    updateMenuVisibility();
                }
            };

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

            const detailImg = document.getElementById('detailImg');
            const detailNama = document.getElementById('detailNama');
            const detailKategori = document.getElementById('detailKategori');
            const detailHarga = document.getElementById('detailHarga');
            const detailStatus = document.getElementById('detailStatus');
            const detailDeskripsi = document.getElementById('detailDeskripsi');

            document.querySelectorAll('.btn-view-menu').forEach((button) => {
                button.addEventListener('click', function() {
                    detailNama.textContent = this.dataset.nama;
                    detailKategori.textContent = this.dataset.kategori;
                    detailHarga.textContent = this.dataset.harga;
                    detailStatus.textContent = this.dataset.status;
                    detailDeskripsi.textContent = this.dataset.deskripsi;

                    if (this.dataset.foto) {
                        detailImg.src = this.dataset.foto;
                        detailImg.style.display = 'block';
                    } else {
                        detailImg.style.display = 'none';
                    }
                });
            });
        });
    </script>
    @endpush
    @endsection
