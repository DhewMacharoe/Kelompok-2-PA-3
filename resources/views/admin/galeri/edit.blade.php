@extends('admin.layouts.app')

@section('title', 'Edit Galeri')

@section('content')
<div class="content-header">
    <h2>Edit Galeri</h2>
</div>

<div class="content-body">
    <div class="card shadow-sm mx-auto" style="max-width: 720px;">
        <div class="card-body">

            <form action="{{ route('admin.galeri.update', $galeri) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Judul Galeri</label>
                    <input type="text"
                           name="judul"
                           class="form-control"
                           value="{{ old('judul', $galeri->judul) }}"
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
                              placeholder="Contoh: Dokumentasi suasana barbershop dan coffee.">{{ old('deskripsi', $galeri->deskripsi) }}</textarea>

                    @error('deskripsi')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Gambar Galeri</label>
                    <input type="file"
                           name="gambar"
                           id="gambarInput"
                           class="form-control"
                           accept="image/*">

                    <small class="text-muted">
                        Kosongkan jika tidak ingin mengganti gambar.
                    </small>

                    @error('gambar')
                        <small class="text-danger d-block">{{ $message }}</small>
                    @enderror
                </div>

                @if($galeri->gambar)
                    <div class="mb-3">
                        <label class="form-label">Preview Gambar Saat Ini</label>
                        <br>
                        <img id="previewGambar"
                             src="{{ asset('storage/' . $galeri->gambar) }}"
                             alt="{{ $galeri->judul }}"
                             style="width: 180px; height: 120px; object-fit: cover; border-radius: 8px;">
                    </div>
                @endif

                <div class="mb-4">
                    <label class="form-label">Status</label>
                    <select name="is_active" class="form-control" required>
                        <option value="1" {{ old('is_active', $galeri->is_active) == 1 ? 'selected' : '' }}>
                            Aktif
                        </option>
                        <option value="0" {{ old('is_active', $galeri->is_active) == 0 ? 'selected' : '' }}>
                            Nonaktif
                        </option>
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const gambarInput = document.getElementById('gambarInput');
        const previewGambar = document.getElementById('previewGambar');

        if (gambarInput && previewGambar) {
            gambarInput.addEventListener('change', function (event) {
                const file = event.target.files[0];

                if (file) {
                    previewGambar.src = URL.createObjectURL(file);
                }
            });
        }
    });
</script>
@endsection