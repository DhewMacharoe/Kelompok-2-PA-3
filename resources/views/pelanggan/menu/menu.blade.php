@extends('pelanggan.layouts.app')

@section('title', 'Menu Kafe')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
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
            <div class="menu-card">
                <div class="menu-card-image">
                    <img src="https://images.unsplash.com/photo-1510707577719-ae7c14805e3a?q=80&w=1200&auto=format&fit=crop"
                        alt="Espresso">
                </div>
                <div class="menu-card-body">
                    <h3>Espresso</h3>
                    <p class="menu-desc">Kopi hitam pekat tanpa tambahan.</p>
                    <div class="menu-meta">
                        <span class="menu-price">Rp12.000</span>
                    </div>
                </div>
            </div>

            <div class="menu-card">
                <div class="menu-card-image">
                    <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?q=80&w=1200&auto=format&fit=crop"
                        alt="Americano">
                </div>
                <div class="menu-card-body">
                    <h3>Americano</h3>
                    <p class="menu-desc">Espresso yang dicampur air panas.</p>
                    <div class="menu-meta">
                        <span class="menu-price">Rp15.000</span>
                    </div>
                </div>
            </div>

            <div class="menu-card">
                <div class="menu-card-image">
                    <img src="https://images.unsplash.com/photo-1534778101976-62847782c213?q=80&w=1200&auto=format&fit=crop"
                        alt="Cappuccino">
                </div>
                <div class="menu-card-body">
                    <h3>Cappuccino</h3>
                    <p class="menu-desc">Espresso, susu, dan busa susu.</p>
                    <div class="menu-meta">
                        <span class="menu-price">Rp20.000</span>
                    </div>
                </div>
            </div>

            <div class="menu-card">
                <div class="menu-card-image">
                    <img src="https://images.unsplash.com/photo-1461023058943-07fcbe16d735?q=80&w=1200&auto=format&fit=crop"
                        alt="Cafe Latte">
                </div>
                <div class="menu-card-body">
                    <h3>Café Latte</h3>
                    <p class="menu-desc">Espresso dan susu yang creamy.</p>
                    <div class="menu-meta">
                        <span class="menu-price">Rp22.000</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="menu-note">
            <div class="menu-note-icon">☕</div>
            <p>Nikmati pilihan kopi ini sambil potong rambut atau menunggu giliran.</p>
        </div>
    </section>
@endsection
