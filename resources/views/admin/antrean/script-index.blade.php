<script>
    // === LOGIKA FILTER ===
    function filterAntrean(status, button) {
        const rows = document.querySelectorAll('#antreanTableBody tr[data-status]');
        const buttons = document.querySelectorAll('.filter-btn');
        const normalizedFilter = (status || '').toString().trim().toLowerCase();
        const selectedDate = document.getElementById('tanggalFilter')?.value || '';

        buttons.forEach((item) => item.classList.remove('active'));
        if (button) {
            button.classList.add('active');
        }

        rows.forEach((row) => {
            const rowStatus = (row.getAttribute('data-status') || '').toString().trim().toLowerCase();
            const rowDate = normalizedFilter === 'selesai' || normalizedFilter === 'batal' ||
                normalizedFilter === 'all' ?
                (row.getAttribute('data-date-finished') || row.getAttribute('data-date-created') || '') :
                (row.getAttribute('data-date-created') || '');

            const matchesStatus = normalizedFilter === 'all' || rowStatus === normalizedFilter;
            const matchesDate = !selectedDate || rowDate === selectedDate || rowStatus === 'menunggu';
            const isVisible = matchesStatus && (normalizedFilter === 'menunggu' ? true : matchesDate);
            row.style.display = isVisible ? '' : 'none';
        });
    }

    function getTodayDateString() {
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    function resetTanggalFilter() {
        const tanggalInput = document.getElementById('tanggalFilter');
        if (tanggalInput) {
            tanggalInput.value = getTodayDateString();
        }

        const activeButton = document.querySelector('.filter-btn.active') || document.querySelector(
            '.filter-btn[data-filter="menunggu"]');
        filterAntrean(activeButton?.dataset?.filter || 'menunggu', activeButton);
    }

    document.addEventListener('DOMContentLoaded', function() {
        if (window.Echo) {
            window.Echo.channel('Antrean-channel').listen('AntreanUpdate', () => {
                window.location.reload();
            });

            window.Echo.channel('AntreanList-channel').listen('AntreanListUpdate', () => {
                window.location.reload();
            });
        }

        const defaultButton = document.querySelector('.filter-btn[data-filter="menunggu"]');
        filterAntrean('menunggu', defaultButton);

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
            tanggalFilter.value = getTodayDateString();
            tanggalFilter.addEventListener('change', function() {
                const activeButton = document.querySelector('.filter-btn.active') || defaultButton;
                filterAntrean(activeButton?.dataset?.filter || 'menunggu', activeButton);
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
        if (formTambah) {
            formTambah.addEventListener('submit', function(event) {
                if (!layananSelect1 || !layananSelect2) {
                    return;
                }

                if (!layananSelect1.value) {
                    event.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: 'Layanan 1 wajib dipilih.'
                    });
                    return;
                }

                if (layananSelect2.value && layananSelect2.value === layananSelect1.value) {
                    event.preventDefault();
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
                    .then(data => {
                        Swal.fire({
                            if: data.success,
                            icon: data.success ? 'success' : 'info',
                            title: data.success ? 'Berhasil!' : 'Info',
                            text: data.message,
                            showConfirmButton: true,
                        }).then(() => {
                            window.location.reload();
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
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
                            window.location.reload();
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Gagal', 'Terjadi kesalahan saat mengubah status.', 'error');
                        button.innerHTML = originalText;
                        button.disabled = false;
                    });
            }
        });
    }
</script>
