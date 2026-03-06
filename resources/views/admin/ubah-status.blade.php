@extends('layouts.admin')

@section('title', 'Detail Antrian')
@section('header_title', 'Detail Antrian')

@section('content')
    <div
        style="display:flex; gap:8px; padding:8px 16px; background:var(--bg); border-bottom:1px solid var(--border-light); overflow-x:auto;">
        <button class="btn btn-sm btn-primary" onclick="setStatus('menunggu')">Menunggu</button>
        <button class="btn btn-sm btn-secondary" onclick="setStatus('dipanggil')">Dipanggil</button>
        <button class="btn btn-sm btn-secondary" onclick="setStatus('selesai')">Selesai</button>
    </div>

    <div class="main-content">
        <section class="hero" style="padding:20px 16px;">
            <div style="display:flex; align-items:center; gap:16px;">
                <div
                    style="width:56px; height:56px; border:2px solid var(--accent-gold); display:flex; align-items:center; justify-content:center; font-size:24px; font-weight:700; color:#fff; flex-shrink:0; border-radius:var(--radius-md);">
                    06</div>
                <div style="flex:1;">
                    <div id="status-badge-area"><span class="badge badge-waiting">Menunggu</span></div>
                    <div style="font-size:18px; font-weight:700; color:#fff; margin:4px 0;">Andi Wijaya</div>
                    <div style="font-size:11px; color:rgba(255,255,255,0.5);">Masuk antrian: 09.45 WIB</div>
                </div>
            </div>
        </section>

        <div class="section-label">Riwayat Status</div>
        <div class="timeline">
        </div>

        <div class="context-banner" id="context-banner">
            Status saat ini: <strong>MENUNGGU</strong> — Tekan "Panggil" untuk memanggil pelanggan ini.
        </div>
        <div style="height:100px;"></div>
    </div>

    <div class="action-bar" id="action-area">
        <button class="btn btn-primary">📢 PANGGIL PELANGGAN</button>
        <button class="btn btn-secondary">Lewati</button>
    </div>

    <div class="modal-overlay" id="modal-confirm" style="display:none;">
        <div class="modal">
            <div class="modal-title" id="modal-title">Konfirmasi</div>
            <div class="modal-body" id="modal-body">Apakah Anda yakin?</div>
            <div class="modal-actions">
                <button class="btn btn-primary btn-sm" onclick="hideModal()">Ya, Lanjutkan</button>
                <button class="btn btn-secondary btn-sm" onclick="hideModal()">Batal</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Di fungsi setStatus(status), ubah link kembali:
        // action.innerHTML = '<a href="{{ url('admin/antrian') }}" class="btn btn-secondary">← Kembali ke Daftar Antrian</a>';
    </script>
@endpush
