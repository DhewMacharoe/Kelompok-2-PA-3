@extends('layouts.super_admin')

@section('title', 'Tambah Tenant Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="m-0 fw-bold text-dark"><i class="bi bi-plus-circle-fill me-2 text-warning"></i>Tambah Tenant</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('super-admin.barbershops.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="nama" class="form-label fw-bold">Nama Tenant <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" required placeholder="Contoh: Arga Barbershop atau Salon Cantik">
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label fw-bold">Slug URL (Opsional)</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug" value="{{ old('slug') }}" placeholder="Contoh: arga-balige (akan otomatis dibuat jika kosong)">
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kategori" class="form-label fw-bold">Kategori Tenant <span class="text-danger">*</span></label>
                            <select class="form-select @error('kategori') is-invalid @enderror" id="kategori" name="kategori" required onchange="updateColorOptions()">
                                <option value="barbershop" {{ old('kategori') == 'barbershop' ? 'selected' : '' }}>Barbershop (Maskulin)</option>
                                <option value="salon" {{ old('kategori') == 'salon' ? 'selected' : '' }}>Salon (Feminim)</option>
                            </select>
                            @error('kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Pilihan Warna Aksen Web <span class="text-danger">*</span></label>
                            <div id="color-options-container" class="d-flex flex-wrap gap-2 p-2 border rounded-3 bg-light" style="min-height: 40px; align-items: center;">
                                <!-- Will be populated dynamically by JS -->
                            </div>
                            <input type="hidden" name="warna_primer" id="warna_primer" value="{{ old('warna_primer', '#E8A53A') }}">
                            @error('warna_primer')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="telepon" class="form-label fw-bold">No. Telepon / WhatsApp</label>
                            <input type="text" class="form-control @error('telepon') is-invalid @enderror" id="telepon" name="telepon" value="{{ old('telepon') }}" placeholder="Contoh: 0821xxxxxxxx">
                            @error('telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold d-block">Status Keaktifan</label>
                            <div class="form-check form-switch pt-2">
                                <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" checked>
                                <label class="form-check-label fw-bold text-muted" for="is_active">Aktif (Dapat diakses pelanggan)</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="latitude" class="form-label fw-bold">Latitude Lokasi</label>
                            <input type="number" step="any" class="form-control @error('latitude') is-invalid @enderror" id="latitude" name="latitude" value="{{ old('latitude') }}" placeholder="Contoh: 2.386130">
                            @error('latitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="longitude" class="form-label fw-bold">Longitude Lokasi</label>
                            <input type="number" step="any" class="form-control @error('longitude') is-invalid @enderror" id="longitude" name="longitude" value="{{ old('longitude') }}" placeholder="Contoh: 99.147852">
                            @error('longitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label fw-bold">Alamat Lengkap</label>
                        <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat lengkap tenant...">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="deskripsi" class="form-label fw-bold">Deskripsi Singkat</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3" placeholder="Deskripsikan layanan unggulan tenant...">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('super-admin.barbershops.index') }}" class="btn btn-outline-secondary px-4 py-2" aria-label="Batal Tambah Tenant">Batal</a>
                        <button type="submit" class="btn btn-gold px-4 py-2" aria-label="Simpan Tenant Baru">Simpan Tenant</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const colors = {
        barbershop: [
            { name: 'Emas (Gold)', hex: '#E8A53A' },
            { name: 'Biru (Vibrant Blue)', hex: '#0578FB' },
            { name: 'Hijau (Teal Mint)', hex: '#10B981' }
        ],
        salon: [
            { name: 'Merah Muda (Rose Pink)', hex: '#EC4899' },
            { name: 'Ungu (Violet Purple)', hex: '#A78BFA' },
            { name: 'Oranye (Coral Peach)', hex: '#F97316' },
            { name: 'Magenta (Orchid)', hex: '#E040FB' }
        ]
    };

    function updateColorOptions() {
        const kategori = document.getElementById('kategori').value;
        const container = document.getElementById('color-options-container');
        const inputWarna = document.getElementById('warna_primer');
        
        container.innerHTML = '';
        
        const options = colors[kategori] || [];
        
        let selectedHex = inputWarna.value.toUpperCase();
        const matchesOption = options.some(opt => opt.hex.toUpperCase() === selectedHex);
        if (!matchesOption && options.length > 0) {
            selectedHex = options[0].hex;
            inputWarna.value = selectedHex;
        }
        
        options.forEach(opt => {
            const isSelected = opt.hex.toUpperCase() === selectedHex.toUpperCase();
            const swatch = document.createElement('div');
            swatch.className = `d-flex align-items-center gap-1 px-2 py-1 border rounded-2 color-swatch-item ${isSelected ? 'border-primary bg-white shadow-sm' : 'border-secondary-subtle bg-white'}`;
            swatch.style.cursor = 'pointer';
            swatch.style.transition = 'all 0.15s';
            swatch.style.borderWidth = isSelected ? '2px' : '1px';
            swatch.onclick = () => selectColor(opt.hex, swatch);
            
            swatch.innerHTML = `
                <span style="display:inline-block; width: 14px; height: 14px; border-radius: 50%; background-color: ${opt.hex}; border: 1px solid rgba(0,0,0,0.15);"></span>
                <span class="fw-semibold text-dark" style="font-size: 0.75rem;">${opt.name}</span>
            `;
            
            container.appendChild(swatch);
        });
    }

    function selectColor(hex, element) {
        document.getElementById('warna_primer').value = hex;
        document.querySelectorAll('.color-swatch-item').forEach(el => {
            el.classList.remove('border-primary', 'shadow-sm');
            el.classList.add('border-secondary-subtle');
            el.style.borderWidth = '1px';
        });
        element.classList.remove('border-secondary-subtle');
        element.classList.add('border-primary', 'shadow-sm');
        element.style.borderWidth = '2px';
    }

    document.addEventListener('DOMContentLoaded', () => {
        updateColorOptions();
    });
</script>
@endpush
