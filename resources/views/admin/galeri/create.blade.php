@extends('admin.layouts.app')

@section('title', 'Tambah Galeri')

@section('content')
@push('styles')
    @include('admin.shared.style-common')
@endpush

<div class="content-header">
    <h2>Tambah Galeri</h2>
</div>

<div class="content-body">
    <div class="card shadow-sm mx-auto form-card-wide">
        <div class="card-body">

            <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <x-form.field
                    label="Judul Galeri"
                    name="judul"
                    :value="old('judul')"
                    placeholder="Contoh: Suasana Arga Home's"
                    help="Gunakan judul yang singkat dan mudah dikenali."
                    required
                />

                <x-form.field
                    label="Deskripsi"
                    name="deskripsi"
                    type="textarea"
                    :value="old('deskripsi')"
                    :rows="4"
                    placeholder="Contoh: Dokumentasi suasana barbershop dan coffee."
                    help="Deskripsi singkat membantu pengguna memahami isi galeri."
                />

                <x-form.field
                    label="Gambar Galeri"
                    name="gambar"
                    type="file"
                    accept="image/*"
                    help="Gunakan JPG atau PNG agar tampilan tetap ringan dan tajam."
                    required
                />

                <x-form.field
                    label="Status"
                    name="is_active"
                    type="select"
                    :options="['1' => 'Aktif', '0' => 'Nonaktif']"
                    :value="old('is_active', '1')"
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
@endsection