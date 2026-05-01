<script type="module">
    async function playQueueAudio(antrean) {
        if (!antrean) return;

        const status = String(antrean.status || '').toLowerCase();
        const nomor = antrean.nomor_antrean || '-';
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

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.detail-card-button').forEach((element) => {
            element.addEventListener('keydown', function(event) {
                if (event.key === 'Enter' || event.key === ' ') {
                    event.preventDefault();
                    this.click();
                }
            });
        });

        const detailModal = document.getElementById('detailModal');
        if (detailModal) {
            detailModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                if (!button) {
                    return;
                }

                const type = button.dataset.type || '-';
                const title = button.dataset.title || '-';
                const image = button.dataset.image || '';
                const price = button.dataset.price || '-';
                const description = button.dataset.description || '-';
                const extra = button.dataset.extra || '-';
                const estimation = button.dataset.estimation || '-';
                const category = button.dataset.category || '-';
                const availability = button.dataset.availability || '-';
                const showMeta = button.dataset.showMeta === '1';
                const metaRow = document.getElementById('detailModalMetaRow');
                const metaLabel = metaRow ? metaRow.querySelector('span') : null;

                document.getElementById('detailModalTitle').textContent = title;
                document.getElementById('detailModalImage').src = image;
                document.getElementById('detailModalPrice').textContent = price;
                document.getElementById('detailModalDescription').textContent = description;
                document.getElementById('detailModalExtra').textContent = extra;
                document.getElementById('detailModalType').textContent = type === 'layanan' ?
                    'Layanan Barber' : 'Menu Cafe';
                document.getElementById('detailModalMeta').textContent = type === 'layanan' ?
                    estimation : category;
                document.getElementById('detailModalStatus').textContent = type === 'layanan' ?
                    'Tersedia' : availability;

                if (metaRow) {
                    if (showMeta) {
                        metaRow.classList.remove('d-none');
                        metaRow.style.display = 'flex';
                        if (metaLabel) {
                            metaLabel.textContent = 'Estimasi';
                        }
                    } else {
                        metaRow.classList.add('d-none');
                        metaRow.style.display = 'none';
                    }
                }
            });

            detailModal.addEventListener('hidden.bs.modal', function() {
                const metaRow = document.getElementById('detailModalMetaRow');
                const metaLabel = metaRow ? metaRow.querySelector('span') : null;

                if (metaRow) {
                    metaRow.classList.remove('d-none');
                    metaRow.style.display = 'flex';
                }

                if (metaLabel) {
                    metaLabel.textContent = 'Kategori / Estimasi';
                }
            });
        }

        if (window.Echo) {
            window.Echo.channel('Antrean-channel')
                .listen('AntreanUpdate', async (e) => {
                    const antrean = e.antrean;

                    // Update cepat untuk elemen utama
                    const nomorEl = document.getElementById('antrean-nomor');
                    if (nomorEl && antrean?.nomor_antrean) {
                        nomorEl.textContent = antrean.nomor_antrean;
                    }

                    const statusEl = document.getElementById('antrean-status');
                    if (statusEl && antrean?.status) {
                        statusEl.textContent = antrean.status.toUpperCase();
                    }

                    await playQueueAudio(antrean);
                    window.location.reload();
                })
                .listen('AntreanUpadate', async (e) => {
                    const antrean = e.antrean;
                    await playQueueAudio(antrean);
                    window.location.reload();
                });

            // Saat daftar menunggu berubah (tambah/batal/dipanggil), sinkronkan seluruh dashboard.
            window.Echo.channel('AntreanList-channel')
                .listen('AntreanListUpdate', () => {
                    window.location.reload();
                });
        }
    });
</script>
