@extends('admin.layouts.app')

@section('title', 'Layanan')

@section('header_title')
    <div class="header-title">Layanan</div>
@endsection

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .main-container {
            padding: 20px;
            font-family: 'Inter', sans-serif;
            max-width: 1180px;
            margin: 0 auto;
        }

        .btn-tambah {
            background-color: #4CC779;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            margin: 0;
            font-weight: 500;
            cursor: pointer;
        }

        .table-container {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        .custom-table thead {
            background-color: #2C3E50;
            color: white;
        }

        .custom-table th,
        .custom-table td {
            padding: 15px;
            border-bottom: 1px solid #eee;
        }

        .status-text {
            font-weight: 500;
        }

        .action-link {
            color: #4a80da;
            text-decoration: none;
            font-weight: 600;
        }

        .badge-active {
            background-color: #4CC779;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
        }

        .badge-inactive {
            background-color: #EB5757;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
        }

        .table-thumb {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .btn {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background-color: #2F80ED;
            color: white;
        }

        .btn-secondary {
            background-color: #7B7F88;
            color: white;
        }

        .btn-warning {
            background-color: #F39C12;
            color: white;
        }

        .btn-success {
            background-color: #4CC779;
            color: white;
        }

        .btn-danger {
            background-color: #EB5757;
            color: white;
        }

        .empty-row {
            padding: 40px;
            color: #999;
        }

        .detail-modal {
            display: none;
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.6);
            justify-content: center;
            align-items: center;
            z-index: 9999;
            padding: 20px;
        }

        .detail-modal.show {
            display: flex;
        }

        .detail-modal-card {
            width: 100%;
            max-width: 780px;
            background: white;
            border-radius: 20px;
            padding: 24px;
            position: relative;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .detail-modal-close {
            position: absolute;
            top: 18px;
            right: 18px;
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #556673;
        }

        .detail-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 24px;
        }

        .detail-modal-img {
            width: 260px;
            height: 260px;
            border-radius: 18px;
            background-color: #f5f7fb;
            background-position: center;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #8b97a6;
            font-weight: 600;
            text-align: center;
            padding: 20px;
        }

        .detail-modal-body {
            display: grid;
            gap: 16px;
        }

        .detail-modal-item {
            display: flex;
            justify-content: space-between;
            padding: 16px;
            border-radius: 12px;
            background-color: #f9fbff;
            border: 1px solid #e7ecf6;
        }

        .detail-modal-item strong {
            color: #2C3E50;
        }

        .detail-modal-desc {
            padding: 16px;
            border-radius: 12px;
            background-color: #f9fbff;
            border: 1px solid #e7ecf6;
            color: #556673;
            line-height: 1.7;
        }
    </style>

    <div class="main-container">
        @if (session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: "{{ addslashes(session('success')) }}",
                        showConfirmButton: false,
                        timer: 2000
                    });
                });
            </script>
        @endif

        <div
            style="display: flex; flex-wrap: wrap; gap: 12px; align-items: flex-end; justify-content: space-between; margin-bottom: 8px;">
            <div style="display: flex; flex-wrap: wrap; gap: 12px; align-items: flex-end; flex: 1; min-width: 320px;">
                <div>
                    <label for="statusFilter"
                        style="font-weight: 600; color: #2C3E50; display:block; margin-bottom:6px;">Status</label>
                    <select id="statusFilter"
                        style="padding: 10px 12px; border-radius: 8px; border: 1px solid #ddd; min-width: 160px;">
                        <option value="" {{ empty($status) ? 'selected' : '' }}>Semua</option>
                        <option value="aktif" {{ ($status ?? '') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ ($status ?? '') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
                <div style="min-width: 240px; flex: 1;">
                    <label for="searchInput"
                        style="font-weight: 600; color: #2C3E50; display:block; margin-bottom:6px;">Cari Layanan</label>
                    <input id="searchInput" type="text" placeholder="Ketik nama layanan..."
                        style="width:100%; padding: 10px 12px; border-radius: 8px; border: 1px solid #ddd;">
                </div>
            </div>

            <div style="display: flex; align-items: flex-end;">
                <a href="{{ route('admin.layanan.create') }}" class="btn-tambah shadow-sm" style="white-space: nowrap;">+
                    Tambah</a>
            </div>
        </div>

        <div id="searchSuggestion" style="margin-bottom: 16px; color: #4d648d; font-size: 0.95rem;"></div>

        <div class="table-container">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($layanans as $item)
                        <tr data-name="{{ strtolower($item->nama) }}"
                            data-status="{{ $item->is_active ? 'aktif' : 'nonaktif' }}"
                            data-description="{{ strtolower($item->deskripsi ?? '') }}">
                            <td>{{ $item->nama }}</td>
                            <td>
                                @if ($item->is_active)
                                    <span class="badge badge-active">Aktif</span>
                                @else
                                    <span class="badge badge-inactive">Nonaktif</span>
                                @endif
                            </td>
                            <td class="action-buttons">
                                <button type="button" class="btn btn-secondary btn-sm btn-view"
                                    data-nama="{{ $item->nama }}"
                                    data-foto="{{ $item->foto ? (\Illuminate\Support\Str::startsWith($item->foto, ['http://', 'https://']) ? $item->foto : asset('images/' . $item->foto)) : '' }}"
                                    data-harga="Rp {{ number_format($item->harga, 0, ',', '.') }}"
                                    data-estimasi="{{ $item->estimasi_waktu ?? '-' }}"
                                    data-status="{{ $item->is_active ? 'Aktif' : 'Nonaktif' }}"
                                    data-deskripsi="{{ str_replace(["\r", "\n"], ' ', e($item->deskripsi ?? 'Tidak ada deskripsi tambahan.')) }}">View</button>

                                <form action="{{ route('admin.layanan.toggleStatus', $item->id) }}" method="POST"
                                    class="form-toggle" data-nama="{{ $item->nama }}"
                                    data-status="{{ $item->is_active ? 'nonaktifkan' : 'aktifkan' }}"
                                    style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="button"
                                        class="btn {{ $item->is_active ? 'btn-warning' : 'btn-success' }} btn-sm btn-toggle-alert">
                                        {{ $item->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>
                                </form>

                                <a href="{{ route('admin.layanan.edit', $item->id) }}"
                                    class="btn btn-primary btn-sm">Edit</a>

                                <button type="button" class="btn btn-danger btn-sm btn-delete-alert"
                                    data-id="{{ $item->id }}" data-nama="{{ $item->nama }}">Hapus</button>

                                <form id="delete-form-{{ $item->id }}"
                                    action="{{ route('admin.layanan.destroy', $item->id) }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="empty-row">Belum ada data layanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="detailModal" class="detail-modal">
        <div class="detail-modal-card">
            <button id="detailClose" class="detail-modal-close">&times;</button>
            <div class="detail-modal-header">
                <div>
                    <h2 id="detailNama">Nama Layanan</h2>
                    <p id="detailLabel" style="margin-top: 8px; color: #556673;">Detail lengkap layanan barbershop.</p>
                </div>
            </div>
            <div class="detail-modal-body">
                <div class="detail-modal-item"><strong>Harga</strong> <span id="detailHarga">-</span></div>
                <div class="detail-modal-item"><strong>Estimasi Waktu</strong> <span id="detailEstimasi">-</span></div>
                <div class="detail-modal-item"><strong>Status</strong> <span id="detailStatus">-</span></div>
                <div class="detail-modal-desc"><strong>Deskripsi:</strong>
                    <p id="detailDeskripsi" style="margin-top: 8px;">-</p>
                </div>
            </div>
        </div>
    </div>
    <div style="height:50px;"></div>
@endsection
