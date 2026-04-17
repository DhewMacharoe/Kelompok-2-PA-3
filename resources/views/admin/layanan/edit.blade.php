@extends('layouts.admin')

@section('title', 'Edit Layanan')
@section('header_title', 'Layanan')

@section('content')
<div class="section-card">
    <div class="section-header">
        <h2>Edit Layanan</h2>
    </div>

    <div class="form-card">
        <form action="{{ route('admin.layanan.update', $layanan->id) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @include('admin.layanan._form', ['layanan' => $layanan])
        </form>
    </div>
</div>
@endsection