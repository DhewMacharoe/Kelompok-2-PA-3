@csrf

<div class="form-group">
    <label>Nama Layanan</label>
    <input type="text" name="nama" class="form-control" value="{{ old('nama', $layanan->nama ?? '') }}">
    @error('nama')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <label>Harga</label>
    <input type="text" id="harga_mask" class="form-control" 
           value="{{ old('harga') ? 'Rp.' . number_format(old('harga'), 0, ',', '.') : (isset($layanan->harga) ? 'Rp.' . number_format($layanan->harga, 0, ',', '.') : '') }}"
           placeholder="Rp.0">
    
    <input type="hidden" name="harga" id="harga_raw" value="{{ old('harga', $layanan->harga ?? '') }}">
    
    @error('harga')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <label>Estimasi Waktu</label>
    <input type="text" name="estimasi_waktu" class="form-control"
        value="{{ old('estimasi_waktu', $layanan->estimasi_waktu ?? '') }}">
    @error('estimasi_waktu')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <label>Deskripsi</label>
    <textarea name="deskripsi" rows="4" class="form-control">{{ old('deskripsi', $layanan->deskripsi ?? '') }}</textarea>
    @error('deskripsi')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <label>Gambar Layanan</label>
    <input type="file" name="foto" class="form-control">
    @error('foto')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

@if (!empty($layanan?->foto))
    <div class="form-group">
        <label>Preview Gambar</label><br>
        @php
            $previewFoto = \Illuminate\Support\Str::startsWith($layanan->foto, ['http://', 'https://'])
                ? $layanan->foto
                : asset('images/' . $layanan->foto);
        @endphp
        <img src="{{ $previewFoto }}" class="preview-img" style="max-width: 200px;">
    </div>
@endif

<div class="form-group">
    <label>Status</label>
    <select name="is_active" class="form-control">
        <option value="1" @selected(old('is_active', $layanan->is_active ?? 1) == 1)>Aktif</option>
        <option value="0" @selected(old('is_active', $layanan->is_active ?? 1) == 0)>Nonaktif</option>
    </select>
    @error('is_active')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-actions">
    <a href="{{ route('admin.layanan.index') }}" class="btn-batal">Batal</a>
    <button type="submit" class="btn-submit">Simpan</button>
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