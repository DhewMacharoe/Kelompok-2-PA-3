@extends('admin.layouts.app')

@section('title', 'Tentukan Lokasi')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<style>
    /* Card Premium Styling */
    .location-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        border: none;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .location-card:hover {
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
    }

    #map {
        height: 500px;
        width: 100%;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.06);
    }

    .form-control-premium {
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        padding: 12px 16px;
        transition: all 0.3s;
        font-size: 0.95rem;
    }

    .form-control-premium:focus {
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 4px rgba(5, 120, 251, 0.15);
    }

    .btn-save-premium {
        background-color: var(--primary-blue);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s;
        box-shadow: 0 4px 12px rgba(5, 120, 251, 0.3);
    }

    .btn-save-premium:hover:not(:disabled) {
        background-color: #0466d6;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(5, 120, 251, 0.4);
    }

    .btn-save-premium:active:not(:disabled) {
        transform: translateY(0);
    }

    /* Search Results Dropdown */
    .search-results-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        z-index: 1000;
        max-height: 250px;
        overflow-y: auto;
        display: none;
    }

    .search-result-item {
        padding: 10px 16px;
        cursor: pointer;
        transition: background 0.2s;
        font-size: 0.9rem;
        border-bottom: 1px solid #f1f5f9;
    }

    .search-result-item:last-child {
        border-bottom: none;
    }

    .search-result-item:hover {
        background: #f1f5f9;
    }
</style>
@endpush

