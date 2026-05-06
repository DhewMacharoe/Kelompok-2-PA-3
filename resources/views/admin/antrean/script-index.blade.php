<script>
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
        if (window.Echo) {
            window.Echo.channel('Antrean-channel').listen('AntreanUpdate', async (e) => {
                if (!window.isActionInProgress) {
                    const antrean = e.antrean || {};
                    await playQueueAudio(antrean);
                    window.location.reload();
                }
            });

            window.Echo.channel('AntreanList-channel').listen('AntreanListUpdate', async (e) => {
                if (!window.isActionInProgress) {
                    const antreanList = e.antreanList || [];
                    if (antreanList.length > 0) {
                        await playQueueAudio(antreanList[0]);
                    }
                    window.location.reload();
                }
            });
        }

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
    });

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
            title: 'Panggil Antrean?',
            text: "Sistem akan memanggil pelanggan selanjutnya.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#2F80ED',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Panggil',
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
                                title: data.success ? 'Berhasil!' : 'Info',
                                text: data.message,
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
                        Swal.fire('Gagal', 'Terjadi kesalahan saat memanggil antrean berikutnya.', 'error');
                    });
            }
        });
    }

    // === PERUBAHAN SWEETALERT: Fungsi Ubah Status ===
    function ubahStatus(button, id, targetStatus) {
        let swalConfig = {
            title: targetStatus === 'selesai' ? 'Selesaikan Antrean?' : 'Batalkan Antrean?',
            text: targetStatus === 'selesai' ? 'Tandai antrean ini sebagai selesai?' :
                'Apakah Anda yakin ingin membatalkan antrean ini?',
            icon: targetStatus === 'selesai' ? 'question' : 'warning',
            showCancelButton: true,
            confirmButtonColor: targetStatus === 'selesai' ? '#4CC779' : '#EB5757',
            cancelButtonColor: '#6c757d',
            confirmButtonText: targetStatus === 'selesai' ? 'Ya, Selesai' : 'Ya, Batalkan',
            cancelButtonText: 'Kembali'
        };

        Swal.fire(swalConfig).then((result) => {
            if (result.isConfirmed) {
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
                            status: targetStatus
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
                            text: 'Status berhasil diubah menjadi: ' + targetStatus,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.isActionInProgress = false;
                            window.location.reload();
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        window.isActionInProgress = false;
                        Swal.fire('Gagal', 'Terjadi kesalahan saat mengubah status.', 'error');
                        button.innerHTML = originalText;
                        button.disabled = false;
                    });
            }
        });
    }
</script>
