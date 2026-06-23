@extends('pelanggan.layouts.app')

@section('title', 'Profil Pengguna')

@push('styles')
<style>
    .profile-container {
        max-width: 800px;
        margin: 2rem auto;
        padding: 0 1rem;
    }

    .profile-header-card {
        background: linear-gradient(135deg, #1f2937, #111827);
        border-radius: 1rem;
        padding: 2rem;
        color: white;
        margin-bottom: 2rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
    }

    .profile-header-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
        pointer-events: none;
    }

    .profile-info {
        position: relative;
        z-index: 1;
    }

    .profile-name {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
        letter-spacing: -0.025em;
    }

    .profile-email {
        color: #9ca3af;
        font-size: 0.95rem;
    }

    .edit-profile-btn {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s ease;
        position: relative;
        z-index: 1;
    }

    .edit-profile-btn:hover {
        background: rgba(255, 255, 255, 0.2);
        color: white;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .history-card {
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        border: 1px solid #f3f4f6;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .history-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025);
    }

    .history-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
        border-bottom: 1px solid #f3f4f6;
        padding-bottom: 1rem;
    }

    .history-date {
        font-size: 0.875rem;
        color: #6b7280;
        font-weight: 500;
    }

    .history-status {
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .status-selesai {
        background: #def7ec;
        color: #03543f;
    }

    .status-menunggu {
        background: #fdf6b2;
        color: #723b13;
    }

    .status-sedang {
        background: #e1effe;
        color: #1e429f;
    }

    .status-batal {
        background: #fde8e8;
        color: #9b1c1c;
    }

    .service-list {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .service-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .service-icon {
        background: #f3f4f6;
        width: 32px;
        height: 32px;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #4b5563;
    }

    .service-name {
        font-weight: 600;
        color: #374151;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        background: white;
        border-radius: 1rem;
        border: 2px dashed #e5e7eb;
    }

    .empty-icon {
        font-size: 3rem;
        color: #9ca3af;
        margin-bottom: 1rem;
    }

    .alasan-batal {
        margin-top: 1rem;
        padding: 0.75rem;
        background: #fef2f2;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        color: #7f1d1d;
        border: 1px solid #fee2e2;
    }

    .alasan-title {
        font-weight: 600;
        margin-bottom: 0.25rem;
        display: block;
    }

    /* Custom Tabs Styling */
    .custom-tabs {
        border-bottom: 2px solid #f3f4f6;
        gap: 0.5rem;
    }
    
    .custom-tabs .nav-link {
        color: #6b7280;
        font-weight: 600;
        border: none;
        border-bottom: 3px solid transparent;
        padding: 0.75rem 1.5rem;
        transition: all 0.2s ease;
        background: transparent;
    }
    
    .custom-tabs .nav-link:hover {
        color: #374151;
        border-color: transparent;
    }
    
    .custom-tabs .nav-link.active {
        color: #1f2937;
        border-bottom-color: {{ $activeDesign->warna_primer ?? '#d4af37' }};
        background: transparent;
    }
</style>
@endpush

@section('content')
<div class="profile-container">
    <div class="profile-header-card">
        <div class="profile-info">
            <h1 class="profile-name">{{ $user->username }}</h1>
            <div class="profile-email">{{ $user->email }}</div>
        </div>
        <a href="{{ route('profile.edit') }}" class="edit-profile-btn">
            <i class="bi bi-pencil-square me-1"></i> Ubah Profil
        </a>
    </div>

    <h2 class="section-title">
        <i class="bi bi-clock-history"></i> Riwayat Antrean & Layanan
    </h2>

    @php
        $riwayatSelesai = $riwayatAntrean->where('status', 'selesai');
        $riwayatBatal = $riwayatAntrean->where('status', 'batal');
    @endphp

    <ul class="nav nav-tabs custom-tabs mb-4" id="historyTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="booking-tab" data-bs-toggle="tab" data-bs-target="#booking" type="button" role="tab" aria-controls="booking" aria-selected="true">
                <i class="bi bi-calendar-check me-1"></i> Booking Aktif ({{ $bookingAktif->count() }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="selesai-tab" data-bs-toggle="tab" data-bs-target="#selesai" type="button" role="tab" aria-controls="selesai" aria-selected="false">
                <i class="bi bi-check-circle me-1"></i> Selesai ({{ $riwayatSelesai->count() }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="batal-tab" data-bs-toggle="tab" data-bs-target="#batal" type="button" role="tab" aria-controls="batal" aria-selected="false">
                <i class="bi bi-x-circle me-1"></i> Batal ({{ $riwayatBatal->count() }})
            </button>
        </li>
    </ul>

    <div class="tab-content" id="historyTabContent">
        <!-- Tab Booking Aktif -->
        <div class="tab-pane fade show active" id="booking" role="tabpanel" aria-labelledby="booking-tab">
            @forelse($bookingAktif as $antrean)
                <div class="history-card" style="border-left: 4px solid #f2901f;">
                    <div class="history-header">
                        <div>
                            <div class="history-date text-dark font-weight-bold">
                                <i class="bi bi-calendar-event me-1 text-primary"></i>
                                {{ \Carbon\Carbon::parse($antrean->tanggal_booking)->translatedFormat('l, d F Y') }} - Jam {{ \Carbon\Carbon::parse($antrean->waktu_booking)->format('H:i') }} WIB
                            </div>
                            <div class="text-muted mt-1" style="font-size: 0.8rem;">
                                No. Antrean: <strong class="text-primary">{{ $antrean->nomor_antrean_seq }}</strong> | Cabang: <strong>{{ optional($antrean->barbershop)->nama ?? 'Cabang Utama' }}</strong>
                            </div>
                        </div>
                        <span class="history-status {{ $antrean->status == 'menunggu' ? 'status-menunggu' : 'status-sedang' }}">
                            {{ $antrean->status }}
                        </span>
                    </div>

                    <div class="service-list">
                        @if($antrean->layanan1)
                        <div class="service-item">
                            <div class="service-icon">
                                @if ($antrean->layanan1->ikon === 'paint')
                                    <i class="fas fa-paint-brush"></i>
                                @elseif ($antrean->layanan1->ikon === 'face')
                                    <i class="fas fa-smile"></i>
                                @else
                                    <i class="fas fa-cut"></i>
                                @endif
                            </div>
                            <span class="service-name">{{ $antrean->layanan1->nama }}</span>
                        </div>
                        @endif
                        
                        @if($antrean->layanan2)
                        <div class="service-item">
                            <div class="service-icon">
                                @if ($antrean->layanan2->ikon === 'paint')
                                    <i class="fas fa-paint-brush"></i>
                                @elseif ($antrean->layanan2->ikon === 'face')
                                    <i class="fas fa-smile"></i>
                                @else
                                    <i class="fas fa-cut"></i>
                                @endif
                            </div>
                            <span class="service-name">{{ $antrean->layanan2->nama }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="bi bi-calendar-x empty-icon"></i>
                    <h3 class="fw-bold text-dark h5 mb-2">Belum ada booking aktif</h3>
                    <p class="text-muted mb-4">Jadwal reservasi yang telah Anda buat akan muncul di sini.</p>
                    <a href="{{ route('barbershop.home', ['slug' => $activeBarbershop->slug ?? 'arga-barbershop']) }}" class="btn btn-outline-primary rounded-pill px-4">Buat Antrean Sekarang</a>
                </div>
            @endforelse
        </div>

        <!-- Tab Selesai -->
        <div class="tab-pane fade" id="selesai" role="tabpanel" aria-labelledby="selesai-tab">
            @forelse($riwayatSelesai as $antrean)
                <div class="history-card">
                    <div class="history-header">
                        <div>
                            <div class="history-date">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ \Carbon\Carbon::parse($antrean->created_at)->translatedFormat('l, d F Y') }}
                            </div>
                            <div class="text-muted mt-1" style="font-size: 0.8rem;">
                                No. Antrean: <strong>{{ $antrean->nomor_antrean_seq }}</strong>
                            </div>
                        </div>
                        <span class="history-status status-{{ $antrean->status }}">
                            {{ $antrean->status }}
                        </span>
                    </div>

                    <div class="service-list">
                        @if($antrean->layanan1)
                        <div class="service-item">
                            <div class="service-icon">
                                @if ($antrean->layanan1->ikon === 'paint')
                                    <i class="fas fa-paint-brush"></i>
                                @elseif ($antrean->layanan1->ikon === 'face')
                                    <i class="fas fa-smile"></i>
                                @else
                                    <i class="fas fa-cut"></i>
                                @endif
                            </div>
                            <span class="service-name">{{ $antrean->layanan1->nama }}</span>
                        </div>
                        @endif
                        
                        @if($antrean->layanan2)
                        <div class="service-item">
                            <div class="service-icon">
                                @if ($antrean->layanan2->ikon === 'paint')
                                    <i class="fas fa-paint-brush"></i>
                                @elseif ($antrean->layanan2->ikon === 'face')
                                    <i class="fas fa-smile"></i>
                                @else
                                    <i class="fas fa-cut"></i>
                                @endif
                            </div>
                            <span class="service-name">{{ $antrean->layanan2->nama }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="bi bi-check2-circle empty-icon"></i>
                    <h3 class="fw-bold text-dark h5 mb-2">Belum ada riwayat selesai</h3>
                    <p class="text-muted mb-4">Layanan yang telah selesai akan muncul di sini.</p>
                </div>
            @endforelse
        </div>

        <!-- Tab Batal -->
        <div class="tab-pane fade" id="batal" role="tabpanel" aria-labelledby="batal-tab">
            @forelse($riwayatBatal as $antrean)
                <div class="history-card">
                    <div class="history-header">
                        <div>
                            <div class="history-date">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ \Carbon\Carbon::parse($antrean->created_at)->translatedFormat('l, d F Y') }}
                            </div>
                            <div class="text-muted mt-1" style="font-size: 0.8rem;">
                                No. Antrean: <strong>{{ $antrean->nomor_antrean_seq }}</strong>
                            </div>
                        </div>
                        <span class="history-status status-{{ $antrean->status }}">
                            {{ $antrean->status }}
                        </span>
                    </div>

                    <div class="service-list">
                        @if($antrean->layanan1)
                        <div class="service-item">
                            <div class="service-icon">
                                @if ($antrean->layanan1->ikon === 'paint')
                                    <i class="fas fa-paint-brush"></i>
                                @elseif ($antrean->layanan1->ikon === 'face')
                                    <i class="fas fa-smile"></i>
                                @else
                                    <i class="fas fa-cut"></i>
                                @endif
                            </div>
                            <span class="service-name">{{ $antrean->layanan1->nama }}</span>
                        </div>
                        @endif
                        
                        @if($antrean->layanan2)
                        <div class="service-item">
                            <div class="service-icon">
                                @if ($antrean->layanan2->ikon === 'paint')
                                    <i class="fas fa-paint-brush"></i>
                                @elseif ($antrean->layanan2->ikon === 'face')
                                    <i class="fas fa-smile"></i>
                                @else
                                    <i class="fas fa-cut"></i>
                                @endif
                            </div>
                            <span class="service-name">{{ $antrean->layanan2->nama }}</span>
                        </div>
                        @endif
                    </div>

                    @if($antrean->alasan_batal)
                    <div class="alasan-batal">
                        <span class="alasan-title">Alasan Pembatalan:</span>
                        {{ $antrean->alasan_batal }}
                    </div>
                    @endif
                </div>
            @empty
                <div class="empty-state">
                    <i class="bi bi-x-circle empty-icon"></i>
                    <h3 class="fw-bold text-dark h5 mb-2">Belum ada riwayat batal</h3>
                    <p class="text-muted mb-4">Layanan yang dibatalkan akan muncul di sini.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
