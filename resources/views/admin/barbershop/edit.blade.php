@extends('admin.layouts.app')

@section('title', 'Edit Design Web')

@section('header_title')
    <div class="header-title">Edit Design Web</div>
@endsection

@push('styles')
<style>
    .form-card {
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.06);
        border: none;
        overflow: hidden;
        background-color: #ffffff;
    }
    .form-header {
        background: linear-gradient(135deg, #1e1e24 0%, {{ $barbershop->warna_primer ?? '#e8a53a' }} 100%);
        padding: 25px 30px;
        color: #fff;
    }
    .form-label { 
        font-weight: 600; 
        color: #495057; 
        font-size: 0.9rem;
    }
    .form-control { 
        border-radius: 8px; 
        padding: 10px 15px; 
        border: 1px solid #ced4da; 
        transition: all 0.3s ease;
    }
    .form-control:focus { 
        border-color: {{ $barbershop->warna_primer ?? '#e8a53a' }}; 
        box-shadow: 0 0 0 0.25rem {{ $barbershop->warna_primer ?? '#e8a53a' }}25; 
    }
    .input-group-text {
        border-radius: 8px 0 0 8px;
    }
    .input-group > .form-control {
        border-radius: 0 8px 8px 0;
    }
    .custom-pills .nav-link {
        border-radius: 10px;
        padding: 12px 20px;
        font-weight: 600;
        color: #495057;
        background-color: #f8f9fa;
        transition: all 0.3s ease;
        border: 1px solid #eef2f5;
    }
    .custom-pills .nav-link:hover {
        background-color: #eef2f5;
    }
    .custom-pills .nav-link.active {
        background-color: {{ $barbershop->warna_primer ?? '#e8a53a' }};
        color: white;
        box-shadow: 0 4px 12px {{ ($barbershop->warna_primer ?? '#e8a53a') }}30;
        border-color: {{ $barbershop->warna_primer ?? '#e8a53a' }};
    }
    .hero-config-card {
        border-radius: 12px;
        border: 1px solid #eef2f5;
        background-color: #ffffff;
        transition: all 0.3s ease;
    }
    .hero-config-card:hover {
        box-shadow: 0 6px 18px rgba(0,0,0,0.03);
    }
    .btn-submit { 
        background-color: {{ $barbershop->warna_primer ?? '#e8a53a' }}; 
        color: white; 
        border: none; 
        padding: 12px 28px; 
        border-radius: 10px; 
        font-weight: 600; 
        transition: all 0.3s ease; 
        box-shadow: 0 4px 12px {{ ($barbershop->warna_primer ?? '#e8a53a') }}30;
    }
    .btn-submit:hover { 
        background-color: {{ $barbershop->warna_primer ?? '#e8a53a' }}e6; 
        color: white; 
        transform: translateY(-2px);
        box-shadow: 0 6px 16px {{ ($barbershop->warna_primer ?? '#e8a53a') }}40;
    }
    .btn-cancel { 
        background-color: #f8f9fa; 
        color: #495057; 
        border: 1px solid #ced4da; 
        padding: 12px 28px; 
        border-radius: 10px; 
        font-weight: 600; 
        text-decoration: none; 
        display: inline-block; 
        transition: all 0.3s ease; 
    }
    .btn-cancel:hover { 
        background-color: #eef2f5; 
        color: #2b2c3a; 
    }
</style>
@endpush

@section('content')
<div class="content-body pb-5">
    <div class="form-card card mx-auto mt-4" style="max-width: 850px;">
        <div class="form-header">
            <h4 class="mb-1 fw-bold text-white"><i class="fas fa-magic me-2"></i>Edit Desain & Profil Web</h4>
            <p class="mb-0 text-white-50 small">Sesuaikan tampilan, teks spanduk hero, kontak, dan maps website Anda.</p>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('admin.barbershop.update', $barbershop->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Tabs Form Navigation -->
                <ul class="nav nav-pills custom-pills row g-2 mb-4" id="editTabs" role="tablist">
                    <li class="nav-item col-md-4" role="presentation">
                        <button class="nav-link w-100 active text-truncate" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-pane" type="button" role="tab" aria-controls="profile-pane" aria-selected="true">
                            <i class="fas fa-id-card me-2"></i>1. Profil & Warna
                        </button>
                    </li>
                    <li class="nav-item col-md-4" role="presentation">
                        <button class="nav-link w-100 text-truncate" id="heroes-tab" data-bs-toggle="tab" data-bs-target="#heroes-pane" type="button" role="tab" aria-controls="heroes-pane" aria-selected="false">
                            <i class="fas fa-images me-2"></i>2. Hero Halaman
                        </button>
                    </li>
                    <li class="nav-item col-md-4" role="presentation">
                        <button class="nav-link w-100 text-truncate" id="contacts-tab" data-bs-toggle="tab" data-bs-target="#contacts-pane" type="button" role="tab" aria-controls="contacts-pane" aria-selected="false">
                            <i class="fas fa-map-marked-alt me-2"></i>3. Kontak & Peta
                        </button>
                    </li>
                </ul>

                <!-- Tabs Form Content -->
                <div class="tab-content" id="editTabsContent">

                    <!-- Tab 1: Profil & Warna -->
                    <div class="tab-pane fade show active" id="profile-pane" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label for="nama_brand" class="form-label">Nama Brand / Judul Web <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_brand') is-invalid @enderror" id="nama_brand" name="nama_brand" value="{{ old('nama_brand', $barbershop->nama_brand) }}" required placeholder="Contoh: Arga Home's">
                                @error('nama_brand')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="slogan" class="form-label">Slogan / Tagline Brand <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('slogan') is-invalid @enderror" id="slogan" name="slogan" value="{{ old('slogan', $barbershop->slogan) }}" required placeholder="Contoh: Barber, Coffee & Food">
                                @error('slogan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label for="favicon" class="form-label">Favicon / Logo Brand</label>
                                <div class="row align-items-center g-3">
                                    <div class="col-auto">
                                        @if($barbershop->favicon)
                                            <img src="{{ asset($barbershop->favicon) }}" alt="Favicon" class="img-thumbnail rounded shadow-sm" style="max-height: 55px; max-width: 55px; object-fit: contain; padding: 2px;">
                                        @else
                                            <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="img-thumbnail rounded shadow-sm" style="max-height: 55px; max-width: 55px; object-fit: contain; padding: 2px;">
                                        @endif
                                    </div>
                                    <div class="col">
                                        <input type="file" class="form-control @error('favicon') is-invalid @enderror" id="favicon" name="favicon" accept="image/*">
                                        <small class="text-muted d-block mt-1">Format: JPG, PNG, GIF, SVG, ICO. Maks 2MB. Biarkan kosong jika tidak diubah.</small>
                                    </div>
                                </div>
                                @error('favicon')
                                    <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Kontak <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $barbershop->email) }}" required placeholder="info@argahomes.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="card p-3 bg-light border-0 h-100 d-flex flex-column justify-content-center">
                                    <label for="warna_primer" class="form-label mb-1">Warna Dasar / Aksen Web</label>
                                    <div class="d-flex align-items-center gap-3">
                                        <input type="color" class="form-control form-control-color border-0" id="warna_primer" name="warna_primer" value="{{ old('warna_primer', $barbershop->warna_primer ?? '#e8a53a') }}" title="Pilih warna dasar" style="width: 50px; height: 40px; padding: 2px; border-radius: 6px;">
                                        <span class="text-muted small">Pilih warna dasar kustom untuk tombol, badge, dan ikon (Default: Emas/Gold #e8a53a)</span>
                                    </div>
                                    @error('warna_primer')
                                        <div class="invalid-feedback d-block mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <label for="alaamat" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('alaamat') is-invalid @enderror" id="alaamat" name="alaamat" rows="3" required placeholder="Jl.P.Siantar Km 2, Tampubolon, Balige...">{{ old('alaamat', $barbershop->alaamat) }}</textarea>
                                @error('alaamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="button" class="btn btn-primary next-tab-btn px-4 py-2 fw-semibold" style="background-color: {{ $barbershop->warna_primer ?? '#e8a53a' }}; border: none;" data-next="#heroes-tab">
                                Lanjut ke Hero Halaman <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Tab 2: Hero Halaman -->
                    <div class="tab-pane fade" id="heroes-pane" role="tabpanel" aria-labelledby="heroes-tab">
                        
                        <!-- 1. Hero Beranda -->
                        <div class="hero-config-card p-3 mb-4">
                            <h6 class="fw-bold mb-3 d-flex align-items-center gap-2 text-dark border-bottom pb-2">
                                <i class="fas fa-home text-muted"></i> Hero Halaman Beranda (Home)
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-7">
                                    <label for="deskripsi_hero" class="form-label">Deskripsi Hero Beranda <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('deskripsi_hero') is-invalid @enderror" id="deskripsi_hero" name="deskripsi_hero" rows="4" required placeholder="Tulis deskripsi selamat datang untuk halaman utama...">{{ old('deskripsi_hero', $barbershop->deskripsi_hero) }}</textarea>
                                    <small class="text-muted d-block mt-1">Deskripsi ini akan ditampilkan pada area spanduk beranda (hero) dan bagian footer.</small>
                                    @error('deskripsi_hero')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label">Gambar Hero Beranda</label>
                                    @if($barbershop->gambar_hero)
                                        <div class="mb-2">
                                            <img src="{{ asset($barbershop->gambar_hero) }}" alt="Current Hero" class="img-thumbnail rounded shadow-sm" style="max-height: 80px; object-fit: cover; width: 100%;">
                                        </div>
                                    @endif
                                    <input type="file" class="form-control form-control-sm @error('gambar_hero') is-invalid @enderror" id="gambar_hero" name="gambar_hero" accept="image/*">
                                    <small class="text-muted">Format: JPG, PNG, GIF, SVG. Maks 2MB.</small>
                                    @error('gambar_hero')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- 2. Hero Layanan -->
                        <div class="hero-config-card p-3 mb-4">
                            <h6 class="fw-bold mb-3 d-flex align-items-center gap-2 text-dark border-bottom pb-2">
                                <i class="fas fa-concierge-bell text-muted"></i> Hero Halaman Daftar Layanan
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-7">
                                    <div class="mb-3">
                                        <label for="judul_hero_layanan" class="form-label">Judul Hero Layanan <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('judul_hero_layanan') is-invalid @enderror" id="judul_hero_layanan" name="judul_hero_layanan" value="{{ old('judul_hero_layanan', $barbershop->judul_hero_layanan) }}" required placeholder="Contoh: Daftar Layanan">
                                        @error('judul_hero_layanan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="deskripsi_hero_layanan" class="form-label">Deskripsi Hero Layanan <span class="text-danger">*</span></label>
                                        <textarea class="form-control @error('deskripsi_hero_layanan') is-invalid @enderror" id="deskripsi_hero_layanan" name="deskripsi_hero_layanan" rows="2" required placeholder="Lihat pilihan layanan yang tersedia...">{{ old('deskripsi_hero_layanan', $barbershop->deskripsi_hero_layanan) }}</textarea>
                                        @error('deskripsi_hero_layanan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label">Gambar Hero Layanan</label>
                                    @if($barbershop->gambar_hero_layanan)
                                        <div class="mb-2">
                                            <img src="{{ asset($barbershop->gambar_hero_layanan) }}" alt="Current Services Hero" class="img-thumbnail rounded shadow-sm" style="max-height: 80px; object-fit: cover; width: 100%;">
                                        </div>
                                    @endif
                                    <input type="file" class="form-control form-control-sm @error('gambar_hero_layanan') is-invalid @enderror" id="gambar_hero_layanan" name="gambar_hero_layanan" accept="image/*">
                                    <small class="text-muted">Format: JPG, PNG, GIF, SVG. Maks 2MB.</small>
                                    @error('gambar_hero_layanan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- 3. Hero Galeri -->
                        <div class="hero-config-card p-3 mb-4">
                            <h6 class="fw-bold mb-3 d-flex align-items-center gap-2 text-dark border-bottom pb-2">
                                <i class="fas fa-images text-muted"></i> Hero Halaman Galeri
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-7">
                                    <div class="mb-3">
                                        <label for="judul_hero_galeri" class="form-label">Judul Hero Galeri <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('judul_hero_galeri') is-invalid @enderror" id="judul_hero_galeri" name="judul_hero_galeri" value="{{ old('judul_hero_galeri', $barbershop->judul_hero_galeri) }}" required placeholder="Contoh: Galeri Kami">
                                        @error('judul_hero_galeri')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="deskripsi_hero_galeri" class="form-label">Deskripsi Hero Galeri <span class="text-danger">*</span></label>
                                        <textarea class="form-control @error('deskripsi_hero_galeri') is-invalid @enderror" id="deskripsi_hero_galeri" name="deskripsi_hero_galeri" rows="2" required placeholder="Lihat suasana barbershop kami...">{{ old('deskripsi_hero_galeri', $barbershop->deskripsi_hero_galeri) }}</textarea>
                                        @error('deskripsi_hero_galeri')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label">Gambar Hero Galeri</label>
                                    @if($barbershop->gambar_hero_galeri)
                                        <div class="mb-2">
                                            <img src="{{ asset($barbershop->gambar_hero_galeri) }}" alt="Current Gallery Hero" class="img-thumbnail rounded shadow-sm" style="max-height: 80px; object-fit: cover; width: 100%;">
                                        </div>
                                    @endif
                                    <input type="file" class="form-control form-control-sm @error('gambar_hero_galeri') is-invalid @enderror" id="gambar_hero_galeri" name="gambar_hero_galeri" accept="image/*">
                                    <small class="text-muted">Format: JPG, PNG, GIF, SVG. Maks 2MB.</small>
                                    @error('gambar_hero_galeri')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>



                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-outline-secondary px-4 py-2 fw-semibold next-tab-btn" data-next="#profile-tab">
                                <i class="fas fa-arrow-left me-2"></i> Sebelumnya
                            </button>
                            <button type="button" class="btn btn-primary px-4 py-2 fw-semibold next-tab-btn" style="background-color: {{ $barbershop->warna_primer ?? '#e8a53a' }}; border: none;" data-next="#contacts-tab">
                                Lanjut ke Kontak & Peta <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Tab 3: Kontak & Peta -->
                    <div class="tab-pane fade" id="contacts-pane" role="tabpanel" aria-labelledby="contacts-tab">
                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label for="whatsapp" class="form-label">Nomor WhatsApp</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-success text-white border-0" style="width: 45px; justify-content: center;"><i class="fab fa-whatsapp"></i></span>
                                    <input type="text" class="form-control @error('whatsapp') is-invalid @enderror" id="whatsapp" name="whatsapp" value="{{ old('whatsapp', $barbershop->kontak['whatsapp'] ?? '') }}" placeholder="Contoh: 0821-6789-3019">
                                </div>
                                @error('whatsapp')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="instagram" class="form-label">Link Instagram (Opsional)</label>
                                <div class="input-group">
                                    <span class="input-group-text text-white border-0" style="background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%); width: 45px; justify-content: center;"><i class="fab fa-instagram"></i></span>
                                    <input type="url" class="form-control @error('instagram') is-invalid @enderror" id="instagram" name="instagram" value="{{ old('instagram', $barbershop->kontak['instagram'] ?? '') }}" placeholder="https://instagram.com/akun">
                                </div>
                                @error('instagram')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="facebook" class="form-label">Link Facebook (Opsional)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-primary text-white border-0" style="width: 45px; justify-content: center;"><i class="fab fa-facebook-f"></i></span>
                                    <input type="url" class="form-control @error('facebook') is-invalid @enderror" id="facebook" name="facebook" value="{{ old('facebook', $barbershop->kontak['facebook'] ?? '') }}" placeholder="https://facebook.com/halaman">
                                </div>
                                @error('facebook')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="link_map" class="form-label">Link Google Maps (Tombol Navigasi)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-danger text-white border-0" style="width: 45px; justify-content: center;"><i class="fas fa-map-marker-alt"></i></span>
                                    <input type="url" class="form-control @error('link_map') is-invalid @enderror" id="link_map" name="link_map" value="{{ old('link_map', $barbershop->kontak['link_map'] ?? '') }}" placeholder="https://maps.app.goo.gl/xyz">
                                </div>
                                <small class="text-muted d-block mt-1">Link ini digunakan pada tombol rute navigasi Google Maps di footer website konsumen.</small>
                                @error('link_map')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="map_embed" class="form-label">URL Embed Peta (Iframe Preview)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-secondary text-white border-0" style="width: 45px; justify-content: center;"><i class="fas fa-code"></i></span>
                                    <textarea class="form-control @error('map_embed') is-invalid @enderror" id="map_embed" name="map_embed" rows="3" placeholder="Contoh: https://www.google.com/maps/embed?pb=...">{{ old('map_embed', $barbershop->kontak['map_embed'] ?? '') }}</textarea>
                                </div>
                                <small class="text-muted d-block mt-1">Cara mendapatkan: Buka Google Maps > Bagikan > Sematkan Peta > Salin URL di dalam parameter <code>src="..."</code> saja.</small>
                                @error('map_embed')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-outline-secondary px-4 py-2 fw-semibold next-tab-btn" data-next="#heroes-tab">
                                <i class="fas fa-arrow-left me-2"></i> Sebelumnya
                            </button>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.barbershop.index') }}" class="btn-cancel px-4 py-2">Batal</a>
                                <button type="submit" class="btn-submit">Simpan Perubahan</button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle Next / Previous tab buttons
        document.querySelectorAll('.next-tab-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const targetTabId = this.dataset.next;
                const nextTabEl = document.querySelector(targetTabId);
                if (nextTabEl) {
                    const tabTrigger = new bootstrap.Tab(nextTabEl);
                    tabTrigger.show();
                    window.scrollTo({ top: 100, behavior: 'smooth' });
                }
            });
        });

        // Handle HTML5 validation across hidden tabs
        document.addEventListener('invalid', function(e) {
            const invalidField = e.target;
            if(!invalidField.closest('form')) return;

            const tabPane = invalidField.closest('.tab-pane');
            if (tabPane && !tabPane.classList.contains('show')) {
                e.preventDefault(); // Prevent browser error "invalid form control is not focusable"
                const targetTabBtn = document.querySelector('button[data-bs-target="#' + tabPane.id + '"]');
                if (targetTabBtn) {
                    const tab = new bootstrap.Tab(targetTabBtn);
                    tab.show();
                    setTimeout(() => {
                        invalidField.focus();
                        invalidField.reportValidity();
                    }, 200);
                }
            }
        }, true);
    });
</script>
@endsection
