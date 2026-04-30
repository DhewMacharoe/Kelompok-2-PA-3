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

            if (myQueueNumber && antrean.nomor_antrean) {
                myQueueNumber.textContent = antrean.nomor_antrean;
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

        function syncLayananDropdownPelanggan() {
            if (!layananSelect1 || !layananSelect2) {
                return;
            }

            const selectedLayanan1 = layananSelect1.value;

            Array.from(layananSelect2.options).forEach(option => {
                if (!option.value) {
                    return;
                }

                const isSameAsLayanan1 = selectedLayanan1 !== '' && option.value === selectedLayanan1;
                option.disabled = isSameAsLayanan1;
                option.hidden = isSameAsLayanan1;
            });

            if (layananSelect2.value && layananSelect2.value === selectedLayanan1) {
                layananSelect2.value = '';
            }

            if (layananHelp) {
                layananHelp.textContent = layananSelect2.value ?
                    'Dua layanan dipilih.' :
                    'Layanan 2 opsional dan tidak boleh sama dengan layanan 1.';
            }
        }

        if (layananSelect1 && layananSelect2) {
            layananSelect1.addEventListener('change', syncLayananDropdownPelanggan);
            layananSelect2.addEventListener('change', syncLayananDropdownPelanggan);
            syncLayananDropdownPelanggan();
        }

        if (formTambahPelanggan) {
            formTambahPelanggan.addEventListener('submit', function(event) {
                if (!layananSelect1 || !layananSelect2) {
                    return;
                }

                if (!layananSelect1.value) {
                    event.preventDefault();
                    alert('Layanan 1 wajib dipilih.');
                    return;
                }

                if (layananSelect2.value && layananSelect2.value === layananSelect1.value) {
                    event.preventDefault();
                    alert('Layanan 1 dan layanan 2 tidak boleh sama.');
                }
            });
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
                                <div class="queue-number-box">${item.nomor_antrean}</div>
                                <div class="queue-info">
                                    <p class="queue-name">${item.nama_pelanggan}</p>
                                    <p class="queue-time">(${formatJam(item.created_at)})</p>
                                </div>
                                <div>${isMyQueue ? '<span class="badge-mine">ANTREAN SAYA</span>' : ''}<span class="badge-waiting">MENUNGGU</span></div>
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
                nomorEl.textContent = antrean.nomor_antrean;
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
            const nomorantrean = antrean.nomor_antrean || antrean.nomor_antrean || '-';
            const namaPelanggan = antrean.nama_pelanggan || '-';
            const status = antrean.status || '-';
            const text = `Nomor antrean ${nomorantrean}, atas nama ${namaPelanggan}, status ${status}`;

            if ('speechSynthesis' in window) {
                const speech = new SpeechSynthesisUtterance(text);
                speech.lang = 'id-ID'; // bahasa Indonesia
                speech.rate = 1; // kecepatan bicara (0.1 - 10)
                speech.pitch = 1; // nada suara
                // Cancel antrian ucapan sebelumnya agar notifikasi terbaru langsung dibacakan.
                window.speechSynthesis.cancel();
                window.speechSynthesis.speak(speech);
            } else {
                console.warn('[PWA] Speech synthesis tidak didukung di browser ini');
            }
        };

        // Kompatibilitas: dengarkan nama event baru dan lama.
        window.Echo.channel('Antrean-channel')
            .listen('AntreanUpdate', handleQueueStatusUpdate)
            .listen('AntreanUpadate', handleQueueStatusUpdate);




    });
</script>

