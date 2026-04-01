@extends('layouts.admin')

@section('title', 'Tambah Pelanggan Baru')

@section('header_title')
    <div class="header-title">Daftar Pelanggan</div>
    <div style="width:64px;"></div>
@endsection

@section('content')
    <div class="section-label" style="padding-top:24px;">Formulir Pendaftaran</div>

    <form action="{{ route('admin.simpan-pelanggan') }}" method="POST" class="form-section" style="padding:0 16px;">
        @csrf

        <div class="form-group" style="margin-bottom:20px;">
            <label class="form-label"
                style="display:block; margin-bottom:8px; font-size:13px; color:var(--text-muted);">Nama Pelanggan</label>
            <input type="text" name="nama_pelanggan" class="form-input" placeholder="Masukkan nama panggilan..." required
                style="width:100%; padding:14px; background:var(--bg-main); border:1px solid var(--border-light); color:var(--text-main); border-radius:8px;">
        </div>

        <div
            style="background:rgba(229,169,60,0.1); border:1px solid rgba(229,169,60,0.3); padding:16px; border-radius:8px; margin-bottom:24px;">
            <div style="font-size:12px; color:var(--accent); text-align:center;">Nomor antrian akan di-generate otomatis
                oleh sistem berdasarkan urutan hari ini.</div>
        </div>

        <button type="submit" class="btn btn-primary"
            style="width:100%; padding:14px; background:var(--accent); border:none; border-radius:8px; font-weight:bold; cursor:pointer;">+
            MASUKKAN KE ANTRIAN</button>
    </form>
@endsection
