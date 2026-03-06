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
