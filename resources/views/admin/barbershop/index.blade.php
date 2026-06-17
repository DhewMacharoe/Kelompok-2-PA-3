@extends('admin.layouts.app')

@section('title', 'barbershop Web')

@section('header_title')
    <div class="header-title">barbershop Web</div>
@endsection

@push('styles')
<style>
    .profile-card {
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        border: none;
        overflow: hidden;
        background-color: #ffffff;
    }
    .profile-header {
        background: linear-gradient(135deg, #1a1a1a 0%, {{ $barbershop->warna_primer ?? '#2c3e50' }} 100%);
        padding: 30px;
        color: #fff;
        position: relative;
    }
    .brand-logo-container {
        width: 90px;
        height: 90px;
        background: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        border: 3px solid #fff;
        overflow: hidden;
    }
    .brand-logo-container img {
        max-width: 80%;
        max-height: 80%;
        object-fit: contain;
    }
    .info-label {
        font-weight: 600;
        color: #495057;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .info-value {
        color: #2b2b2b;
        font-size: 1.05rem;
    }
    .btn-edit-profile {
        background-color: {{ $barbershop->warna_primer ?? '#e8a53a' }};
        color: white;
        border: none;
        padding: 10px 24px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }
    .btn-edit-profile:hover {
        background-color: {{ $barbershop->warna_primer ?? '#e8a53a' }}e6;
        color: white;
        transform: translateY(-2px);
    }
    .social-icon-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background-color: #f8f9fa;
        color: #495057;
        font-size: 1.1rem;
        transition: all 0.3s ease;
    }
    .social-icon-badge:hover {
        background-color: {{ $barbershop->warna_primer ?? '#e8a53a' }};
        color: white;
    }
    .text-muted-white {
        color: rgba(255, 255, 255, 0.7);
    }
</style>
@endpush

