@extends('pelanggan.layouts.app')
@section('title', 'Rekomendasi Gaya Rambut')

@section('content')
    <div class="container py-4">
        <h2 class="text-center mb-4 text-gold fw-bold">Rekomendasi Gaya Rambut</h2>

        <div class="d-flex gap-2 mb-4 justify-content-center">
            <button class="btn btn-gold" onclick="showState('upload')">Upload Foto</button>
            <button class="btn btn-outline-secondary" onclick="showState('hasil')">Hasil Analisis</button>
        </div>

        <div id="state-upload" style="display: block;">
            <div class="text-center py-5">
                <i class="fas fa-camera fa-3x text-muted mb-3"></i>
                <p>Upload foto wajah Anda untuk mendapatkan rekomendasi gaya rambut</p>
                <input type="file" id="fileInput" accept="image/*" class="d-none">
                <button class="btn btn-gold" onclick="document.getElementById('fileInput').click()">Pilih Foto</button>
            </div>
        </div>

        <div id="state-hasil" style="display: none;">
            <div class="text-center py-5">
                <i class="fas fa-magic fa-3x text-gold mb-3"></i>
                <h4>Analisis Selesai!</h4>
                <p>Berdasarkan bentuk wajah Anda, berikut rekomendasi gaya rambut:</p>
                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5>Undercut</h5>
                                <p>Cocok untuk wajah oval</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
