@extends('layouts.app')

@section('content')
<div class="container-coffee">

    <!-- HEADER -->
    <div class="header">
        <div class="logo">✂ Arga's Home</div>
        <div class="menu-icon">☰</div>
    </div>

    <!-- HERO -->
    <div class="hero">
        <div class="overlay">
            <h1 class="heading-1">Menu Coffee</h1>
            <p class="text-small">Nikmati berbagai pilihan minuman kopi yang tersedia di barbershop kami</p>
        </div>
    </div>

    <!-- CARD MENU -->
    <div class="card">
        <h2 class="heading-2">Daftar Menu Coffee</h2>

        @php
        $menus = [
            ['name'=>'Espresso','desc'=>'Kopi hitam pekat tanpa tambahan','time'=>'30-50 menit','price'=>'12.000','img'=>'espresso.jpg'],
            ['name'=>'Americano','desc'=>'Espresso yang dicampur air panas','time'=>'30-50 menit','price'=>'15.000','img'=>'americano.jpg'],
            ['name'=>'Cappuccino','desc'=>'Espresso, susu, dan busa susu','time'=>'26-40 menit','price'=>'20.000','img'=>'cappuccino.jpg'],
            ['name'=>'Cafe Latte','desc'=>'Espresso dan susu yang creamy','time'=>'35-55 menit','price'=>'22.000','img'=>'latte.jpg'],
        ];
        @endphp

        @foreach($menus as $menu)
        <div class="menu-item">
            <img src="{{ asset('images/'.$menu['img']) }}" class="menu-img">

            <div class="menu-info">
                <h3 class="heading-3">{{ $menu['name'] }}</h3>
                <p class="text-small">{{ $menu['desc'] }}</p>

                <div class="meta">
                    <span>⏱ {{ $menu['time'] }}</span>
                    <span class="price">Rp{{ $menu['price'] }}</span>
                </div>
            </div>
        </div>
        @endforeach

        <div class="note">
            ☕ Nikmati pilihan kopi ini sambil potong rambut atau menunggu giliran.
        </div>

        <!-- BUTTON -->
        <button class="btn-primary full-width">Selengkapnya</button>

    </div>

</div>
@endsection