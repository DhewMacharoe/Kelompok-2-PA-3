@extends('layouts.super_admin')

@section('title', 'Kelola Barbershop')

@section('content')
<div class="card shadow-sm border-0 rounded-3">
    <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
        <h5 class="m-0 fw-bold text-dark"><i class="bi bi-shop me-2"></i>Daftar Seluruh Barbershop</h5>
        <a href="{{ route('super-admin.barbershops.create') }}" class="btn btn-sm btn-gold px-3"><i class="bi bi-plus-lg me-1"></i>Tambah Barbershop</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-4 py-3" style="width: 50px;">ID</th>
                        <th class="py-3">Nama Barbershop</th>
                        <th class="py-3">Alamat</th>
                        <th class="py-3">Kontak</th>
                        <th class="py-3 text-center">Koordinat (Lat, Lng)</th>
                        <th class="py-3 text-center">Status</th>
                        <th class="py-3 text-end px-4" style="width: 250px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barbershops as $barber)
                        <tr>
                            <td class="px-4 fw-bold text-muted">{{ $barber->id }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $barber->nama }}</div>
                                <div class="text-muted small">/{!! $barber->slug !!}</div>
                            </td>
                            <td>{{ $barber->alamat ?? 'Alamat belum diatur' }}</td>
                            <td>{{ $barber->telepon ?? '-' }}</td>
                            <td class="text-center font-monospace small">
                                @if($barber->latitude && $barber->longitude)
                                    {{ number_format($barber->latitude, 6) }}, {{ number_format($barber->longitude, 6) }}
                                @else
                                    <span class="text-muted">Tidak ada</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($barber->is_active)
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill">Aktif</span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill">Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-end px-4">
                                <div class="d-inline-flex gap-2">
                                    <a href="{{ route('super-admin.barbershops.edit', $barber->id) }}" class="btn btn-sm btn-outline-secondary px-2">
                                        <i class="bi bi-pencil me-1"></i>Edit
                                    </a>
                                    <form action="{{ route('super-admin.barbershops.destroy', $barber->id) }}" method="POST" class="d-inline m-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus barbershop ini beserta seluruh data di dalamnya?')">
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
                                Belum ada barbershop terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
