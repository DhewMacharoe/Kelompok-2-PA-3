@extends('layouts.super_admin')

@section('title', 'Kelola Admin Tenant')

@section('content')
<div class="card shadow-sm border-0 rounded-3">
    <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h5 class="m-0 fw-bold text-dark"><i class="bi bi-people me-2" aria-hidden="true"></i>Daftar Admin Tenant</h5>
        <a href="{{ route('super-admin.admins.create') }}" class="btn btn-sm btn-gold px-3 py-2" aria-label="Tambah Admin Baru"><i class="bi bi-plus-lg me-1" aria-hidden="true"></i>Tambah Admin</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-4 py-3" style="width: 50px;">ID</th>
                        <th class="py-3">Nama Lengkap</th>
                        <th class="py-3">Username</th>
                        <th class="py-3">Email</th>
                        <th class="py-3">Mengelola Tenant</th>
                        <th class="py-3 text-end px-4" style="width: 250px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($admins as $adm)
                        <tr>
                            <td class="px-4 fw-bold text-muted">{{ $adm->id }}</td>
                            <td class="fw-bold text-dark">{{ $adm->name }}</td>
                            <td><span class="badge bg-secondary bg-opacity-10 text-secondary font-monospace">{{ $adm->username }}</span></td>
                            <td>{{ $adm->email }}</td>
                            <td>
                                @if($adm->barbershop)
                                    <div class="fw-bold text-primary">{{ $adm->barbershop->nama }}</div>
                                    <div class="text-muted small">ID Tenant: {{ $adm->barbershop->id }}</div>
                                @else
                                    <span class="text-danger fw-bold"><i class="bi bi-exclamation-circle me-1"></i>Belum terikat</span>
                                @endif
                            </td>
                            <td class="text-end px-4">
                                <div class="d-inline-flex gap-2 flex-wrap">
                                    <a href="{{ route('super-admin.admins.edit', $adm->id) }}" class="btn btn-sm btn-outline-secondary px-3 py-2" aria-label="Edit Admin">
                                        <i class="bi bi-pencil me-1" aria-hidden="true"></i>Edit
                                    </a>
                                    <form action="{{ route('super-admin.admins.destroy', $adm->id) }}" method="POST" class="d-inline m-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus admin ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger px-3 py-2" aria-label="Hapus Admin">
                                            <i class="bi bi-trash" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-people fs-1 d-block mb-3"></i>
                                Belum ada admin tenant terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
