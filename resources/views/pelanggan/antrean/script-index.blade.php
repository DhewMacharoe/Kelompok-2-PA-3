<script type="module">
    function formatJam(datetime) {
        const date = new Date(datetime);
        return date.toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    function setButtonDisabled(button, disabled) {
        if (!button) {
            return;
        }

        button.disabled = disabled;
        button.classList.toggle('disabled', disabled);
        button.setAttribute('aria-disabled', disabled ? 'true' : 'false');
        button.style.pointerEvents = disabled ? 'none' : '';
    }

    document.addEventListener('DOMContentLoaded', function() {
        const queueAppCard = document.querySelector('.app-card');
        const loggedInUsername = queueAppCard?.dataset.loggedInUsername || null;
        const queueLocation = {
            latitude: parseFloat(queueAppCard?.dataset.queueLatitude || '0'),
            longitude: parseFloat(queueAppCard?.dataset.queueLongitude || '0'),
            radiusMeters: parseInt(queueAppCard?.dataset.queueRadius || '100', 10),
        };


        const layananSelect1 = document.getElementById('layanan_id1');
        const layananSelect2 = document.getElementById('layanan_id2');
        const layananHelp = document.getElementById('layanan-help-pelanggan');
        const formTambahPelanggan = document.getElementById('formTambahAntreanPelanggan');
        const lokasiFeedback = document.getElementById('lokasi-feedback');
        const userLatitudeInput = document.getElementById('user_latitude');
        const userLongitudeInput = document.getElementById('user_longitude');
        const queueLocationStatus = document.getElementById('queue-location-status');
        const queueLocationDistance = document.getElementById('queue-location-distance');
        const queueLocationHelper = document.getElementById('queue-location-helper');
        const queueLocationMap = document.getElementById('queue-location-map');
        const queueLocationMapEmpty = document.getElementById('queue-location-map-empty');
        const queueListContainer = document.querySelector('.queue-list-container');
        const myQueueCard = document.getElementById('my-queue-card');
        const myQueueNumber = document.getElementById('my-queue-number');
        const myQueuePosition = document.getElementById('my-queue-position');
        const myQueueServices = document.getElementById('my-queue-services');
        const myQueueStatusChip = document.getElementById('my-queue-status-chip');
        const cancelQueueAction = document.getElementById('my-queue-cancel-action');
        const cancelQueueButton = document.getElementById('btn-cancel-my-queue');
        let queueLocationVerified = false;
        let queueLocationRequestInProgress = false;
        let queueLocationHasReading = false;
        let queueLocationWatchId = null;
        let leafletMap = null;
        let queueTargetMarker = null;
        let queueUserMarker = null;
        let queueRadiusCircle = null;
        let queueDistanceLine = null;

        function showLocationError(message) {
            if (!lokasiFeedback) {
                alert(message);
                return;
            }

            lokasiFeedback.textContent = message;
            lokasiFeedback.classList.remove('d-none');
        }

        function clearLocationError() {
            if (!lokasiFeedback) {
                return;
            }

            lokasiFeedback.textContent = '';
            lokasiFeedback.classList.add('d-none');
        }

        function toRadians(value) {
            return value * Math.PI / 180;
        }

        function calculateDistanceMeters(fromLatitude, fromLongitude, toLatitude, toLongitude) {
            const earthRadius = 6371000;
            const latitudeDifference = toRadians(toLatitude - fromLatitude);
            const longitudeDifference = toRadians(toLongitude - fromLongitude);
            const a = Math.sin(latitudeDifference / 2) * Math.sin(latitudeDifference / 2)
                + Math.cos(toRadians(fromLatitude)) * Math.cos(toRadians(toLatitude))
                * Math.sin(longitudeDifference / 2) * Math.sin(longitudeDifference / 2);

            return earthRadius * (2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a)));
        }

        function hasQueueLocationConfig() {
            return Number.isFinite(queueLocation.latitude)
                && Number.isFinite(queueLocation.longitude)
                && queueLocation.latitude !== 0
                && queueLocation.longitude !== 0;
        }

        function initializeLeafletMap() {
            if (!queueLocationMap) {
                return;
            }

            if (!hasQueueLocationConfig()) {
                if (queueLocationMapEmpty) {
                    queueLocationMapEmpty.textContent = 'Lokasi antrean belum dikonfigurasi.';
                    queueLocationMapEmpty.classList.remove('d-none');
                }
                return;
            }

            if (typeof window.L === 'undefined') {
                if (queueLocationMapEmpty) {
                    queueLocationMapEmpty.textContent = 'Leaflet gagal dimuat. Coba refresh halaman.';
                    queueLocationMapEmpty.classList.remove('d-none');
                }
                return;
            }

            if (leafletMap) {
                return;
            }

            leafletMap = window.L.map(queueLocationMap, {
                zoomControl: true,
                attributionControl: true,
            }).setView([queueLocation.latitude, queueLocation.longitude], 18);

            window.L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 20,
                attribution: '&copy; OpenStreetMap contributors',
            }).addTo(leafletMap);

            queueTargetMarker = window.L.circleMarker([queueLocation.latitude, queueLocation.longitude], {
                radius: 8,
                color: '#0d4620',
                weight: 2,
                fillColor: '#1f6f43',
                fillOpacity: 1,
            }).addTo(leafletMap).bindPopup('Lokasi antrean');

            queueRadiusCircle = window.L.circle([queueLocation.latitude, queueLocation.longitude], {
                radius: queueLocation.radiusMeters,
                color: '#1f6f43',
                weight: 2,
                fillColor: '#2f9e5f',
                fillOpacity: 0.2,
            }).addTo(leafletMap);

            if (queueLocationMapEmpty) {
                queueLocationMapEmpty.classList.add('d-none');
            }
        }

        function updateLeafletMapMarkers(latitude, longitude) {
            if (!leafletMap || typeof window.L === 'undefined') {
                return;
            }

            const userLatLng = [latitude, longitude];
            const targetLatLng = [queueLocation.latitude, queueLocation.longitude];

            if (!queueUserMarker) {
                queueUserMarker = window.L.circleMarker(userLatLng, {
                    radius: 7,
                    color: '#0a58ca',
                    weight: 2,
                    fillColor: '#0d6efd',
                    fillOpacity: 1,
                }).addTo(leafletMap).bindPopup('Lokasi Anda');
            } else {
                queueUserMarker.setLatLng(userLatLng);
            }

            if (queueDistanceLine) {
                leafletMap.removeLayer(queueDistanceLine);
            }

            queueDistanceLine = window.L.polyline([targetLatLng, userLatLng], {
                color: '#f59f00',
                weight: 2,
                dashArray: '5, 5',
                opacity: 0.9,
            }).addTo(leafletMap);

            const bounds = window.L.latLngBounds([targetLatLng, userLatLng]);
            leafletMap.fitBounds(bounds.pad(0.25), {
                maxZoom: 18,
                animate: true,
            });
        }

        function clearLeafletUserMarker() {
            if (!leafletMap) {
                return;
            }

            if (queueUserMarker) {
                leafletMap.removeLayer(queueUserMarker);
                queueUserMarker = null;
            }

            if (queueDistanceLine) {
                leafletMap.removeLayer(queueDistanceLine);
                queueDistanceLine = null;
            }
        }

        function resetLeafletMap() {
            if (!leafletMap) {
                return;
            }

            leafletMap.remove();
            leafletMap = null;
            queueTargetMarker = null;
            queueUserMarker = null;
            queueRadiusCircle = null;
            queueDistanceLine = null;

            if (queueLocationMapEmpty) {
                queueLocationMapEmpty.textContent = 'Memuat peta lokasi...';
                queueLocationMapEmpty.classList.remove('d-none');
            }
        }

        function startQueueLocationWatch() {
            if (!navigator.geolocation || queueLocationWatchId !== null || !hasQueueLocationConfig()) {
                return;
            }

            queueLocationWatchId = navigator.geolocation.watchPosition((position) => {
                updateQueueLocationPreview(position.coords.latitude, position.coords.longitude);
            }, () => {
                // Keep existing state when watch fails; one-time request handles user feedback.
            }, {
                enableHighAccuracy: true,
                maximumAge: 0,
                timeout: 10000,
            });
        }

        function stopQueueLocationWatch() {
            if (queueLocationWatchId === null || !navigator.geolocation) {
                return;
            }

            navigator.geolocation.clearWatch(queueLocationWatchId);
            queueLocationWatchId = null;
        }

        function updateQueueLocationPreview(latitude, longitude) {
            if (!queueLocation.latitude || !queueLocation.longitude) {
                return;
            }

            const distance = calculateDistanceMeters(latitude, longitude, queueLocation.latitude, queueLocation.longitude);
            const withinRadius = distance <= queueLocation.radiusMeters;

            if (queueLocationDistance) {
                queueLocationDistance.textContent = `${Math.round(distance)} m`;
                queueLocationDistance.style.color = withinRadius ? '#1f6f43' : '#b42318';
            }

            if (queueLocationStatus) {
                queueLocationStatus.textContent = withinRadius ? 'Di dalam area' : 'Di luar area';
                queueLocationStatus.style.background = withinRadius ? '#e8f7ef' : '#fdecec';
                queueLocationStatus.style.color = withinRadius ? '#1f6f43' : '#b42318';
                queueLocationStatus.style.borderColor = withinRadius ? '#bfe8ce' : '#f5c1c1';
            }

            if (queueLocationHelper) {
                queueLocationHelper.textContent = withinRadius
                    ? 'Anda sudah berada di dalam area yang diizinkan. Silakan lanjutkan mengambil antrean.'
                    : 'Anda masih di luar area. Dekatkan lokasi Anda ke titik antrean sebelum menekan Ambil Antrean.';
                queueLocationHelper.style.color = withinRadius ? '#1f6f43' : '#b42318';
            }

            if (userLatitudeInput) {
                userLatitudeInput.value = String(latitude);
            }

            if (userLongitudeInput) {
                userLongitudeInput.value = String(longitude);
            }

            updateLeafletMapMarkers(latitude, longitude);

            queueLocationHasReading = true;
            queueLocationVerified = withinRadius;
        }

        function requestQueueLocationPreview() {
            if (!navigator.geolocation) {
                showLocationError('Browser/perangkat Anda tidak mendukung akses lokasi. Aktifkan GPS lalu coba lagi.');
                return;
            }

            if (queueLocationRequestInProgress) {
                return;
            }

            queueLocationRequestInProgress = true;
            clearLocationError();

            if (queueLocationStatus) {
                queueLocationStatus.textContent = 'Meminta GPS...';
            }

            navigator.geolocation.getCurrentPosition((position) => {
                queueLocationRequestInProgress = false;
                updateQueueLocationPreview(position.coords.latitude, position.coords.longitude);
            }, (error) => {
                queueLocationRequestInProgress = false;
                queueLocationVerified = false;
                queueLocationHasReading = false;
                clearLeafletUserMarker();

                if (queueLocationStatus) {
                    queueLocationStatus.textContent = 'GPS gagal';
                    queueLocationStatus.style.background = '#fdecec';
                    queueLocationStatus.style.color = '#b42318';
                    queueLocationStatus.style.borderColor = '#f5c1c1';
                }

                if (queueLocationHelper) {
                    queueLocationHelper.textContent = 'Izinkan akses lokasi agar kami bisa menampilkan posisi Anda terhadap titik antrean.';
                    queueLocationHelper.style.color = '#6f6552';
                }

                if (error.code === error.PERMISSION_DENIED) {
                    showLocationError('Akses lokasi ditolak. Izinkan GPS/location agar Anda bisa melihat posisi dan mengambil antrean.');
                    return;
                }

                if (error.code === error.POSITION_UNAVAILABLE) {
                    showLocationError('Lokasi tidak dapat dideteksi. Pastikan GPS aktif lalu coba lagi.');
                    return;
                }

                if (error.code === error.TIMEOUT) {
                    showLocationError('Permintaan lokasi melebihi batas waktu. Coba lagi.');
                    return;
                }

                showLocationError('Gagal mengakses lokasi perangkat. Coba lagi.');
            }, {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0,
            });
        }

        function requestUserLocationAndSubmit() {
            if (!navigator.geolocation) {
                showLocationError('Browser/perangkat Anda tidak mendukung akses lokasi. Aktifkan GPS lalu coba lagi.');
                return;
            }

            if (queueLocationRequestInProgress) {
                return;
            }

            queueLocationRequestInProgress = true;
            clearLocationError();

            navigator.geolocation.getCurrentPosition((position) => {
                queueLocationRequestInProgress = false;

                if (userLatitudeInput) {
                    userLatitudeInput.value = String(position.coords.latitude);
                }

                if (userLongitudeInput) {
                    userLongitudeInput.value = String(position.coords.longitude);
                }

                queueLocationVerified = true;

                if (typeof formTambahPelanggan.requestSubmit === 'function') {
                    formTambahPelanggan.requestSubmit();
                    return;
                }

                formTambahPelanggan.submit();
            }, (error) => {
                queueLocationRequestInProgress = false;

                if (error.code === error.PERMISSION_DENIED) {
                    showLocationError('Akses lokasi ditolak. Izinkan GPS/location agar Anda bisa mengambil antrean.');
                    return;
                }

                if (error.code === error.POSITION_UNAVAILABLE) {
                    showLocationError('Lokasi tidak dapat dideteksi. Pastikan GPS aktif lalu coba lagi.');
                    return;
                }

                if (error.code === error.TIMEOUT) {
                    showLocationError('Permintaan lokasi melebihi batas waktu. Coba lagi.');
                    return;
                }

                showLocationError('Gagal mengakses lokasi perangkat. Coba lagi.');
            }, {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0,
            });
        }

        function normalizeStatus(status) {
            return String(status || '').toLowerCase();
        }

        function isCurrentUserQueue(antrean) {
            return !!loggedInUsername && String(antrean?.nama_pelanggan || '') === String(loggedInUsername);
        }

        function updateMyQueueCard(antrean) {
            if (!myQueueCard || !isCurrentUserQueue(antrean)) {
                return;
            }

            const status = normalizeStatus(antrean.status);

            if (cancelQueueAction) {
                cancelQueueAction.hidden = status !== 'menunggu';
            }

            if (myQueueNumber && antrean.nomor_antrean_seq) {
                myQueueNumber.textContent = antrean.nomor_antrean_seq;
            }

            if (myQueuePosition && status !== 'menunggu') {
                myQueuePosition.textContent = '-';
            }

            if (myQueueStatusChip) {
                myQueueStatusChip.textContent = status ? status.toUpperCase() : '-';
            }

            setButtonDisabled(cancelQueueButton, status === 'sedang dilayani');

            if (!['menunggu', 'sedang dilayani'].includes(status)) {
                window.setTimeout(() => {
                    window.location.reload();
                }, 120);
            }
        }

        window.selectedServices = [];

        window.selectService = function(id) {
            if (window.selectedServices.length >= 2) return;

            const card = document.querySelector(`.service-card[data-id="${id}"]`);
            if (!card || card.classList.contains('disabled')) return;

            const option = document.querySelector(`#layanan_id1 option[value="${id}"]`);
            if (!option) return;

            const service = {
                id: id,
                name: option.getAttribute('data-nama'),
                price: option.getAttribute('data-harga'),
                time: option.getAttribute('data-waktu')
            };

            window.selectedServices.push(service);
            updateUI();
        };

        window.removeService = function(index) {
            window.selectedServices.splice(index, 1);
            updateUI();
        };

        window.showServiceGrid = function() {
            document.getElementById('step-review').classList.remove('active');
            document.getElementById('step-layanan').classList.add('active');
        };

        function updateUI() {
            const container = document.getElementById('selected-services-container');
            const btnAddMore = document.getElementById('btn-add-more-service');
            const stepLayanan = document.getElementById('step-layanan');
            const stepReview = document.getElementById('step-review');
            const input1 = document.getElementById('layanan_id1');
            const input2 = document.getElementById('layanan_id2');

            // Reset inputs
            input1.value = '';
            input2.value = '';

            // Reset cards
            document.querySelectorAll('.service-card').forEach(card => {
                card.classList.remove('selected', 'disabled');
                const id = card.getAttribute('data-id');
                if (window.selectedServices.find(s => String(s.id) === String(id))) {
                    card.classList.add('selected', 'disabled');
                }
            });

            if (window.selectedServices.length === 0) {
                stepReview.classList.remove('active');
                stepLayanan.classList.add('active');
                return;
            }

            // Render selected services
            container.innerHTML = '';
            window.selectedServices.forEach((service, index) => {
                if (index === 0) input1.value = service.id;
                if (index === 1) input2.value = service.id;

                container.innerHTML += `
                    <div class="selected-item">
                        <div>
                            <div class="selected-item-name">${service.name}</div>
                            <div class="text-muted" style="font-size: 0.8rem">Rp${parseInt(service.price).toLocaleString('id-ID')} • ${service.time} mnt</div>
                        </div>
                        <button type="button" class="btn-remove-service" onclick="removeService(${index})"><i class="fas fa-times"></i> Hapus</button>
                    </div>
                `;
            });

            // Toggle add more button
            if (window.selectedServices.length >= 2) {
                btnAddMore.style.display = 'none';
                stepLayanan.classList.remove('active');
                stepReview.classList.add('active');
            } else {
                btnAddMore.style.display = 'block';
                stepLayanan.classList.remove('active');
                stepReview.classList.add('active');
            }
        }

        if (formTambahPelanggan) {
            formTambahPelanggan.addEventListener('submit', function(event) {
                if (window.selectedServices.length === 0) {
                    event.preventDefault();
                    alert('Harap pilih minimal 1 layanan.');
                    showServiceGrid();
                    return;
                }

                if (queueLocationHasReading && !queueLocationVerified) {
                    event.preventDefault();
                    showLocationError('Anda masih di luar area antrean. Dekatkan lokasi Anda ke titik antrean sebelum menekan Ambil Antrean.');
                    return;
                }

                if (queueLocationRequestInProgress) {
                    event.preventDefault();
                    showLocationError('Sedang mengambil lokasi perangkat. Tunggu sebentar lalu coba lagi.');
                    return;
                }

                if (queueLocationVerified) {
                    clearLocationError();
                    return;
                }

                event.preventDefault();
                requestUserLocationAndSubmit();
            });
        }

        const modalTambah = document.getElementById('modalTambahAntrean');
        if (modalTambah) {
            modalTambah.addEventListener('hidden.bs.modal', function () {
                window.selectedServices = [];
                queueLocationVerified = false;
                queueLocationRequestInProgress = false;
                queueLocationHasReading = false;
                if (userLatitudeInput) {
                    userLatitudeInput.value = '';
                }

                if (userLongitudeInput) {
                    userLongitudeInput.value = '';
                }

                clearLocationError();
                if (queueLocationStatus) {
                    queueLocationStatus.textContent = 'Menunggu GPS';
                    queueLocationStatus.style.background = '#fff3d2';
                    queueLocationStatus.style.color = '#7a5b1c';
                    queueLocationStatus.style.borderColor = '#e2c57f';
                }

                if (queueLocationDistance) {
                    queueLocationDistance.textContent = '-';
                    queueLocationDistance.style.color = '#1d1b17';
                }

                if (queueLocationHelper) {
                    queueLocationHelper.textContent = 'Aktifkan GPS untuk melihat posisi Anda terhadap titik antrean.';
                    queueLocationHelper.style.color = '#6f6552';
                }

                clearLeafletUserMarker();

                stopQueueLocationWatch();
                resetLeafletMap();
                updateUI();
            });

            modalTambah.addEventListener('shown.bs.modal', function () {
                initializeLeafletMap();
                requestQueueLocationPreview();
                startQueueLocationWatch();
            });

            // Auto-open modal dan pilih layanan jika ada query parameter layanan_id
            const urlParams = new URLSearchParams(window.location.search);
            const autoLayananId = urlParams.get('layanan_id');

            if (autoLayananId) {
                // Bersihkan URL query parameter tanpa reload
                const cleanUrl = window.location.pathname;
                window.history.replaceState({}, document.title, cleanUrl);

                // Tunggu sedikit agar DOM dan Bootstrap selesai inisialisasi
                setTimeout(() => {
                    const btnAddQueue = document.querySelector('.btn-add-queue');
                    if (btnAddQueue) {
                        // Buka modal
                        const bsModal = new bootstrap.Modal(modalTambah);
                        bsModal.show();

                        // Pilih layanan secara otomatis setelah modal terbuka
                        modalTambah.addEventListener('shown.bs.modal', function autoSelect() {
                            selectService(parseInt(autoLayananId));
                            modalTambah.removeEventListener('shown.bs.modal', autoSelect);
                        }, { once: true });
                    }
                }, 300);
            }
        }

        if (typeof window.Echo === 'undefined') {
            return;
        }

        try {
            window.Echo.channel('AntreanList-channel').listen('AntreanListUpdate', (e) => {
                const antreanList = (e.antreanList || []).filter(item =>
                    normalizeStatus(item.status) === 'menunggu'
                );

                if (!queueListContainer) {
                    return;
                }

                queueListContainer.innerHTML = '';

                if (antreanList.length > 0) {
                    antreanList.forEach(item => {
                        const isMyQueue = isCurrentUserQueue(item);
                        queueListContainer.insertAdjacentHTML('beforeend', `
                            <div class="queue-card ${isMyQueue ? 'my-queue-highlight' : ''}">
                                <div class="queue-number-box">${item.nomor_antrean_seq}</div>
                                <div class="queue-info">
                                    <p class="queue-name">${item.nama_pelanggan}</p>
                                    <p class="queue-time">(${formatJam(item.created_at)})</p>
                                </div>
                                <div class="queue-badges">${isMyQueue ? '<span class="badge-mine">ANTREAN SAYA</span>' : ''}<span class="badge-waiting">MENUNGGU</span></div>
                            </div>
                        `);
                    });
                } else {
                    queueListContainer.innerHTML = `
                        <div class="text-center mt-4 mb-4 text-muted">Tidak ada antrean</div>
                    `;
                }
            });
        } catch (error) {
            return;
        }

        const handleQueueStatusUpdate = (e) => {
            const antrean = e.antrean;

            const nomorEl = document.getElementById('antrean-nomor');
            if (nomorEl) {
                nomorEl.textContent = antrean.nomor_antrean_seq;
            }

            const statusEl = document.getElementById('antrean-status');
            if (statusEl) {
                statusEl.textContent = String(antrean.status || '').toUpperCase();
            }

            const namaEl = document.getElementById('antrean-nama');
            if (namaEl) {
                namaEl.textContent = antrean.nama_pelanggan;
            }

            updateMyQueueCard(antrean);
        };

        // Kompatibilitas: dengarkan nama event baru dan lama.
        window.Echo.channel('Antrean-channel')
            .listen('AntreanUpdate', handleQueueStatusUpdate)
            .listen('AntreanUpadate', handleQueueStatusUpdate);




    });
</script>

