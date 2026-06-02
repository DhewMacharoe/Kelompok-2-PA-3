@extends('admin.layouts.app')

@section('title', 'Edit Layanan')

@section('header_title')
    <div class="header-title">Edit Layanan</div>
@endsection

@section('content')
@push('styles')
    @include('admin.shared.style-common')
@endpush

<div class="content-header">
    <h2 class="section-title-offset">Edit Layanan</h2>
</div>

<div class="content-body">
    <div class="card shadow-sm mx-auto form-card-wide">
        <div class="card-body">
            <form action="{{ route('admin.layanan.update', $layanan->id) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @include('admin.layanan._form', ['layanan' => $layanan])
            </form>
        </div>
    </div>
</div>
@endsection