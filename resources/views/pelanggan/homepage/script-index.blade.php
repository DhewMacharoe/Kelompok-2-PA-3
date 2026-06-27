<script type="module">

    document.addEventListener('DOMContentLoaded', function() {
        // Swap Logo dynamically to full brand logo on homepage
        const logoImg = document.querySelector('.pelanggan-navbar .navbar-brand img');
        if (logoImg) {
            logoImg.src = "{{ isset($activeDesign) && $activeDesign->favicon ? asset($activeDesign->favicon) : asset('assets/images/logo.png') }}";
            logoImg.style.maxHeight = '48px';
            logoImg.style.height = 'auto';
        }





        // Custom Service Detail Modal logic for Homepage
        const modalOverlay = document.getElementById('layananDetailModal');
        const modalCloseBtn = document.getElementById('modalCloseBtn');
        const modalName = document.getElementById('modalLayananName');
        const modalTime = document.getElementById('modalLayananTime');
        const modalDescription = document.getElementById('modalLayananDescription');
        const modalPrice = document.getElementById('modalLayananPrice');

        const btnBuatAntrean = document.getElementById('btnBuatAntreanDariLayanan');
        const antreanBaseUrl = "{{ route('antrean') }}";

        document.querySelectorAll('.layanan-card-trigger').forEach(item => {
            item.addEventListener('click', function() {
                const layananId = this.dataset.id;
                const ikon = this.dataset.ikon;
                modalName.textContent = this.dataset.name;
                modalTime.innerHTML = '<i class="far fa-clock" aria-hidden="true"></i> ' + (this.dataset.time ? this.dataset.time + ' Menit' : '-');
                modalDescription.textContent = this.dataset.description;
                modalPrice.textContent = 'Rp ' + this.dataset.price;

                // Update modal icon
                const modalIconWrapper = document.querySelector('.modal-image-wrapper');
                if (modalIconWrapper) {
                    let iconClass = 'fas fa-cut';
                    if (ikon === 'paint') iconClass = 'fas fa-paint-brush';
                    if (ikon === 'face') iconClass = 'fas fa-smile';
                    modalIconWrapper.innerHTML = `<i class="${iconClass}" aria-hidden="true"></i>`;
                }

                // Update href tombol Buat Antrean
                if (btnBuatAntrean) {
                    btnBuatAntrean.href = antreanBaseUrl + '?layanan_id=' + layananId;
                }

                modalOverlay.classList.add('active');
            });

            // Keydown listener for accessibility (acting as button)
            item.addEventListener('keydown', function(event) {
                if (event.key === 'Enter' || event.key === ' ') {
                    event.preventDefault();
                    this.click();
                }
            });
        });

        const modalBackBtn = document.getElementById('modalBackBtn');
        const modalBackBottomBtn = document.getElementById('modalBackBottomBtn');

        function handleBackOrClose() {
            modalOverlay.classList.remove('active');
            // Bersihkan URL query parameter tanpa reload
            const cleanUrl = window.location.pathname;
            window.history.replaceState({}, document.title, cleanUrl);
        }

        if (modalBackBtn) {
            modalBackBtn.addEventListener('click', handleBackOrClose);
        }

        if (modalBackBottomBtn) {
            modalBackBottomBtn.addEventListener('click', handleBackOrClose);
        }

        if (modalCloseBtn) {
            modalCloseBtn.addEventListener('click', handleBackOrClose);
        }

        if (modalOverlay) {
            modalOverlay.addEventListener('click', function(event) {
                if (event.target === modalOverlay) {
                    handleBackOrClose();
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

        // Stopwatch untuk Antrean Dipanggil/Dilayani
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
