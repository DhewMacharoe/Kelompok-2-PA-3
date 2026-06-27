@extends('layouts.super_admin')

@section('title', 'Tambah Admin Tenant')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="m-0 fw-bold text-dark"><i class="bi bi-person-plus-fill me-2 text-warning"></i>Tambah Admin Tenant</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('super-admin.admins.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required placeholder="Masukkan nama lengkap...">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label fw-bold">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username') }}" required placeholder="Contoh: argaadmin">
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required placeholder="Contoh: admin@arga.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label fw-bold">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required placeholder="Minimal 8 karakter...">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="barbershop_id" class="form-label fw-bold">Asosiasi Tenant <span class="text-danger">*</span></label>
                        <select class="form-select @error('barbershop_id') is-invalid @enderror" id="barbershop_id" name="barbershop_id" required>
                            <option value="" disabled selected>Pilih Tenant...</option>
                            @foreach($barbershops as $barber)
                                <option value="{{ $barber->id }}" {{ old('barbershop_id') == $barber->id ? 'selected' : '' }}>
                                    {{ $barber->nama }} (ID: {{ $barber->id }})
                                </option>
                            @endforeach
                        </select>
                        @error('barbershop_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('super-admin.admins.index') }}" class="btn btn-outline-secondary px-4 py-2" aria-label="Batal Simpan">Batal</a>
                        <button type="submit" class="btn btn-gold px-4 py-2" aria-label="Simpan Admin">Simpan Admin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
