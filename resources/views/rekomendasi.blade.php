@extends('layouts.public')
@section('title', 'Rekomendasi Gaya Rambut')

@section('header')
    <button class="header-back" onclick="history.back()">← Kembali</button>
    <div class="header-title">Rekomendasi Gaya</div>
    <div style="width:64px;"></div>
@endsection

@section('content')
    <div
        style="display:flex; gap:8px; padding:12px 16px; background:var(--bg); border-bottom:1px solid var(--border-light);">
        <button class="btn btn-sm btn-primary" onclick="showState('upload')">Upload</button>
        <button class="btn btn-sm btn-secondary" onclick="showState('hasil')">Hasil Analisis</button>
    </div>

@endsection

@push('scripts')
    <script>
        function showState(state) {
            document.getElementById('state-upload').style.display = state === 'upload' ? 'block' : 'none';
            document.getElementById('state-hasil').style.display = state === 'hasil' ? 'block' : 'none';
        }
        document.addEventListener('DOMContentLoaded', () => {
            const input = document.getElementById('fileInput');
            const btn = document.getElementById('btn-analisis');
            if (input && btn) {
                input.addEventListener('change', () => {
                    if (input.files.length) {
                        btn.className = 'btn btn-primary';
                        btn.textContent = '🔍 ANALISIS WAJAH SAYA';
                        btn.onclick = () => showState('hasil');
                    }
                });
            }
        });
    </script>
@endpush
