@extends('admin.layouts.app')

@section('title', 'Edit Layanan')

@section('header_title')
    <div class="header-title">Edit Layanan</div>
@endsection

@section('content')
<div class="content-header px-4 py-3">
    <h2 class="mb-0 fw-bold">Edit Layanan</h2>
</div>

<div class="content-body">
    <div class="card shadow-sm mx-auto" style="max-width: 720px;">
        <div class="card-body">
            <form action="{{ route('admin.layanan.update', $layanan->id) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @include('admin.layanan._form', ['layanan' => $layanan])
            </form>
        </div>
    </div>
</div>
@endsection