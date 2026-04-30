@extends('admin.layouts.app')

@section('title', 'Galeri')

@section('content')

@push  ('styles')
<link rel="stylesheet" href="{{ asset('css/admin_galeri.css') }}">
@endpush

<div class="content-body">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">

        <a href="{{ route('admin.galeri.create') }}" class="btn btn-success">
            + Tambah
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th style="width: 80px;">No</th>
                    <th style="width: 160px;">Foto</th>
                    <th>Judul</th>
                    <th style="width: 120px;">Status</th>
                    <th style="width: 300px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($galeris as $galeri)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>
                               <img src="{{ \Illuminate\Support\Str::startsWith($galeri->gambar, ['http://', 'https://']) ? $galeri->gambar : asset('images/' . $galeri->gambar) }}"
                                 alt="{{ $galeri->judul }}"
                                 style="width: 120px; height: 80px; object-fit: cover; border-radius: 8px;">
                        </td>

                        <td>
                            <strong>{{ $galeri->judul }}</strong>
                            @if($galeri->deskripsi)
                                <br>
                                <small class="text-muted">{{ Str::limit($galeri->deskripsi, 80) }}</small>
                            @endif
                        </td>

                        <td>
                            @if($galeri->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </td>

                        <td>
                            <form action="{{ route('admin.galeri.toggleStatus', $galeri) }}"
                                  method="POST"
                                  class="d-inline">
                                @csrf
                                @method('PATCH')

                                <button type="submit"
                                        class="btn btn-warning btn-sm"
                                        data-loading-text="Memproses...">
                                    {{ $galeri->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>

                            <a href="{{ route('admin.galeri.edit', $galeri) }}"
                               class="btn btn-primary btn-sm">
                                Edit
                            </a>

                            <button type="button"
                                    class="btn btn-danger btn-sm btn-delete-galeri"
                                    data-action="{{ route('admin.galeri.destroy', $galeri) }}"
                                    data-judul="{{ $galeri->judul }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteGaleriModal">
                                Hapus
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            Belum ada foto galeri.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Konfirmasi Hapus Galeri --}}
<div class="modal fade" id="deleteGaleriModal" tabindex="-1" aria-labelledby="deleteGaleriModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="deleteGaleriModalLabel">
                    Hapus Foto Galeri?
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <div class="modal-body">
                <p class="mb-2">
                    Foto galeri <strong id="deleteGaleriTitle">ini</strong> akan dihapus secara permanen.
                </p>
                <p class="text-muted mb-0">
                    Foto yang sudah dihapus tidak akan tampil lagi di halaman pelanggan.
                </p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Batal
                </button>

                <form id="deleteGaleriForm" method="POST">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger" data-loading-text="Menghapus...">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.btn-delete-galeri');
        const deleteForm = document.getElementById('deleteGaleriForm');
        const deleteTitle = document.getElementById('deleteGaleriTitle');

        deleteButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                const action = this.getAttribute('data-action');
                const judul = this.getAttribute('data-judul');

                deleteForm.setAttribute('action', action);
                deleteTitle.textContent = judul;
            });
        });
    });
</script>
@endsection
