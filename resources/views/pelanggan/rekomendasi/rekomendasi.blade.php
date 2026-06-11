@extends('pelanggan.layouts.app')
@section('title', 'Rekomendasi & Try-On Gaya Rambut')

@push('styles')
    <style>
        .rekomendasi-shell {
            position: relative;
        }

        .rekomendasi-hero {
            background: linear-gradient(135deg, rgba(26, 26, 26, 0.96), rgba(76, 55, 24, 0.95)),
                radial-gradient(circle at top right, rgba(212, 175, 55, 0.24), transparent 28%),
                linear-gradient(135deg, #111, #272727);
            border-radius: 28px;
            padding: 28px;
            color: #fff;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.14);
            overflow: hidden;
        }

        .rekomendasi-hero h2 {
            letter-spacing: -0.02em;
        }

        .rekomendasi-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: #f7f1df;
            font-size: 0.88rem;
            margin-right: 8px;
            margin-bottom: 8px;
        }

        .rekomendasi-card,
        .preview-card,
        .result-card {
            border: 0;
            border-radius: 24px;
            box-shadow: 0 18px 45px rgba(22, 28, 45, 0.08);
            overflow: hidden;
        }

        .preview-shell {
            width: 100%;
            max-width: 320px;
            aspect-ratio: 1 / 1;
            margin: 0 auto;
            border-radius: 24px;
            background: linear-gradient(180deg, #f7f3ea, #f0ebe2);
            border: 1px solid #eadfc6;
            overflow: hidden;
            position: relative;
        }

        #preview-container {
            width: 100% !important;
            height: 100% !important;
            border-radius: 24px !important;
            background: transparent !important;
            box-shadow: none !important;
        }

        .rekomendasi-preview-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 999px;
            background: #fff;
            border: 1px solid #efe5cf;
            color: #4c4c4c;
            font-size: 0.82rem;
            font-weight: 600;
        }

        .analysis-box {
            background: linear-gradient(180deg, #fff, #fbf8f1);
            border: 1px solid #efe6d1;
            border-radius: 18px;
        }

        .analysis-progress {
            height: 10px;
            border-radius: 999px;
            background: #ece5d7;
            overflow: hidden;
        }

        .analysis-progress .progress-bar {
            background: linear-gradient(90deg, #d4af37, #9c7b22);
        }

        .result-banner {
            background: linear-gradient(135deg, #fff, #f7f2e6);
            border: 1px solid #eee1bf;
            border-radius: 18px;
        }

        .result-summary {
            border-radius: 18px;
            background: #fff;
            border: 1px solid #ece6da;
        }

        .tip-card {
            border: 1px solid #eee1bf;
            border-radius: 18px;
            background: #fff;
            padding: 16px;
            height: 100%;
        }

        .tip-card i {
            color: #c59b2d;
        }

        .recommendation-card {
            border: 1px solid #ece6da;
            border-radius: 20px;
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }

        @media (hover: hover) and (pointer: fine) {
            .recommendation-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 18px 32px rgba(22, 28, 45, 0.11);
                border-color: #d9c38a;
            }
        }

        .recommendation-rank {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 42px;
            height: 42px;
            border-radius: 14px;
            background: #111;
            color: #fff;
            font-weight: 700;
        }

        .recommendation-reason {
            color: #5d6470;
            line-height: 1.65;
        }

        .recommendation-note {
            background: #f8f5ee;
            border-radius: 14px;
            padding: 12px 14px;
            color: #5a4a22;
        }

        .thumb-img {
            width: 72px;
            height: 72px;
            object-fit: cover;
            border-radius: 8px;
            cursor: pointer;
        }

        .tryon-panel {
            background: linear-gradient(180deg, #fff, #fbfaf7);
            border-radius: 18px;
            border: 1px solid #ece6da;
        }

        .hero-icon {
            font-size: 3.5rem;
            color: rgba(212, 175, 55, 0.3);
            text-align: center;
        }

        @media (min-width: 992px) {
            .rekomendasi-hero {
                padding: 40px;
            }

            .rekomendasi-hero h2 {
                font-size: 1.8rem;
                line-height: 1.3;
            }

            .rekomendasi-hero p {
                font-size: 1rem;
            }
        }

        @media (max-width: 767.98px) {
            .rekomendasi-hero {
                padding: 18px;
                border-radius: 18px;
            }

            .preview-shell {
                max-width: 280px;
            }

            .rekomendasi-hero h2 {
                font-size: 1.2rem;
            }

            .rekomendasi-chip {
                padding: 6px 10px;
                font-size: 0.78rem;
            }

            .hero-icon {
                display: none;
            }
        }

        @media (max-width: 575.98px) {
            .thumb-img {
                width: 56px;
                height: 56px;
            }

            .result-banner p {
                font-size: 0.95rem;
            }

            .modal-body img {
                max-height: 220px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container py-5 rekomendasi-shell">


        <div class="row justify-content-center g-4">
            <!-- Bagian Input Kamera / Foto -->
            <div class="col-md-5 col-lg-4 mb-4">
                <div class="card preview-card h-100">
                    <div class="card-body p-4 text-center">
                        <div class="mb-3 text-start">
                            <h5 class="fw-bold mb-1">Ambil foto wajah</h5>
                            <p class="text-muted small mb-0">Gunakan kamera atau unggah gambar dengan wajah yang terlihat jelas.</p>
                        </div>

                        <div class="mb-4 d-flex justify-content-center">
                            <div class="preview-shell">
                                <!-- AI Loading Overlay inside preview box -->
                                <div id="ai-loading-overlay" class="position-absolute d-flex flex-column align-items-center justify-content-center" 
                                     style="top:0; left:0; width:100%; height:100%; background: rgba(255, 255, 255, 0.96); z-index: 100; transition: opacity 0.5s ease, visibility 0.5s;">
                                    <div class="spinner-border text-warning mb-2" role="status" style="width: 2rem; height: 2rem;">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <div class="fw-bold small text-dark mb-1">Menyiapkan AI Wajah</div>
                                    <div class="text-muted text-center" style="font-size: 0.72rem; padding: 0 15px;">Sedang memuat modul cerdas...</div>
                                </div>

                                <div id="preview-container" class="d-flex align-items-center justify-content-center">
                                    <video id="webcam" width="300" height="300" autoplay playsinline
                                        style="display:none; object-fit: cover; transform: scaleX(-1);"></video>
                                    <img id="image-preview" style="display:none; width: 100%; height: 100%; object-fit: cover;">
                                    <canvas id="ar-canvas" width="300" height="300"
                                        style="position: absolute; left: 0; top: 0; z-index: 10; pointer-events: none;"></canvas>
                                    <div id="placeholder-text" class="text-muted p-3 text-center">
                                        <div class="rekomendasi-preview-label mb-2"><i class="fas fa-image"></i> Preview</div>
                                        <div>Silakan pilih metode di bawah untuk memulai analisis.</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mb-3">
                            <button type="button" id="btn-camera" class="btn btn-secondary">
                                <i class="fas fa-camera me-2"></i>Aktifkan Kamera
                            </button>
                            <button type="button" id="btn-capture" class="btn btn-primary" style="display:none;">
                                <i class="fas fa-circle me-2"></i>Ambil Foto
                            </button>
                            <input type="file" id="file-upload" accept="image/*" class="d-none">
                            <button type="button" onclick="document.getElementById('file-upload').click()"
                                class="btn btn-secondary">
                                <i class="fas fa-upload me-2"></i>Unggah Foto
                            </button>
                        </div>

                        <div id="status-analisis" class="mb-4 p-3 analysis-box d-none text-start">
                            <div class="d-flex justify-content-between align-items-start gap-3 mb-2">
                                <div>
                                    <div class="text-muted small fw-semibold text-uppercase mb-1">Hasil deteksi</div>
                                    <h3 id="live-bentuk-wajah" class="text-warning fw-bold text-uppercase mb-1">Menganalisis...</h3>
                                </div>
                                <span id="live-akurasi" class="badge bg-dark">Akurasi: 0%</span>
                            </div>
                            <div class="analysis-progress mb-2">
                                <div id="analysis-progress-bar" class="progress-bar" role="progressbar" style="width: 0%"
                                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p id="analysis-caption" class="text-muted small mb-0">Sistem sedang membaca karakter wajah Anda untuk menyesuaikan rekomendasi.</p>
                        </div>

                        <button type="button" id="btn-kirim" class="btn btn-gold w-100 fw-bold py-2" disabled
                            onclick="kirimHasil()">
                            Tampilkan Rekomendasi
                        </button>
                    </div>
                </div>
            </div>

            <!-- Bagian Hasil Rekomendasi (Card) -->
            <div class="col-md-7 col-lg-7 mb-4 d-none" id="hasil-rekomendasi-container">
                <div class="card result-card h-100 bg-light">
                    <div class="card-body p-4">
                        <div class="result-banner p-3 p-md-4 mb-4">
                            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                                <div>
                                    <div class="text-uppercase text-muted small fw-semibold mb-1">Hasil rekomendasi</div>
                                    <h4 class="fw-bold mb-2">Rekomendasi Gaya Rambut</h4>
                                    <p id="hasil-ringkasan" class="text-muted mb-0" style="line-height: 1.7;">
                                        Ringkasan analisis akan muncul setelah bentuk wajah terdeteksi.
                                    </p>
                                    <div id="disclaimer-botak" class="small mt-3 p-2 bg-white border border-info rounded text-muted d-none" style="border-left: 4px solid #0dcaf0 !important;">
                                        <i class="fas fa-info-circle text-info me-1"></i> <strong>Catatan:</strong> AI kami berfokus menganalisis struktur tulang rahang dan proporsi wajah Anda. Rekomendasi di bawah ini merupakan referensi gaya yang secara estetika paling ideal untuk bentuk wajah Anda, terlepas dari panjang atau gaya rambut Anda saat ini.
                                    </div>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-success py-2 px-3 mb-2">Bentuk Wajah: <span id="label-bentuk-wajah"></span></span>
                                    <div class="small text-muted">Akurasi model: <span id="label-akurasi-hasil" class="fw-semibold text-dark">0%</span></div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mb-4" id="hasil-tips">
                            <!-- Tips akan di-generate via JavaScript di sini -->
                        </div>

                        <div class="row g-3" id="daftar-card-rekomendasi">
                            <!-- Card rekomendasi akan di-generate via JavaScript di sini -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <!-- Face-API.js (Ringan & Cepat < 5MB) menggantikan TensorFlow 95MB -->
    <script src="https://cdn.jsdelivr.net/npm/@vladmandic/face-api/dist/face-api.min.js"></script>

    <script>
        const CLASS_NAMES = ['Heart', 'Oblong', 'Oval', 'Round', 'Square'];
        const fallbackImageUrl = "{{ asset('assets/images/rambut/buzz_cut.png') }}";
        let aiModel = null,
            faceDetector = null;
        let currentBentukWajah = '',
            currentAkurasi = 0;
        let base64Image = ''; // Menyimpan gambar untuk dikirim ke AI Generatif
        let isCameraActive = false;

        const video = document.getElementById('webcam');
        const imgPreview = document.getElementById('image-preview');
        const btnCamera = document.getElementById('btn-camera');
        const btnCapture = document.getElementById('btn-capture');
        const fileUpload = document.getElementById('file-upload');
        const btnKirim = document.getElementById('btn-kirim');
        const analysisProgressBar = document.getElementById('analysis-progress-bar');

        function escapeHtml(value) {
            return String(value)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function resetResultView() {
            document.getElementById('hasil-rekomendasi-container').classList.add('d-none');
            document.getElementById('hasil-ringkasan').innerText = 'Ringkasan analisis akan muncul setelah bentuk wajah terdeteksi.';
            document.getElementById('hasil-tips').innerHTML = '';
            document.getElementById('daftar-card-rekomendasi').innerHTML = '';
            document.getElementById('label-bentuk-wajah').innerText = '-';
            document.getElementById('label-akurasi-hasil').innerText = '0%';
            document.getElementById('disclaimer-botak').classList.add('d-none');
        }

        let pendingImageSrc = null;
        let isModelLoaded = false;
        let userIsLikelyBald = false;

        // Fungsi untuk menghentikan kamera
        function stopCameraStream() {
            if (video.srcObject) {
                video.srcObject.getTracks().forEach(track => track.stop());
                video.srcObject = null;
            }
            video.style.display = 'none';
            btnCapture.style.display = 'none';

            isCameraActive = false;
            btnCamera.innerHTML = '<i class="fas fa-camera me-2"></i>Aktifkan Kamera';
            btnCamera.classList.remove('btn-danger');
            btnCamera.classList.add('btn-secondary');
        }

        // Load Fast Face-API Models via CDN
        async function loadModels() {
            try {
                // Menggunakan model ringan dari Vladmandic CDN (total ~3MB)
                const MODEL_URL = 'https://vladmandic.github.io/face-api/model/';
                
                await Promise.all([
                    faceapi.nets.tinyFaceDetector.loadFromUri(MODEL_URL),
                    faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL),
                    faceapi.nets.ageGenderNet.loadFromUri(MODEL_URL)
                ]);
                
                isModelLoaded = true;
                
                // Hide loading overlay smoothly
                const overlay = document.getElementById('ai-loading-overlay');
                if (overlay) {
                    overlay.style.opacity = '0';
                    setTimeout(() => {
                        overlay.style.display = 'none';
                    }, 500);
                }

                // Run pending image if any
                if (pendingImageSrc) {
                    processImage(pendingImageSrc);
                    pendingImageSrc = null;
                }
            } catch (error) {
                console.error('Gagal memuat model AI ringan:', error);
                const overlay = document.getElementById('ai-loading-overlay');
                if (overlay) {
                    overlay.innerHTML = `
                        <div class="text-danger fs-3 mb-2"><i class="fas fa-exclamation-triangle"></i></div>
                        <div class="fw-bold small text-dark mb-1">AI Gagal Dimuat</div>
                        <div class="text-muted text-center" style="font-size: 0.75rem; padding: 0 10px; line-height: 1.4;">
                            Pastikan koneksi internet stabil.<br>
                            <span class="text-danger small">${escapeHtml(error.message || error)}</span>
                        </div>
                    `;
                }
            }
        }
        loadModels();

        // Kamera Logic
        btnCamera.onclick = async () => {
            if (isCameraActive) {
                stopCameraStream();
                if (imgPreview.style.display === 'none' || imgPreview.src === '') {
                    document.getElementById('placeholder-text').style.display = 'block';
                }
                return;
            }

            try {
                if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                    throw new Error("Browser Anda tidak mendukung akses kamera di konteks ini. Pastikan menggunakan HTTPS.");
                }
                
                stopCameraStream();

                let stream;
                try {
                    stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user' } });
                } catch (err) {
                    console.warn("Fallback kamera...", err);
                    stream = await navigator.mediaDevices.getUserMedia({ video: true });
                }

                video.srcObject = stream;
                video.style.display = 'block';
                imgPreview.style.display = 'none';
                btnCapture.style.display = 'block';
                document.getElementById('placeholder-text').style.display = 'none';

                isCameraActive = true;
                btnCamera.innerHTML = '<i class="fas fa-times me-2"></i>Nonaktifkan Kamera';
                btnCamera.classList.remove('btn-secondary');
                btnCamera.classList.add('btn-danger');
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: "Gagal mengakses kamera: " + error.message,
                    confirmButtonText: 'OK'
                });
            }
        };

        btnCapture.onclick = () => {
            const canvas = document.createElement('canvas');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext('2d').drawImage(video, 0, 0);

            base64Image = canvas.toDataURL('image/jpeg');
            processImage(base64Image);
            stopCameraStream();
        };

        // Upload Logic
        fileUpload.onchange = (e) => {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = (event) => {
                    base64Image = event.target.result;
                    stopCameraStream();
                    processImage(base64Image);
                };
                reader.readAsDataURL(e.target.files[0]);
            }
        };

        // Strict Mode: Blur Detection menggunakan Mathematical Laplacian Variance
        function isImageBlurry(imgElement) {
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            // Ukuran kecil agar komputasi kilat
            const size = 150; 
            canvas.width = size;
            canvas.height = size;
            ctx.drawImage(imgElement, 0, 0, size, size);
            
            const imageData = ctx.getImageData(0, 0, size, size);
            const data = imageData.data;
            const gray = new Float32Array(size * size);
            
            // Convert ke Grayscale
            for(let i=0; i<data.length; i+=4) {
                gray[i/4] = data[i]*0.299 + data[i+1]*0.587 + data[i+2]*0.114;
            }
            
            // Convolution Laplacian Kernel (Pendeteksi Tepi)
            const kernel = [0, 1, 0, 1, -4, 1, 0, 1, 0];
            let sum = 0, variance = 0;
            const laplacianValues = [];
            
            for(let y=1; y<size-1; y++) {
                for(let x=1; x<size-1; x++) {
                    let val = 
                        gray[(y-1)*size + x] * kernel[1] +
                        gray[y*size + (x-1)] * kernel[3] +
                        gray[y*size + x] * kernel[4] +
                        gray[y*size + (x+1)] * kernel[5] +
                        gray[(y+1)*size + x] * kernel[7];
                    laplacianValues.push(val);
                    sum += val;
                }
            }
            
            const mean = sum / laplacianValues.length;
            for(let i=0; i<laplacianValues.length; i++) {
                variance += Math.pow(laplacianValues[i] - mean, 2);
            }
            variance = variance / laplacianValues.length;
            
            // Jika varian edge sangat kecil (< 15), berarti gambar sangat goyang/buram. 
            // Angka diturunkan dari 60 ke 15 agar HP dengan kamera standar tetap lolos.
            return variance < 15; 
        }

        // Strict Mode Khusus: Deteksi Botak 2.0 (Diperlonggar)
        function isLikelyBald(imgElement, landmarksPos) {
            const chinY = landmarksPos[8].y;
            const browY = Math.min(landmarksPos[19].y, landmarksPos[24].y);
            const browLeft = landmarksPos[19].x;
            const browRight = landmarksPos[24].x;
            
            const faceH = chinY - browY; 
            const faceW = browRight - browLeft; 
            
            const foreheadY = browY - (faceH * 0.2); 
            const foreheadX = browLeft;
            const boxW = faceW;
            const boxH = faceH * 0.15; 
            
            // Ambil area di atas dahi (sekitar 50% tinggi wajah). Math.max untuk mencegah minus (crop).
            const hairY = Math.max(0, browY - (faceH * 0.5)); 
            
            // Pastikan ada jarak ruang minimal di atas dahi untuk diukur
            if (foreheadY - hairY < 10) return false; 
            
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            const nWidth = imgElement.naturalWidth || imgElement.width;
            const nHeight = imgElement.naturalHeight || imgElement.height;
            const scaleX = nWidth / imgElement.width;
            const scaleY = nHeight / imgElement.height;
            
            canvas.width = nWidth;
            canvas.height = nHeight;
            ctx.drawImage(imgElement, 0, 0, nWidth, nHeight);

            try {
                const fData = ctx.getImageData(foreheadX * scaleX, foreheadY * scaleY, boxW * scaleX, boxH * scaleY).data;
                const hData = ctx.getImageData(foreheadX * scaleX, hairY * scaleY, boxW * scaleX, boxH * scaleY).data;
                
                let fR = 0, fG = 0, fB = 0;
                const fCount = fData.length / 4;
                for(let i=0; i<fData.length; i+=4) { fR+=fData[i]; fG+=fData[i+1]; fB+=fData[i+2]; }
                fR /= fCount; fG /= fCount; fB /= fCount;
                
                let hR = 0, hG = 0, hB = 0;
                const hCount = hData.length / 4;
                let hGrays = new Float32Array(hCount);
                
                for(let i=0, j=0; i<hData.length; i+=4, j++) { 
                    hR+=hData[i]; hG+=hData[i+1]; hB+=hData[i+2]; 
                    hGrays[j] = (hData[i]*0.299 + hData[i+1]*0.587 + hData[i+2]*0.114);
                }
                hR /= hCount; hG /= hCount; hB /= hCount;
                
                // Perbedaan warna RGB Euclidean
                const colorDiff = Math.sqrt(Math.pow(fR - hR, 2) + Math.pow(fG - hG, 2) + Math.pow(fB - hB, 2));
                
                let meanGray = 0;
                for(let i=0; i<hCount; i++) meanGray += hGrays[i];
                meanGray /= hCount;
                
                let variance = 0;
                for(let i=0; i<hCount; i++) variance += Math.pow(hGrays[i] - meanGray, 2);
                const stdDev = Math.sqrt(variance / hCount);
                
                // Toleransi dilonggarkan drastis agar lebih gampang ketahuan!
                // Perbedaan warna hingga 65 (krn shading lampu/kilap) dan noise/stdDev tekstur hingga 25 (kamera HP jelek).
                if (colorDiff < 65 && stdDev < 25) {
                    return true;
                }
                
                return false;
            } catch(e) {
                return false;
            }
        }

        // Analisis Wajah dengan Strict Mode
        async function processImage(src) {
            imgPreview.src = src;
            imgPreview.style.display = 'block';
            document.getElementById('placeholder-text').style.display = 'none';
            document.getElementById('status-analisis').classList.remove('d-none');
            document.getElementById('live-bentuk-wajah').innerText = 'Memfilter Gambar...';
            document.getElementById('live-akurasi').innerText = 'Akurasi: 0%';
            
            if (analysisProgressBar) {
                analysisProgressBar.style.width = '10%';
                analysisProgressBar.setAttribute('aria-valuenow', '10');
            }
            resetResultView();

            if (!isModelLoaded) {
                document.getElementById('analysis-caption').innerText = 'Menunggu modul AI dimuat...';
                pendingImageSrc = src;
                return;
            }

            document.getElementById('analysis-caption').innerText = 'Menjalankan Pengecekan Strict Mode...';

            imgPreview.onload = async () => {
                // 1. Strict Mode: Cek Blur
                if (isImageBlurry(imgPreview)) {
                    showError('Kualitas Foto Ditolak', 'Foto terlalu buram atau goyang. Mohon ambil ulang foto yang lebih tajam dan jelas.');
                    return;
                }

                if (analysisProgressBar) analysisProgressBar.style.width = '30%';

                // 2. Strict Mode: Face Detection (Manusia, Single Face, Occlusion)
                const options = new faceapi.TinyFaceDetectorOptions({ inputSize: 224, scoreThreshold: 0.5 });
                const allFaces = await faceapi.detectAllFaces(imgPreview, options).withFaceLandmarks().withAgeAndGender();

                if (analysisProgressBar) analysisProgressBar.style.width = '60%';

                if (allFaces.length === 0) {
                    showError('Wajah Tidak Terdeteksi', 'Wajah manusia tidak terdeteksi. Pastikan pencahayaan cukup dan wajah terlihat utuh menghadap layar.');
                    return;
                }
                
                if (allFaces.length > 1) {
                    showError('Multi-Wajah Terdeteksi', 'Terdeteksi lebih dari 1 wajah di dalam frame. Harap pastikan hanya ada Anda sendirian.');
                    return;
                }

                const face = allFaces[0];
                const confidence = face.detection.score;

                // 3. Strict Mode: Kacamata / Masker / Topi (Confidence Rendah)
                // Threshold diturunkan dari 0.85 ke 0.50 agar kamera HP biasa tetap lolos
                if (confidence < 0.50) {
                    showError('Wajah Terhalang', 'Deteksi wajah kurang jelas. Mohon lepaskan masker atau kacamata hitam, dan cari tempat yang sedikit lebih terang.');
                    return;
                }

                // Cek Kebotakan Secara Halus (Tanpa memblokir sistem)
                userIsLikelyBald = isLikelyBald(imgPreview, face.landmarks.positions);

                // 4. Strict Mode: Gender Filter
                // Threshold dikembalikan ke 0.60. Jika AI mendeteksi perempuan dengan keyakinan > 60%, akan ditolak.
                if (face.gender === 'female' && face.genderProbability > 0.60) {
                    showError('Peringatan Gender', 'Sistem mendeteksi profil wajah perempuan. Harap maklum, saat ini rekomendasi gaya rambut kami dirancang khusus untuk anatomi pria.');
                    return;
                }

                if (analysisProgressBar) analysisProgressBar.style.width = '85%';
                document.getElementById('analysis-caption').innerText = 'Menghitung Geometri Rahang dan Tulang Pipi...';

                // 5. Perhitungan Matematis Bentuk Wajah Berdasarkan 68 Landmarks
                const landmarks = face.landmarks.positions;
                
                // Jarak Pipi ke Pipi (Lebar Wajah Maksimal) -> Point 0 ke 16
                const faceWidth = Math.hypot(landmarks[0].x - landmarks[16].x, landmarks[0].y - landmarks[16].y);
                
                // Jarak Rahang Bawah (Jaw) -> Point 4 ke 12
                const jawWidth = Math.hypot(landmarks[4].x - landmarks[12].x, landmarks[4].y - landmarks[12].y);
                
                // Panjang Wajah (Alis Tertinggi ke Dagu) * 1.4 untuk estimasi dahi/hairline
                const browY = Math.min(landmarks[19].y, landmarks[24].y); 
                const chinY = landmarks[8].y;
                const faceLength = (chinY - browY) * 1.4;

                // Rasio
                const lengthRatio = faceLength / faceWidth;
                const jawRatio = jawWidth / faceWidth;
                
                let shape = 'Oval'; 
                
                // Threshold disesuaikan agar tidak didominasi Oval/Oblong
                if (lengthRatio > 1.38) {
                    shape = 'Oblong'; // Wajah secara signifikan memanjang vertikal
                } else if (lengthRatio < 1.22) {
                    // Wajah cenderung pendek/melebar
                    if (jawRatio > 0.82) {
                        shape = 'Square'; // Rahang kotak dominan
                    } else {
                        shape = 'Round'; // Rahang membulat
                    }
                } else {
                    // Wajah proporsi sedang (1.22 - 1.38)
                    if (jawRatio > 0.85) {
                        shape = 'Square'; // Meski panjangnya normal, rahangnya sangat lebar
                    } else if (jawRatio < 0.78) {
                        shape = 'Heart'; // Dagu lancip, rahang bawah menyempit
                    } else {
                        shape = 'Oval'; // Rahang & pipi seimbang
                    }
                }

                currentBentukWajah = shape;
                currentAkurasi = (confidence * 100).toFixed(2);

                if (analysisProgressBar) {
                    analysisProgressBar.style.width = '100%';
                    analysisProgressBar.setAttribute('aria-valuenow', '100');
                }

                document.getElementById('live-bentuk-wajah').innerText = currentBentukWajah;
                document.getElementById('live-akurasi').innerText = `Akurasi: ${currentAkurasi}%`;
                document.getElementById('analysis-caption').innerText = 'Wajah berhasil dipetakan. Tekan tombol di bawah untuk melihat rekomendasi yang lebih detail.';
                
                btnKirim.disabled = false;
            };
        }

        function showError(title, message) {
            document.getElementById('analysis-caption').innerText = 'Analisis dibatalkan: ' + message;
            document.getElementById('live-bentuk-wajah').innerText = 'Ditolak';
            document.getElementById('live-akurasi').innerText = 'Error';
            if (analysisProgressBar) {
                analysisProgressBar.style.width = '0%';
                analysisProgressBar.classList.add('bg-danger');
            }
            btnKirim.disabled = true;

            Swal.fire({
                icon: 'warning',
                title: title,
                text: message,
                confirmButtonText: 'Coba Lagi'
            });
        }

        // Mengambil Data Rekomendasi Tanpa Reload
        function kirimHasil() {
            btnKirim.disabled = true;
            btnKirim.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memuat...';

            fetch("{{ route('rekomendasi.process') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        bentuk_wajah: currentBentukWajah,
                        akurasi_sistem: currentAkurasi
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        tampilkanRekomendasi(data.data);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: data.message || 'Gagal menampilkan rekomendasi.',
                            confirmButtonText: 'OK'
                        });
                    }
                    btnKirim.disabled = false;
                    btnKirim.innerText = "Tampilkan Rekomendasi";
                })
                .catch(() => {
                    btnKirim.disabled = false;
                    btnKirim.innerText = "Tampilkan Rekomendasi";
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Terjadi kesalahan server.',
                        confirmButtonText: 'OK'
                    });
                });
        }

        // Render HTML Cards secara dinamis
        function tampilkanRekomendasi(data) {
            const bentukWajah = data.bentuk_wajah || '-';
            const akurasi = data.akurasi_sistem || 0;
            const summary = data.summary || 'Rekomendasi siap ditampilkan.';
            const tips = Array.isArray(data.tips) ? data.tips : [];
            const daftarRekomendasi = Array.isArray(data.rekomendasi) ? data.rekomendasi : [];

            document.getElementById('hasil-rekomendasi-container').classList.remove('d-none');
            document.getElementById('label-bentuk-wajah').innerText = bentukWajah.toUpperCase();
            document.getElementById('label-akurasi-hasil').innerText = `${akurasi}%`;
            document.getElementById('hasil-ringkasan').innerText = summary;
            
            // Tampilkan disclaimer hanya jika terdeteksi botak
            if (userIsLikelyBald) {
                document.getElementById('disclaimer-botak').classList.remove('d-none');
            } else {
                document.getElementById('disclaimer-botak').classList.add('d-none');
            }

            const tipsContainer = document.getElementById('hasil-tips');
            tipsContainer.innerHTML = '';
            if (tips.length) {
                tips.forEach((tip, index) => {
                    tipsContainer.innerHTML += `
                        <div class="col-12 col-md-4">
                            <div class="tip-card">
                                <div class="d-flex align-items-start gap-3">
                                    <div class="recommendation-rank" style="min-width: 34px; height: 34px; border-radius: 12px;">${index + 1}</div>
                                    <div>
                                        <div class="fw-bold mb-1">Tips ${index + 1}</div>
                                        <div class="text-muted small" style="line-height: 1.65;">${escapeHtml(tip)}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });
            }

            const container = document.getElementById('daftar-card-rekomendasi');
            container.innerHTML = '';

            daftarRekomendasi.forEach((rek, index) => {
                const nama = escapeHtml(rek.name || rek);
                const alasan = escapeHtml(rek.reason || 'Rekomendasi ini dipilih berdasarkan proporsi wajah Anda.');
                const catatan = escapeHtml(rek.barber_note || 'Diskusikan detailnya dengan kapster agar hasil lebih presisi.');
                const prioritas = escapeHtml(rek.priority || 'Disarankan');
                const frontUrl = escapeHtml((rek.images && rek.images.front) || fallbackImageUrl);
                const sideUrl = escapeHtml((rek.images && rek.images.side) || fallbackImageUrl);
                const backUrl = escapeHtml((rek.images && rek.images.back) || fallbackImageUrl);

                const cardHtml = `
                    <div class="col-12 col-md-6">
                        <div class="card recommendation-card h-100">
                            <div class="card-body p-4 d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                                    <div class="recommendation-rank">${index + 1}</div>
                                    <span class="badge bg-light text-dark border">${prioritas}</span>
                                </div>
                                <h5 class="fw-bold text-dark mb-2">${nama}</h5>
                                <p class="recommendation-reason mb-3">${alasan}</p>
                                <div class="recommendation-note mb-3">
                                    <div class="fw-semibold mb-1"><i class="fas fa-scissors me-2"></i>Catatan ke kapster</div>
                                    <div class="small">${catatan}</div>
                                </div>
                                <div class="d-flex gap-2 mb-3">
                                    <img src="${frontUrl}" alt="${nama} front" class="thumb-img" onclick="openGallery({front: '${frontUrl}', side: '${sideUrl}', back: '${backUrl}'})">
                                    <img src="${sideUrl}" alt="${nama} side" class="thumb-img" onclick="openGallery({front: '${frontUrl}', side: '${sideUrl}', back: '${backUrl}'})">
                                    <img src="${backUrl}" alt="${nama} back" class="thumb-img" onclick="openGallery({front: '${frontUrl}', side: '${sideUrl}', back: '${backUrl}'})">
                                </div>
                                <div class="mt-auto">
                                    <button class="btn btn-secondary btn-sm w-100" data-front="${frontUrl}" data-side="${sideUrl}" data-back="${backUrl}" onclick="openGallery(this.dataset)">
                                        <i class="fas fa-image me-1"></i> Lihat Gambar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                container.innerHTML += cardHtml;
            });

            if (daftarRekomendasi.length === 0) {
                container.innerHTML = `
                    <div class="col-12">
                        <div class="alert alert-warning mb-0">
                            Rekomendasi belum tersedia. Coba unggah foto yang lebih jelas atau konsultasikan langsung dengan kapster.
                        </div>
                    </div>
                `;
            }
        }

        // Buka modal galeri gambar (front/side/back)
        function openGallery(dataset) {
            // dataset may be DOMStringMap or object with keys front/side/back
            const front = dataset.front || dataset['data-front'] || '';
            const side = dataset.side || dataset['data-side'] || '';
            const back = dataset.back || dataset['data-back'] || '';

            const frontImg = document.getElementById('modal-img-front');
            const sideImg = document.getElementById('modal-img-side');
            const backImg = document.getElementById('modal-img-back');

            frontImg.src = front || fallbackImageUrl;
            sideImg.src = side || fallbackImageUrl;
            backImg.src = back || fallbackImageUrl;

            const modalEl = document.getElementById('galleryModal');
            const bsModal = new bootstrap.Modal(modalEl);
            bsModal.show();
        }
    </script>

    <!-- Modal Galeri Gaya Rambut -->
    <div class="modal fade" id="galleryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-fullscreen-sm-down modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Preview Gaya Rambut</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-4 text-center">
                            <div class="mb-2 small text-muted">Depan</div>
                            <img id="modal-img-front" src="{{ asset('assets/images/rambut/buzz_cut.png') }}" class="img-fluid rounded" style="max-height:260px; object-fit:cover;">
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="mb-2 small text-muted">Samping</div>
                            <img id="modal-img-side" src="{{ asset('assets/images/rambut/buzz_cut.png') }}" class="img-fluid rounded" style="max-height:260px; object-fit:cover;">
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="mb-2 small text-muted">Belakang</div>
                            <img id="modal-img-back" src="{{ asset('assets/images/rambut/buzz_cut.png') }}" class="img-fluid rounded" style="max-height:260px; object-fit:cover;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection
