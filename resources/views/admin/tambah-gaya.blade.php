@extends('layouts.admin')

@section('title', 'Tambah Gaya Rambut')
@section('header_title', 'Tambah Gaya Rambut')

@section('content')
    <div style="display:flex; gap:8px; padding:8px 16px; background:var(--bg); border-bottom:1px solid var(--border-light);">
        <button class="btn btn-sm btn-primary" onclick="setMode('tambah')">Mode: Tambah</button>
        <button class="btn btn-sm btn-secondary" onclick="setMode('edit')">Mode: Edit</button>
    </div>

    <div class="main-content">
        <div style="padding:16px;">
            <div class="upload-area" id="upload-area">
                <div class="upload-icon">📷</div>
                <div class="upload-label">Upload Foto Gaya Rambut</div>
                <div class="upload-hint" style="color:var(--error-text); font-weight:700;">(wajib)</div>
            </div>
        </div>

        <div class="error-banner" id="form-error" style="display:none;">
            ⚠ <span id="error-detail">Field wajib belum diisi.</span>
        </div>

        <div class="form-section">
        </div>
        <div style="height:100px;"></div>
    </div>

    <div class="action-bar">
        <button class="btn btn-primary" id="btn-simpan" onclick="simpan()">✓ SIMPAN GAYA RAMBUT</button>
        <button class="btn btn-secondary" onclick="history.back()">Batal</button>
    </div>
@endsection

@push('scripts')
    <script>
        // Fungsi setMode dan simpan diletakkan di sini, 
        // pastikan baris redirect diubah menjadi:
        // window.location.href = '{{ url('admin/galeri') }}';
    </script>
@endpush
