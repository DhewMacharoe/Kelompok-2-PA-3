@extends('layouts.super_admin')

@section('title', 'Dasbor Utama')

@section('content')
<div class="row g-4 mb-4">
    <!-- Stat Card 1 -->
    <div class="col-md-4 col-xl-2">
        <div class="stat-card-global border-start border-4 border-primary">
            <p class="text-muted small text-uppercase mb-1 fw-bold">Total Tenant</p>
            <h3 class="m-0 fw-bold">{{ $totalBarbershops }}</h3>
        </div>
    </div>
    <!-- Stat Card 2 -->
    <div class="col-md-4 col-xl-2">
        <div class="stat-card-global border-start border-4 border-success">
            <p class="text-muted small text-uppercase mb-1 fw-bold">Total Admin</p>
            <h3 class="m-0 fw-bold">{{ $totalAdmins }}</h3>
        </div>
    </div>
    <!-- Stat Card 3 -->
    <div class="col-md-4 col-xl-2">
        <div class="stat-card-global border-start border-4 border-warning">
            <p class="text-muted small text-uppercase mb-1 fw-bold">Antrean Hari Ini</p>
            <h3 class="m-0 fw-bold">{{ $totalQueuesToday }}</h3>
        </div>
    </div>
    <!-- Stat Card 4 -->
    <div class="col-md-4 col-xl-2">
        <div class="stat-card-global border-start border-4 border-info">
            <p class="text-muted small text-uppercase mb-1 fw-bold">Antrean Menunggu</p>
            <h3 class="m-0 fw-bold text-info">{{ $queuesMenunggu }}</h3>
        </div>
    </div>
    <!-- Stat Card 5 -->
    <div class="col-md-4 col-xl-2">
        <div class="stat-card-global border-start border-4 border-success">
            <p class="text-muted small text-uppercase mb-1 fw-bold">Antrean Selesai</p>
            <h3 class="m-0 fw-bold text-success">{{ $queuesSelesai }}</h3>
        </div>
    </div>
    <!-- Stat Card 6 -->
    <div class="col-md-4 col-xl-2">
        <div class="stat-card-global border-start border-4 border-danger">
            <p class="text-muted small text-uppercase mb-1 fw-bold">Antrean Batal</p>
            <h3 class="m-0 fw-bold text-danger">{{ $queuesBatal }}</h3>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0 rounded-3">
    <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
        <h5 class="m-0 fw-bold text-dark"><i class="bi bi-shop me-2"></i>Daftar Tenant</h5>
        <a href="{{ route('super-admin.barbershops.create') }}" class="btn btn-sm btn-gold px-3"><i class="bi bi-plus-lg me-1"></i>Tambah Tenant</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-4 py-3" style="width: 50px;">ID</th>
                        <th class="py-3">Nama Tenant</th>
                        <th class="py-3">Alamat</th>
                        <th class="py-3">Kontak</th>
                        <th class="py-3 text-center">Antrean Hari Ini</th>
                        <th class="py-3 text-center">Status</th>
                        <th class="py-3 text-end px-4" style="width: 320px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barbershops as $barber)
                        <tr>
                            <td class="px-4 fw-bold text-muted">{{ $barber->id }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $barber->nama }}</div>
                                <div class="d-flex align-items-center gap-2 mt-1">
                                    <span class="text-muted small">/{!! $barber->slug !!}</span>
                                    <span class="badge {{ $barber->kategori === 'barbershop' ? 'bg-primary bg-opacity-10 text-primary' : 'bg-danger bg-opacity-10 text-danger' }} py-1 px-2 rounded-pill" style="font-size: 0.7rem; font-weight: 600;">
                                        {{ $barber->kategori === 'barbershop' ? 'Barbershop' : 'Salon' }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="text-truncate" style="max-width: 250px;" title="{{ $barber->alamat }}">
                                    {{ $barber->alamat ?? 'Alamat belum diatur' }}
                                </div>
                            </td>
                            <td>{{ $barber->telepon ?? '-' }}</td>
                            <td class="text-center">
                                <span class="badge bg-info text-dark" title="Menunggu">{{ $barber->queues_menunggu }}</span>
                                <span class="badge bg-success" title="Selesai">{{ $barber->queues_selesai }}</span>
                                <span class="badge bg-danger" title="Batal">{{ $barber->queues_batal }}</span>
                                <div class="small text-muted mt-1 fw-bold">Total: {{ $barber->queues_total }}</div>
                            </td>
                            <td class="text-center">
                                @if($barber->is_active)
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill"><i class="bi bi-patch-check-fill me-1"></i>Aktif</span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill"><i class="bi bi-slash-circle-fill me-1"></i>Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-end px-4">
                                <div class="d-inline-flex gap-2">
                                    <a href="{{ route('super-admin.switch-tenant', $barber->id) }}" class="btn btn-sm btn-primary px-3" style="background-color: var(--primary-blue); border: none;">
                                        <i class="bi bi-door-open me-1"></i>Kelola Data
                                    </a>
                                    <a href="{{ route('super-admin.barbershops.edit', $barber->id) }}" class="btn btn-sm btn-outline-secondary px-2">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('super-admin.barbershops.destroy', $barber->id) }}" method="POST" class="d-inline m-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tenant ini beserta seluruh data di dalamnya?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger px-2">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-shop fs-1 d-block mb-3"></i>
                                Belum ada tenant terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
