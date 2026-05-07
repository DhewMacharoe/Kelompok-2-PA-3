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


        const layananSelect1 = document.getElementById('layanan_id1');
        const layananSelect2 = document.getElementById('layanan_id2');
        const layananHelp = document.getElementById('layanan-help-pelanggan');
        const formTambahPelanggan = document.getElementById('formTambahAntreanPelanggan');
        const queueListContainer = document.querySelector('.queue-list-container');
        const myQueueCard = document.getElementById('my-queue-card');
        const myQueueNumber = document.getElementById('my-queue-number');
        const myQueuePosition = document.getElementById('my-queue-position');
        const myQueueServices = document.getElementById('my-queue-services');
        const myQueueStatusChip = document.getElementById('my-queue-status-chip');
        const cancelQueueAction = document.getElementById('my-queue-cancel-action');
        const cancelQueueButton = document.getElementById('btn-cancel-my-queue');

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
                }
            });
        }

        const modalTambah = document.getElementById('modalTambahAntrean');
        if (modalTambah) {
            modalTambah.addEventListener('hidden.bs.modal', function () {
                window.selectedServices = [];
                updateUI();
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

        async function playQueueAudio(antrean) {
            if (!antrean) return;

            const status = String(antrean.status || '').toLowerCase();
            const nomor = antrean.nomor_antrean_seq || '-';
            const nama = antrean.nama_pelanggan || '-';

            let text = '';
            if (status === 'sedang dilayani') {
                text = `Panggilan kepada antrean nomor ${nomor} atas nama ${nama}`;
            } else if (status === 'batal') {
                text = `Antrean nomor ${nomor} atas nama ${nama} dibatalkan`;
            } else if (status === 'selesai') {
                text = `Antrean nomor ${nomor} atas nama ${nama} selesai`;
            } else {
                return Promise.resolve();
            }

            return new Promise((resolve) => {
                try {
                    if (!('speechSynthesis' in window)) throw new Error('no-speech');

                    let voices = window.speechSynthesis.getVoices();
                    if (!voices.length) {
                        const onVoices = () => {
                            window.speechSynthesis.removeEventListener('voiceschanged', onVoices);
                            playUtterance();
                        };
                        window.speechSynthesis.addEventListener('voiceschanged', onVoices);
                        setTimeout(() => { if (window.speechSynthesis.getVoices().length === 0) playUtterance(); }, 1000);
                    } else {
                        playUtterance();
                    }

                    function playUtterance() {
                        const utter = new SpeechSynthesisUtterance(text);
                        utter.lang = 'id-ID';
                        utter.rate = 1;
                        utter.pitch = 1;

                        utter.onend = resolve;
                        utter.onerror = (e) => {
                            console.warn('[TTS] Error:', e);
                            fallbackAudio(resolve);
                        };

                        window.speechSynthesis.cancel();
                        window.speechSynthesis.speak(utter);
                    }
                } catch (err) {
                    console.warn('[TTS] Failed:', err);
                    fallbackAudio(resolve);
                }
            });
        }

        function fallbackAudio(resolve) {
            try {
                const ctx = new (window.AudioContext || window.webkitAudioContext)();
                const o = ctx.createOscillator();
                const g = ctx.createGain();
                o.type = 'sine';
                o.frequency.value = 880;
                g.gain.value = 0.1;
                o.connect(g);
                g.connect(ctx.destination);
                o.start();
                setTimeout(() => { o.stop(); ctx.close(); resolve(); }, 400);
            } catch (e) {
                console.warn('[Fallback] Audio failed', e);
                resolve();
            }
        }

        const handleQueueStatusUpdate = async (e) => {
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

            await playQueueAudio(antrean);
        };

        // Kompatibilitas: dengarkan nama event baru dan lama.
        window.Echo.channel('Antrean-channel')
            .listen('AntreanUpdate', handleQueueStatusUpdate)
            .listen('AntreanUpadate', handleQueueStatusUpdate);




    });
</script>

