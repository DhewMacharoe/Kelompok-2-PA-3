@extends('admin.layouts.app')

@section('title', 'Tambah barbershop Web')

@section('header_title')
    <div class="header-title">Tambah barbershop Web</div>
@endsection

@push('styles')
<style>
    .form-label { font-weight: 500; color: #333; }
    .form-control { border-radius: 8px; padding: 10px 15px; border: 1px solid #ced4da; }
    .form-control:focus { border-color: {{ $activebarbershop->warna_primer ?? '#e8a53a' }}; box-shadow: 0 0 0 0.2rem {{ $activebarbershop->warna_primer ?? '#e8a53a' }}40; }
    .btn-submit { background-color: {{ $activebarbershop->warna_primer ?? '#e8a53a' }}; color: white; border: none; padding: 10px 24px; border-radius: 8px; font-weight: 600; transition: all 0.3s ease; }
    .btn-submit:hover { background-color: {{ $activebarbershop->warna_primer ?? '#e8a53a' }}e6; color: white; }
    .btn-cancel { background-color: #6c757d; color: white; border: none; padding: 10px 24px; border-radius: 8px; font-weight: 600; text-decoration: none; display: inline-block; transition: all 0.3s ease; }
    .btn-cancel:hover { background-color: #5a6268; color: white; }
</style>
@endpush

@section('content')
<div class="content-header">
    <h2 style="margin-left: 20px; margin-top: 20px;">Tambah barbershop Web</h2>
</div>

<div class="content-body pb-5">
    <div class="card shadow-sm mx-auto" style="max-width: 800px; border-radius: 12px; border: none;">
        <div class="card-body p-4">
            <form action="{{ route('admin.barbershop.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="nama_brand" class="form-label">Nama Brand / Judul Web <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('nama_brand') is-invalid @enderror" id="nama_brand" name="nama_brand" value="{{ old('nama_brand') }}" required placeholder="Contoh: Arga Home's">
                    @error('nama_brand')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="favicon" class="form-label">Favicon / Logo (Opsional)</label>
                    <input type="file" class="form-control @error('favicon') is-invalid @enderror" id="favicon" name="favicon" accept="image/*">
                    <small class="text-muted">Format yang didukung: JPG, PNG, GIF, SVG, ICO. Maks 2MB.</small>
                    @error('favicon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="alaamat" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('alaamat') is-invalid @enderror" id="alaamat" name="alaamat" rows="3" required placeholder="Contoh: Jl.P.Siantar Km 2...">{{ old('alaamat') }}</textarea>
                    @error('alaamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required placeholder="Contoh: info@argahomes.com">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="slogan" class="form-label">Slogan / Tagline Brand <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('slogan') is-invalid @enderror" id="slogan" name="slogan" value="{{ old('slogan', 'Barber, Coffee & Food') }}" required placeholder="Contoh: Barber, Coffee & Food">
                    @error('slogan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <h5 class="mt-5 mb-3" style="color: {{ $barbershop->warna_primer ?? '#e8a53a' }}; font-weight: bold; border-bottom: 2px solid #f0f0f0; padding-bottom: 10px;">Hero Halaman Beranda (Home)</h5>
                <div class="mb-4">
                    <label for="deskripsi_hero" class="form-label">Deskripsi Hero Beranda <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('deskripsi_hero') is-invalid @enderror" id="deskripsi_hero" name="deskripsi_hero" rows="3" required placeholder="Contoh: Tempat pangkas rambut premium dengan layanan walk-in queue...">{{ old('deskripsi_hero', 'Tempat pangkas rambut premium dengan layanan walk-in queue. Dapatkan pengalaman grooming terbaik!') }}</textarea>
                    <small class="text-muted">Deskripsi ini akan ditampilkan pada area selamat datang (hero) di halaman utama dan di bagian footer.</small>
                    @error('deskripsi_hero')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="gambar_hero" class="form-label">Gambar Hero Beranda (Opsional)</label>
                    <input type="file" class="form-control @error('gambar_hero') is-invalid @enderror" id="gambar_hero" name="gambar_hero" accept="image/*">
                    <small class="text-muted">Format yang didukung: JPG, PNG, GIF, SVG. Maks 2MB.</small>
                    @error('gambar_hero')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <h5 class="mt-5 mb-3" style="color: {{ $barbershop->warna_primer ?? '#e8a53a' }}; font-weight: bold; border-bottom: 2px solid #f0f0f0; padding-bottom: 10px;">Hero Halaman Daftar Layanan</h5>
                <div class="mb-4">
                    <label for="judul_hero_layanan" class="form-label">Judul Hero Layanan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('judul_hero_layanan') is-invalid @enderror" id="judul_hero_layanan" name="judul_hero_layanan" value="{{ old('judul_hero_layanan', 'Daftar Layanan') }}" required placeholder="Contoh: Daftar Layanan">
                    @error('judul_hero_layanan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="deskripsi_hero_layanan" class="form-label">Deskripsi Hero Layanan <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('deskripsi_hero_layanan') is-invalid @enderror" id="deskripsi_hero_layanan" name="deskripsi_hero_layanan" rows="3" required placeholder="Contoh: Lihat pilihan layanan yang tersedia beserta harga dan estimasi waktunya...">{{ old('deskripsi_hero_layanan', 'Lihat pilihan layanan yang tersedia beserta harga dan estimasi waktunya.') }}</textarea>
                    @error('deskripsi_hero_layanan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="gambar_hero_layanan" class="form-label">Gambar Hero Layanan (Opsional)</label>
                    <input type="file" class="form-control @error('gambar_hero_layanan') is-invalid @enderror" id="gambar_hero_layanan" name="gambar_hero_layanan" accept="image/*">
                    <small class="text-muted">Format yang didukung: JPG, PNG, GIF, SVG. Maks 2MB.</small>
                    @error('gambar_hero_layanan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <h5 class="mt-5 mb-3" style="color: {{ $barbershop->warna_primer ?? '#e8a53a' }}; font-weight: bold; border-bottom: 2px solid #f0f0f0; padding-bottom: 10px;">Hero Halaman Galeri</h5>
                <div class="mb-4">
                    <label for="judul_hero_galeri" class="form-label">Judul Hero Galeri <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('judul_hero_galeri') is-invalid @enderror" id="judul_hero_galeri" name="judul_hero_galeri" value="{{ old('judul_hero_galeri', 'Galeri Kami') }}" required placeholder="Contoh: Galeri Kami">
                    @error('judul_hero_galeri')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="deskripsi_hero_galeri" class="form-label">Deskripsi Hero Galeri <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('deskripsi_hero_galeri') is-invalid @enderror" id="deskripsi_hero_galeri" name="deskripsi_hero_galeri" rows="3" required placeholder="Contoh: Lihat suasana barbershop, hasil potongan rambut, dan area coffee sebelum datang ke tempat...">{{ old('deskripsi_hero_galeri', 'Lihat suasana barbershop, hasil potongan rambut, dan area coffee sebelum datang ke tempat.') }}</textarea>
                    @error('deskripsi_hero_galeri')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="gambar_hero_galeri" class="form-label">Gambar Hero Galeri (Opsional)</label>
                    <input type="file" class="form-control @error('gambar_hero_galeri') is-invalid @enderror" id="gambar_hero_galeri" name="gambar_hero_galeri" accept="image/*">
                    <small class="text-muted">Format yang didukung: JPG, PNG, GIF, SVG. Maks 2MB.</small>
                    @error('gambar_hero_galeri')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <h5 class="mt-5 mb-3" style="color: {{ $barbershop->warna_primer ?? '#e8a53a' }}; font-weight: bold; border-bottom: 2px solid #f0f0f0; padding-bottom: 10px;">Hero Halaman Menu Café</h5>
                <div class="mb-4">
                    <label for="judul_hero_menu" class="form-label">Judul Hero Menu <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('judul_hero_menu') is-invalid @enderror" id="judul_hero_menu" name="judul_hero_menu" value="{{ old('judul_hero_menu', 'Menu Café') }}" required placeholder="Contoh: Menu Café">
                    @error('judul_hero_menu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="deskripsi_hero_menu" class="form-label">Deskripsi Hero Menu <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('deskripsi_hero_menu') is-invalid @enderror" id="deskripsi_hero_menu" name="deskripsi_hero_menu" rows="3" required placeholder="Contoh: Nikmati berbagai pilihan makanan dan minuman kopi yang tersedia di barbershop kami...">{{ old('deskripsi_hero_menu', 'Nikmati berbagai pilihan makanan dan minuman kopi yang tersedia di barbershop kami.') }}</textarea>
                    @error('deskripsi_hero_menu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="gambar_hero_menu" class="form-label">Gambar Hero Menu (Opsional)</label>
                    <input type="file" class="form-control @error('gambar_hero_menu') is-invalid @enderror" id="gambar_hero_menu" name="gambar_hero_menu" accept="image/*">
                    <small class="text-muted">Format yang didukung: JPG, PNG, GIF, SVG. Maks 2MB.</small>
                    @error('gambar_hero_menu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <h5 class="mt-5 mb-3" style="color: {{ $barbershop->warna_primer ?? '#e8a53a' }}; font-weight: bold; border-bottom: 2px solid #f0f0f0; padding-bottom: 10px;">Pengaturan Lainnya</h5>

                <div class="mb-4">
                    <label for="warna_primer" class="form-label">Warna Dasar / Aksen Web</label>
                    <div class="d-flex align-items-center gap-3">
                        <input type="color" class="form-control form-control-color" id="warna_primer" name="warna_primer" value="{{ old('warna_primer', '#e8a53a') }}" title="Pilih warna dasar" style="width: 60px; height: 45px; padding: 4px;">
                        <span class="text-muted">Pilih warna dasar kustom untuk aksen tombol, badge, dan ikon pada website (Default: Emas/Gold #e8a53a)</span>
                    </div>
                    @error('warna_primer')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <h5 class="mt-5 mb-3" style="color: {{ $barbershop->warna_primer ?? '#e8a53a' }}; font-weight: bold; border-bottom: 2px solid #f0f0f0; padding-bottom: 10px;">Kontak & Sosial Media</h5>

                <div class="mb-4">
                    <label for="whatsapp" class="form-label">WhatsApp (Nomor Telepon)</label>
                    <input type="text" class="form-control @error('whatsapp') is-invalid @enderror" id="whatsapp" name="whatsapp" value="{{ old('whatsapp') }}" placeholder="Contoh: 0821-6789-3019">
                    @error('whatsapp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="instagram" class="form-label">Link Instagram (Opsional)</label>
                    <input type="url" class="form-control @error('instagram') is-invalid @enderror" id="instagram" name="instagram" value="{{ old('instagram') }}" placeholder="Contoh: https://instagram.com/argahomes">
                    @error('instagram')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="facebook" class="form-label">Link Facebook (Opsional)</label>
                    <input type="url" class="form-control @error('facebook') is-invalid @enderror" id="facebook" name="facebook" value="{{ old('facebook') }}" placeholder="Contoh: https://facebook.com/argahomes">
                    @error('facebook')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="link_map" class="form-label">Link Google Maps (Tombol)</label>
                    <input type="url" class="form-control @error('link_map') is-invalid @enderror" id="link_map" name="link_map" value="{{ old('link_map') }}" placeholder="Contoh: https://maps.app.goo.gl/xyz">
                    <small class="text-muted">Link ini digunakan pada tombol "Lihat di Maps" pada bagian footer.</small>
                    @error('link_map')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="map_embed" class="form-label">URL Embed Peta (Iframe)</label>
                    <textarea class="form-control @error('map_embed') is-invalid @enderror" id="map_embed" name="map_embed" rows="3" placeholder='Contoh: https://www.google.com/maps/embed?...'>{{ old('map_embed') }}</textarea>
                    <small class="text-muted">Cara mendapatkan: Buka Google Maps > Bagikan > Sematkan Peta > Salin URL pada bagian <code>src="..."</code>.</small>
                    @error('map_embed')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2 mt-5">
                    <a href="{{ route('admin.barbershop.index') }}" class="btn-cancel">Batal</a>
                    <button type="submit" class="btn-submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
