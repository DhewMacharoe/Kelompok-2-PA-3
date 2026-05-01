@extends('admin.layouts.app')

@section('title', 'Tambah Layanan')

@section('header_title')
    <div class="header-title">Tambah Layanan</div>
@endsection

@section('content')
<div class="content-header">
    <h2 style="margin-left: 20px; margin-top: 20px;">Tambah Layanan</h2>
</div>

<div class="content-body">
    <div class="card shadow-sm mx-auto" style="max-width: 720px;">
        <div class="card-body">
            <form action="{{ route('admin.layanan.store') }}" method="POST" enctype="multipart/form-data">
                @include('admin.layanan._form')
            </form>
        </div>
    </div>
</div>
@endsection
