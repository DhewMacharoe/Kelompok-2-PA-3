@extends('admin.layouts.app')

@section('title', 'Tambah Layanan')

@section('header_title')
    <div class="header-title">Tambah Layanan</div>
@endsection

@section('content')
@push('styles')
    @include('admin.shared.style-common')
@endpush

<div class="content-header">
    <h2 class="section-title-offset">Tambah Layanan</h2>
</div>

<div class="content-body">
    <div class="card shadow-sm mx-auto form-card-wide">
        <div class="card-body">
            <form action="{{ route('admin.layanan.store') }}" method="POST" enctype="multipart/form-data">
                @include('admin.layanan._form')
            </form>
        </div>
    </div>
</div>
@endsection
