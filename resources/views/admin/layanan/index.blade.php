@extends('layouts.admin')

@section('title', 'Layanan')
@section('header_title', 'Layanan')

@section('content')
<div class="section-card">
    <div class="section-header">
        <h2>Layanan</h2>
        <a href="{{ route('admin.layanan.create') }}" class="btn btn-success">+ Tambah</a>
    </div>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-card">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Estimasi</th>
                    <th>Status</th>
                    <th>Foto</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($layanans as $item)
                    <tr>
                        <td>{{ $item->nama }}</td>
                        <td>{{ ucfirst($item->kategori) }}</td>
                        <td>Rp{{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td>{{ $item->estimasi_waktu ?? '-' }}</td>
                        <td>
                            @if($item->is_active)
                                <span class="badge badge-active">Aktif</span>
                            @else
                                <span class="badge badge-inactive">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            @if($item->foto)
                                <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama }}" class="table-thumb">
                            @else
                                -
                            @endif
                        </td>
                        <td class="action-buttons">
                            <a href="{{ route('admin.layanan.edit', $item->id) }}" class="btn btn-primary btn-sm">Edit</a>

                            <form action="{{ route('admin.layanan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus layanan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty-row">Belum ada data layanan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection