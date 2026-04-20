@extends('admin.layouts.app')

@section('title', 'Tambah Layanan')

@section('header_title')
    <div class="header-title">Tambah Layanan</div>
@endsection

@section('content')
    <style>
        /* CSS Khusus Halaman Ini */
        .main-container {
            padding: 20px;
            font-family: 'Inter', sans-serif;
        }

        .form-card {
            background: white;
            padding: 24px;
            border-radius: 12px;
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .form-group {
            margin-bottom: 16px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            color: #333;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            box-sizing: border-box;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 24px;
        }

        .btn-submit {
            background-color: #2F80ED;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
        }

        .btn-batal {
            background-color: #EB5757;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
        }
    </style>

    <div class="main-container">
        <div class="form-card">
            <form action="{{ route('admin.layanan.store') }}" method="POST" enctype="multipart/form-data">
                @include('admin.layanan._form')
            </form>
        </div>
    </div>

    <div style="height:50px;"></div>
@endsection
