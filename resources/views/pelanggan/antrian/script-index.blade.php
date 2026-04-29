<script type="module">

    function formatJam(datetime) {
    const date = new Date(datetime);
    return date.toLocaleTimeString('id-ID', {
        hour: '2-digit',
        minute: '2-digit'
    });
    }
    document.addEventListener('DOMContentLoaded', function () {
        console.log('Echo script loaded');

        const loggedInUsername = @json(auth()->check() ? auth()->user()->username : null);

        const layananSelect1 = document.getElementById('layanan_id1');
        const layananSelect2 = document.getElementById('layanan_id2');
        const layananHelp = document.getElementById('layanan-help-pelanggan');
        const formTambahPelanggan = document.getElementById('formTambahAntrianPelanggan');

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
                layananHelp.textContent = layananSelect2.value
                    ? 'Dua layanan dipilih.'
                    : 'Layanan 2 opsional dan tidak boleh sama dengan layanan 1.';
            }
        }

        if (layananSelect1 && layananSelect2) {
            layananSelect1.addEventListener('change', syncLayananDropdownPelanggan);
            layananSelect2.addEventListener('change', syncLayananDropdownPelanggan);
            syncLayananDropdownPelanggan();
        }

        if (formTambahPelanggan) {
            formTambahPelanggan.addEventListener('submit', function (event) {
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
            console.error('window.Echo is not defined');
            return;
        }

        console.log('Echo is available');

        try {
            const channel = window.Echo.channel('AntrianList-channel');
            console.log('Channel created:', channel);

            channel.listen('AntreanListUpdate', (e) => {
            console.log('Antrian list updated:', e);

            const antreanList = (e.antreanList || []).filter(item =>
                String(item.status || '').toLowerCase() === 'menunggu'
            );
            const queueListContainer = document.querySelector('.queue-list-container');

            // Kosongkan isi lama
            queueListContainer.innerHTML = '';

            if (antreanList.length > 0) {
                antreanList.forEach(item => {
                    const isMyQueue = loggedInUsername && item.nama_pelanggan === loggedInUsername;
                    queueListContainer.innerHTML += `
                        <div class="queue-card ${isMyQueue ? 'my-queue-highlight' : ''}">
                            <div class="queue-number-box">${item.nomor_antrian}</div>
                            <div class="queue-info">
                                <p class="queue-name">${item.nama_pelanggan}</p>
                                <p class="queue-time">(${formatJam(item.created_at)})</p>
                            </div>
                            <div>${isMyQueue ? '<span class="badge-mine">ANTREAN SAYA</span>' : ''}<span class="badge-waiting">MENUNGGU</span></div>
                        </div>
                    `;
                });
            } else {
                queueListContainer.innerHTML = `
                    <div class="text-center mt-4 mb-4 text-muted">Tidak ada antrian</div>
                `;
            }
        });
        } catch (error) {
            console.error('Terjadi kesalahan saat inisialisasi Echo:', error);
        }

        window.Echo.channel('Antrian-channel').listen('AntreanUpadate', (e) => {

                    console.log('DATA MASUK:', e);

                    let antrian = e.antrean;

                    // Update nomor antrian
                    let nomorEl = document.getElementById('antrian-nomor');
                    if (nomorEl) {
                        nomorEl.textContent = antrian.nomor_antrian;
                    }

                    // Update status
                    let statusEl = document.getElementById('antrian-status');
                    if (statusEl) {
                        statusEl.textContent = antrian.status.toUpperCase();
                    }

                    let namaEl = document.getElementById('antrian-nama');
                    if (namaEl) {
                        namaEl.textContent = antrian.nama_pelanggan;}

                    const text = `Nomor antrian ${antrian.nomor_antrian}, atas nama ${antrian.nama_pelanggan}, status ${antrian.status}`;

                // suara dingdong
                // const dingdong = new Audio('/sounds/dingdong.mp3'); // pastikan file ada

                // dingdong.play();

                dingdong.onended = () => {
                    const speech = new SpeechSynthesisUtterance(text);
                    speech.lang = 'id-ID';
                    speech.rate = 1;
                    speech.pitch = 1;

                    window.speechSynthesis.speak(speech);
                    };
                });


    });
</script>
