<script type="module">

    document.addEventListener('DOMContentLoaded', function() {
        // Swap Logo dynamically to full brand logo on homepage
        const logoImg = document.querySelector('.pelanggan-navbar .navbar-brand img');
        if (logoImg) {
            logoImg.src = "{{ asset('assets/images/favicon.png') }}";
            logoImg.style.maxHeight = '48px';
            logoImg.style.height = 'auto';
        }



        // Accessibility triggers for cards acting as buttons
        document.querySelectorAll('.detail-card-button').forEach((element) => {
            element.addEventListener('keydown', function(event) {
                if (event.key === 'Enter' || event.key === ' ') {
                    event.preventDefault();
                    this.click();
                }
            });
        });

        // Detail Modal wiring
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
                const metaLabel = document.getElementById('detailModalMetaLabel');

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
                        metaRow.style.display = 'block';
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
                const metaLabel = document.getElementById('detailModalMetaLabel');

                if (metaRow) {
                    metaRow.classList.remove('d-none');
                    metaRow.style.display = 'block';
                }

                if (metaLabel) {
                    metaLabel.textContent = 'Kategori / Estimasi';
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

        // Echo Channel queue listeners
        checkEcho(() => {
            window.Echo.channel('Antrean-channel')
                .listen('AntreanUpdate', (e) => {
                    const antrean = e.antrean;

                    // Quick elements updates
                    const nomorEl = document.getElementById('antrean-nomor');
                    if (nomorEl && antrean?.nomor_antrean_seq) {
                        nomorEl.textContent = antrean.nomor_antrean_seq;
                    }

                    const statusEl = document.getElementById('antrean-status');
                    if (statusEl && antrean?.status) {
                        statusEl.textContent = antrean.status.toUpperCase();
                    }

                    window.location.reload();
                })
                .listen('AntreanUpadate', (e) => {
                    const antrean = e.antrean;
                    window.location.reload();
                });

            // Synchronize on queue changes
            window.Echo.channel('AntreanList-channel')
                .listen('AntreanListUpdate', () => {
                    window.location.reload();
                });
        });
    });
</script>