@section('content')
<div class="row g-4 justify-content-center">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="fw-bold text-dark mb-1">Tentukan Lokasi Antrean</h4>
                <p class="text-muted mb-0">Atur koordinat pusat dan radius jangkauan antrean agar pelanggan dapat mendaftar dalam radius tersebut.</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert" style="background-color: #d1e7dd; color: #0f5132;">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card location-card p-4">
            <div class="row g-4">
                <div class="col-lg-8">
                    <!-- Search Input -->
                    <div class="position-relative mb-3">
                        <label for="search-input" class="form-label fw-semibold text-muted">Cari Alamat atau Tempel URL Google Maps</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 rounded-start-3" style="border-color: #cbd5e1;">
                                <i class="bi bi-geo-alt text-muted"></i>
                            </span>
                            <input type="text" id="search-input" class="form-control form-control-premium border-start-0 rounded-end-3" placeholder="Masukkan nama tempat / alamat, atau tempel URL Google Maps..." autocomplete="off">
                            <button type="button" id="btn-search" class="btn btn-outline-secondary rounded-3 ms-2 px-3 fw-semibold">Proses</button>
                        </div>
                        <div class="form-text mt-1 text-muted small">
                            <i class="bi bi-info-circle me-1"></i> Anda bisa mencari alamat secara langsung, atau menempelkan URL Google Maps lengkap dari address bar browser (contoh: <code>https://www.google.com/maps/place/.../@2.33758,99.079255,...</code>) untuk presisi koordinat 100%.
                        </div>
                        <div id="search-results" class="search-results-dropdown"></div>
                    </div>

                    <!-- Map container -->
                    <div id="map"></div>
                </div>

                <div class="col-lg-4">
                    <form action="{{ route('admin.lokasi.store') }}" method="POST" id="locationForm" class="h-100 d-flex flex-column justify-content-between">
                        @csrf
                        <div>
                            <h5 class="fw-bold text-dark mb-4 border-bottom pb-2">Informasi Koordinat</h5>

                            <!-- Latitude -->
                            <div class="mb-3">
                                <label for="latitude" class="form-label fw-semibold text-muted">Latitude (Garis Lintang)</label>
                                <input type="text" name="latitude" id="latitude" class="form-control form-control-premium bg-light" value="{{ $latitude }}" readonly>
                                @error('latitude')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Longitude -->
                            <div class="mb-3">
                                <label for="longitude" class="form-label fw-semibold text-muted">Longitude (Garis Bujur)</label>
                                <input type="text" name="longitude" id="longitude" class="form-control form-control-premium bg-light" value="{{ $longitude }}" readonly>
                                @error('longitude')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Radius -->
                            <div class="mb-4">
                                <label for="radius_meters" class="form-label fw-semibold text-muted d-flex justify-content-between">
                                    <span>Radius Jangkauan</span>
                                    <span class="text-primary fw-bold" id="radius-val">{{ $radius }} Meter</span>
                                </label>
                                <input type="range" class="form-range" id="radius_slider" min="10" max="1000" step="10" value="{{ $radius }}">
                                <input type="number" name="radius_meters" id="radius_meters" class="form-control form-control-premium mt-2" value="{{ $radius }}" min="10" max="1000">
                                <span class="text-muted small">Tentukan radius melingkar dari titik koordinat dalam satuan meter.</span>
                                @error('radius_meters')
                                    <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-top">
                            <button type="submit" class="btn-save-premium w-100 shadow-sm" data-loading-text="Menyimpan...">
                                <i class="bi bi-save me-2"></i> Simpan Lokasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ambil nilai koordinat & radius awal
        let initLat = parseFloat("{{ $latitude }}") || 2.33758;
        let initLon = parseFloat("{{ $longitude }}") || 99.079255;
        let initRadius = parseInt("{{ $radius }}") || 100;

        // Inisialisasi Peta Leaflet
        const map = L.map('map').setView([initLat, initLon], 16);

        // Tambah Tile Layer OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Buat Marker yang Draggable
        const marker = L.marker([initLat, initLon], {
            draggable: true
        }).addTo(map);

        // Buat Circle Radius Jangkauan
        const circle = L.circle([initLat, initLon], {
            color: '#0578FB',
            fillColor: '#0578FB',
            fillOpacity: 0.15,
            radius: initRadius
        }).addTo(map);

        // Update nilai input form
        function updateCoordinates(lat, lng) {
            document.getElementById('latitude').value = lat.toFixed(6);
            document.getElementById('longitude').value = lng.toFixed(6);
        }

        // Event saat Marker di-drag
        marker.on('drag', function(e) {
            const position = marker.getLatLng();
            updateCoordinates(position.lat, position.lng);
            circle.setLatLng(position);
        });

        // Event saat Marker selesai di-drag
        marker.on('dragend', function(e) {
            const position = marker.getLatLng();
            map.panTo(position);
        });

        // Event saat Peta di-klik
        map.on('click', function(e) {
            const lat = e.latlng.lat;
            const lng = e.latlng.lng;
            marker.setLatLng([lat, lng]);
            circle.setLatLng([lat, lng]);
            updateCoordinates(lat, lng);
            map.panTo([lat, lng]);
        });

        // Slider & Input Radius Logic
        const radiusSlider = document.getElementById('radius_slider');
        const radiusInput = document.getElementById('radius_meters');
        const radiusValText = document.getElementById('radius-val');

        function updateRadius(val) {
            let parsedVal = parseInt(val);
            if (isNaN(parsedVal) || parsedVal < 10) parsedVal = 10;
            if (parsedVal > 1000) parsedVal = 1000;
            
            radiusSlider.value = parsedVal;
            radiusInput.value = parsedVal;
            radiusValText.textContent = parsedVal + ' Meter';
            circle.setRadius(parsedVal);
        }

        radiusSlider.addEventListener('input', function(e) {
            updateRadius(e.target.value);
        });

        radiusInput.addEventListener('input', function(e) {
            updateRadius(e.target.value);
        });

        // Google Maps URL Regex Parser
        function parseGoogleMapsUrl(url) {
            // Format 1: @latitude,longitude (e.g. /@2.33758,99.079255)
            const atRegex = /@(-?\d+\.\d+),(-?\d+\.\d+)/;
            const atMatch = url.match(atRegex);
            if (atMatch) {
                return {
                    lat: parseFloat(atMatch[1]),
                    lng: parseFloat(atMatch[2])
                };
            }

            // Format 2: q=latitude,longitude
            const qRegex = /[?&]q=(-?\d+\.\d+),(-?\d+\.\d+)/;
            const qMatch = url.match(qRegex);
            if (qMatch) {
                return {
                    lat: parseFloat(qMatch[1]),
                    lng: parseFloat(qMatch[2])
                };
            }

            // Format 3: /dir/.../latitude,longitude
            const dirRegex = /\/dir\/[^\/]+\/(-?\d+\.\d+),(-?\d+\.\d+)/;
            const dirMatch = url.match(dirRegex);
            if (dirMatch) {
                return {
                    lat: parseFloat(dirMatch[1]),
                    lng: parseFloat(dirMatch[2])
                };
            }

            return null;
        }

        // Nominatim Geocoding Search & Google Maps URL processing logic
        const searchInput = document.getElementById('search-input');
        const btnSearch = document.getElementById('btn-search');
        const searchResults = document.getElementById('search-results');
        let searchTimeout;

        async function triggerSearch() {
            const query = searchInput.value.trim();
            if (!query) {
                searchResults.style.display = 'none';
                return;
            }

            // Check if input is a Google Maps URL
            if (query.startsWith('http://') || query.startsWith('https://') || query.includes('google.com/maps')) {
                const coords = parseGoogleMapsUrl(query);
                searchResults.innerHTML = '';

                if (coords) {
                    marker.setLatLng([coords.lat, coords.lng]);
                    circle.setLatLng([coords.lat, coords.lng]);
                    updateCoordinates(coords.lat, coords.lng);
                    map.setView([coords.lat, coords.lng], 17);

                    const successItem = document.createElement('div');
                    successItem.className = 'search-result-item text-success fw-semibold';
                    successItem.innerHTML = '<i class="bi bi-check-circle-fill me-2"></i> Koordinat berhasil diekstrak dari URL Google Maps!';
                    searchResults.appendChild(successItem);
                    searchResults.style.display = 'block';

                    setTimeout(() => {
                        searchResults.style.display = 'none';
                    }, 3000);
                } else if (query.includes('maps.app.goo.gl')) {
                    const warnItem = document.createElement('div');
                    warnItem.className = 'search-result-item text-warning small';
                    warnItem.innerHTML = '<i class="bi bi-exclamation-triangle-fill me-2"></i> Tautan singkat tidak didukung secara langsung. Buka link tersebut terlebih dahulu di browser Anda, lalu salin URL lengkap di address bar.';
                    searchResults.appendChild(warnItem);
                    searchResults.style.display = 'block';
                } else {
                    const errItem = document.createElement('div');
                    errItem.className = 'search-result-item text-danger small';
                    errItem.innerHTML = '<i class="bi bi-x-circle-fill me-2"></i> URL Google Maps tidak valid atau format koordinat tidak ditemukan.';
                    searchResults.appendChild(errItem);
                    searchResults.style.display = 'block';
                }
                return;
            }

            // Standard Geosearch using Nominatim OSM
            try {
                const response = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=5`);
                const data = await response.json();
                
                searchResults.innerHTML = '';
                if (data && data.length > 0) {
                    data.forEach(result => {
                        const item = document.createElement('div');
                        item.className = 'search-result-item';
                        item.textContent = result.display_name;
                        item.addEventListener('click', function() {
                            const lat = parseFloat(result.lat);
                            const lon = parseFloat(result.lon);
                            
                            marker.setLatLng([lat, lon]);
                            circle.setLatLng([lat, lon]);
                            updateCoordinates(lat, lon);
                            map.setView([lat, lon], 17);
                            
                            searchInput.value = result.display_name;
                            searchResults.style.display = 'none';
                        });
                        searchResults.appendChild(item);
                    });
                    searchResults.style.display = 'block';
                } else {
                    const noResult = document.createElement('div');
                    noResult.className = 'search-result-item text-muted text-center';
                    noResult.textContent = 'Lokasi tidak ditemukan';
                    searchResults.appendChild(noResult);
                    searchResults.style.display = 'block';
                }
            } catch (error) {
                console.error('Nominatim API error:', error);
            }
        }

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            // Don't auto-trigger Nominatim geocoding on URL paste to prevent premature requests
            const val = searchInput.value.trim();
            if (!val.startsWith('http') && !val.includes('google.com/maps')) {
                searchTimeout = setTimeout(triggerSearch, 500);
            }
        });

        btnSearch.addEventListener('click', triggerSearch);

        // Tutup dropdown pencarian ketika klik di luar
        document.addEventListener('click', function(e) {
            if (e.target !== searchInput && e.target !== btnSearch && e.target !== searchResults) {
                searchResults.style.display = 'none';
            }
        });
    });
</script>
@endpush
