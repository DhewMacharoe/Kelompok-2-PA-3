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
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: message,
                    confirmButtonText: 'OK'
                });
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
            if (!card ||
                card.classList.contains('disabled') ||
                card.classList.contains('included-disabled') ||
                card.classList.contains('incompatible-disabled')
            ) return;

            const option = document.querySelector(`#layanan_id1 option[value="${id}"]`);
            if (!option) return;

            const service = {
                id: id,
                name: option.getAttribute('data-nama'),
                price: option.getAttribute('data-harga'),
                time: option.getAttribute('data-waktu'),
                deskripsi: option.getAttribute('data-deskripsi')
            };

            window.selectedServices.push(service);
            updateUI();
            if(document.getElementById('is_booking_toggle').checked && document.getElementById('tanggal_booking').value) {
                fetchAvailableSlots();
            }
        };

        window.removeService = function(index) {
            window.selectedServices.splice(index, 1);
            updateUI();
            if(document.getElementById('is_booking_toggle').checked && document.getElementById('tanggal_booking').value) {
                fetchAvailableSlots();
            }
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

            const selectedIds = window.selectedServices.map(s => parseInt(s.id));
            let packageConstituentIds = [];
            
            selectedIds.forEach(id => {
                const serviceData = (window.barberLayananList || []).find(l => l.id === id);
                if (serviceData && serviceData.included_service_ids) {
                    packageConstituentIds = packageConstituentIds.concat(serviceData.included_service_ids);
                }
            });

            const activeIds = [...selectedIds, ...packageConstituentIds];

            // Extract selected features for overlap check
            const selectedFeatures = [];
            window.selectedServices.forEach(s => {
                if (s.deskripsi) {
                    const features = s.deskripsi.split(',').map(f => f.trim().toLowerCase());
                    selectedFeatures.push(...features);
                }
            });

            // Reset cards
            document.querySelectorAll('.service-card').forEach(card => {
                card.classList.remove('selected', 'disabled', 'included-disabled', 'incompatible-disabled');

                // Clear custom badges
                const customBadge = card.querySelector('.badge-container-custom');
                if (customBadge) {
                    customBadge.remove();
                }

                const id = parseInt(card.getAttribute('data-id'));
                const meta = card.querySelector('.service-meta');
                const option = document.querySelector(`#layanan_id1 option[value="${id}"]`);
                const deskripsi = option ? option.getAttribute('data-deskripsi') : null;

                // 1. If currently selected
                if (selectedIds.includes(id)) {
                    card.classList.add('selected', 'disabled');
                    return;
                }

                // 2. Rule BR-02: If it's a constituent service of a selected package
                const serviceData = (window.barberLayananList || []).find(l => l.id === id);
                const isPackage = serviceData && serviceData.included_service_ids && serviceData.included_service_ids.length > 0;

                if (!isPackage && packageConstituentIds.includes(id)) {
                    card.classList.add('included-disabled');
                    const badge = document.createElement('div');
                    badge.className = 'badge-container-custom mt-2';
                    badge.innerHTML = `<span class="included-badge"><i class="fas fa-check-circle"></i> Sudah Termasuk</span>`;
                    if (meta) {
                        meta.appendChild(badge);
                    }
                    return;
                }

                // 3. Rule BR-03: Incompatibilities
                if (activeIds.length > 0) {
                    const conflictRule = (window.barberIncompatibilities || []).find(rule => {
                        const a = parseInt(rule.service_id_a);
                        const b = parseInt(rule.service_id_b);
                        return (activeIds.includes(a) && id === b) || (activeIds.includes(b) && id === a);
                    });

                    if (conflictRule) {
                        card.classList.add('incompatible-disabled');
                        const badge = document.createElement('div');
                        badge.className = 'badge-container-custom mt-2';
                        badge.innerHTML = `<span class="incompatible-badge" title="${conflictRule.deskripsi_konflik}"><i class="fas fa-exclamation-circle"></i> Konflik</span>`;
                        if (meta) {
                            meta.appendChild(badge);
                        }
                        return;
                    }

                    // Check for overlapping features
                    if (selectedFeatures.length > 0 && deskripsi) {
                        const cardFeatures = deskripsi.split(',').map(f => f.trim().toLowerCase());
                        const overlap = cardFeatures.filter(f => selectedFeatures.includes(f));
                        if (overlap.length > 0 && !selectedIds.includes(id)) {
                            card.classList.add('incompatible-disabled');
                            const badge = document.createElement('div');
                            badge.className = 'badge-container-custom mt-2';
                            badge.innerHTML = `<span class="incompatible-badge" title="Terdapat layanan yang sama: ${overlap.join(', ')}"><i class="fas fa-exclamation-circle"></i> Konflik Fitur</span>`;
                            if (meta) {
                                meta.appendChild(badge);
                            }
                            return;
                        }
                    }
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

        // --- BOOKING LOGIC ---
        const bookingToggle = document.getElementById('is_booking_toggle');
        const bookingDescText = document.getElementById('booking-desc-text');
        const bookingContainer = document.getElementById('booking-fields-container');
        const tanggalBooking = document.getElementById('tanggal_booking');
        const waktuBooking = document.getElementById('waktu_booking');
        const slotsContainer = document.getElementById('available-slots-container');

        if(bookingToggle) {
            bookingToggle.addEventListener('change', function() {
                if(this.checked) {
                    bookingDescText.textContent = "Sistem akan mencari waktu kosong berdasarkan durasi layanan.";
                    bookingContainer.style.display = 'block';
                    const locPreview = document.querySelector('.queue-location-preview');
                    if (locPreview) locPreview.style.display = 'none';
                    waktuBooking.disabled = false;
                    tanggalBooking.required = true;
                    if(tanggalBooking.value) {
                        fetchAvailableSlots();
                    }
                } else {
                    bookingDescText.textContent = "Mendaftar untuk antrean langsung saat ini juga (Walk-in).";
                    bookingContainer.style.display = 'none';
                    const locPreview = document.querySelector('.queue-location-preview');
                    if (locPreview) locPreview.style.display = 'flex'; // or block depending on css
                    waktuBooking.disabled = true;
                    tanggalBooking.required = false;
                    waktuBooking.value = "";
                }
            });

            // Trigger change event if initially checked (e.g. forced by server)
            if (bookingToggle.checked) {
                bookingToggle.dispatchEvent(new Event('change'));
            }
        }

        if(tanggalBooking) {
            tanggalBooking.addEventListener('change', function() {
                if(this.value && window.selectedServices.length > 0) {
                    fetchAvailableSlots();
                } else if(!this.value) {
                    slotsContainer.innerHTML = '<span class="text-muted small">Pilih tanggal terlebih dahulu.</span>';
                }
            });
        }

        function fetchAvailableSlots() {
            if(!tanggalBooking.value || window.selectedServices.length === 0) return;

            slotsContainer.innerHTML = '<span class="text-muted small">Mencari jadwal kosong...</span>';
            waktuBooking.value = "";

            let layanan1 = window.selectedServices[0]?.id;
            let layanan2 = window.selectedServices[1]?.id;

            const currentSlug = "{{ session('current_barbershop_slug') }}";
            let url = `/${currentSlug}/antrean/available-slots?date=${tanggalBooking.value}&layanan_id1=${layanan1}`;
            if(layanan2) url += `&layanan_id2=${layanan2}`;

            fetch(url, {
                headers: {
                    'Accept': 'application/json'
                }
            })
                .then(async response => {
                    if (!response.ok && response.status !== 422) {
                        throw new Error('Network response was not ok');
                    }
                    return await response.json();
                })
                .then(data => {
                    if(data.status === 'success') {
                        renderSlots(data.slots);
                    } else if (data.errors) {
                        slotsContainer.innerHTML = '<span class="text-danger small">Jadwal tidak tersedia untuk layanan ini.</span>';
                    } else {
                        slotsContainer.innerHTML = '<span class="text-danger small">Gagal mengambil jadwal.</span>';
                    }
                })
                .catch(err => {
                    console.error(err);
                    slotsContainer.innerHTML = '<span class="text-danger small">Terjadi kesalahan.</span>';
                });
        }

        function renderSlots(slots) {
            slotsContainer.innerHTML = '';
            if(slots.length === 0) {
                slotsContainer.innerHTML = '<span class="text-danger small">Tidak ada jadwal kosong yang tersedia di tanggal ini.</span>';
                return;
            }

            slots.forEach(slot => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'btn btn-outline-dark btn-sm slot-btn';
                btn.textContent = slot;
                btn.style.borderRadius = '8px';
                btn.onclick = function() {
                    document.querySelectorAll('.slot-btn').forEach(b => {
                        b.classList.remove('btn-dark', 'text-white');
                        b.classList.add('btn-outline-dark');
                    });
                    this.classList.remove('btn-outline-dark');
                    this.classList.add('btn-dark', 'text-white');
                    waktuBooking.value = slot;
                };
                slotsContainer.appendChild(btn);
            });
        }

        if (formTambahPelanggan) {
            formTambahPelanggan.addEventListener('submit', function(event) {
                if (window.selectedServices.length === 0) {
                    event.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Validasi Data',
                        text: 'Harap pilih minimal 1 layanan.',
                        confirmButtonText: 'OK'
                    });
                    showServiceGrid();
                    return;
                }

                if(bookingToggle && bookingToggle.checked) {
                    if(!tanggalBooking.value) {
                        event.preventDefault();
                        Swal.fire({ icon: 'warning', title: 'Pilih Tanggal', text: 'Harap pilih tanggal booking.' });
                        return;
                    }
                    if(!waktuBooking.value) {
                        event.preventDefault();
                        Swal.fire({ icon: 'warning', title: 'Pilih Waktu', text: 'Harap pilih jam kosong yang tersedia.' });
                        return;
                    }
                }

                // If Walk-in queue, we need location verification. If booking, we might not need location,
                // but let's keep it consistent or skip location for booking.
                // Assuming we skip location validation for booking (as they can book from anywhere):
                if(!bookingToggle || !bookingToggle.checked) {
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

                    if (!queueLocationVerified) {
                        event.preventDefault();
                        requestUserLocationAndSubmit();
                        return;
                    }
                }

                // All validations passed. Let default submit happen if location is verified or booking is selected.
            });
        }

        if (cancelQueueButton) {
            cancelQueueButton.addEventListener('click', function(event) {
                event.preventDefault();
                const form = this.closest('form');
                Swal.fire({
                    title: 'Alasan Pembatalan',
                    input: 'textarea',
                    inputPlaceholder: 'Tuliskan alasan pembatalan di sini...',
                    inputAttributes: {
                        'aria-label': 'Tuliskan alasan pembatalan'
                    },
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Batalkan Antrean Saya',
                    cancelButtonText: 'Kembali',
                    preConfirm: (alasan) => {
                        if (!alasan) {
                            Swal.showValidationMessage('Alasan pembatalan wajib diisi');
                        }
                        return alasan;
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const loadingText = this.getAttribute('data-loading-text') || 'Membatalkan...';
                        this.textContent = loadingText;
                        this.disabled = true;

                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'alasan_batal';
                        input.value = result.value;
                        form.appendChild(input);

                        form.submit();
                    }
                });
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

            // Auto-open modal dan pilih layanan jika ada query parameter layanan_id atau restore state dari sessionStorage
            const urlParams = new URLSearchParams(window.location.search);

            // 1. Restore state dari sessionStorage jika ada
            const savedStateJson = sessionStorage.getItem('antrean_page_state');
            let hasRestoredState = false;
            if (savedStateJson) {
                try {
                    const savedState = JSON.parse(savedStateJson);
                    sessionStorage.removeItem('antrean_page_state');

                    if (savedState.selectedServices && savedState.selectedServices.length > 0) {
                        window.selectedServices = savedState.selectedServices;
                        updateUI();
                    }

                    if (savedState.modalOpen) {
                        const bsModal = new bootstrap.Modal(modalTambah);
                        bsModal.show();
                        hasRestoredState = true;
                    }

                    if (savedState.scrollPosition) {
                        setTimeout(() => {
                            window.scrollTo(0, savedState.scrollPosition);
                        }, 100);
                    }
                } catch (e) {
                    console.error("Gagal mengurai state antrean:", e);
                }
            }

            // 2. Pilih layanan jika ada parameter layanan_id
            const autoLayananId = urlParams.get('layanan_id');
            if (autoLayananId) {
                // Bersihkan URL query parameter tanpa reload
                const cleanUrl = window.location.pathname;
                window.history.replaceState({}, document.title, cleanUrl);

                // Tunggu sedikit agar DOM dan Bootstrap selesai inisialisasi
                setTimeout(() => {
                    const btnAddQueue = document.querySelector('.btn-add-queue');
                    if (btnAddQueue) {
                        // Buka modal jika belum terbuka dari restore state
                        if (!hasRestoredState) {
                            const bsModal = new bootstrap.Modal(modalTambah);
                            bsModal.show();
                        }

                        // Pilih layanan secara otomatis setelah modal terbuka
                        const autoSelect = () => {
                            const serviceId = parseInt(autoLayananId);
                            const alreadySelected = window.selectedServices.some(s => s.id === serviceId);
                            if (!alreadySelected) {
                                selectService(serviceId);
                            }
                        };

                        if (modalTambah.classList.contains('show')) {
                            autoSelect();
                        } else {
                            modalTambah.addEventListener('shown.bs.modal', function autoSelectHandler() {
                                autoSelect();
                                modalTambah.removeEventListener('shown.bs.modal', autoSelectHandler);
                            }, { once: true });
                        }
                    }
                }, 300);
            }

            // 3. Simpan state sebelum berpindah ke halaman Detail Layanan
            document.addEventListener('click', function(event) {
                const detailLink = event.target.closest('.detail-layanan-link');
                if (detailLink) {
                    const state = {
                        modalOpen: true,
                        selectedServices: window.selectedServices || [],
                        scrollPosition: window.scrollY
                    };
                    sessionStorage.setItem('antrean_page_state', JSON.stringify(state));
                }
            });
        }

        function checkEcho(callback) {
            if (window.Echo) {
                callback();
            } else {
                let attempts = 0;
                const interval = setInterval(() => {
                    attempts++;
                    if (window.Echo) {
                        clearInterval(interval);
                        callback();
                    } else if (attempts > 100) {
                        clearInterval(interval);
                        console.warn('Laravel Echo tidak terdeteksi.');
                    }
                }, 50);
            }
        }

        checkEcho(() => {
            try {
                window.Echo.channel('AntreanList-channel.{{ $activeBarbershop->id ?? "" }}').listen('AntreanListUpdate', (e) => {
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
                            const totalEst = item.total_estimasi_waktu || 30;
                            const estMnt = `${totalEst} mnt`;

                            queueListContainer.insertAdjacentHTML('beforeend', `
                                <div class="card shadow-sm mb-2 ${isMyQueue ? 'border-success border-2' : 'border-0'}" style="background: #ffffff; border-radius: 12px;">
                                    <div class="card-body p-3 d-flex align-items-center">
                                        <div class="d-flex align-items-center justify-content-center text-white fw-bold me-3 flex-shrink-0" style="width: 50px; height: 50px; background-color: #1a1a1a; font-size: 1.1rem; border-radius: 10px;">
                                            ${item.nomor_antrean_seq}
                                        </div>
                                        <div class="flex-grow-1 min-w-0">
                                            <h6 class="fw-bold mb-1 text-dark text-truncate" style="font-size: 0.95rem;">${item.nama_pelanggan}</h6>
                                            <p class="text-muted mb-0" style="font-size: 0.75rem;">
                                                ${item.is_booking ? `
                                                    <span class="text-nowrap text-primary fw-bold"><i class="far fa-calendar-alt me-1"></i> Booking: ${item.waktu_booking}</span>
                                                ` : `
                                                    <span class="text-nowrap"><i class="far fa-clock me-1"></i> Masuk: ${formatJam(item.created_at)}</span>
                                                `}
                                                <span class="ms-2 text-nowrap"><i class="fas fa-hourglass-half me-1"></i> Est: ${estMnt}</span>
                                            </p>
                                        </div>
                                        <div class="flex-shrink-0 ms-2">
                                            ${isMyQueue ? `
                                                <span class="badge" style="border: 1px solid #198754; color: #198754; background: #e8f7ef; padding: 6px 12px; border-radius: 20px; font-weight: 700; font-size: 0.65rem; letter-spacing: 0.5px;">ANTREAN SAYA</span>
                                            ` : `
                                                <span class="badge" style="border: 1px solid {{ $activeBarbershop->warna_primer ?? '#e8a53a' }}; color: {{ $activeBarbershop->warna_primer ?? '#e8a53a' }}; background: #fffaf0; padding: 6px 12px; border-radius: 20px; font-weight: 700; font-size: 0.65rem; letter-spacing: 0.5px;">MENUNGGU</span>
                                            `}
                                        </div>
                                    </div>
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
                console.error(error);
            }

            const handleQueueStatusUpdate = (e) => {
                const antrean = e.antrean;
                const status = String(antrean.status || '').toLowerCase();

                // Reload the page if the queue is finished or cancelled so the UI resets
                if (status === 'selesai' || status === 'batal') {
                    setTimeout(() => window.location.reload(), 500);
                    return;
                }

                const nomorEl = document.getElementById('antrean-nomor');
                if (!nomorEl) {
                    // If the UI is currently in "Belum Ada" state, reload to show "Sedang Melayani"
                    setTimeout(() => window.location.reload(), 500);
                    return;
                }

                nomorEl.textContent = antrean.nomor_antrean_seq;

                const statusEl = document.getElementById('antrean-status');
                if (statusEl) {
                    statusEl.textContent = status.toUpperCase();
                }

                const namaEl = document.getElementById('antrean-nama');
                if (namaEl) {
                    namaEl.textContent = antrean.nama_pelanggan;
                }

                // Update stopwatch timestamp if available
                const stopwatchEl = document.getElementById('stopwatch-dipanggil');
                if (stopwatchEl && status === 'sedang dilayani') {
                    // Jika antrean.updated_at tersedia dari broadcast, gunakan itu. Jika tidak, gunakan waktu sekarang.
                    const startTimeMs = antrean.updated_at ? new Date(antrean.updated_at).getTime() : new Date().getTime();
                    stopwatchEl.dataset.start = startTimeMs;
                }

                updateMyQueueCard(antrean);
            };

            // Kompatibilitas: dengarkan nama event baru dan lama.
            window.Echo.channel('Antrean-channel.{{ $activeBarbershop->id ?? "" }}')
                .listen('AntreanUpdate', handleQueueStatusUpdate)
                .listen('AntreanUpadate', handleQueueStatusUpdate);
        });

        // Stopwatch untuk Antrean Dipanggil
        const stopwatchEl = document.getElementById('stopwatch-dipanggil');
        let stopwatchInterval;

        function updateStopwatch() {
            if (!stopwatchEl) return;
            const startTime = parseInt(stopwatchEl.dataset.start);
            if (!startTime) return;

            const now = new Date().getTime();
            const diff = now - startTime;

            if (diff < 0) return;

            const hours = Math.floor(diff / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((diff % (1000 * 60)) / 1000);

            stopwatchEl.textContent =
                String(hours).padStart(2, '0') + ':' +
                String(minutes).padStart(2, '0') + ':' +
                String(seconds).padStart(2, '0');
        }

        if (stopwatchEl) {
            updateStopwatch();
            stopwatchInterval = setInterval(updateStopwatch, 1000);
        }

    });
</script>

