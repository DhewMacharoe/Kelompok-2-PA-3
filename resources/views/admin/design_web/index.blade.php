@extends('admin.layouts.app')

@section('title', 'Design Web')

@section('header_title')
    <div class="header-title">Design Web</div>
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
        background: linear-gradient(135deg, #1a1a1a 0%, {{ $design->warna_primer ?? '#2c3e50' }} 100%);
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
        background-color: {{ $design->warna_primer ?? '#e8a53a' }};
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
        background-color: {{ $design->warna_primer ?? '#e8a53a' }}e6;
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
        background-color: {{ $design->warna_primer ?? '#e8a53a' }};
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
                    @if($design->favicon)
                        <img src="{{ asset($design->favicon) }}" alt="Favicon">
                    @else
                        <img src="{{ asset('assets/images/logo.png') }}" alt="Default Logo">
                    @endif
                </div>
                <div>
                    <h3 class="mb-1 style-brand-name text-white" style="font-weight: 700; margin: 0;">{{ $design->nama_brand }}</h3>
                    <p class="mb-0 text-muted-white" style="font-size: 0.9rem;">Profil Brand & Desain Web</p>
                </div>
            </div>
            <div>
                <a href="{{ route('admin.design.edit', $design->id) }}" class="btn-edit-profile shadow-sm">
                    <i class="fas fa-edit"></i> Edit Profil
                </a>
            </div>
        </div>

        <div class="p-4">
            <div class="row g-4">
                <div class="col-md-6 mb-4 mb-md-0">
                    <div class="info-label mb-1">Nama Brand / Judul Web</div>
                    <div class="info-value mb-4"><strong>{{ $design->nama_brand }}</strong></div>

                    <div class="info-label mb-1">Slogan / Tagline Brand</div>
                    <div class="info-value mb-4"><em>{{ $design->slogan ?? 'Barber, Coffee & Food' }}</em></div>

                    <div class="info-label mb-1">Email Kontak</div>
                    <div class="info-value mb-4">{{ $design->email }}</div>

                    <div class="info-label mb-1">Warna Dasar / Aksen Web</div>
                    <div class="info-value mb-4 d-flex align-items-center gap-2">
                        <span style="display: inline-block; width: 20px; height: 20px; border-radius: 4px; background-color: {{ $design->warna_primer ?? '#e8a53a' }}; border: 1px solid #ddd;"></span>
                        <code>{{ $design->warna_primer ?? '#e8a53a' }}</code>
                    </div>

                    <div class="info-label mb-1">Alamat Lengkap</div>
                    <div class="info-value" style="line-height: 1.5;">{{ $design->alaamat }}</div>
                </div>

                <div class="col-md-6 ps-md-4" style="border-left: 1px solid #f0f0f0;">
                    <h5 class="mb-4" style="color: {{ $design->warna_primer ?? '#e8a53a' }}; font-weight: 600; border-bottom: 2px solid #f8f9fa; padding-bottom: 8px;">Kontak & Sosial Media</h5>
                    
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <span class="social-icon-badge"><i class="fab fa-whatsapp" style="color: #25D366; font-size: 1.25rem;"></i></span>
                        <div>
                            <div class="text-muted" style="font-size: 0.8rem;">WhatsApp</div>
                            <div class="info-value"><strong>{{ $design->kontak['whatsapp'] ?? '-' }}</strong></div>
                        </div>
                    </div>
 
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <span class="social-icon-badge"><i class="fab fa-instagram" style="color: #E1306C; font-size: 1.25rem;"></i></span>
                        <div>
                            <div class="text-muted" style="font-size: 0.8rem;">Instagram</div>
                            @if(isset($design->kontak['instagram']) && !empty($design->kontak['instagram']))
                                <div class="info-value"><a href="{{ $design->kontak['instagram'] }}" target="_blank" style="color: {{ $design->warna_primer ?? '#e8a53a' }}; text-decoration: none; font-weight: 500;">Link Instagram</a></div>
                            @else
                                <div class="info-value">-</div>
                            @endif
                        </div>
                    </div>
 
                    <div class="d-flex align-items-center gap-3">
                        <span class="social-icon-badge"><i class="fab fa-facebook" style="color: #1877F2; font-size: 1.25rem;"></i></span>
                        <div>
                            <div class="text-muted" style="font-size: 0.8rem;">Facebook</div>
                            @if(isset($design->kontak['facebook']) && !empty($design->kontak['facebook']))
                                <div class="info-value"><a href="{{ $design->kontak['facebook'] }}" target="_blank" style="color: {{ $design->warna_primer ?? '#e8a53a' }}; text-decoration: none; font-weight: 500;">Link Facebook</a></div>
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
