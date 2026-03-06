@extends('layouts.admin')

@section('title', 'Kelola Galeri Gaya Rambut')
@section('header_title', 'Kelola Galeri')

@section('content')
    <div class="summary-grid">
        <div class="summary-card">
            <div class="s-label">💈 Total Gaya</div>
            <div class="s-value">12</div>
        </div>
        <div class="summary-card">
            <div class="s-label">✅ Aktif</div>
            <div class="s-value" style="color:var(--success-text);">10</div>
        </div>
        <div class="summary-card">
            <div class="s-label">⛔ Nonaktif</div>
            <div class="s-value" style="color:var(--text-muted);">2</div>
        </div>
        <div class="summary-card">
            <div class="s-label">Bentuk Wajah</div>
            <div class="s-value">4</div>
        </div>
    </div>

    <div class="filter-bar">
        <button class="filter-chip active">Semua</button>
        <button class="filter-chip">Oval</button>
        <button class="filter-chip">Bulat</button>
        <button class="filter-chip">Persegi</button>
        <button class="filter-chip">Lonjong</button>
    </div>

    <div class="section-label">Daftar Gaya Rambut</div>

    <div class="gallery-grid">
        <div class="gallery-item">
            <div class="gallery-photo">FOTO<br>UNDERCUT</div>
            <div class="gallery-info">
                <div class="gallery-name">Undercut</div>
                <div class="gallery-tag">Oval, Persegi</div>
                <div style="margin-top:4px;"><span class="badge badge-available" style="font-size:9px;">✅ Aktif</span></div>
            </div>
            <div class="gallery-actions">
                <a href="{{ url('admin/tambah-gaya') }}" class="btn btn-sm btn-secondary"
                    style="flex:1; font-size:10px; padding:5px 8px;">✏ Edit</a>
                <button class="btn btn-sm btn-danger" style="flex:1; font-size:10px; padding:5px 8px;"
                    onclick="showHapus('Undercut')">🗑</button>
            </div>
        </div>
    </div>

    <div style="height:100px;"></div>

    <div class="action-bar">
        <a href="{{ url('admin/tambah-gaya') }}" class="btn btn-primary">+ Tambah Gaya Rambut</a>
    </div>

    <div class="modal-overlay" id="modal-hapus" style="display:none;">
        <div class="modal">
            <div class="modal-title">Hapus gaya rambut ini?</div>
            <div class="modal-body"><strong id="hapus-nama"></strong><br>Tindakan ini tidak bisa dibatalkan.</div>
            <div class="modal-actions">
                <button class="btn btn-danger btn-sm" onclick="hideHapus()">🗑 Hapus</button>
                <button class="btn btn-secondary btn-sm" onclick="hideHapus()">Batal</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function showHapus(n) {
            document.getElementById('hapus-nama').textContent = n;
            document.getElementById('modal-hapus').style.display = 'flex';
        }

        function hideHapus() {
            document.getElementById('modal-hapus').style.display = 'none';
        }
    </script>
@endpush
