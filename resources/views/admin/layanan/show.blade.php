@extends('admin.layouts.app')

@section('title', 'Detail Layanan')

@section('header_title')
    <div class="header-title">Detail Layanan</div>
@endsection

@section('content')
    <style>
        .detail-container {
            padding: 20px;
            font-family: 'Inter', sans-serif;
        }

        .detail-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            max-width: 800px;
            margin: 0 auto;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }

        .detail-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 24px;
        }

        .detail-header h2 {
            margin: 0;
            font-size: 28px;
            color: #2C3E50;
        }

        .detail-img {
            width: 220px;
            height: 220px;
            border-radius: 16px;
            background-color: #f5f7fb;
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
        }

        .detail-body {
            display: grid;
            grid-template-columns: 1fr;
            gap: 18px;
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            padding: 16px;
            border-radius: 12px;
            background-color: #f9fbff;
            border: 1px solid #e7ecf6;
        }

        .detail-item strong {
            color: #2C3E50;
        }

        .detail-item span {
            color: #556673;
        }

        .detail-description {
            padding: 16px;
            border-radius: 12px;
            background-color: #f9fbff;
            border: 1px solid #e7ecf6;
            color: #556673;
            line-height: 1.7;
        }

        .btn-back {
            display: inline-block;
            background-color: #2F80ED;
            color: white;
            padding: 12px 24px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(47, 128, 237, 0.2);
            transition: all 0.2s ease;
        }
        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(47, 128, 237, 0.25);
            color: white;
        }
    </style>

    <div class="detail-container">
        <div class="detail-card">
            <div class="detail-header">
                <div style="display: flex; align-items: center; gap: 16px;">
                    <div class="icon-circle shadow-sm" style="width: 50px; height: 50px; display: inline-flex; align-items: center; justify-content: center; background-color: #f5f7fb; border-radius: 50%; font-size: 24px; color: #2C3E50; border: 1px solid #e7ecf6; flex-shrink: 0;">
                        @if ($layanan->ikon === 'paint')
                            <i class="fas fa-paint-brush"></i>
                        @elseif ($layanan->ikon === 'face')
                            <i class="fas fa-smile"></i>
                        @else
                            <i class="fas fa-cut"></i>
                        @endif
                    </div>
                    <div>
                        <h2 style="margin: 0; font-size: 28px; color: #2C3E50;">{{ $layanan->nama }}</h2>
                        <p style="margin-top: 4px; margin-bottom: 0; color: #556673;">Detail lengkap layanan barbershop.</p>
                    </div>
                </div>
                <a href="{{ route('admin.layanan.index') }}" class="btn-back" aria-label="Kembali ke Daftar Layanan">Kembali</a>
            </div>

            <div class="detail-body">
                <div class="detail-item">
                    <strong>Harga</strong>
                    <span>Rp {{ number_format($layanan->harga, 0, ',', '.') }}</span>
                </div>
                <div class="detail-item">
                    <strong>Estimasi Waktu</strong>
                    <span>{{ $layanan->estimasi_waktu ?? '-' }}</span>
                </div>
                <div class="detail-item">
                    <strong>Status</strong>
                    <span>{{ $layanan->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                </div>
                <div class="detail-description">
                    <strong>Deskripsi:</strong>
                    <p style="margin-top: 8px;">{{ $layanan->deskripsi ?? 'Tidak ada deskripsi tambahan.' }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
