@extends('pelanggan.layouts.app')

@section('title', 'Antrian')

@push('styles')
    @include('pelanggan.antrian.style-index')
    <style>
        /* CSS untuk membuat antrian bisa di-scroll */
        .queue-list-container {
            max-height: 400px;
            overflow-y: auto;
            overflow-x: hidden;
            padding-right: 10px;
        }

        .queue-list-container::-webkit-scrollbar {
            width: 6px;
        }
        .queue-list-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        .queue-list-container::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }
        .queue-list-container::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* Modifikasi sedikit untuk tombol di offcanvas agar sesuai tema */
        .btn-submit-bottom {
            background-color: #0d6efd; /* Sesuaikan warna dengan tema Anda */
            color: white;
            padding: 10px;
            font-weight: bold;
            border-radius: 8px;
        }
    </style>
@endpush

@section('content')

<div class="container px-3">
    <div class="app-card">
        <div class="row g-0">

            <div class="col-md-5">
                <div class="header-section">
                    <div class="text-gold">SEDANG DILAYANI</div>
                    <div class="active-number-box">
                        <p class="active-number" id="antrian-nomor">{{ $dipanggil ? $dipanggil->nomor_antrian : '0' }}</p>
                    </div>
                    <div class="active-name" id = "antrian-nama">{{ $dipanggil ? $dipanggil->nama_pelanggan : 'Tidak ada' }}
                    </div>
                    <div class="active-name" id = "antrian-status">{{ $dipanggil ? $dipanggil->status : 'Tidak ada' }}
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <div class="right-panel">

                    <div class="queue-section">
                        <div class="section-title">URUTAN ANTRIAN</div>


                        <div class="queue-list-container">
                            @if ($data_antrian && count($data_antrian) > 0)
                                @foreach ($data_antrian as $antrian)
                                <div class="queue-card">
                                    <div class="queue-number-box">{{ $antrian->nomor_antrian }}</div>
                                    <div class="queue-info">
                                        <p class="queue-name">{{ $antrian->nama_pelanggan }}</p>
                                        <p class="queue-time">(({{ $antrian->created_at->format('H:i') }}))</p>
                                    </div>
                                    <div><span class="badge-waiting">MENUNGGU</span></div>
                                </div>
                                @endforeach
                            @else
                                <div class="text-center mt-4 mb-4 text-muted">Tidak ada antrian</div>
                            @endif

                        </div>
                    </div>

                    <div class="footer-section">
                        @auth
                            @if(!$punyaAntrianAktif)
                                <button class="btn btn-add-queue" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTambahAntrean" aria-controls="offcanvasTambahAntrean" style="width: 100%;">
                                    Tambah Antrean
                                </button>
                            @endif
                        @else
                            <a href="{{ route('login.user') }}" class="btn btn-add-queue" style="width: 100%; text-decoration: none; display: block; text-align: center;">Login</a>
                        @endauth
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasTambahAntrean" aria-labelledby="offcanvasTambahAntreanLabel" style="height: auto; border-top-left-radius: 20px; border-top-right-radius: 20px; box-shadow: 0 -4px 10px rgba(0,0,0,0.1);">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title fw-bold" id="offcanvasTambahAntreanLabel">Tambah Antrean</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>

  <div class="offcanvas-body">
      <form action="{{ route('antrian.store') }}" method="POST">
          @csrf
          <div class="mb-4">
              <label for="nama_pelanggan" class="form-label text-muted">Nama Pelanggan</label>
              <input type="text" class="form-control form-control-lg" id="nama_pelanggan" name="nama_pelanggan" placeholder="Ketik nama di sini..." required>
          </div>
          <div class="d-grid">
              <button type="submit" class="btn btn-submit-bottom btn-lg">Tambah</button>
          </div>
      </form>
  </div>
</div>

@endsection

@push('scripts')
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

            const antreanList = e.antreanList;
            const queueListContainer = document.querySelector('.queue-list-container');

            // Kosongkan isi lama
            queueListContainer.innerHTML = '';

            if (antreanList.length > 0) {
                antreanList.forEach(item => {
                    queueListContainer.innerHTML += `
                        <div class="queue-card">
                            <div class="queue-number-box">${item.nomor_antrian}</div>
                            <div class="queue-info">
                                <p class="queue-name">${item.nama_pelanggan}</p>
                                <p class="queue-time">(${formatJam(item.created_at)})</p>
                            </div>
                            <div><span class="badge-waiting">MENUNGGU</span></div>
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
                });


    });



</script>
@endpush
