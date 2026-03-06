@extends('layouts.admin')

@section('title', 'Tambah Pelanggan')
@section('header_title', 'Tambah Pelanggan')

@section('content')
    <section class="hero" style="text-align:center; padding:24px 16px;">
        <div class="hero-label">Nomor Antrian Berikutnya</div>
        <div class="hero-number-box" style="display:inline-block; margin:8px auto;">
            <div class="hero-number">09</div>
        </div>
        <div class="hero-subtitle">(Generate otomatis)</div>
    </section>

    <div class="spacer-md"></div>

    <div class="form-section">
        <div class="form-group">
            <label class="form-label">Nama Pelanggan <span style="color:var(--error-text);">*</span></label>
            <input type="text" class="form-input" placeholder="Ketik nama pelanggan..." id="nama">
            <div class="form-error" id="nama-error" style="display:none;">⚠ Nama wajib diisi</div>
        </div>

        <div class="form-group">
            <label class="form-label">Jenis Layanan <span
                    style="font-size:11px; font-weight:400; color:var(--text-muted);">(opsional)</span></label>
            <select class="form-select">
                <option value="">Pilih layanan...</option>
                <option>Potong Rambut</option>
                <option>Creambath</option>
            </select>
        </div>
    </div>
    <div style="height:100px;"></div>

    <div class="action-bar">
        <button class="btn btn-primary" onclick="tambahPelanggan()">✓ TAMBAHKAN KE ANTRIAN</button>
        <button class="btn btn-secondary" onclick="history.back()">Batal</button>
    </div>

    <div class="toast" id="toast-sukses" style="display:none;">✅ Pelanggan berhasil ditambahkan ke antrian!</div>
@endsection

@push('scripts')
    <script>
        function tambahPelanggan() {
            const nama = document.getElementById('nama').value;
            if (!nama.trim()) {
                document.getElementById('nama-error').style.display = 'flex';
                document.getElementById('nama').classList.add('error');
                return;
            }
            document.getElementById('toast-sukses').style.display = 'block';
            setTimeout(() => {
                window.location.href = '{{ url('dashboard') }}';
            }, 1800);
        }
    </script>
@endpush
