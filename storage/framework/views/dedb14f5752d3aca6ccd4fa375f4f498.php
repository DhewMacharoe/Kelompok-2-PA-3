<?php $__env->startSection('title', 'Lokasi dan Jam Operasional'); ?>

<?php $__env->startPush('styles'); ?>
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
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="row g-4 justify-content-center">
    <div class="col-12">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="fw-bold text-dark mb-1">Lokasi & Jam Operasional</h4>
                <p class="text-muted mb-0">Atur koordinat jangkauan antrean dan jam operasional outlet.</p>
            </div>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert" style="background-color: #d1e7dd; color: #0f5132;">
                <i class="bi bi-check-circle-fill me-2"></i> <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row g-4">
            <!-- Left Card: Peta & Pencarian -->
            <div class="col-lg-8">
                <div class="card location-card p-4 h-100 shadow-sm border-0">
                    <h5 class="fw-bold text-dark mb-4"><i class="bi bi-map text-primary me-2"></i>Peta & Lokasi</h5>
                    
                    <!-- Search Input -->
                    <div class="position-relative mb-4">
                        <label for="search-input" class="form-label fw-semibold text-muted mb-2">Cari Alamat / Link Maps</label>
                        <div class="input-group shadow-xs rounded-3 overflow-hidden">
                            <span class="input-group-text bg-light border-end-0" style="border-color: #cbd5e1;">
                                <i class="bi bi-geo-alt text-primary"></i>
                            </span>
                            <input type="text" id="search-input" class="form-control form-control-premium border-start-0 border-end-0" placeholder="Ketik alamat atau tempel tautan Google Maps..." autocomplete="off" style="border-color: #cbd5e1;">
                            <button type="button" id="btn-search" class="btn btn-primary px-4 fw-bold">Cari</button>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
                            <div class="form-text text-muted small mb-0 flex-grow-1" style="max-width: 70%;">
                                <i class="bi bi-info-circle text-primary me-1"></i> Tempel tautan Google Maps lengkap untuk koordinat presisi.
                            </div>
                            <button type="button" id="btn-reset-default" class="btn btn-outline-danger btn-sm rounded-3 fw-semibold py-1.5 px-3 border shadow-xs" style="font-size: 0.82rem;">
                                <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Lokasi
                            </button>
                        </div>
                        <div id="search-results" class="search-results-dropdown"></div>
                    </div>

                    <!-- Map container -->
                    <div id="map"></div>
                </div>
            </div>

            <!-- Right Card: Form Konfigurasi -->
            <div class="col-lg-4">
                <div class="card location-card p-4 h-100 shadow-sm border-0">
                    <form action="<?php echo e(route('admin.lokasi.store')); ?>" method="POST" id="locationForm" class="h-100 d-flex flex-column justify-content-between">
                        <?php echo csrf_field(); ?>
                        <div>
                            <h5 class="fw-bold text-dark mb-4 pb-2 border-bottom"><i class="bi bi-sliders text-primary me-2"></i>Konfigurasi Antrean</h5>

                            <!-- Koordinat (Latitude & Longitude) -->
                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <label for="latitude" class="form-label fw-semibold text-muted mb-1">Latitude</label>
                                    <input type="text" name="latitude" id="latitude" class="form-control form-control-premium bg-light text-muted" value="<?php echo e($latitude); ?>" readonly>
                                    <?php $__errorArgs = ['latitude'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="text-danger small"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="col-6">
                                    <label for="longitude" class="form-label fw-semibold text-muted mb-1">Longitude</label>
                                    <input type="text" name="longitude" id="longitude" class="form-control form-control-premium bg-light text-muted" value="<?php echo e($longitude); ?>" readonly>
                                    <?php $__errorArgs = ['longitude'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="text-danger small"><?php echo e($message); ?></span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <!-- Radius -->
                            <div class="mb-4">
                                <label for="radius_meters" class="form-label fw-semibold text-muted mb-1 d-flex justify-content-between">
                                    <span>Radius Jangkauan</span>
                                    <span class="text-primary fw-bold" id="radius-val"><?php echo e($radius); ?> Meter</span>
                                </label>
                                <input type="range" class="form-range" id="radius_slider" min="10" max="1000" step="10" value="<?php echo e($radius); ?>">
                                <input type="number" name="radius_meters" id="radius_meters" class="form-control form-control-premium mt-2" value="<?php echo e($radius); ?>" min="10" max="1000">
                                <span class="text-muted small">Atur batas radius pendaftaran pelanggan.</span>
                                <?php $__errorArgs = ['radius_meters'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger small"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Jam Operasional -->
                            <div class="mb-4 pt-3 border-top">
                                <h6 class="fw-bold text-dark mb-3"><i class="bi bi-clock text-primary me-2"></i>Jam Operasional</h6>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <label for="jam_buka" class="form-label fw-semibold text-muted mb-1">Buka</label>
                                        <input type="time" name="jam_buka" id="jam_buka" class="form-control form-control-premium" value="<?php echo e($jam_buka ?? '09:00'); ?>" required>
                                        <?php $__errorArgs = ['jam_buka'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="text-danger small"><?php echo e($message); ?></span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <div class="col-6">
                                        <label for="jam_tutup" class="form-label fw-semibold text-muted mb-1">Tutup</label>
                                        <input type="time" name="jam_tutup" id="jam_tutup" class="form-control form-control-premium" value="<?php echo e($jam_tutup ?? '21:00'); ?>" required>
                                        <?php $__errorArgs = ['jam_tutup'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="text-danger small"><?php echo e($message); ?></span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Status Hari Raya -->
                            <div class="mb-4 pt-3 border-top">
                                <h6 class="fw-bold text-dark mb-3"><i class="bi bi-calendar-event text-primary me-2"></i>Hari Raya & Fitur</h6>
                                <label for="keterangan_libur" class="form-label fw-semibold text-muted mb-1">Status Operasional Hari Raya</label>
                                <select name="keterangan_libur" id="keterangan_libur" class="form-select form-control-premium mb-3" required>
                                    <option value="libur" <?php echo e(($keterangan_libur ?? 'libur') === 'libur' ? 'selected' : ''); ?>>Libur pada Hari Raya</option>
                                    <option value="buka" <?php echo e(($keterangan_libur ?? 'libur') === 'buka' ? 'selected' : ''); ?>>Tetap Buka pada Hari Raya</option>
                                </select>
                                
                                <label for="is_booking_enabled" class="form-label fw-semibold text-muted mb-1">Fitur Booking Antrean</label>
                                <select name="is_booking_enabled" id="is_booking_enabled" class="form-select form-control-premium" required>
                                    <option value="1" <?php echo e(($is_booking_enabled ?? '1') === '1' ? 'selected' : ''); ?>>Aktif (Bisa Booking)</option>
                                    <option value="0" <?php echo e(($is_booking_enabled ?? '1') === '0' ? 'selected' : ''); ?>>Nonaktif (Hanya Walk-in)</option>
                                </select>
                                <span class="text-muted small d-block mt-1">Status ini menentukan apakah pelanggan bisa memesan antrean untuk hari ke depan.</span>
                                <?php $__errorArgs = ['is_booking_enabled'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="text-danger small"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="mt-auto pt-3">
                            <button type="submit" class="btn btn-primary w-100 py-2.5 fw-bold shadow-sm rounded-3 btn-save-premium" data-loading-text="Menyimpan...">
                                <i class="bi bi-save me-2"></i>Simpan Pengaturan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ambil nilai koordinat & radius awal
        let initLat = parseFloat("<?php echo e($latitude); ?>") || 2.33758;
        let initLon = parseFloat("<?php echo e($longitude); ?>") || 99.079255;
        let initRadius = parseInt("<?php echo e($radius); ?>") || 100;

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

            // Format 4: ll=latitude,longitude (e.g. ll=2.33758,99.079255)
            const llRegex = /[?&]ll=(-?\d+\.\d+),(-?\d+\.\d+)/;
            const llMatch = url.match(llRegex);
            if (llMatch) {
                return {
                    lat: parseFloat(llMatch[1]),
                    lng: parseFloat(llMatch[2])
                };
            }

            // Format 5: query=latitude,longitude (e.g. query=2.386130,99.147852)
            const queryRegex = /[?&]query=(-?\d+\.\d+),(-?\d+\.\d+)/;
            const queryMatch = url.match(queryRegex);
            if (queryMatch) {
                return {
                    lat: parseFloat(queryMatch[1]),
                    lng: parseFloat(queryMatch[2])
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

        // Reset to default location logic
        const btnResetDefault = document.getElementById('btn-reset-default');
        if (btnResetDefault) {
            btnResetDefault.addEventListener('click', function() {
                Swal.fire({
                    title: 'Reset Lokasi?',
                    text: 'Apakah Anda ingin mengembalikan lokasi ke lokasi default?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#0578FB',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Reset',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const defaultUrl = "<?php echo e($activeDesign && isset($activeDesign->kontak['link_map']) && !empty($activeDesign->kontak['link_map']) ? $activeDesign->kontak['link_map'] : 'https://www.google.com/maps?ll=2.33758,99.079255'); ?>";
                        let defaultLat = 2.33758;
                        let defaultLng = 99.079255;
                        
                        const coords = parseGoogleMapsUrl(defaultUrl);
                        if (coords) {
                            defaultLat = coords.lat;
                            defaultLng = coords.lng;
                        }
                        
                        searchInput.value = defaultUrl;
                        marker.setLatLng([defaultLat, defaultLng]);
                        circle.setLatLng([defaultLat, defaultLng]);
                        updateCoordinates(defaultLat, defaultLng);
                        map.setView([defaultLat, defaultLng], 17);
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Lokasi berhasil di-reset ke default. Jangan lupa untuk menekan tombol "Simpan Pengaturan" di sebelah kanan.',
                            confirmButtonColor: '#0578FB'
                        });
                    }
                });
            });
        }

        // Tutup dropdown pencarian ketika klik di luar
        document.addEventListener('click', function(e) {
            if (e.target !== searchInput && e.target !== btnSearch && e.target !== searchResults) {
                searchResults.style.display = 'none';
            }
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH K:\Deploy-Argahomes\resources\views/admin/lokasi/index.blade.php ENDPATH**/ ?>