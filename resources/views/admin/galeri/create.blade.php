@extends('admin.layouts.app')

@section('title', 'Tambah Galeri')

@section('content')
<div class="content-header">
    <h2>Tambah Galeri</h2>
</div>

<div class="content-body">
    <div class="card shadow-sm mx-auto" style="max-width: 720px;">
        <div class="card-body">

            <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Judul Galeri</label>
                    <input type="text" 
                           name="judul" 
                           class="form-control" 
                           value="{{ old('judul') }}" 
                           placeholder="Contoh: Suasana Arga Home's"
                           required>

                    @error('judul')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" 
                              class="form-control" 
                              rows="4" 
                              placeholder="Contoh: Dokumentasi suasana barbershop dan coffee.">{{ old('deskripsi') }}</textarea>

                    @error('deskripsi')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Gambar Galeri</label>
                    <input type="file" 
                           name="gambar" 
                           class="form-control" 
                           accept="image/*"
                           required>

                    @error('gambar')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Status</label>
                    <select name="is_active" class="form-control" required>
                        <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Nonaktif</option>
                    </select>

                    @error('is_active')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.galeri.index') }}" class="btn btn-danger">
                        Batal
                    </a>

                    <button type="submit" class="btn btn-primary" data-loading-text="Menyimpan...">
                        Simpan
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection