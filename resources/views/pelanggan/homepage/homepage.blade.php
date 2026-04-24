@extends('pelanggan.layouts.app')

@section('title', 'Dashboard - Arga\'s Home')

@push('styles')
    @include('pelanggan.homepage.style-index')
@endpush


@section('content')
<section class="hero d-flex justify-content-center align-items-center px-3">
    <div class="card queue-card shadow-lg border-0">
        <div class="bg-gold text-white p-3 d-flex align-items-center justify-content-center gap-3">
            <i class="fas fa-users fs-1"></i>
            <div>
                <h5 class="mb-0 fs-6">Status Antrian</h5>
                <p class="mb-0 small opacity-75">Total Antrian: {{ $jumlahAntrian }}</p>
            </div>
        </div>

        <div class="card-body text-center py-4">
            @if ($antrian)
            <div class="text-uppercase small text-muted mb-2 font-weight-bold">Sekarang Melayani</div>

            <h2 class="mb-2 fw-bold text-dark" id="antrian-nomor" style="letter-spacing: 3px; font-size: 2.5rem;">
                {{ $antrian->nomor_antrian }}
            </h2>

            <div class="d-inline-flex align-items-center px-3 py-2 rounded-pill bg-light text-dark fw-semibold mb-3 border"
                id="antrian-status">
                <span class="dot bg-success rounded-circle me-2" style="width: 10px; height: 10px;"></span>
                {{ $antrian->status === 'sedang dilayani' ? 'Dalam Proses' : ucfirst($antrian->status) }}
            </div>

            <p class="mb-0 text-muted fw-bold">{{ $antrian->nama_pelanggan }}</p>
            @else
            <div class="py-3">
                <i class="fas fa-check-circle text-muted fs-2 mb-2"></i>
                <p class="mb-0 text-muted">Belum ada antrian aktif</p>
            </div>
            @endif
        </div>
    </div>
</section>
<div class="container py-5">

    <h2 class="text-center mb-5 text-uppercase text-dark fw-light">
        ARGA'S <span class="text-gold fw-bold">Home</span>
    </h2>

    <div class="row text-center mb-5 g-4">
        <div class="col-6 col-md-3">
            <a href="{{ route('antrian') }}" class="text-decoration-none text-dark fw-bold menu-item d-block">
                <div class="icon-circle shadow-sm"><i class="fas fa-id-card"></i></div>
                Antrian Barbershop
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('galeri') }}" class="text-decoration-none text-dark fw-bold menu-item d-block">
                <div class="icon-circle shadow-sm"><i class="fas fa-images"></i></div>
                Galeri
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('pelanggan.layanan') }}" class="text-decoration-none text-dark fw-bold menu-item d-block">
                <div class="icon-circle shadow-sm"><i class="fas fa-cut"></i></div>
                Layanan Barber
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('menu') }}" class="text-decoration-none text-dark fw-bold menu-item d-block">
                <div class="icon-circle shadow-sm"><i class="fas fa-coffee"></i></div>
                Menu Coffee
            </a>
        </div>
    </div>

    <h4 class="border-gold-left ps-2 mb-4 fw-bold">Layanan Yang Ditawarkan</h4>

    <div class="row g-3">
        @foreach ($layanans as $layanan)
        <div class="col-6 col-md-4 col-lg-3 col-xl-2">
            @php
                $fotoLayanan = null;
                if (!empty($layanan->foto)) {
                    $fotoLayanan = \Illuminate\Support\Str::startsWith($layanan->foto, ['http://', 'https://'])
                        ? $layanan->foto
                        : asset('storage/' . $layanan->foto);
                }
            @endphp
            <div role="button" tabindex="0" class="detail-card-button" data-bs-toggle="modal" data-bs-target="#detailModal"
                data-type="layanan"
                data-title="{{ $layanan->nama }}"
                data-image="{{ $fotoLayanan ?? 'https://via.placeholder.com/600x400?text=No+Image' }}"
                data-price="Rp{{ number_format($layanan->harga, 0, ',', '.') }}"
                data-description="{{ e($layanan->deskripsi ?? 'Tidak ada deskripsi.') }}"
                data-estimation="{{ $layanan->estimasi_waktu ?? '-' }} menit"
                data-extra="Layanan barbershop"
                data-show-meta="1">
            <div class="card haircut-card shadow-sm border-0 h-100">
                <img src="{{ $fotoLayanan ?? 'https://via.placeholder.com/600x400?text=No+Image' }}"
                    class="card-img-top haircut-img" alt="{{ $layanan->nama }}">
                <div class="card-body p-2 text-center">
                    <h6 class="card-title text-muted mb-1" style="font-size: 0.9rem;">{{ $layanan->nama }}</h6>
                        <p class="card-text fw-bold text-dark mb-0">Rp{{ number_format($layanan->harga, 0, ',', '.') }}</p>
                    <div class="detail-card-meta">
                        <span class="detail-card-badge"><i class="fas fa-info-circle"></i> Detail</span>
                        <span>{{ $layanan->estimasi_waktu ?? '-' }} menit</span>
                    </div>
                </div>
            </div>
            </div>
        </div>

        @endforeach

    </div>

    <h4 class="border-gold-left ps-2 mb-4 mt-5 fw-bold">Menu Cafe</h4>

    <div class="row g-3">
        @forelse ($menus as $menu)
            <div class="col-6 col-md-4 col-lg-3 col-xl-2">
                @php
                    $fotoMenu = null;
                    if (!empty($menu->foto)) {
                        $fotoMenu = \Illuminate\Support\Str::startsWith($menu->foto, ['http://', 'https://'])
                            ? $menu->foto
                            : asset('storage/' . $menu->foto);
                    }
                @endphp
                <div role="button" tabindex="0" class="detail-card-button" data-bs-toggle="modal" data-bs-target="#detailModal"
                    data-type="menu"
                    data-title="{{ $menu->nama }}"
                    data-image="{{ $fotoMenu ?? 'https://via.placeholder.com/600x400?text=No+Image' }}"
                    data-price="Rp{{ number_format($menu->harga, 0, ',', '.') }}"
                    data-description="{{ e($menu->deskripsi ?? 'Tidak ada deskripsi.') }}"
                    data-category="{{ $menu->kategori ?? '-' }}"
                    data-availability="{{ $menu->is_available ? 'Tersedia' : 'Habis' }}"    
                    data-extra="Menu Cafe"
                    data-show-meta="0">
                <div class="card haircut-card shadow-sm border-0 h-100">
                    <img src="{{ $fotoMenu ?? 'https://via.placeholder.com/600x400?text=No+Image' }}"
                        class="card-img-top haircut-img" alt="{{ $menu->nama }}">
                    <div class="card-body p-2 text-center">
                        <h6 class="card-title text-muted mb-1" style="font-size: 0.9rem;">{{ $menu->nama }}</h6>
                        <p class="card-text fw-bold text-dark mb-0">Rp{{ number_format($menu->harga, 0, ',', '.') }}</p>
                        <div class="detail-card-meta">
                            <span class="detail-card-badge"><i class="fas fa-mug-hot"></i> Detail</span>
                            <span>{{ $menu->kategori ?? 'Coffee' }}</span>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-light border text-center mb-0">
                    Menu cafe belum tersedia saat ini.
                </div>
            </div>
        @endforelse
    </div>
</div>

<div class="modal fade detail-modal" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title mb-1" id="detailModalTitle">Detail</h5>
                    <small class="text-muted" id="detailModalExtra">-</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-4 align-items-start">
                    <div class="col-md-5">
                        <img id="detailModalImage" src="" alt="Detail gambar" class="detail-modal-img">
                    </div>
                    <div class="col-md-7">
                        <div class="mb-3">
                            <div class="text-muted small text-uppercase fw-semibold mb-1" id="detailModalType">-</div>
                            <div class="detail-modal-price" id="detailModalPrice">-</div>
                        </div>
                        <p class="detail-modal-text mb-3" id="detailModalDescription">-</p>
                        <div class="d-grid gap-2">
                            <div class="d-flex justify-content-between border rounded-3 px-3 py-2" id="detailModalMetaRow">
                                <span class="text-muted">Kategori / Estimasi</span>
                                <strong id="detailModalMeta">-</strong>
                            </div>
                            <div class="d-flex justify-content-between border rounded-3 px-3 py-2">
                                <span class="text-muted">Status</span>
                                <strong id="detailModalStatus">-</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script type="module">
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
                document.getElementById('detailModalType').textContent = type === 'layanan' ? 'Layanan Barber' : 'Menu Cafe';
                document.getElementById('detailModalMeta').textContent = type === 'layanan' ? estimation : category;
                document.getElementById('detailModalStatus').textContent = type === 'layanan' ? 'Tersedia' : availability;

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
            window.Echo.channel('Antrian-channel')
                .listen('AntreanUpadate', (e) => {
                    const antrian = e.antrean;

                    // Update cepat untuk elemen utama, lalu sinkronkan penuh melalui reload.
                    const nomorEl = document.getElementById('antrian-nomor');
                    if (nomorEl && antrian?.nomor_antrian) {
                        nomorEl.textContent = antrian.nomor_antrian;
                    }

                    const statusEl = document.getElementById('antrian-status');
                    if (statusEl && antrian?.status) {
                        statusEl.textContent = antrian.status.toUpperCase();
                    }

                    window.location.reload();
                });

            // Saat daftar menunggu berubah (tambah/batal/dipanggil), sinkronkan seluruh dashboard.
            window.Echo.channel('AntrianList-channel')
                .listen('AntreanListUpdate', () => {
                    window.location.reload();
                });
        }
    });
</script>
@endpush