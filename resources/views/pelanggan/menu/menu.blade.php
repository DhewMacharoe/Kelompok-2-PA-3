@extends('pelanggan.layouts.app')

@section('title', 'Menu Kafe')

@push('styles')
    @include('pelanggan.menu.styles')
@endpush

@section('content')
    <section class="menu-hero">
        <div class="menu-hero-overlay">
            <div class="menu-hero-text">
                <h1>Menu Coffee</h1>
                <p>Nikmati berbagai pilihan minuman kopi yang tersedia di barbershop kami.</p>
            </div>
        </div>
    </section>

    <section class="menu-content">
        <div class="menu-section-header">
            <h2>Daftar Menu Coffee</h2>
            <div class="menu-line"></div>
        </div>

        <div class="menu-list">
            @forelse ($menus as $menu)
                <div class="menu-card">
                    <div class="menu-card-image">
                        @php
                            // Sementara: dukung URL eksternal API gambar.
                            // <img src="{{ asset('storage/' . $menu->foto) }}" alt="{{ $menu->nama }}">
                            $fotoMenu = null;
                            if (!empty($menu->foto)) {
                                $fotoMenu = \Illuminate\Support\Str::startsWith($menu->foto, ['http://', 'https://'])
                                    ? $menu->foto
                                    : asset('storage/' . $menu->foto);
                            }
                        @endphp
                        <img src="{{ $fotoMenu ?? 'https://via.placeholder.com/1200x800?text=No+Image' }}"
                            alt="{{ $menu->nama }}">
                    </div>
                    <div class="menu-card-body">
                        <h3>{{ $menu->nama }}</h3>
                        <p class="menu-desc">{{ $menu->deskripsi ?? '-' }}</p>
                        <div class="menu-meta">
                            <span class="menu-price">Rp{{ number_format($menu->harga, 0, ',', '.') }}</span>
                            @if (!$menu->is_available)
                                <span style="margin-left: 10px; color: #b71c1c; font-weight: 700;">Habis</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <p>Menu kafe belum tersedia saat ini.</p>
            @endforelse
        </div>

        <div class="menu-note">
            <div class="menu-note-icon">☕</div>
            <p>Nikmati pilihan kopi ini sambil potong rambut atau menunggu giliran.</p>
        </div>
    </section>
@endsection
