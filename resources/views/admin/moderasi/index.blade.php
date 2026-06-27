@extends('admin.layouts.app')

@section('title', 'Moderasi Pelanggan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark m-0">Moderasi Pelanggan</h4>
        <p class="text-muted small m-0">Kelola pelanggan bermasalah dan awasi risiko pembatalan antrean.</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-4">
        <!-- Filter dan Search -->
        <form action="{{ route('admin.moderasi.index') }}" method="GET" class="row g-3 mb-4">
            <div class="col-md-6 col-lg-4">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0" 
                           placeholder="Cari nama, username, email..." value="{{ $search ?? '' }}" aria-label="Cari nama, username, email pelanggan">
                </div>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary px-4 py-2" style="background-color: var(--primary-blue); border: none;" aria-label="Cari Pelanggan">
                    Cari
                </button>
                @if($search)
                    <a href="{{ route('admin.moderasi.index') }}" class="btn btn-outline-secondary px-3 py-2 ms-2" aria-label="Reset Pencarian">
                        Reset
                    </a>
                @endif
            </div>
        </form>

        <!-- Tabel Pelanggan -->
        <div class="table-responsive">
            <table class="table table-hover align-middle" style="min-width: 1000px;">
                <thead class="table-light">
                    <tr>
                        <th scope="col" class="py-3 px-3">Nama Pelanggan</th>
                        <th scope="col" class="py-3">Info Kontak</th>
                        <th scope="col" class="py-3 text-center">Total Antrean</th>
                        <th scope="col" class="py-3 text-center">Batal (Pelanggan)</th>
                        <th scope="col" class="py-3 text-center">No-Show</th>
                        <th scope="col" class="py-3 text-center">Persentase Batal</th>
                        <th scope="col" class="py-3">Aktivitas Terakhir</th>
                        <th scope="col" class="py-3 text-center">Risiko</th>
                        <th scope="col" class="py-3 text-center">Status</th>
                        <th scope="col" class="py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        @php
                            $risk = $user->riskLevel();
                            $total = $user->totalQueues();
                            $cancel = $user->customerCancellationsCount();
                            $noshow = $user->noShowsCount();
                            $pct = $user->cancellationPercentage();
                        @endphp
                        <tr>
                            <td class="px-3">
                                <div class="fw-bold text-dark">{{ $user->name }}</div>
                                <div class="text-muted small">&#64;{{ $user->username ?? 'belum-set' }}</div>
                            </td>
                            <td>
                                <div class="small"><i class="bi bi-envelope-fill text-muted me-1"></i> {{ $user->email }}</div>
                                <div class="small mt-1"><i class="bi bi-whatsapp text-success me-1"></i> {{ $user->no_whatsapp ?? '-' }}</div>
                            </td>
                            <td class="text-center fw-semibold text-dark">{{ $total }}</td>
                            <td class="text-center fw-semibold text-danger">{{ $cancel }}</td>
                            <td class="text-center fw-semibold text-danger">{{ $noshow }}</td>
                            <td class="text-center">
                                <span class="fw-semibold text-dark">{{ $pct }}%</span>
                            </td>
                            <td class="small">
                                {{ $user->lastActivity() ? \Carbon\Carbon::parse($user->lastActivity())->translatedFormat('d M Y, H:i') : '-' }}
                            </td>
                            <td class="text-center">
                                @if($risk === 'high')
                                    <span class="badge rounded-pill bg-danger px-3 py-2">Tinggi</span>
                                @elseif($risk === 'medium')
                                    <span class="badge rounded-pill bg-warning text-dark px-3 py-2">Sedang</span>
                                @else
                                    <span class="badge rounded-pill bg-success px-3 py-2">Rendah</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($user->is_blocked)
                                    <span class="badge bg-secondary px-2.5 py-1.5"><i class="bi bi-lock-fill me-1"></i>Diblokir</span>
                                @else
                                    <span class="badge bg-success-subtle text-success px-2.5 py-1.5"><i class="bi bi-patch-check-fill me-1"></i>Aktif</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.moderasi.show', $user->id) }}" class="btn btn-sm btn-outline-primary px-3 py-2" aria-label="Lihat Detail Pelanggan">
                                    <i class="bi bi-eye-fill me-1" aria-hidden="true"></i>Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-5 text-muted">
                                <i class="bi bi-people fs-1 d-block mb-3 opacity-50"></i>
                                Tidak ada data pelanggan ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
