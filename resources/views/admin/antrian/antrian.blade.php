@extends('layouts.admin')

@section('title', 'Riwayat & Kelola Antrian')

@section('header_title')
    <div class="header-title">Riwayat Antrian</div>
    <div style="width:64px;"></div>
@endsection

@section('content')
    <div class="section-label" style="padding-top: 24px;">Semua Riwayat Antrian</div>

    <div class="card-list">
        @forelse($antrians as $item)
            <div class="queue-card">
                <div class="queue-number" style="font-size:18px; width:40px; height:40px;">{{ $item->nomor_antrian }}</div>
                <div class="queue-info">
                    <div class="queue-name">{{ $item->nama_pelanggan }}</div>
                    <div class="queue-time">
                        Masuk: {{ \Carbon\Carbon::parse($item->waktu_masuk)->format('d M Y, H:i') }}
                    </div>
                </div>
                <div class="queue-badge">
                    @if ($item->status == 'menunggu')
                        <span class="badge" style="background:rgba(229,169,60,0.2); color:var(--accent);">Menunggu</span>
                    @elseif($item->status == 'sedang dilayani')
                        <span class="badge" style="background:rgba(255,76,76,0.2); color:var(--danger);">Dilayani</span>
                    @elseif($item->status == 'selesai')
                        <span class="badge" style="background:rgba(76,175,80,0.2); color:#4CAF50;">Selesai</span>
                    @elseif($item->status == 'batal')
                        <span class="badge" style="background:rgba(255,255,255,0.1); color:var(--text-muted);">Batal</span>
                    @endif
                </div>
            </div>
        @empty
            <div style="text-align:center; padding:30px 20px; color:var(--text-muted);">
                Belum ada riwayat antrian yang tercatat.
            </div>
        @endforelse
    </div>

    <div style="height:100px;"></div>
    <div style="height:100px;"></div>

    <div class="action-bar"
        style="position:fixed; bottom:0; width:100%; max-width:480px; background:var(--bg-main); padding:16px; border-top:1px solid var(--border-light); z-index:10;">
        <a href="{{ route('admin.tambah-pelanggan') }}" class="btn btn-secondary"
            style="width:100%; display:block; text-align:center; padding:14px; border:1px solid var(--border-light); border-radius:8px;">+
            Tambah Pelanggan Baru</a>
    </div>
@endsection
