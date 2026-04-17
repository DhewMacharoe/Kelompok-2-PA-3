@csrf

<div class="form-group">
    <label>Nama Layanan</label>
    <input type="text" name="nama" value="{{ old('nama', $layanan->nama ?? '') }}">
    @error('nama')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <label>Kategori</label>
        <select name="kategori">
            <option value="barber" @selected(old('kategori', $layanan->kategori ?? '') == 'barber')>Barber</option>
            <option value="kafe" @selected(old('kategori', $layanan->kategori ?? '') == 'kafe')>Kafe</option>
        </select>
    @error('kategori')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <label>Harga</label>
    <input type="number" name="harga" value="{{ old('harga', $layanan->harga ?? '') }}">
    @error('harga')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <label>Estimasi Waktu</label>
    <input type="text" name="estimasi_waktu" value="{{ old('estimasi_waktu', $layanan->estimasi_waktu ?? '') }}">
    @error('estimasi_waktu')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <label>Deskripsi</label>
    <textarea name="deskripsi" rows="4">{{ old('deskripsi', $layanan->deskripsi ?? '') }}</textarea>
    @error('deskripsi')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <label>Gambar Layanan</label>
    <input type="file" name="foto">
    @error('foto')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

@if(!empty($layanan?->foto))
    <div class="form-group">
        <label>Preview Gambar</label><br>
        <img src="{{ asset('storage/' . $layanan->foto) }}" class="preview-img">
    </div>
@endif

<div class="form-group">
    <label>Status</label>
    <select name="is_active">
        <option value="1" @selected(old('is_active', $layanan->is_active ?? 1) == 1)>Aktif</option>
        <option value="0" @selected(old('is_active', $layanan->is_active ?? 1) == 0)>Nonaktif</option>
    </select>
    @error('is_active')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>

<div class="form-actions">
    <a href="{{ route('admin.layanan.index') }}" class="btn btn-secondary">Batal</a>
    <button type="submit" class="btn btn-primary">Simpan</button>
</div>