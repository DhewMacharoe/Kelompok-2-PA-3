@extends('layouts.admin')

@section('title', 'Kelola Menu Kafe')
@section('header_title', 'Kelola Menu Kafe')

@section('content')
    <div class="summary-grid">
        <div class="summary-card">
            <div class="s-label">🍽 Total Menu</div>
            <div class="s-value">8</div>
        </div>
        <div class="summary-card">
            <div class="s-label">✅ Tersedia</div>
            <div class="s-value" style="color:var(--success-text);">6</div>
        </div>
        <div class="summary-card">
            <div class="s-label">❌ Habis</div>
            <div class="s-value" style="color:var(--error-text);">2</div>
        </div>
        <div class="summary-card">
            <div class="s-label">📂 Kategori</div>
            <div class="s-value">3</div>
        </div>
    </div>

    <div class="filter-bar">
        <button class="filter-chip active">Semua</button>
        <button class="filter-chip">☕ Minuman</button>
        <button class="filter-chip">🍞 Makanan</button>
    </div>

    <div class="section-label">Daftar Menu</div>

    <div class="card-list">
        <div class="card">
            <div class="card-body">
                <div class="card-row">
                    <div class="card-img">FOTO<br>MENU</div>
                    <div class="card-info">
                        <div class="card-title">Kopi Hitam</div>
                        <div class="card-desc">Kopi robusta lokal pilihan</div>
                        <div class="card-meta">
                            <span class="card-price">Rp 12.000</span>
                            <span class="badge badge-available">✅ Tersedia</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-actions">
                <a href="{{ url('admin/tambah-menu') }}" class="btn btn-sm btn-secondary">✏ Edit</a>
                <button class="btn btn-sm btn-danger" onclick="showHapus('Kopi Hitam')">🗑 Hapus</button>
            </div>
        </div>
    </div>

    <div style="height:100px;"></div>

    <div class="action-bar">
        <a href="{{ url('admin/tambah-menu') }}" class="btn btn-primary">+ Tambah Menu Baru</a>
    </div>

    <div class="modal-overlay" id="modal-hapus" style="display:none;">
        <div class="modal">
            <div class="modal-title">Hapus menu ini?</div>
            <div class="modal-body">
                <strong id="hapus-nama">Kopi Hitam</strong><br>
                Tindakan ini tidak bisa dibatalkan.
            </div>
            <div class="modal-actions">
                <button class="btn btn-danger btn-sm" onclick="hideHapus()">🗑 Hapus</button>
                <button class="btn btn-secondary btn-sm" onclick="hideHapus()">Batal</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function showHapus(nama) {
            document.getElementById('hapus-nama').textContent = nama;
            document.getElementById('modal-hapus').style.display = 'flex';
        }

        function hideHapus() {
            document.getElementById('modal-hapus').style.display = 'none';
        }
    </script>
@endpush
