<script>
    let isSpeaking = false;

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

        isSpeaking = true;

        return new Promise((resolve) => {
            const handleFinish = () => {
                isSpeaking = false;
                resolve();
            };

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

                    // Keep a global reference to prevent garbage collection
                    window.currentUtterance = utter;

                    utter.onend = () => {
                        window.currentUtterance = null;
                        handleFinish();
                    };
                    utter.onerror = (e) => {
                        window.currentUtterance = null;
                        console.warn('[TTS] Error:', e);
                        fallbackAudio(handleFinish);
                    };

                    window.speechSynthesis.cancel();
                    window.speechSynthesis.speak(utter);
                }
            } catch (err) {
                console.warn('[TTS] Failed:', err);
                fallbackAudio(handleFinish);
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

    window.isActionInProgress = false;

    // === LOGIKA FILTER ===
    function submitAntreanFilter(status) {
        const form = document.querySelector('.antrean-filter-form');
        const statusInput = document.getElementById('statusFilterInput');

        if (!form || !statusInput) {
            return;
        }

        statusInput.value = status || 'all';
        form.submit();
    }

    function resetTanggalFilter() {
        const tanggalInput = document.getElementById('tanggalFilter');
        if (tanggalInput) {
            tanggalInput.value = '';
        }

        const statusInput = document.getElementById('statusFilterInput');
        submitAntreanFilter(statusInput?.value || 'all');
    }

    document.addEventListener('DOMContentLoaded', function() {
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
            window.Echo.channel('Antrean-channel').listen('AntreanUpdate', async (e) => {
                if (!window.isActionInProgress) {
                    const antrean = e.antrean || {};
                    await playQueueAudio(antrean);
                    window.location.reload();
                }
            });

            window.Echo.channel('AntreanList-channel').listen('AntreanListUpdate', async (e) => {
                if (!window.isActionInProgress) {
                    // Wait briefly to allow any simultaneous AntreanUpdate event to trigger and set isSpeaking
                    await new Promise(r => setTimeout(r, 100));

                    if (isSpeaking) {
                        console.log('Skipping reload in AntreanListUpdate because TTS is speaking.');
                        return;
                    }

                    const antreanList = e.antreanList || [];
                    if (antreanList.length > 0) {
                        await playQueueAudio(antreanList[0]);
                    }

                    if (isSpeaking) {
                        console.log('Skipping reload in AntreanListUpdate because TTS started speaking.');
                        return;
                    }

                    window.location.reload();
                }
            });
        });

        document.querySelectorAll('.queue-action-btn').forEach((button) => {
            button.addEventListener('click', function() {
                const id = this.dataset.queueId;
                const targetStatus = this.dataset.queueStatus;
                if (id && targetStatus) {
                    ubahStatus(this, id, targetStatus);
                }
            });
        });

        const tanggalFilter = document.getElementById('tanggalFilter');
        if (tanggalFilter) {
            tanggalFilter.addEventListener('change', function() {
                const statusInput = document.getElementById('statusFilterInput');
                submitAntreanFilter(statusInput?.value || 'all');
            });
        }

        const layananSelect1 = document.getElementById('layanan_id1');
        const layananSelect2 = document.getElementById('layanan_id2');
        const layananHelp = document.getElementById('layanan-help');
        const formTambah = document.getElementById('formTambahAntrean');
        const hasFormErrors = !!document.querySelector('#modalTambah .error-box');

        function syncLayananDropdown() {
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
                    'Baru satu layanan dipilih. Layanan 2 bersifat opsional.';
            }
        }

        if (layananSelect1 && layananSelect2) {
            layananSelect1.addEventListener('change', syncLayananDropdown);
            layananSelect2.addEventListener('change', syncLayananDropdown);
            syncLayananDropdown();
        }

        // === PERUBAHAN SWEETALERT: Validasi Form ===
        function restoreSubmitButtons(form) {
            if (!form) {
                return;
            }

            form.querySelectorAll('button[type="submit"]').forEach((button) => {
                if (button.dataset.originalText) {
                    button.disabled = false;
                    button.textContent = button.dataset.originalText;
                    delete button.dataset.originalText;
                }
            });
        }

        if (formTambah) {
            formTambah.addEventListener('submit', function(event) {
                if (!layananSelect1 || !layananSelect2) {
                    return;
                }

                if (!layananSelect1.value) {
                    event.preventDefault();
                    restoreSubmitButtons(formTambah);
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: 'Layanan 1 wajib dipilih.'
                    });
                    return;
                }

                if (layananSelect2.value && layananSelect2.value === layananSelect1.value) {
                    event.preventDefault();
                    restoreSubmitButtons(formTambah);
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: 'Layanan 1 dan layanan 2 tidak boleh sama.'
                    });
                }
            });
        }

        if (hasFormErrors) {
            document.getElementById('modalTambah').style.display = 'flex';
        }

        // === BULK CANCEL LOGIC ===
        const selectAllCheckboxes = document.querySelectorAll('.select-all-queues');
        const queueCheckboxes = document.querySelectorAll('.queue-checkbox');
        const btnBatalMasal = document.getElementById('btnBatalMasal');
        const countTerpilih = document.getElementById('countTerpilih');

        function updateBatalMasalVisibility() {
            const checkedCount = document.querySelectorAll('.queue-checkbox:checked').length;
            if (checkedCount > 0) {
                if (btnBatalMasal) {
                    btnBatalMasal.style.display = 'inline-block';
                    countTerpilih.innerText = checkedCount;
                }
            } else {
                if (btnBatalMasal) {
                    btnBatalMasal.style.display = 'none';
                }
                selectAllCheckboxes.forEach(cb => cb.checked = false);
            }

            const allChecked = (checkedCount === queueCheckboxes.length && queueCheckboxes.length > 0);
            selectAllCheckboxes.forEach(cb => cb.checked = allChecked);
        }

        selectAllCheckboxes.forEach(selectAll => {
            selectAll.addEventListener('change', function() {
                // If checking the walk-in select all, check walk-in checkboxes. 
                // But for simplicity, we'll just check ALL checkboxes in both tables.
                queueCheckboxes.forEach(cb => {
                    cb.checked = this.checked;
                });
                updateBatalMasalVisibility();
            });
        });

        queueCheckboxes.forEach(cb => {
            cb.addEventListener('change', updateBatalMasalVisibility);
        });

        if (btnBatalMasal) {
            btnBatalMasal.addEventListener('click', function() {
                const selectedIds = Array.from(document.querySelectorAll('.queue-checkbox:checked')).map(cb => cb.value);

                if (selectedIds.length === 0) return;

                Swal.fire({
                    title: 'Batalkan ' + selectedIds.length + ' Antrean Terpilih',
                    input: 'textarea',
                    inputPlaceholder: 'Tuliskan alasan pembatalan untuk semua antrean ini...',
                    inputAttributes: {
                        'aria-label': 'Tuliskan alasan pembatalan massal'
                    },
                    showCancelButton: true,
                    confirmButtonColor: '#EB5757',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Batalkan',
                    cancelButtonText: 'Batal',
                    preConfirm: (alasan) => {
                        if (!alasan) {
                            Swal.showValidationMessage('Alasan pembatalan wajib diisi');
                        }
                        return alasan;
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        processBatalMasal(this, selectedIds, result.value);
                    }
                });
            });
        }

    });

    // === BULK CANCEL PROCESS ===
    function processBatalMasal(button, ids, alasan) {
        window.isActionInProgress = true;
        let originalText = button.innerHTML;
        button.innerHTML = 'Memproses...';
        button.disabled = true;

        fetch(`/admin/antrean/batal-masal`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    queue_ids: ids,
                    alasan_batal: alasan
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: data.message,
                    confirmButtonText: 'OK',
                    showConfirmButton: true
                }).then(() => {
                    window.isActionInProgress = false;
                    window.location.reload();
                });
            })
            .catch(error => {
                console.error('Error:', error);
                window.isActionInProgress = false;
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Terjadi kesalahan saat membatalkan antrean.',
                    confirmButtonText: 'OK'
                });
                button.innerHTML = originalText;
                button.disabled = false;
            });
    }

    // === LOGIKA MODAL TAMBAH ===
    function toggleModal() {
        const modal = document.getElementById('modalTambah');
        if (modal.style.display === 'flex') {
            modal.style.display = 'none';
        } else {
            modal.style.display = 'flex';
        }
    }
    window.onclick = function(event) {
        const modal = document.getElementById('modalTambah');
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    // === PERUBAHAN SWEETALERT: Fungsi Panggil ===
    function panggil() {
        Swal.fire({
            title: 'Konfirmasi',
            text: "Sistem akan memanggil pelanggan selanjutnya.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#2F80ED',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Lanjutkan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.isActionInProgress = true;
                // Tampilkan loading saat fetch berjalan
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
                    .then(async data => {
                        const showSuccessAlertAndReload = () => {
                            Swal.fire({
                                icon: data.success ? 'success' : 'info',
                                title: data.success ? 'Berhasil' : 'Info',
                                text: data.message,
                                confirmButtonText: 'OK',
                                showConfirmButton: true,
                            }).then(() => {
                                window.isActionInProgress = false;
                                window.location.reload();
                            });
                        };

                        if (data.success && data.antrean) {
                            await playQueueAudio(data.antrean);
                        }
                        showSuccessAlertAndReload();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        window.isActionInProgress = false;
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Terjadi kesalahan saat memanggil antrean berikutnya.',
                            confirmButtonText: 'OK'
                        });
                    });
            }
        });
    }

    // === PERUBAHAN SWEETALERT: Fungsi Ubah Status ===
    function ubahStatus(button, id, targetStatus) {
        if (targetStatus === 'batal') {
            Swal.fire({
                title: 'Alasan Pembatalan',
                input: 'textarea',
                inputPlaceholder: 'Tuliskan alasan pembatalan di sini...',
                inputAttributes: {
                    'aria-label': 'Tuliskan alasan pembatalan'
                },
                showCancelButton: true,
                confirmButtonColor: '#EB5757',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Batalkan Antrean',
                cancelButtonText: 'Kembali',
                preConfirm: (alasan) => {
                    if (!alasan) {
                        Swal.showValidationMessage('Alasan pembatalan wajib diisi');
                    }
                    return alasan;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    processUbahStatus(button, id, targetStatus, result.value);
                }
            });
        } else {
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Tandai antrean ini sebagai selesai?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#4CC779',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Lanjutkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    processUbahStatus(button, id, targetStatus, null);
                }
            });
        }
    }

    function processUbahStatus(button, id, targetStatus, alasan) {
        window.isActionInProgress = true;
        let originalText = button.innerHTML;
        button.innerHTML = 'Memproses...';
        button.disabled = true;

        fetch(`/admin/antrean/${id}/ubah-status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    status: targetStatus,
                    alasan_batal: alasan
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(async data => {
                let audioPromise = Promise.resolve();
                if (data.success && data.antrean) {
                    audioPromise = playQueueAudio(data.antrean);
                }

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Status berhasil diubah menjadi: ' + targetStatus,
                    confirmButtonText: 'OK',
                    showConfirmButton: true
                }).then(async () => {
                    await audioPromise;
                    window.isActionInProgress = false;
                    window.location.reload();
                });
            })
            .catch(error => {
                console.error('Error:', error);
                window.isActionInProgress = false;
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Terjadi kesalahan saat mengubah status.',
                    confirmButtonText: 'OK'
                });
                button.innerHTML = originalText;
                button.disabled = false;
            });
    }

    document.addEventListener('DOMContentLoaded', function() {
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
