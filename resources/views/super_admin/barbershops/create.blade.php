@extends('layouts.super_admin')

@section('title', 'Tambah Barbershop Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="m-0 fw-bold text-dark"><i class="bi bi-plus-circle-fill me-2 text-warning"></i>Tambah Barbershop</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('super-admin.barbershops.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="nama" class="form-label fw-bold">Nama Barbershop <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" required placeholder="Contoh: Arga Barbershop Cabang Balige">
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label fw-bold">Slug URL (Opsional)</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug') }}" placeholder="Contoh: arga-balige (akan otomatis dibuat jika kosong)">
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="telepon" class="form-label fw-bold">No. Telepon / WhatsApp</label>
                            <input type="text" class="form-control @error('telepon') is-invalid @enderror" id="telepon" name="telepon" value="{{ old('telepon') }}" placeholder="Contoh: 0821xxxxxxxx">
                            @error('telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold d-block">Status Keaktifan</label>
                            <div class="form-check form-switch pt-2">
                                <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" checked>
                                <label class="form-check-label fw-bold text-muted" for="is_active">Aktif (Dapat diakses pelanggan)</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="latitude" class="form-label fw-bold">Latitude Lokasi</label>
                            <input type="number" step="any" class="form-control @error('latitude') is-invalid @enderror" id="latitude" name="latitude" value="{{ old('latitude') }}" placeholder="Contoh: 2.386130">
                            @error('latitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="longitude" class="form-label fw-bold">Longitude Lokasi</label>
                            <input type="number" step="any" class="form-control @error('longitude') is-invalid @enderror" id="longitude" name="longitude" value="{{ old('longitude') }}" placeholder="Contoh: 99.147852">
                            @error('longitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label fw-bold">Alamat Lengkap</label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat lengkap barbershop...">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="deskripsi" class="form-label fw-bold">Deskripsi Singkat</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3" placeholder="Deskripsikan layanan unggulan barbershop...">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('super-admin.barbershops.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
                        <button type="submit" class="btn btn-gold px-4">Simpan Barbershop</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
