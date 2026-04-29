@extends('layouts.admin')

@section('title', 'Tambah Menu')
@section('header_title', 'Tambah Menu Baru')

@section('content')
    <div style="display:flex; gap:8px; padding:8px 16px; background:var(--bg); border-bottom:1px solid var(--border-light);">
        <button class="btn btn-sm btn-primary" onclick="setMode('tambah')">Mode: Tambah</button>
        <button class="btn btn-sm btn-secondary" onclick="setMode('edit')">Mode: Edit</button>
    </div>

    <div class="main-content">
        <div style="padding:16px;">
            <div class="upload-area" id="upload-area">
                <div class="upload-icon">📷</div>
                <div class="upload-label">Upload Foto Menu</div>
                <div class="upload-hint">(opsional)</div>
            </div>
        </div>

        <div class="error-banner" id="form-error" style="display:none;">
            ⚠ <span id="error-detail">Field wajib belum diisi. Periksa form.</span>
        </div>

        <div class="form-section">
            <form id="menu-form" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="nama">Nama Menu</label>
                    <input type="text" id="nama" name="nama" required>
                </div>
                <div class="form-group">
                    <label for="kategori">Kategori</label>
                    <select id="kategori" name="kategori" required>
                        <option value="">Pilih Kategori</option>
                        <option value="makanan">Makanan</option>
                        <option value="minuman">Minuman</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="harga">Harga</label>
                    <input type="number" id="harga" name="harga" required>
                </div>
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi"></textarea>
                </div>
                <div class="form-group">
                    <label for="foto">Foto (URL atau Upload)</label>
                    <input type="text" id="foto" name="foto" placeholder="URL gambar atau biarkan kosong untuk upload">
                    <input type="file" id="foto_file" name="foto_file" accept="image/*">
                </div>
                <div class="form-group">
                    <label for="is_available">Tersedia</label>
                    <input type="checkbox" id="is_available" name="is_available" value="1" checked>
                </div>
            </form>
        </div>
        <div style="height:100px;"></div>
    </div>

    <div class="action-bar">
        <button class="btn btn-primary" id="btn-simpan" onclick="simpan()">✓ SIMPAN MENU</button>
        <button class="btn btn-secondary" onclick="history.back()">Batal</button>
    </div>
@endsection

@push('scripts')
    <script>
        // Redirect di dalam js simpan():
        // window.location.href = '{{ url('admin/menu') }}';
    </script>
@endpush
