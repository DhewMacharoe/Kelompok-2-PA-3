@csrf

<x-form.field
    label="Nama Layanan"
    name="nama"
    :value="$layanan->nama ?? ''"
    placeholder="Contoh: Haircut Premium"
    help="Gunakan nama layanan yang singkat dan jelas."
/>

<div class="form-field mb-3">
    <label for="harga_mask" class="form-label form-field__label">Harga</label>
    <input type="text" id="harga_mask" class="form-control form-field__control"
           value="{{ old('harga') ? 'Rp.' . number_format(old('harga'), 0, ',', '.') : (isset($layanan->harga) ? 'Rp.' . number_format($layanan->harga, 0, ',', '.') : '') }}"
           placeholder="Rp.0" aria-describedby="harga_help harga_error">

    <input type="hidden" name="harga" id="harga_raw" value="{{ old('harga', $layanan->harga ?? '') }}">

    <div id="harga_help" class="form-field__help form-text">Masukkan angka tanpa pemisah manual, format akan disesuaikan otomatis.</div>

    @error('harga')
        <div id="harga_error" class="form-field__error invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

<x-form.field
    label="Estimasi Waktu"
    name="estimasi_waktu"
    :value="$layanan->estimasi_waktu ?? ''"
    placeholder="Contoh: 30 menit"
    help="Tulis estimasi waktu yang mudah dipahami pelanggan."
/>

<x-form.field
    label="Deskripsi"
    name="deskripsi"
    type="textarea"
    :value="$layanan->deskripsi ?? ''"
    :rows="4"
    placeholder="Jelaskan layanan secara singkat dan informatif."
    help="Pastikan deskripsi ringkas, jelas, dan mudah dibaca di mobile."
/>

<div style="display: none;" class="mb-3">
    <x-form.field
        label="Gambar Layanan"
        name="foto"
        type="file"
        accept="image/*"
        help="Gunakan gambar JPG atau PNG dengan komposisi yang rapi."
    />
</div>

@if (!empty($layanan?->foto))
    <div style="display: none;" class="mb-3">
        <label class="form-label">Preview Gambar Saat Ini</label><br>
        @php
            $previewFoto = \Illuminate\Support\Str::startsWith($layanan->foto, ['http://', 'https://'])
                ? $layanan->foto
                : asset('images/' . $layanan->foto);
        @endphp
        <img src="{{ $previewFoto }}" class="preview-img" style="width: 180px; height: 120px; object-fit: cover; border-radius: 8px;">
    </div>
@endif

<x-form.field
    label="Status"
    name="is_active"
    type="select"
    :options="['1' => 'Aktif', '0' => 'Nonaktif']"
    :value="old('is_active', $layanan->is_active ?? 1)"
    help="Status aktif akan menampilkan layanan di area publik."
    wrapperClass="mb-4"
/>

<style>
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 24px;
        flex-wrap: wrap;
    }

    .btn-submit,
    .btn-batal {
        min-width: 120px;
        padding: 12px 22px;
        border-radius: 10px;
        font-weight: 600;
        text-align: center;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.2s ease, box-shadow 0.2s ease, opacity 0.2s ease;
    }

    .btn-submit {
        background: linear-gradient(135deg, #2F80ED, #1B6AD6);
        color: white;
        border: none;
        box-shadow: 0 10px 18px rgba(47, 128, 237, 0.18);
    }

    .btn-submit:hover {
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 12px 22px rgba(47, 128, 237, 0.22);
    }

    .btn-batal {
        background-color: #EB5757;
        color: white;
        border: none;
        text-decoration: none;
        box-shadow: 0 10px 18px rgba(235, 87, 87, 0.16);
    }

    .btn-batal:hover {
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 12px 22px rgba(235, 87, 87, 0.2);
    }

    @media (max-width: 768px) {
        .form-actions {
            width: 100%;
        }

        .form-actions .btn-submit,
        .form-actions .btn-batal {
            flex: 1 1 140px;
        }
    }
</style>

<div class="form-actions">
    <a href="{{ route('admin.layanan.index') }}" class="btn-batal">Batal</a>
    <button type="submit" class="btn-submit" data-loading-text="Menyimpan...">Simpan</button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const hargaMask = document.getElementById('harga_mask');
        const hargaRaw = document.getElementById('harga_raw');

        hargaMask.addEventListener('input', function(e) {
            let value = this.value.replace(/[^0-9]/g, '');
            
            // Simpan angka murni ke hidden input untuk dikirim ke server
            hargaRaw.value = value;

            // Format tampilan ke user
            if (value) {
                this.value = formatRupiah(value, 'Rp. ');
            } else {
                this.value = '';
            }
        });

        function formatRupiah(angka, prefix) {
            let number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp.' + rupiah : '');
        }
    });
</script>