@extends('layouts.admin')

@section('title', 'Rekap Operasional')
@section('header_title', 'Rekap Operasional')

@section('content')
    <div class="filter-bar">
        <button class="filter-chip active" onclick="setPeriode('hari', this)">Hari Ini</button>
        <button class="filter-chip" onclick="setPeriode('minggu', this)">Minggu Ini</button>
        <button class="filter-chip" onclick="setPeriode('bulan', this)">Bulan Ini</button>
    </div>

    <section class="hero" style="padding:20px 16px;">
        <div class="hero-label" id="rekap-label">Hari Ini — Selasa, 3 Mar 2026</div>
        <div class="summary-grid" style="padding:12px 0 0; background:transparent;">
        </div>
    </section>

    <div class="section-label">📅 Riwayat Harian</div>

    <div class="card-list">
        <div class="recap-row" style="border-color:var(--border); border-width:2px;">
            <div>
                <div class="recap-date">Sel, 3 Mar 2026</div>
                <div class="recap-meta" style="color:var(--accent-gold);">(Hari ini)</div>
            </div>
            <div class="recap-value">
                <div>12 orang</div>
                <div class="recap-trend trend-up">↑ +2</div>
                <div style="font-size:11px; color:var(--text-muted);">avg 46 mnt</div>
            </div>
        </div>
    </div>

    <div style="padding:16px;">
        <button class="btn btn-secondary">📥 Export Rekap</button>
    </div>
    <div style="height:24px;"></div>
@endsection

@push('scripts')
    <script>
        const data = {
            hari: {
                label: 'Hari Ini — Selasa, 3 Mar 2026',
                pelanggan: '12',
                trend: '<span class="trend-up">↑ +2 vs kemarin</span>',
                rata: '46',
                selesai: '11',
                lewati: '1'
            },
            minggu: {
                label: 'Minggu Ini — 24 Feb s/d 3 Mar 2026',
                pelanggan: '67',
                trend: '<span class="trend-down">↓ -5 vs minggu lalu</span>',
                rata: '48',
                selesai: '62',
                lewati: '5'
            },
            bulan: {
                label: 'Maret 2026 (1–3 Mar)',
                pelanggan: '37',
                trend: '<span style="color:var(--text-muted);">Berjalan...</span>',
                rata: '47',
                selesai: '34',
                lewati: '3'
            }
        };

        function setPeriode(key, btn) {
            document.querySelectorAll('.filter-chip').forEach(c => c.classList.remove('active'));
            btn.classList.add('active');
            const d = data[key];
            document.getElementById('rekap-label').textContent = d.label;
            // Sisanya sama seperti file JS asli
        }
    </script>
@endpush
