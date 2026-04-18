@extends('admin.layouts.app')

@section('title', 'Menu Cafe')

@section('header_title')
<div class="header-title">Menu Kafe</div>
@endsection

@section('content')
<style>
    /* Layout Utama */
    .main-container {
        padding: 20px;
        background-color: #f4f4f4;
        min-height: 100vh;
    }

    /* Filter Bar */
    .filter-bar {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid #ccc;
    }

    .filter-btn {
        padding: 6px 15px;
        border-radius: 5px;
        border: 1px solid #adb5bd;
        background: white;
        font-size: 12px;
        font-weight: bold;
        color: #6c757d;
        text-transform: uppercase;
    }

    .filter-btn.active {
        background-color: #337ab7;
        color: white;
        border-color: #337ab7;
    }

    /* Grid Menu */
    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 20px;
    }

    /* Card Styling */
    .menu-card,
    .add-card {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        border: 1px solid #ddd;
    }

    .menu-card-body {
        display: flex;
        padding: 15px;
        gap: 15px;
    }

    .menu-img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 8px;
    }

    .menu-info {
        flex: 1;
    }

    .menu-title {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 5px;
        color: #333;
    }

    .menu-price {
        font-size: 14px;
        color: #d4a017;
        /* Warna emas/coklat gelap */
        font-weight: bold;
        margin-bottom: 8px;
    }

    /* Badge Aktif */
    .badge-aktif {
        background-color: #e8f5e9;
        color: #2e7d32;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 10px;
        font-weight: bold;
        border: 1px solid #c8e6c9;
    }

    /* Footer Card & Tombol */
    .menu-card-footer {
        display: flex;
        padding: 10px 15px;
        background-color: #f9f8f3;
        /* Warna krem muda sesuai gambar */
        gap: 10px;
    }

    .btn-edit {
        background-color: #ffc107;
        color: white;
        border: none;
        padding: 5px 15px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: bold;
    }

    .btn-nonaktif {
        background-color: #d9534f;
        color: white;
        border: none;
        padding: 5px 15px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: bold;
    }

    /* Card Tambah Menu */
    .add-card {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 150px;
        background-color: #f9f8f3;
        border: 1px solid #ddd;
    }

    .btn-tambahkan {
        background-color: #5cb85c;
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 5px;
        font-weight: bold;
        font-size: 12px;
    }
</style>



<div class="main-container">
    <div class="filter-bar">
        <button class="filter-btn active">SEMUA</button>
        <button class="filter-btn">AKTIF</button>
        <button class="filter-btn">NONAKTIF</button>
    </div>

    <div class="menu-grid">

        @foreach ($menus as $menu)
        <div class="menu-card">
            <div class="menu-card-body">

                {{-- FOTO --}}
                @if($menu->foto)
                <img src="{{ asset('storage/' . $menu->foto) }}" class="menu-img">
                @else
                <img src="https://via.placeholder.com/65" class="menu-img">
                @endif

                <div class="menu-info">
                    <h3 class="menu-title">{{ $menu->nama }}</h3>

                    <p class="menu-price">
                        Rp {{ number_format($menu->harga, 0, ',', '.') }}
                    </p>

                    {{-- STATUS --}}
                    @if($menu->is_available)
                    <span class="badge-aktif">AKTIF</span>
                    @else
                    <span class="badge-aktif" style="background:#fdecea;color:#b71c1c;border-color:#f5c6cb;">
                        NONAKTIF
                    </span>
                    @endif
                </div>
            </div>

            <div class="menu-card-footer">

                {{-- EDIT --}}
                <button class="btn-edit"
                    data-bs-toggle="modal"
                    data-bs-target="#modalEdit{{ $menu->id }}">
                    EDIT
                </button>

                {{-- TOGGLE STATUS --}}
                <form action="{{ route('admin.MenuCafe.update', $menu->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="nama" value="{{ $menu->nama }}">
                    <input type="hidden" name="harga" value="{{ $menu->harga }}">
                    <input type="hidden" name="deskripsi" value="{{ $menu->deskripsi }}">
                    <input type="hidden" name="is_available" value="{{ $menu->is_available ? 0 : 1 }}">

                    <button type="submit" class="btn-nonaktif">
                        {{ $menu->is_available ? 'NONAKTIFKAN' : 'AKTIFKAN' }}
                    </button>
                </form>

            </div>
        </div>
        @endforeach


        {{-- TAMBAH MENU --}}
        <div class="add-card">
            <button class="btn-tambahkan" data-bs-toggle="modal" data-bs-target="#modalCreate">
                TAMBAHKAN +
            </button>
        </div>

    </div>
    <!-- Modal Edit -->
    <div class="modal fade" id="modalEdit{{ $menu->id }}" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('admin.MenuCafe.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Edit Menu</h5>
                    </div>

                    <div class="modal-body">
                        <input type="text" name="nama" value="{{ $menu->nama }}" class="form-control mb-2">
                        <input type="number" name="harga" value="{{ $menu->harga }}" class="form-control mb-2">
                        <textarea name="deskripsi" class="form-control mb-2">{{ $menu->deskripsi }}</textarea>

                        <input type="file" name="foto" class="form-control mb-2">

                        <select name="is_available" class="form-control">
                            <option value="1" {{ $menu->is_available ? 'selected' : '' }}>Tersedia</option>
                            <option value="0" {{ !$menu->is_available ? 'selected' : '' }}>Tidak</option>
                        </select>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Create -->
    <div class="modal fade" id="modalCreate" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('admin.MenuCafe.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Tambah Menu</h5>
                    </div>

                    <div class="modal-body">
                        <input type="text" name="nama" placeholder="Nama" class="form-control mb-2">
                        <input type="number" name="harga" placeholder="Harga" class="form-control mb-2">
                        <textarea name="deskripsi" class="form-control mb-2"></textarea>
                        <input type="file" name="foto" class="form-control mb-2">

                        <select name="is_available" class="form-control">
                            <option value="1">Tersedia</option>
                            <option value="0">Tidak</option>
                        </select>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection