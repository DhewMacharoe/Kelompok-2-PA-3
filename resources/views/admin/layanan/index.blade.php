@extends('admin.layouts.app')

@section('title', 'Layanan')

@section('header_title')
    <div class="header-title">Layanan</div>
@endsection

@section('content')
<style>
    /* CSS Khusus Halaman Ini */
    .main-container {
        padding: 20px;
        font-family: 'Inter', sans-serif;
        max-width: 1180px;
        margin: 0 auto;
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
        margin: 0;
        font-weight: 500;
        cursor: pointer;
    }

    /* Styling Tabel */
    .table-container {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }
    .custom-table {
        width: 100%;
        border-collapse: collapse;
        text-align: center;
    }
    .custom-table thead {
        background-color: #2C3E50;
        color: white;
    }
    .custom-table th, .custom-table td {
        padding: 15px;
        border-bottom: 1px solid #eee;
    }

    /* Status Badge */
    .status-text { font-weight: 500; }
    .action-link { color: #4a80da; text-decoration: none; font-weight: 600; }

    /* Badge */
    .badge-active { background-color: #4CC779; color: white; padding: 5px 10px; border-radius: 4px; }
    .badge-inactive { background-color: #EB5757; color: white; padding: 5px 10px; border-radius: 4px; }

    .table-thumb { width: 50px; height: 50px; object-fit: cover; border-radius: 4px; }
    .action-buttons { display: flex; gap: 10px; justify-content: center; }
    .btn { padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; }
    .btn-primary { background-color: #2F80ED; color: white; }
    .btn-secondary { background-color: #7B7F88; color: white; }
    .btn-warning { background-color: #F39C12; color: white; }
    .btn-success { background-color: #4CC779; color: white; }
    .btn-danger { background-color: #EB5757; color: white; }
    .empty-row { padding: 40px; color: #999; }

    .detail-modal {
        display: none;
        position: fixed;
        inset: 0;
        background-color: rgba(0,0,0,0.6);
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
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
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
    .detail-modal-item strong { color: #2C3E50; }
    .detail-modal-desc {
        padding: 16px;
        border-radius: 12px;
        background-color: #f9fbff;
        border: 1px solid #e7ecf6;
        color: #556673;
        line-height: 1.7;
    }
</style>

<div class="main-container">
    @if(session('success'))
        <div style="background-color: #4CC779; color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display: flex; flex-wrap: wrap; gap: 12px; align-items: flex-end; justify-content: space-between; margin-bottom: 8px;">
        <div style="display: flex; flex-wrap: wrap; gap: 12px; align-items: flex-end; flex: 1; min-width: 320px;">
            <div>
                <label for="categoryFilter" style="font-weight: 600; color: #2C3E50; display:block; margin-bottom:6px;">Kategori</label>
                <select id="categoryFilter" style="padding: 10px 12px; border-radius: 8px; border: 1px solid #ddd; min-width: 160px;">
                    <option value="" {{ empty($category) ? 'selected' : '' }}>Semua</option>
                    <option value="barber" {{ ($category ?? '') === 'barber' ? 'selected' : '' }}>Barber</option>
                    <option value="kafe" {{ ($category ?? '') === 'kafe' ? 'selected' : '' }}>Kafe</option>
                </select>
            </div>
            <div>
                <label for="statusFilter" style="font-weight: 600; color: #2C3E50; display:block; margin-bottom:6px;">Status</label>
                <select id="statusFilter" style="padding: 10px 12px; border-radius: 8px; border: 1px solid #ddd; min-width: 160px;">
                    <option value="" {{ empty($status) ? 'selected' : '' }}>Semua</option>
                    <option value="aktif" {{ ($status ?? '') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ ($status ?? '') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <div style="min-width: 240px; flex: 1;">
                <label for="searchInput" style="font-weight: 600; color: #2C3E50; display:block; margin-bottom:6px;">Cari Layanan</label>
                <input id="searchInput" type="text" placeholder="Ketik nama layanan..." style="width:100%; padding: 10px 12px; border-radius: 8px; border: 1px solid #ddd;">
            </div>
        </div>

        <div style="display: flex; align-items: flex-end;">
            <a href="{{ route('admin.layanan.create') }}" class="btn-tambah shadow-sm" style="white-space: nowrap;">
                + Tambah
            </a>
        </div>
    </div>

    <div id="searchSuggestion" style="margin-bottom: 16px; color: #4d648d; font-size: 0.95rem;"></div>

    <div class="table-container">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($layanans as $item)
                    <tr data-name="{{ strtolower($item->nama) }}" data-category="{{ strtolower($item->kategori) }}" data-status="{{ $item->is_active ? 'aktif' : 'nonaktif' }}" data-description="{{ strtolower($item->deskripsi ?? '') }}">
                        <td>{{ $item->nama }}</td>
                        <td>{{ ucfirst($item->kategori) }}</td>
                        <td>
                            @if($item->is_active)
                                <span class="badge badge-active">Aktif</span>
                            @else
                                <span class="badge badge-inactive">Nonaktif</span>
                            @endif
                        </td>
                        <td class="action-buttons">
                            <button type="button" class="btn btn-secondary btn-sm btn-view"
                                data-nama="{{ $item->nama }}"
                                data-foto="{{ $item->foto ? asset('storage/' . $item->foto) : '' }}"
                                data-kategori="{{ ucfirst($item->kategori) }}"
                                data-harga="Rp {{ number_format($item->harga, 0, ',', '.') }}"
                                data-estimasi="{{ $item->estimasi_waktu ?? '-' }}"
                                data-status="{{ $item->is_active ? 'Aktif' : 'Nonaktif' }}"
                                data-deskripsi="{{ str_replace(["\r", "\n"], ' ', e($item->deskripsi ?? 'Tidak ada deskripsi tambahan.')) }}"
                            >View</button>
                            <form action="{{ route('admin.layanan.toggleStatus', $item->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn {{ $item->is_active ? 'btn-warning' : 'btn-success' }} btn-sm">
                                    {{ $item->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>
                            <a href="{{ route('admin.layanan.edit', $item->id) }}" class="btn btn-primary btn-sm">Edit</a>

                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="{{ $item->id }}" data-nama="{{ $item->nama }}">Hapus</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="empty-row">Belum ada data layanan.</td>
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

        <div id="detailImg" class="detail-modal-img">Tidak ada gambar</div>

        <div class="detail-modal-body">
            <div class="detail-modal-item">
                <strong>Kategori</strong>
                <span id="detailKategori">-</span>
            </div>
            <div class="detail-modal-item">
                <strong>Harga</strong>
                <span id="detailHarga">-</span>
            </div>
            <div class="detail-modal-item">
                <strong>Estimasi Waktu</strong>
                <span id="detailEstimasi">-</span>
            </div>
            <div class="detail-modal-item">
                <strong>Status</strong>
                <span id="detailStatus">-</span>
            </div>
            <div class="detail-modal-desc">
                <strong>Deskripsi:</strong>
                <p id="detailDeskripsi" style="margin-top: 8px;">-</p>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus layanan "<strong id="deleteServiceName"></strong>"?</p>
                <p class="text-muted">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('detailModal');
    const detailImg = document.getElementById('detailImg');
    const detailNama = document.getElementById('detailNama');
    const detailKategori = document.getElementById('detailKategori');
    const detailHarga = document.getElementById('detailHarga');
    const detailEstimasi = document.getElementById('detailEstimasi');
    const detailStatus = document.getElementById('detailStatus');
    const detailDeskripsi = document.getElementById('detailDeskripsi');
    const detailClose = document.getElementById('detailClose');

    document.querySelectorAll('.btn-view').forEach(button => {
        button.addEventListener('click', () => {
            detailNama.textContent = button.dataset.nama;
            detailKategori.textContent = button.dataset.kategori;
            detailHarga.textContent = button.dataset.harga;
            detailEstimasi.textContent = button.dataset.estimasi;
            detailStatus.textContent = button.dataset.status;
            detailDeskripsi.textContent = button.dataset.deskripsi;

            if (button.dataset.foto) {
                detailImg.style.backgroundImage = `url(${button.dataset.foto})`;
                detailImg.textContent = '';
            } else {
                detailImg.style.backgroundImage = 'none';
                detailImg.textContent = 'Tidak ada gambar';
            }

            modal.classList.add('show');
        });
    });

    detailClose.addEventListener('click', () => {
        modal.classList.remove('show');
    });

    modal.addEventListener('click', event => {
        if (event.target === modal) {
            modal.classList.remove('show');
        }
    });

    // Delete Modal Handling
    const deleteModalEl = document.getElementById('deleteModal');
    const deleteServiceName = document.getElementById('deleteServiceName');
    const deleteForm = document.getElementById('deleteForm');

    deleteModalEl.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const serviceId = button.getAttribute('data-id');
        const serviceName = button.getAttribute('data-nama');

        deleteServiceName.textContent = serviceName;
        deleteForm.action = `/admin/layanan/${serviceId}`;
    });

    const categoryFilter = document.getElementById('categoryFilter');
    const statusFilter = document.getElementById('statusFilter');
    const searchInput = document.getElementById('searchInput');
    const suggestionBox = document.getElementById('searchSuggestion');
    const rows = Array.from(document.querySelectorAll('tbody tr'));

    function levenshtein(a, b) {
        const matrix = Array.from({ length: b.length + 1 }, () => []);
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
        const category = row.dataset.category;
        const description = row.dataset.description;

        if (!query) return true;

        if (name.includes(query) || category.includes(query) || description.includes(query)) {
            return true;
        }

        if (query.length <= 2) {
            return name.startsWith(query) || category.startsWith(query);
        }

        const fields = [name, category, description];
        return fields.some(field => {
            const score = similarity(field, query);
            return score >= 0.72;
        });
    }

    function updateSuggestion(query) {
        if (!query) {
            suggestionBox.textContent = '';
            return;
        }

        const scores = rows.map(row => {
            const name = row.dataset.name;
            return { name, score: similarity(name, query) };
        }).filter(item => item.score > 0.35)
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
        const category = categoryFilter.value.toLowerCase();
        const status = statusFilter.value.toLowerCase();
        const query = searchInput.value.trim().toLowerCase();
        let visibleCount = 0;

        rows.forEach(row => {
            const matchesCategory = !category || row.dataset.category === category;
            const matchesStatus = !status || row.dataset.status === status;
            const matchesSearch = doesMatch(row, query);
            const visible = matchesCategory && matchesStatus && matchesSearch;
            row.style.display = visible ? '' : 'none';
            if (visible) visibleCount++;
        });

        updateSuggestion(query);

        if (!query) {
            suggestionBox.textContent = '';
        }
    }

    [categoryFilter, statusFilter, searchInput].forEach(element => {
        element.addEventListener('input', filterRows);
        element.addEventListener('change', filterRows);
    });
</script>

<div style="height:50px;"></div>
@endsection