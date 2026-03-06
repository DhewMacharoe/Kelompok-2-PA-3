@extends('layouts.admin')

@section('title', 'Kelola Layanan')
@section('header_title', 'Kelola Layanan')

@section('content')
    <div class="summary-grid">
        <div class="summary-card">
            <div class="s-label">Total Layanan</div>
            <div class="s-value">5</div>
        </div>
        <div class="summary-card">
            <div class="s-label">✅ Aktif</div>
            <div class="s-value" style="color:var(--success-text);">4</div>
        </div>
        <div class="summary-card">
            <div class="s-label">⛔ Nonaktif</div>
            <div class="s-value" style="color:var(--text-muted);">1</div>
        </div>
        <div class="summary-card">
            <div class="s-label">Kategori</div>
            <div class="s-value">2</div>
        </div>
    </div>

    <div class="filter-bar">
        <button class="filter-chip active">Semua</button>
        <button class="filter-chip">✅ Aktif</button>
        <button class="filter-chip">⛔ Nonaktif</button>
    </div>

    <div class="section-label">Daftar Layanan</div>

    <div class="card-list">
        <div class="card">
            <div class="card-body">
                <div class="card-row">
                    <div class="card-img">FOTO</div>
                    <div class="card-info">
                        <div class="card-title">Potong Rambut</div>
                        <div class="card-meta"><span>⏱ ±30 menit</span><span class="card-price">Rp 35.000</span></div>
                        <div class="card-meta" style="margin-top:4px;">
                            <span class="badge badge-available">✅ Aktif</span>
                            <span style="font-size:11px; color:var(--text-muted);">Rambut</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-actions">
                <a href="{{ url('admin/tambah-layanan') }}" class="btn btn-sm btn-secondary">✏ Edit</a>
                <button class="btn btn-sm btn-danger">⛔ Nonaktifkan</button>
            </div>
        </div>
    </div>

    <div style="height:100px;"></div>

    <div class="action-bar">
        <a href="{{ url('admin/tambah-layanan') }}" class="btn btn-primary">+ Tambah Layanan Baru</a>
    </div>
@endsection
