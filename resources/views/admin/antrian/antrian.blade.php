@extends('admin.layouts.app')

@section('title', 'Antrian')

@section('header_title')
    <div class="header-title">Riwayat Antrian</div>
@endsection

@section('content')
    <style>
        /* CSS Khusus Halaman Ini */
        .main-container {
            padding: 20px;
            font-family: 'Inter', sans-serif;
        }

        /* Penampil Antrean Utama (Top Card) */
        .serving-display {
            background-color: #2C3E50;
            color: white;
            text-align: center;
            padding: 40px 20px;
            border-radius: 20px;
            margin-bottom: 24px;
        }

        .serving-display p {
            margin: 0;
            opacity: 0.8;
            font-size: 14px;
        }

        .serving-display .queue-number-big {
            font-size: 80px;
            font-weight: bold;
            margin: 10px 0;
            display: block;
        }

        .btn-group-serving {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }

        .btn-panggil {
            background-color: #2F80ED;
            color: white;
            border: none;
            padding: 10px 30px;
            border-radius: 8px;
            cursor: pointer;
        }

        .btn-batal {
            background-color: #EB5757;
            color: white;
            border: none;
            padding: 10px 30px;
            border-radius: 8px;
            cursor: pointer;
        }

        /* Tombol Tambah */
        .btn-tambah {
            background-color: #4CC779;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 20px;
            font-weight: 500;
            cursor: pointer;
        }

        .filter-bar {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 16px;
        }

        .filter-btn {
            border: 1px solid #dfe3e8;
            background: #fff;
            color: #2C3E50;
            padding: 10px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .filter-btn:hover {
            border-color: #2F80ED;
            color: #2F80ED;
        }

        .filter-btn.active {
            background: #2F80ED;
            border-color: #2F80ED;
            color: white;
        }

        /* Styling Tabel */
        .table-container {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        .custom-table thead {
            background-color: #2C3E50;
            color: white;
        }

        .custom-table th,
        .custom-table td {
            padding: 15px;
            border-bottom: 1px solid #eee;
        }

        .row-highlight {
            background-color: #2196F3 !important;
            color: white !important;
        }

        .row-highlight td {
            border-color: transparent;
        }

        /* Status Badge */
        .status-text {
            font-weight: 500;
        }

        .action-link {
            color: #4a80da;
            text-decoration: none;
            font-weight: 600;
        }

        /* --- CSS BARU UNTUK CARD FORM (MODAL) --- */
        .modal-overlay {
            display: none;
            /* Sembunyikan secara default */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .form-card {
            background: white;
            padding: 24px;
            border-radius: 12px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .form-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .form-card-header h3 {
            margin: 0;
            font-size: 18px;
            color: #2C3E50;
        }

        .btn-close {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #999;
        }

        .form-group {
            margin-bottom: 16px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            color: #333;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            box-sizing: border-box;
        }

        .form-control[multiple] {
            min-height: 130px;
        }

        .form-help {
            margin-top: 6px;
            font-size: 12px;
            color: #6b7280;
        }

        .form-error {
            margin-top: 6px;
            font-size: 12px;
            color: #d93025;
        }

        .error-box {
            background: #fff4f4;
            border: 1px solid #ffd8d8;
            color: #8a1c1c;
            border-radius: 8px;
            padding: 10px 12px;
            margin-bottom: 12px;
            font-size: 13px;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 24px;
        }

        .btn-submit {
            background-color: #2F80ED;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
        }

        /* --- AKHIR CSS BARU --- */
    </style>

    <div class="main-container">

        @php
            $current = $antrians->where('status', 'sedang dilayani')->first();
        @endphp

        <div class="serving-display">
            <p>Sedang dilayani</p>
            <span class="queue-number-big">{{ $current->nomor_antrian ?? '--' }}</span>
            <p style="font-size: 18px; font-weight: 500;">{{ $current->nama_pelanggan ?? 'Tidak ada antrean' }}</p>
            @if ($current)
                <div class="btn-group-serving">
                    <button type="button" class="btn-panggil shadow-sm"
                        onclick="ubahStatus(this, {{ $current->id }}, 'selesai')">
                        Selesai
                    </button>
                    <button type="button" class="btn-batal shadow-sm"
                        onclick="ubahStatus(this, {{ $current->id }}, 'batal')">
                        Batalkan
                    </button>
                </div>
            @else
                <p>Tidak ada antrean yang sedang dilayani saat ini.</p>
                <button type="button" class="btn-panggil shadow-sm" onclick="panggil()">
                    panggil
                </button>
            @endif
        </div>

        <button onclick="toggleModal()" class="btn-tambah shadow-sm">
            + Tambah
        </button>

        <div class="filter-bar" role="tablist" aria-label="Filter status antrian">
            <button type="button" class="filter-btn active" data-filter="menunggu"
                onclick="filterAntrian('menunggu', this)">Menunggu</button>
            <button type="button" class="filter-btn" data-filter="selesai"
                onclick="filterAntrian('selesai', this)">Selesai</button>
            <button type="button" class="filter-btn" data-filter="batal"
                onclick="filterAntrian('batal', this)">Batal</button>
            <button type="button" class="filter-btn" data-filter="all" onclick="filterAntrian('all', this)">Semua</button>
        </div>

        <div class="table-container">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Nomor Antrean</th>
                        <th>Nama</th>
                        <th>Masuk</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="antrianTableBody">
                    @forelse($antrians as $item)
                        <tr class="{{ $item->status == 'sedang dilayani' ? 'row-highlight' : '' }}"
                            data-status="{{ $item->status }}">
                            <td>{{ $item->nomor_antrian }}</td>
                            <td>{{ $item->nama_pelanggan }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->waktu_masuk)->format('Y-m-d H:i:s') }}</td>
                            <td>
                                <span class="status-text">
                                    {{ $item->status == 'sedang dilayani' ? 'Sedang Dilayani' : ucfirst($item->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding: 40px; color: #999;">Belum ada riwayat antrian yang tercatat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="modalTambah" class="modal-overlay">
        <div class="form-card">
            <div class="form-card-header">
                <h3>Tambah Antrean Baru</h3>
                <button onclick="toggleModal()" class="btn-close">&times;</button>
            </div>

            @if ($errors->any())
                <div class="error-box">
                    <strong>Data belum valid:</strong>
                    <ul style="margin: 6px 0 0 16px; padding: 0;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="formTambahAntrian" action="{{ route('admin.simpan-pelanggan') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nama_pelanggan">Nama Pelanggan</label>
                    <input type="text" id="nama_pelanggan" name="nama_pelanggan" class="form-control"
                        placeholder="Masukkan nama..." value="{{ old('nama_pelanggan') }}" required>
                    @error('nama_pelanggan')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="layanan_id1">Layanan 1 (wajib)</label>
                    <select id="layanan_id1" name="layanan_id1" class="form-control" required>
                        <option value="">Pilih layanan 1</option>
                        @foreach ($layananAktif as $layanan)
                            <option value="{{ $layanan->id }}" @selected((string) $layanan->id === (string) old('layanan_id1'))>
                                {{ $layanan->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('layanan_id1')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="layanan_id2">Layanan 2 (opsional)</label>
                    <select id="layanan_id2" name="layanan_id2" class="form-control">
                        <option value="">Pilih layanan 2</option>
                        @foreach ($layananAktif as $layanan)
                            <option value="{{ $layanan->id }}" @selected((string) $layanan->id === (string) old('layanan_id2'))>
                                {{ $layanan->nama }}
                            </option>
                        @endforeach
                    </select>
                    <div class="form-help" id="layanan-help">Pilih layanan kedua jika dibutuhkan, dan tidak boleh sama dengan layanan 1.</div>
                    @error('layanan_id2')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-batal" onclick="toggleModal()">Batal</button>
                    <button type="submit" class="btn-submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <div style="height:50px;"></div>

    <script>
        function filterAntrian(status, button) {
            const rows = document.querySelectorAll('#antrianTableBody tr[data-status]');
            const buttons = document.querySelectorAll('.filter-btn');
            const normalizedFilter = (status || '').toString().trim().toLowerCase();

            buttons.forEach((item) => item.classList.remove('active'));
            if (button) {
                button.classList.add('active');
            }

            rows.forEach((row) => {
                const rowStatus = (row.getAttribute('data-status') || '').toString().trim().toLowerCase();
                const isVisible = normalizedFilter === 'all' || rowStatus === normalizedFilter;
                row.style.display = isVisible ? '' : 'none';
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            const defaultButton = document.querySelector('.filter-btn[data-filter="menunggu"]');
            filterAntrian('menunggu', defaultButton);

            const layananSelect1 = document.getElementById('layanan_id1');
            const layananSelect2 = document.getElementById('layanan_id2');
            const layananHelp = document.getElementById('layanan-help');
            const formTambah = document.getElementById('formTambahAntrian');
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
                    layananHelp.textContent = layananSelect2.value
                        ? 'Dua layanan dipilih.'
                        : 'Baru satu layanan dipilih. Layanan 2 bersifat opsional.';
                }
            }

            if (layananSelect1 && layananSelect2) {
                layananSelect1.addEventListener('change', syncLayananDropdown);
                layananSelect2.addEventListener('change', syncLayananDropdown);
                syncLayananDropdown();
            }

            if (formTambah) {
                formTambah.addEventListener('submit', function (event) {
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

            if (hasFormErrors) {
                document.getElementById('modalTambah').style.display = 'flex';
            }
        });

        function panggil() {
            fetch("{{ route('admin.antrian.panggil') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                })
                .then(response => response.json())
                .then(data => {
                    alert('Antrean berikutnya dipanggil!');
                    window.location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memanggil antrean berikutnya.');
                });
        }

        function ubahStatus(button, id, targetStatus) {
            // Simpan teks asli
            let originalText = button.innerHTML;
            button.innerHTML = 'Memproses...';
            button.disabled = true;

            // PERBAIKAN: Sesuaikan URL fetch dengan route prefix 'admin/antrian/...'
            fetch(`/admin/antrian/${id}/ubah-status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Pastikan ini ada di dalam file .blade.php
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
                    alert('Status berhasil diubah menjadi: ' + targetStatus);

                    if (targetStatus === 'selesai') {
                        button.innerHTML = 'Selesai Diproses';
                    } else {
                        button.innerHTML = 'Dibatalkan';
                    }

                    // Opsional: Muat ulang halaman (refresh) agar antrean dan tabel ikut ter-update
                    window.location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengubah status.');
                    button.innerHTML = originalText;
                    button.disabled = false;
                });
        }

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
    </script>
@endsection
