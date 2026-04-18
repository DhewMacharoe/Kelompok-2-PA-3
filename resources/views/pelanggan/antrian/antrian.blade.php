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
                        <p class="active-number">05</p>
                    </div>
                    <div class="active-name">jose</div>
                </div>
            </div>

            <div class="col-md-7">
                <div class="right-panel">

                    <div class="queue-section">
                        <div class="section-title">URUTAN ANTRIAN</div>

                        <div class="queue-card">
                            <div class="queue-number-box">06</div>
                            <div class="queue-info">
                                <p class="queue-name">sugeng</p>
                                <p class="queue-time">Masuk: 09.45 WIB</p>
                            </div>
                            <div><span class="badge-waiting">MENUNGGU</span></div>
                        </div>

                        <div class="queue-card">
                            <div class="queue-number-box">07</div>
                            <div class="queue-info">
                                <p class="queue-name">paldo</p>
                                <p class="queue-time">Masuk: 10.02 WIB</p>
                            </div>
                            <div><span class="badge-waiting">MENUNGGU</span></div>
                        </div>

                        <div class="queue-card">
                            <div class="queue-number-box">08</div>
                            <div class="queue-info">
                                <p class="queue-name">jappy</p>
                                <p class="queue-time">Masuk: 10.18 WIB</p>
                            </div>
                            <div><span class="badge-waiting">MENUNGGU</span></div>
                        </div>
                    </div>

                    <div class="footer-section">
                        <button class="btn btn-add-queue">Tambah Antrean</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
