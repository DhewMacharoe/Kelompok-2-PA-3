@extends('admin.layouts.app')

@section('title', 'Riwayat & Kelola Antrian')

@section('header_title')
    <div class="header-title">Riwayat Antrian</div>
@endsection

@section('content')
<style>
    /* CSS Khusus Halaman Ini */
    .main-container {
        padding: 20px;
        font-family: 'Inter', sans-serif;
    }

    /* Penampil Antrean Utama (Top Card) */
    .serving-display {
        background-color: #2C3E50;
        color: white;
        text-align: center;
        padding: 40px 20px;
        border-radius: 20px;
        margin-bottom: 24px;
    }
    .serving-display p { margin: 0; opacity: 0.8; font-size: 14px; }
    .serving-display .queue-number-big {
        font-size: 80px;
        font-weight: bold;
        margin: 10px 0;
        display: block;
    }
    .btn-group-serving {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 20px;
    }
    .btn-panggil { background-color: #2F80ED; color: white; border: none; padding: 10px 30px; border-radius: 8px; }
    .btn-batal { background-color: #EB5757; color: white; border: none; padding: 10px 30px; border-radius: 8px; }

    /* Tombol Tambah */
    .btn-tambah {
        background-color: #4CC779;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        display: inline-block;
        margin-bottom: 20px;
        font-weight: 500;
    }

    /* Styling Tabel */
    .table-container {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }
    .custom-table {
        width: 100%;
        border-collapse: collapse;
        text-align: center;
    }
    .custom-table thead {
        background-color: #2C3E50;
        color: white;
    }
    .custom-table th, .custom-table td {
        padding: 15px;
        border-bottom: 1px solid #eee;
    }
    .row-highlight {
        background-color: #2196F3 !important;
        color: white !important;
    }
    .row-highlight td { border-color: transparent; }

    /* Status Badge */
    .status-text { font-weight: 500; }
    .action-link { color: #4a80da; text-decoration: none; font-weight: 600; }
</style>

<div class="main-container">

    @php
        $current = $antrians->where('status', 'sedang dilayani')->first();
    @endphp

    <div class="serving-display">
        <p>Sedang dilayani</p>
        <span class="queue-number-big">{{ $current->nomor_antrian ?? '--' }}</span>
        <p style="font-size: 18px; font-weight: 500;">{{ $current->nama_pelanggan ?? 'Tidak ada antrean' }}</p>
        <div class="btn-group-serving">
            <button class="btn-panggil shadow-sm">Panggil</button>
            <button class="btn-batal shadow-sm">Batalkan</button>
        </div>
    </div>

    <a href="{{ route('admin.tambah-pelanggan') }}" class="btn-tambah shadow-sm">
        + Tambah
    </a>

    <div class="table-container">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Nomor Antrean</th>
                    <th>Nama</th>
                    <th>Masuk</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($antrians as $item)
                    <tr class="{{ $item->status == 'sedang dilayani' ? 'row-highlight' : '' }}">
                        <td>{{ $item->nomor_antrian }}</td>
                        <td>{{ $item->nama_pelanggan }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->waktu_masuk)->format('Y-m-d H:i:s') }}</td>
                        <td>
                            <span class="status-text">
                                {{ ucfirst($item->status == 'sedang dilayani' ? 'Dilayani' : $item->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="#" class="action-link" style="{{ $item->status == 'sedang dilayani' ? 'color:white;' : '' }}">Action</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding: 40px; color: #999;">Belum ada riwayat antrian yang tercatat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div style="height:50px;"></div>
@endsection
