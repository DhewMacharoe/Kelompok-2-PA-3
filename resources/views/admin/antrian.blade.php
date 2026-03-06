@extends('layouts.admin')

@section('title', 'Kelola Antrian')
@section('header_title', 'Kelola Antrian')

@section('content')
    <section class="hero" style="padding:16px;">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <div>
                <div class="hero-label">Sedang Dilayani</div>
                <div style="font-size:32px; font-weight:700; color:#fff; font-family:var(--font-mono);">No. 05</div>
            </div>
            <div style="text-align:right;">
                <div style="font-size:11px; color:rgba(255,255,255,0.5); text-transform:uppercase; letter-spacing:0.06em;">
                    Menunggu</div>
                <div style="font-size:28px; font-weight:700; color:#fff;">3</div>
                <div style="font-size:11px; color:rgba(255,255,255,0.5);">Selesai hari ini: 8</div>
            </div>
        </div>
    </section>

    <div class="filter-bar">
        <button class="filter-chip active">Semua</button>
        <button class="filter-chip">Menunggu</button>
        <button class="filter-chip">Dipanggil</button>
        <button class="filter-chip">Selesai</button>
    </div>

    <div class="section-label">Daftar Antrian Hari Ini</div>

    <div class="action-bar">
        <a href="{{ url('admin/tambah-pelanggan') }}" class="btn btn-primary">+ Tambah Pelanggan</a>
    </div>

    <div class="modal-overlay" id="modal-selesai" style="display:none;">
        <div class="modal">
            <div class="modal-title">Tandai Selesai?</div>
            <div class="modal-body">
                <strong>No. 05 — Budi Santoso</strong><br>
                Tindakan ini tidak bisa dibatalkan.
            </div>
            <div class="modal-actions">
                <button class="btn btn-primary btn-sm" onclick="hideModal()">✓ Selesai</button>
                <button class="btn btn-secondary btn-sm" onclick="hideModal()">Batal</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function showStatusModal() {
            document.getElementById('modal-selesai').style.display = 'flex';
        }

        function hideModal() {
            document.getElementById('modal-selesai').style.display = 'none';
        }
    </script>
@endpush
