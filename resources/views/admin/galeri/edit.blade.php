@extends('admin.layouts.app')

@section('title', 'Edit Galeri')

@section('content')
@push('styles')
    @include('admin.shared.style-common')
@endpush

<div class="content-header">
    <h2>Edit Galeri</h2>
</div>

<div class="content-body">
    <div class="card shadow-sm mx-auto form-card-wide">
        <div class="card-body">

            <form action="{{ route('admin.galeri.update', $galeri) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <x-form.field
                    label="Judul Galeri"
                    name="judul"
                    :value="$galeri->judul"
                    placeholder="Contoh: Suasana Arga Home's"
                    help="Gunakan judul yang singkat dan mudah dikenali."
                    required
                />

                <x-form.field
                    label="Deskripsi"
                    name="deskripsi"
                    type="textarea"
                    :value="$galeri->deskripsi"
                    :rows="4"
                    placeholder="Contoh: Dokumentasi suasana barbershop dan coffee."
                    help="Deskripsi singkat membantu pengguna memahami isi galeri."
                />

                <x-form.field
                    label="Gambar Galeri"
                    name="gambar"
                    type="file"
                    id="gambarInput"
                    accept="image/*"
                    help="Kosongkan jika tidak ingin mengganti gambar."
                />

                @if($galeri->gambar)
                    <div class="mb-3">
                        <label class="form-label">Preview Gambar Saat Ini</label>
                        <br>
                        <img id="previewGambar"
                            src="{{ \Illuminate\Support\Str::startsWith($galeri->gambar, ['http://', 'https://']) ? $galeri->gambar : asset('images/' . $galeri->gambar) }}"
                             alt="{{ $galeri->judul }}"
                             class="preview-image-medium">
                    </div>
                @endif

                <x-form.field
                    label="Status"
                    name="is_active"
                    type="select"
                    :options="['1' => 'Aktif', '0' => 'Nonaktif']"
                    :value="old('is_active', $galeri->is_active)"
                    help="Status aktif akan menampilkan galeri di halaman publik."
                    wrapperClass="mb-4"
                />

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