@extends('pelanggan.layouts.app')

@section('title', 'Antrian')

@push('styles')
    @include('pelanggan.antrian.style-index')
@endpush

@section('content')

<div class="container px-3">
    <div class="app-card">
        <div class="row g-0">

            <div class="col-md-5">
                <div class="header-section">
                    <div class="text-gold">SEDANG DILAYANI</div>
                    <div class="active-number-box">
                        <p class="active-number">{{ $antrianSedangDilayani ? $antrianSedangDilayani->nomor_antrian : '--' }}</p>
                    </div>
                    <div class="active-name">{{ $antrianSedangDilayani ? $antrianSedangDilayani->nama_pelanggan : 'Kosong' }}</div>
                </div>
            </div>

            <div class="col-md-7">
                <div class="right-panel">

                    <div class="queue-section">
                        <div class="section-title">URUTAN ANTRIAN</div>

                        @forelse($antrianMenunggu as $item)
                        <div class="queue-card">
                            <div class="queue-number-box">{{ $item->nomor_antrian }}</div>
                            <div class="queue-info">
                                <p class="queue-name">{{ substr($item->nama_pelanggan, 0, 3) }}***</p>
                                <p class="queue-time">Masuk: {{ \Carbon\Carbon::parse($item->waktu_masuk)->format('H:i') }} WIB</p>
                            </div>
                            <div><span class="badge-waiting">MENUNGGU</span></div>
                        </div>
                        @empty
                        <div style="text-align: center; padding: 20px;">
                            <p>Tidak ada antrian saat ini</p>
                        </div>
                        @endforelse
                    </div>

                    <div class="footer-section">
                        @auth
                            <form action="{{ route('antrian.daftar') }}" method="POST" style="width: 100%;">
                                @csrf
                                <button type="submit" class="btn btn-add-queue" style="width: 100%;">Tambah Antrean</button>
                            </form>
                        @else
                            <a href="{{ route('login.user') }}" class="btn btn-add-queue" style="width: 100%; text-decoration: none; display: block; text-align: center;">Login</a>
                        @endauth
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
