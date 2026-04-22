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
    <input type="number" name="harga" class="form-control" value="{{ old('harga', $layanan->harga ?? '') }}">
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
        <img src="{{ asset('storage/' . $layanan->foto) }}" class="preview-img">
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
