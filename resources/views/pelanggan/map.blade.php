@extends('layouts.public')

@section('title', 'Pilih Barbershop Terdekat')
@section('hide_public_chrome', '1')

@section('head')
    <!-- LeafletJS CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <style>
        .map-portal-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }
        .portal-header {
            text-align: center;
            margin-bottom: 40px;
        }
        .portal-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 12px;
            letter-spacing: -0.025em;
        }
        .portal-subtitle {
            font-size: 1.125rem;
            color: #64748b;
            max-width: 600px;
            margin: 0 auto;
        }
        .portal-layout {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 30px;
            margin-top: 20px;
        }
        @media (max-width: 968px) {
            .portal-layout {
                grid-template-columns: 1fr;
            }
        }
        .map-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            overflow: hidden;
            padding: 10px;
        }
        #map {
            height: 600px;
            width: 100%;
            border-radius: 16px;
            z-index: 1;
        }
        .sidebar-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .sidebar-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1e293b;
            border-bottom: 1px solid #f1f5f9;
            padding-bottom: 12px;
        }
        .barber-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
            overflow-y: auto;
            max-height: 500px;
            padding-right: 4px;
        }
        .barber-item {
            padding: 16px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .barber-item:hover {
            border-color: #3b82f6;
            background: #f0f9ff;
            transform: translateY(-2px);
        }
        .barber-name {
            font-weight: 700;
            color: #0f172a;
            font-size: 1rem;
            margin-bottom: 4px;
        }
        .barber-address {
            font-size: 0.825rem;
            color: #64748b;
            margin-bottom: 10px;
            line-height: 1.4;
        }
        .btn-visit {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 8px 16px;
            background: #2563eb;
            color: #ffffff;
            font-weight: 600;
            font-size: 0.875rem;
            border-radius: 8px;
            text-decoration: none;
            transition: background-color 0.2s ease;
        }
        .btn-visit:hover {
            background: #1d4ed8;
            color: #ffffff;
        }
        /* Leaflet popup customization */
        .leaflet-popup-content-wrapper {
            border-radius: 12px;
            padding: 6px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .leaflet-popup-content h3 {
            font-size: 1.1rem;
            font-weight: 700;
            color: #0f172a;
            margin: 0 0 6px 0;
        }
        .leaflet-popup-content p {
            font-size: 0.85rem;
            color: #475569;
            margin: 0 0 12px 0;
            line-height: 1.4;
        }
    </style>
@endsection

@section('content')
<div class="map-portal-container">
    <div class="portal-header">
        <h1 class="portal-title">Pilih Barbershop Anda</h1>
        <p class="portal-subtitle">Cari lokasi barbershop terdekat, pantau antrean secara langsung, dan pesan layanan Anda dengan mudah.</p>
    </div>

    <div class="portal-layout">
        <!-- Map Container -->
        <div class="map-card">
            <div id="map"></div>
        </div>

        <!-- Sidebar / List -->
        <div class="sidebar-card">
            <h2 class="sidebar-title">Daftar Barbershop</h2>
            <div class="barber-list">
                @foreach($barbershops as $barbershop)
                    <div class="barber-item" onclick="focusBarber({{ $barbershop->latitude }}, {{ $barbershop->longitude }}, {{ $barbershop->id }})">
                        <div class="barber-name">{{ $barbershop->nama }}</div>
                        <div class="barber-address">{{ $barbershop->alamat ?? 'Alamat tidak tersedia' }}</div>
                        <a href="{{ url('/barbershop/' . $barbershop->slug) }}" class="btn-visit">Kunjungi Barbershop</a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <!-- LeafletJS Script -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        // Inisialisasi peta berpusat di Balige, Sumatera Utara (sekitar lokasi koordinat seeder)
        var map = L.map('map').setView([2.3845, 99.1480], 14);

        // Tile layer gratis menggunakan OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Simpan marker dalam objek untuk interaksi sidebar
        var markers = {};

        @foreach($barbershops as $barbershop)
            @if($barbershop->latitude && $barbershop->longitude)
                var marker = L.marker([{{ $barbershop->latitude }}, {{ $barbershop->longitude }}]).addTo(map);
                
                var popupContent = `
                    <div>
                        <h3>{{ $barbershop->nama }}</h3>
                        <p>{{ $barbershop->alamat ?? 'Alamat tidak tersedia.' }}</p>
                        <a href="{{ url('/barbershop/' . $barbershop->slug) }}" class="btn-visit">Kunjungi Barbershop</a>
                    </div>
                `;
                
                marker.bindPopup(popupContent);
                markers[{{ $barbershop->id }}] = marker;
            @endif
        @endforeach

        // Fungsi saat item sidebar diklik
        function focusBarber(lat, lng, id) {
            map.setView([lat, lng], 16, {
                animate: true,
                duration: 1
            });
            
            if (markers[id]) {
                setTimeout(function() {
                    markers[id].openPopup();
                }, 500);
            }
        }
    </script>
@endpush
