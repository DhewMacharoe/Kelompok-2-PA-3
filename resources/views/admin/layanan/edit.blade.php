@extends('admin.layouts.app')

@section('title', 'Edit Layanan')

@section('header_title')
    <div class="header-title">Edit Layanan</div>
@endsection

@section('content')
<div class="content-header">
    <h2 style="margin-left: 20px; margin-top: 20px;">Edit Layanan</h2>
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