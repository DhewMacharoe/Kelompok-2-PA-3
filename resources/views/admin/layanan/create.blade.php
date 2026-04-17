@extends('layouts.admin')

@section('title', 'Tambah Layanan')
@section('header_title', 'Layanan')

@section('content')
<div class="section-card">
    <div class="section-header">
        <h2>Tambah Layanan</h2>
    </div>

    <div class="form-card">
        <form action="{{ route('admin.layanan.store') }}" method="POST" enctype="multipart/form-data">
            @include('admin.layanan._form')
        </form>
    </div>
</div>
@endsection