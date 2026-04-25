@extends('admin.layouts.app')

@section('title', 'Galeri')

@section('header_title')
	<div class="header-title">Galeri</div>
@endsection

@section('content')
	<style>
		.main-container {
			padding: 20px;
			font-family: 'Inter', sans-serif;
			max-width: 1180px;
			margin: 0 auto;
		}

		.table-container {
			background: white;
			border-radius: 12px;
			overflow: hidden;
			box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
			border: 1px solid #eef1f5;
		}

		.wip-wrap {
			padding: 70px 24px;
			text-align: center;
		}

		.wip-badge {
			display: inline-block;
			background: #fff8e8;
			border: 1px dashed #d6b365;
			color: #7a5b16;
			border-radius: 999px;
			padding: 8px 16px;
			font-size: 13px;
			font-weight: 700;
			margin-bottom: 18px;
		}

		.wip-title {
			font-size: 28px;
			font-weight: 700;
			color: #2C3E50;
			margin-bottom: 10px;
		}

		.wip-desc {
			color: #6b7b8b;
			max-width: 520px;
			margin: 0 auto;
			line-height: 1.7;
		}
	</style>

	<div class="main-container">
		<div class="table-container">
			<div class="wip-wrap">
				<div class="wip-badge">WORK IN PROGRESS</div>
				<div class="wip-title">Halaman Galeri Admin</div>
				<p class="wip-desc">
					Fitur kelola galeri sedang dalam proses pengembangan. Untuk sementara belum ada data atau aksi yang
					ditampilkan di halaman ini.
				</p>
			</div>
		</div>
	</div>
@endsection
