@extends('admin.layouts.app')

@section('title', 'Design Web')

@section('header_title')
    <div class="header-title">Design Web</div>
@endsection

@push('styles')
    @include('admin.galeri.style-index')
@endpush

@section('content')
    <div class="main-container">
        @if (session('success'))
            <div id="flash-success" data-message="{{ session('success') }}" hidden></div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const flashSuccess = document.getElementById('flash-success');
                    if (flashSuccess && flashSuccess.dataset.message) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: flashSuccess.dataset.message,
                            confirmButtonText: 'OK'
                        });
                    }
                });
            </script>
        @endif
        @if (session('error'))
            <div id="flash-error" data-message="{{ session('error') }}" hidden></div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const flashError = document.getElementById('flash-error');
                    if (flashError && flashError.dataset.message) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: flashError.dataset.message,
                            confirmButtonText: 'OK'
                        });
                    }
                });
            </script>
        @endif

        <a href="{{ route('admin.design.create') }}" class="btn-tambah shadow-sm">
            + Tambah
        </a>

        <div class="table-container mt-4">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Nama Brand</th>
                        <th>Email</th>
                        <th style="width: 120px;">Status</th>
                        <th style="width: 250px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($designs as $item)
                        <tr>
                            <td data-label="Nama Brand">
                                <strong>{{ $item->nama_brand }}</strong>
                            </td>
                            <td data-label="Email">
                                {{ $item->email }}
                            </td>
                            <td data-label="Status">
                                @if ($item->is_active)
                                    <span class="status-badge status-aktif" style="background-color: #198754; color: white;">Aktif</span>
                                @else
                                    <span class="status-badge status-nonaktif" style="background-color: #6c757d; color: white;">Nonaktif</span>
                                @endif
                            </td>
                            <td data-label="Aksi">
                                <div style="display: flex; gap: 5px; flex-wrap: nowrap; justify-content: center;">
                                    @if (!$item->is_active)
                                    <form action="{{ route('admin.design.activate') }}" method="POST"
                                        class="form-toggle" data-nama="{{ $item->nama_brand }}"
                                        style="display: inline; margin: 0;">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                        <button type="button"
                                            class="btn-action shadow-sm btn-activate-alert" style="margin: 0; background-color: #e8a53a; color: white; border: none; padding: 6px 12px; border-radius: 4px; font-size: 13px; font-weight: 500;">
                                            Aktifkan
                                        </button>
                                    </form>
                                    @else
                                    <form action="{{ route('admin.design.deactivate') }}" method="POST"
                                        class="form-toggle" data-nama="{{ $item->nama_brand }}"
                                        style="display: inline; margin: 0;">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                        <button type="button"
                                            class="btn-action shadow-sm btn-deactivate-alert" style="margin: 0; background-color: #6c757d; color: white; border: none; padding: 6px 12px; border-radius: 4px; font-size: 13px; font-weight: 500;">
                                            Nonaktifkan
                                        </button>
                                    </form>
                                    @endif

                                    <a href="{{ route('admin.design.edit', $item->id) }}"
                                        class="btn-action btn-edit shadow-sm" style="margin: 0;">
                                        Ubah
                                    </a>

                                    <button type="button" class="btn-action btn-hapus shadow-sm btn-delete-alert"
                                        data-id="{{ $item->id }}" data-nama="{{ $item->nama_brand }}" style="margin: 0;">
                                        Hapus
                                    </button>

                                    <form id="delete-form-{{ $item->id }}"
                                        action="{{ route('admin.design.destroy', $item->id) }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="empty-row-row">
                            <td colspan="4" class="empty-row-cell" style="padding: 40px; text-align: center; color: #999;">
                                Belum ada data design.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.querySelectorAll('.btn-activate-alert').forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('form');
                const nama = form.dataset.nama;

                Swal.fire({
                    title: 'Konfirmasi',
                    text: `Apakah Anda yakin ingin mengaktifkan design "${nama}"? Design yang sedang aktif akan otomatis dinonaktifkan.`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#e8a53a',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Aktifkan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        document.querySelectorAll('.btn-deactivate-alert').forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('form');
                const nama = form.dataset.nama;

                Swal.fire({
                    title: 'Konfirmasi',
                    text: `Apakah Anda yakin ingin menonaktifkan design "${nama}"? Jika tidak ada design yang aktif, tampilan web pelanggan akan kembali ke setelan default.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#6c757d',
                    cancelButtonColor: '#dc3545',
                    confirmButtonText: 'Ya, Nonaktifkan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        document.querySelectorAll('.btn-delete-alert').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                const nama = this.dataset.nama;

                Swal.fire({
                    title: 'Konfirmasi',
                    text: `Apakah Anda yakin ingin menghapus design "${nama}"? Data yang dihapus tidak dapat dikembalikan.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(`delete-form-${id}`).submit();
                    }
                });
            });
        });
    </script>
    <div style="height:50px;"></div>
@endsection
