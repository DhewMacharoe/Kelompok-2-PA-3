@extends('admin.layouts.app')

@section('title', 'Detail Pelanggan - ' . $user->name)

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.moderasi.index') }}" class="btn btn-outline-secondary btn-sm px-3 mb-3">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
    </a>
    <div class="d-flex justify-content-between align-items-start">
        <div>
            <h4 class="fw-bold text-dark m-0">{{ $user->name }}</h4>
            <p class="text-muted small m-0">Detail profil, statistik, dan riwayat aktivitas moderasi pelanggan.</p>
        </div>
        <div class="d-flex gap-2">
            @if($user->is_blocked)
                <form action="{{ route('admin.moderasi.unblock', $user->id) }}" method="POST" 
                      onsubmit="return confirm('Apakah Anda yakin ingin membuka blokir akun pelanggan ini?')">
                    @csrf
                    <button type="submit" class="btn btn-success fw-semibold px-4 shadow-sm">
                        <i class="bi bi-unlock-fill me-1"></i> Buka Blokir
                    </button>
                </form>
            @else
                <button type="button" class="btn btn-danger fw-semibold px-4 shadow-sm" 
                        data-bs-toggle="modal" data-bs-target="#blockModal">
                    <i class="bi bi-lock-fill me-1"></i> Blokir Akun
                </button>
            @endif

            <form action="{{ route('admin.moderasi.resetRisk', $user->id) }}" method="POST"
                  onsubmit="return confirm('Apakah Anda yakin ingin mereset indikator risiko pelanggan ini? Perhitungan risiko sebelumnya tidak akan dihitung kembali.')">
                @csrf
                <button type="submit" class="btn btn-warning fw-semibold px-3 shadow-sm text-dark">
                    <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Risiko
                </button>
            </form>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        @foreach($errors->all() as $error)
            {{ $error }}
        @endforeach
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($user->is_blocked)
    <div class="alert alert-warning border-0 shadow-sm p-4 mb-4" role="alert" style="background-color: #FFF3CD; border-left: 5px solid #FFC107 !important;">
        <h5 class="alert-heading fw-bold text-dark mb-2"><i class="bi bi-exclamation-triangle-fill me-2"></i>Akun Sedang Ditangguhkan (Diblokir)</h5>
        <p class="m-0 text-dark">Pelanggan ini sedang diblokir dari sistem pemesanan. Pelanggan tidak dapat membuat booking atau mengambil antrean baru.</p>
        <hr>
        <p class="mb-0 small text-muted"><strong>Alasan Pemblokiran:</strong> {{ $user->blocked_reason ?? 'Tidak ditentukan.' }}</p>
        <p class="mb-0 small text-muted"><strong>Tanggal Diblokir:</strong> {{ \Carbon\Carbon::parse($user->blocked_at)->translatedFormat('d M Y, H:i') }}</p>
    </div>
@endif