@section('content')
<div class="main-container pb-5">
    @if (session('success'))
        <div id="flash-success" data-message="{{ session('success') }}" hidden></div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const flashSuccess = document.getElementById('flash-success');
                if (flashSuccess && flashSuccess.dataset.message) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: flashSuccess.dataset.message,
                        confirmButtonText: 'OK'
                    });
                }
            });
        </script>
    @endif

    <div class="profile-card mx-auto mt-4" style="max-width: 800px;">
        <div class="profile-header d-flex align-items-center justify-content-between flex-wrap gap-4">
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <div class="brand-logo-container">
                    @if($barbershop->favicon)
                        <img src="{{ asset($barbershop->favicon) }}" alt="Favicon">
                    @else
                        <img src="{{ asset('assets/images/logo.png') }}" alt="Default Logo">
                    @endif
                </div>
                <div>
                    <h3 class="mb-1 style-brand-name text-white" style="font-weight: 700; margin: 0;">{{ $barbershop->nama_brand }}</h3>
                    <p class="mb-0 text-muted-white" style="font-size: 0.9rem;">Profil Brand & Desain Web</p>
                </div>
            </div>
            <div>
                <a href="{{ route('admin.barbershop.edit', $barbershop->id) }}" class="btn-edit-profile shadow-sm">
                    <i class="fas fa-edit"></i> Edit Profil
                </a>
            </div>
        </div>

        <div class="p-4">
            <div class="row g-4">
                <div class="col-md-6 mb-4 mb-md-0">
                    <div class="info-label mb-1">Nama Brand / Judul Web</div>
                    <div class="info-value mb-4"><strong>{{ $barbershop->nama_brand }}</strong></div>

                    <div class="info-label mb-1">Slogan / Tagline Brand</div>
                    <div class="info-value mb-4"><em>{{ $design->slogan ?? 'Barber, Coffee & Food' }}</em></div>

                    <h6 class="mt-4 mb-3 fw-bold text-secondary" style="border-bottom: 1px solid #f0f0f0; padding-bottom: 5px;">Hero Beranda (Home)</h6>
                    <div class="info-label mb-1">Deskripsi Hero</div>
                    <div class="info-value mb-3" style="font-size: 0.95rem;">{{ $design->deskripsi_hero ?? 'Tempat pangkas rambut premium dengan layanan walk-in queue. Dapatkan pengalaman grooming terbaik!' }}</div>

                    <div class="info-label mb-1">Gambar Hero</div>
                    <div class="info-value mb-4">
                        @if($design->gambar_hero)
                            <img src="{{ asset($design->gambar_hero) }}" alt="Hero Background" class="img-thumbnail" style="max-height: 80px; width: 100%; max-width: 180px; object-fit: cover; border-radius: 6px;">
                        @else
                            <span class="text-muted small">Menggunakan gambar default (Unsplash)</span>
                        @endif
                    </div>

                    <h6 class="mt-4 mb-3 fw-bold text-secondary" style="border-bottom: 1px solid #f0f0f0; padding-bottom: 5px;">Hero Layanan (Services)</h6>
                    <div class="info-label mb-1">Judul & Deskripsi</div>
                    <div class="info-value mb-3" style="font-size: 0.95rem;">
                        <strong>{{ $design->judul_hero_layanan }}</strong><br>
                        {{ $design->deskripsi_hero_layanan }}
                    </div>

                    <div class="info-label mb-1">Gambar Hero Layanan</div>
                    <div class="info-value mb-4">
                        @if($design->gambar_hero_layanan)
                            <img src="{{ asset($design->gambar_hero_layanan) }}" alt="Layanan Hero Background" class="img-thumbnail" style="max-height: 80px; width: 100%; max-width: 180px; object-fit: cover; border-radius: 6px;">
                        @else
                            <span class="text-muted small">Menggunakan gambar default (Unsplash)</span>
                        @endif
                    </div>

                    <h6 class="mt-4 mb-3 fw-bold text-secondary" style="border-bottom: 1px solid #f0f0f0; padding-bottom: 5px;">Hero Galeri (Gallery)</h6>
                    <div class="info-label mb-1">Judul & Deskripsi</div>
                    <div class="info-value mb-3" style="font-size: 0.95rem;">
                        <strong>{{ $design->judul_hero_galeri }}</strong><br>
                        {{ $design->deskripsi_hero_galeri }}
                    </div>

                    <div class="info-label mb-1">Gambar Hero Galeri</div>
                    <div class="info-value mb-4">
                        @if($design->gambar_hero_galeri)
                            <img src="{{ asset($design->gambar_hero_galeri) }}" alt="Galeri Hero Background" class="img-thumbnail" style="max-height: 80px; width: 100%; max-width: 180px; object-fit: cover; border-radius: 6px;">
                        @else
                            <span class="text-muted small">Menggunakan gambar default (Assets)</span>
                        @endif
                    </div>

                    <h6 class="mt-4 mb-3 fw-bold text-secondary" style="border-bottom: 1px solid #f0f0f0; padding-bottom: 5px;">Hero Menu Café</h6>
                    <div class="info-label mb-1">Judul & Deskripsi</div>
                    <div class="info-value mb-3" style="font-size: 0.95rem;">
                        <strong>{{ $design->judul_hero_menu }}</strong><br>
                        {{ $design->deskripsi_hero_menu }}
                    </div>

                    <div class="info-label mb-1">Gambar Hero Menu</div>
                    <div class="info-value mb-4">
                        @if($design->gambar_hero_menu)
                            <img src="{{ asset($design->gambar_hero_menu) }}" alt="Menu Hero Background" class="img-thumbnail" style="max-height: 80px; width: 100%; max-width: 180px; object-fit: cover; border-radius: 6px;">
                        @else
                            <span class="text-muted small">Menggunakan gambar default (Unsplash)</span>
                        @endif
                    </div>

                    <div class="info-label mb-1">Email Kontak</div>
                    <div class="info-value mb-4">{{ $barbershop->email }}</div>

                    <div class="info-label mb-1">Warna Dasar / Aksen Web</div>
                    <div class="info-value mb-4 d-flex align-items-center gap-2">
                        <span style="display: inline-block; width: 20px; height: 20px; border-radius: 4px; background-color: {{ $barbershop->warna_primer ?? '#e8a53a' }}; border: 1px solid #ddd;"></span>
                        <code>{{ $barbershop->warna_primer ?? '#e8a53a' }}</code>
                    </div>

                    <div class="info-label mb-1">Alamat Lengkap</div>
                    <div class="info-value" style="line-height: 1.5;">{{ $barbershop->alaamat }}</div>
                </div>

                <div class="col-md-6 ps-md-4" style="border-left: 1px solid #f0f0f0;">
                    <h5 class="mb-4" style="color: {{ $barbershop->warna_primer ?? '#e8a53a' }}; font-weight: 600; border-bottom: 2px solid #f8f9fa; padding-bottom: 8px;">Kontak & Sosial Media</h5>
                    
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <span class="social-icon-badge"><i class="fab fa-whatsapp" style="color: #25D366; font-size: 1.25rem;"></i></span>
                        <div>
                            <div class="text-muted" style="font-size: 0.8rem;">WhatsApp</div>
                            <div class="info-value"><strong>{{ $barbershop->kontak['whatsapp'] ?? '-' }}</strong></div>
                        </div>
                    </div>
 
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <span class="social-icon-badge"><i class="fab fa-instagram" style="color: #E1306C; font-size: 1.25rem;"></i></span>
                        <div>
                            <div class="text-muted" style="font-size: 0.8rem;">Instagram</div>
                            @if(isset($barbershop->kontak['instagram']) && !empty($barbershop->kontak['instagram']))
                                <div class="info-value"><a href="{{ $barbershop->kontak['instagram'] }}" target="_blank" style="color: {{ $barbershop->warna_primer ?? '#e8a53a' }}; text-decoration: none; font-weight: 500;">Link Instagram</a></div>
                            @else
                                <div class="info-value">-</div>
                            @endif
                        </div>
                    </div>
 
                    <div class="d-flex align-items-center gap-3">
                        <span class="social-icon-badge"><i class="fab fa-facebook" style="color: #1877F2; font-size: 1.25rem;"></i></span>
                        <div>
                            <div class="text-muted" style="font-size: 0.8rem;">Facebook</div>
                            @if(isset($barbershop->kontak['facebook']) && !empty($barbershop->kontak['facebook']))
                                <div class="info-value"><a href="{{ $barbershop->kontak['facebook'] }}" target="_blank" style="color: {{ $barbershop->warna_primer ?? '#e8a53a' }}; text-decoration: none; font-weight: 500;">Link Facebook</a></div>
                            @else
                                <div class="info-value">-</div>
                            @endif
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-3 mt-4">
                        <span class="social-icon-badge"><i class="fas fa-map-marked-alt" style="color: #4285F4; font-size: 1.25rem;"></i></span>
                        <div>
                            <div class="text-muted" style="font-size: 0.8rem;">Google Maps Link (Default Reset)</div>
                            @if(isset($design->kontak['link_map']) && !empty($design->kontak['link_map']))
                                <div class="info-value"><a href="{{ $design->kontak['link_map'] }}" target="_blank" style="color: {{ $design->warna_primer ?? '#e8a53a' }}; text-decoration: none; font-weight: 500; word-break: break-all;">Tautan Peta</a></div>
                            @else
                                <div class="info-value">-</div>
                            @endif
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-3 mt-4">
                        <span class="social-icon-badge"><i class="fas fa-code" style="color: #34A853; font-size: 1.25rem;"></i></span>
                        <div>
                            <div class="text-muted" style="font-size: 0.8rem;">URL Embed Peta</div>
                            @if(isset($design->kontak['map_embed']) && !empty($design->kontak['map_embed']))
                                <div class="info-value text-muted small" style="word-break: break-all;">{{ $design->kontak['map_embed'] }}</div>
                            @else
                                <div class="info-value">-</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div style="height:50px;"></div>
@endsection
