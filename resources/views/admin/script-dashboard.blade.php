<script>
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
        if (window.Echo) {
            window.Echo.channel('Antrean-channel').listen('AntreanUpdate', async (e) => {
                const antrean = e.antrean || {};
                await playQueueAudio(antrean);
                window.location.reload();
            });

            window.Echo.channel('AntreanList-channel').listen('AntreanListUpdate', async (e) => {
                const antreanList = e.antreanList || [];
                if (antreanList.length > 0) {
                    const item = antreanList[0];
                    await playQueueAudio(item);
                }
                window.location.reload();
            });
        }

        // Logik Grafik (Tetap sama)
        const canvasStatistik = document.getElementById('statistikChart');
        if (canvasStatistik) {
            const ctx1 = canvasStatistik.getContext('2d');
            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: ['Menunggu', 'Selesai', 'Batal'],
                    datasets: [{
                        label: 'Jumlah Orang',
                        data: @json($statistikData ?? []),
                        backgroundColor: ['rgba(54, 162, 235, 0.6)', 'rgba(39, 174, 96, 0.6)',
                            'rgba(255, 99, 132, 0.6)'
                        ],
                        borderColor: ['rgba(54, 162, 235, 1)', 'rgba(39, 174, 96, 1)',
                            'rgba(255, 99, 132, 1)'
                        ],
                        borderWidth: 1,
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }

        const canvasTrend = document.getElementById('trendChart');
        if (canvasTrend) {
            const ctx2 = canvasTrend.getContext('2d');
            new Chart(ctx2, {
                type: 'line',
                data: {
                    labels: @json($trendLabels ?? []),
                    datasets: [{
                        label: 'Total Pengunjung',
                        data: @json($trendData ?? []),
                        borderColor: 'rgba(47, 128, 237, 1)',
                        backgroundColor: 'rgba(47, 128, 237, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }
    });

    function panggil() {
        Swal.fire({
            title: 'Panggil Antrean?',
            text: "Sistem akan memanggil pelanggan selanjutnya ke kursi pangkas.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#0d6efd',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Panggil',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Memproses...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                fetch("{{ route('admin.antrean.panggil') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Tidak ada notifikasi sukses di sini, tunggu event websocket merespons suara lalu page reload
                    })
                    .catch(error => {
                        Swal.fire('Gagal', 'Terjadi kesalahan saat memanggil antrean.', 'error');
                    });
            }
        });
    }

    function ubahStatus(button, id, targetStatus) {
        const executeUpdate = () => {
            let originalText = button.innerHTML;
            button.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
            button.disabled = true;

            fetch(`/admin/antrean/${id}/ubah-status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        status: targetStatus
                    })
                })
                .then(response => response.json())
                .then(data => {
                    // WebSocket listener takes care of playing audio and reloading page
                })
                .catch(error => {
                    button.innerHTML = originalText;
                    button.disabled = false;
                    Swal.fire('Gagal', 'Gagal mengubah status antrean.', 'error');
                });
        };

        // Dialog Konfirmasi Khusus Pembatalan
        if (targetStatus === 'batal') {
            Swal.fire({
                title: 'Batalkan Antrean?',
                text: "Apakah Anda yakin ingin membatalkan antrean ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Batalkan!',
                cancelButtonText: 'Kembali'
            }).then((result) => {
                if (result.isConfirmed) executeUpdate();
            });
        } else if (targetStatus === 'selesai') {
            Swal.fire({
                title: 'Selesaikan Antrean?',
                text: "Pelanggan sudah selesai dilayani?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Selesai',
                cancelButtonText: 'Belum'
            }).then((result) => {
                if (result.isConfirmed) executeUpdate();
            });
        } else {
            executeUpdate();
        }
    }
</script>