<div class="row g-4">
    <!-- Kolom Kiri: Informasi Profil & Statistik -->
    <div class="col-lg-4">
        <!-- Card Profil -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4 text-center">
                <div class="mb-3 d-inline-block bg-primary bg-opacity-10 text-primary rounded-circle p-3">
                    <i class="bi bi-person-fill fs-1"></i>
                </div>
                <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                <span class="badge bg-secondary mb-3">Customer</span>
                
                <div class="text-start border-top pt-3">
                    <div class="mb-2">
                        <label class="text-muted small d-block">Username</label>
                        <span class="fw-semibold text-dark">&#64;{{ $user->username ?? '-' }}</span>
                    </div>
                    <div class="mb-2">
                        <label class="text-muted small d-block">Email</label>
                        <span class="fw-semibold text-dark">{{ $user->email }}</span>
                    </div>
                    <div class="mb-2">
                        <label class="text-muted small d-block">WhatsApp</label>
                        <span class="fw-semibold text-dark">{{ $user->no_whatsapp ?? '-' }}</span>
                    </div>
                    <div>
                        <label class="text-muted small d-block">Tanggal Registrasi</label>
                        <span class="fw-semibold text-dark">{{ $user->created_at ? $user->created_at->translatedFormat('d F Y') : '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Statistik Risiko -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                <h5 class="fw-bold m-0 text-dark">Statistik Moderasi</h5>
            </div>
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-4 bg-light p-3 rounded">
                    <div>
                        <span class="text-muted small d-block">Tingkat Risiko</span>
                        <h5 class="fw-bold m-0">
                            @php $risk = $user->riskLevel(); @endphp
                            @if($risk === 'high')
                                <span class="text-danger"><i class="bi bi-exclamation-triangle-fill"></i> Risiko Tinggi</span>
                            @elseif($risk === 'medium')
                                <span class="text-warning"><i class="bi bi-exclamation-circle-fill"></i> Risiko Sedang</span>
                            @else
                                <span class="text-success"><i class="bi bi-check-circle-fill"></i> Risiko Rendah</span>
                            @endif
                        </h5>
                    </div>
                    <div>
                        @if($risk === 'high')
                            <span class="badge rounded-circle bg-danger p-3" style="width: 15px; height: 15px; display: inline-block;"></span>
                        @elseif($risk === 'medium')
                            <span class="badge rounded-circle bg-warning p-3" style="width: 15px; height: 15px; display: inline-block;"></span>
                        @else
                            <span class="badge rounded-circle bg-success p-3" style="width: 15px; height: 15px; display: inline-block;"></span>
                        @endif
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted small">Total Antrean</span>
                        <span class="fw-bold text-dark">{{ $user->totalQueues() }}</span>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted small">Batal oleh Pelanggan</span>
                        <span class="fw-bold text-danger">{{ $user->customerCancellationsCount() }}</span>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted small">Tidak Hadir / No-Show</span>
                        <span class="fw-bold text-danger">{{ $user->noShowsCount() }}</span>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted small">Persentase Pembatalan</span>
                        <span class="fw-bold text-dark">{{ $user->cancellationPercentage() }}%</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        @php $pct = $user->cancellationPercentage(); @endphp
                        <div class="progress-bar @if($pct >= 50) bg-danger @elseif($pct >= 20) bg-warning @else bg-success @endif" 
                             role="progressbar" style="width: {{ $pct }}%" aria-valuenow="{{ $pct }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                
                @if($user->reset_risk_at)
                    <div class="mt-3 border-top pt-3 text-muted" style="font-size: 0.75rem;">
                        <i class="bi bi-clock-history"></i> Risiko terakhir di-reset pada:<br>
                        <strong>{{ \Carbon\Carbon::parse($user->reset_risk_at)->translatedFormat('d M Y, H:i') }}</strong>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Tab Riwayat & Moderasi -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <!-- Nav Tabs -->
                <ul class="nav nav-tabs border-bottom mb-4" id="moderasiTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-bold" id="booking-tab" data-bs-toggle="tab" 
                                data-bs-target="#booking-content" type="button" role="tab" 
                                aria-controls="booking-content" aria-selected="true">
                            Riwayat Booking & Antrean
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold" id="history-tab" data-bs-toggle="tab" 
                                data-bs-target="#history-content" type="button" role="tab" 
                                aria-controls="history-content" aria-selected="false">
                            Riwayat Tindakan Moderasi
                        </button>
                    </li>
                </ul>

                <!-- Tab Contents -->
                <div class="tab-content" id="moderasiTabsContent">
                    <!-- Tab Booking -->
                    <div class="tab-pane fade show active" id="booking-content" role="tabpanel" aria-labelledby="booking-tab">
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" class="py-2.5">No. Antrean</th>
                                        <th scope="col" class="py-2.5">Tipe</th>
                                        <th scope="col" class="py-2.5">Tanggal/Waktu</th>
                                        <th scope="col" class="py-2.5">Layanan</th>
                                        <th scope="col" class="py-2.5">Status Booking</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($bookings as $booking)
                                        @php
                                            $layananList = $booking->layananUntukRekap();
                                        @endphp
                                        <tr>
                                            <td class="fw-bold text-dark">
                                                {{ str_pad($booking->nomor_antrean_seq, 2, '0', STR_PAD_LEFT) }}
                                            </td>
                                            <td>
                                                @if($booking->is_booking)
                                                    <span class="badge bg-primary-subtle text-primary">Booking</span>
                                                @else
                                                    <span class="badge bg-secondary-subtle text-secondary">Walk-in</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($booking->is_booking)
                                                    <div class="small fw-semibold text-dark">{{ \Carbon\Carbon::parse($booking->tanggal_booking)->translatedFormat('d M Y') }}</div>
                                                    <div class="small text-muted">{{ \Carbon\Carbon::parse($booking->waktu_booking)->format('H:i') }} WIB</div>
                                                @else
                                                    <div class="small fw-semibold text-dark">{{ \Carbon\Carbon::parse($booking->waktu_masuk)->translatedFormat('d M Y') }}</div>
                                                    <div class="small text-muted">{{ \Carbon\Carbon::parse($booking->waktu_masuk)->format('H:i') }} WIB</div>
                                                @endif
                                            </td>
                                            <td>
                                                <ul class="list-unstyled m-0 p-0" style="font-size: 0.85rem;">
                                                    @foreach($layananList as $lay)
                                                        <li>• {{ $lay->nama }}</li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>
                                                @if($booking->status === 'selesai')
                                                    <span class="badge bg-success-subtle text-success"><i class="bi bi-check-circle-fill me-1"></i>Selesai</span>
                                                @elseif($booking->status === 'sedang dilayani')
                                                    <span class="badge bg-warning-subtle text-warning"><i class="bi bi-hourglass-split me-1"></i>Sedang Berlangsung</span>
                                                @elseif($booking->status === 'menunggu')
                                                    <span class="badge bg-info-subtle text-info"><i class="bi bi-clock me-1"></i>Menunggu</span>
                                                @elseif($booking->status === 'batal')
                                                    @if($booking->batal_oleh === 'pelanggan')
                                                        <span class="badge bg-danger-subtle text-danger" data-bs-toggle="tooltip" title="Alasan: {{ $booking->alasan_batal ?? '-' }}">
                                                            <i class="bi bi-x-circle-fill me-1"></i>Dibatalkan Pelanggan
                                                        </span>
                                                    @elseif($booking->batal_oleh === 'admin')
                                                        <span class="badge bg-secondary-subtle text-dark" data-bs-toggle="tooltip" title="Alasan: {{ $booking->alasan_batal ?? '-' }}">
                                                            <i class="bi bi-x-circle-fill me-1"></i>Dibatalkan Admin
                                                        </span>
                                                    @elseif($booking->batal_oleh === 'no_show')
                                                        <span class="badge bg-danger text-white" data-bs-toggle="tooltip" title="Alasan: {{ $booking->alasan_batal ?? '-' }}">
                                                            <i class="bi bi-person-x-fill me-1"></i>Tidak Hadir (No-Show)
                                                        </span>
                                                    @else
                                                        <span class="badge bg-danger-subtle text-danger" data-bs-toggle="tooltip" title="Alasan: {{ $booking->alasan_batal ?? '-' }}">
                                                            <i class="bi bi-x-circle-fill me-1"></i>Dibatalkan
                                                        </span>
                                                    @endif
                                                    @if($booking->alasan_batal)
                                                        <div class="small text-muted mt-1" style="font-size: 0.75rem;">Ket: "{{ $booking->alasan_batal }}"</div>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted">
                                                Belum ada riwayat antrean atau booking.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Tab Tindakan Moderasi -->
                    <div class="tab-pane fade" id="history-content" role="tabpanel" aria-labelledby="history-tab">
                        <div class="timeline">
                            @forelse($histories as $history)
                                <div class="p-3 mb-3 border rounded shadow-sm">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="fw-bold m-0 text-dark">
                                            @if($history->action === 'block')
                                                <span class="text-danger"><i class="bi bi-lock-fill"></i> Akun Diblokir</span>
                                            @elseif($history->action === 'unblock')
                                                <span class="text-success"><i class="bi bi-unlock-fill"></i> Blokir Dibuka</span>
                                            @elseif($history->action === 'reset_risk')
                                                <span class="text-warning"><i class="bi bi-arrow-counterclockwise"></i> Risiko Di-reset</span>
                                            @else
                                                <span class="text-secondary">{{ $history->action }}</span>
                                            @endif
                                        </h6>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($history->created_at)->translatedFormat('d M Y, H:i') }}
                                        </small>
                                    </div>
                                    <p class="m-0 small text-dark mb-2"><strong>Keterangan / Catatan:</strong> {{ $history->reason ?? '-' }}</p>
                                    <div class="text-muted" style="font-size: 0.75rem;">
                                        <i class="bi bi-person-badge-fill"></i> Oleh Admin: <strong>{{ $history->admin->name ?? 'System' }}</strong> (&#64;{{ $history->admin->username ?? 'admin' }})
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4 text-muted">
                                    Belum ada catatan tindakan moderasi untuk pelanggan ini.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Form Pemblokiran -->
<div class="modal fade" id="blockModal" tabindex="-1" aria-labelledby="blockModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.moderasi.block', $user->id) }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold text-dark" id="blockModalLabel">Blokir Akun Pelanggan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted small">Masukkan alasan pemblokiran akun. Pelanggan akan melihat alasan ini pada halaman booking mereka dan tidak dapat memesan jadwal baru.</p>
                    <div class="mb-3">
                        <label for="reason" class="form-label fw-semibold text-dark">Alasan Pemblokiran</label>
                        <textarea class="form-control" id="reason" name="reason" rows="4" 
                                  placeholder="Misal: Pembatalan booking berulang lebih dari 3 kali dalam seminggu." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger px-4">
                        <i class="bi bi-lock-fill"></i> Blokir Sekarang
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
