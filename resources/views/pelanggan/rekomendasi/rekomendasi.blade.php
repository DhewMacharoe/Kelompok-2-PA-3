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
                            <button type="button" id="btn-camera" class="btn btn-outline-dark">
                                <i class="fas fa-camera me-2"></i>Aktifkan Kamera
                            </button>
                            <button type="button" id="btn-capture" class="btn btn-dark" style="display:none;">
                                <i class="fas fa-circle me-2"></i>Ambil Foto
                            </button>
                            <input type="file" id="file-upload" accept="image/*" class="d-none">
                            <button type="button" onclick="document.getElementById('file-upload').click()"
                                class="btn btn-outline-secondary">
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

                        <button type="button" id="btn-kirim" class="btn btn-dark w-100 fw-bold py-2" disabled
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
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/blazeface"></script>

    <script>
        const CLASS_NAMES = ['Heart', 'Oblong', 'Oval', 'Round', 'Square'];
        const fallbackImageUrl = "{{ asset('assets/images/rambut/buzz_cut.png') }}";
        let aiModel = null,
            faceDetector = null;
        let currentBentukWajah = '',
            currentAkurasi = 0;
        let base64Image = ''; // Menyimpan gambar untuk dikirim ke AI Generatif

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
        }

        let pendingImageSrc = null;

        // Fungsi untuk menghentikan kamera
        function stopCameraStream() {
            if (video.srcObject) {
                video.srcObject.getTracks().forEach(track => track.stop());
                video.srcObject = null;
            }
            video.style.display = 'none';
            btnCapture.style.display = 'none';
        }

        // Load Lokal Model
        async function loadModels() {
            try {
                // Gunakan origin saat ini agar tidak salah memanggil localhost di HP
                const modelUrl = window.location.origin + "/ai_model/model.json";
                aiModel = await tf.loadGraphModel(modelUrl);
                faceDetector = await blazeface.load();
                
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
                console.error('Gagal memuat model AI:', error);
                const overlay = document.getElementById('ai-loading-overlay');
                if (overlay) {
                    overlay.innerHTML = `
                        <div class="text-danger fs-3 mb-2"><i class="fas fa-exclamation-triangle"></i></div>
                        <div class="fw-bold small text-dark mb-1">AI Gagal Dimuat</div>
                        <div class="text-muted text-center" style="font-size: 0.75rem; padding: 0 10px; line-height: 1.4;">
                            Gagal mengunduh modul AI.<br>
                            <span class="text-danger small">${escapeHtml(error.message || error)}</span><br>
                            <span class="text-warning fw-semibold mt-1 d-block">Tips: Pastikan koneksi internet stabil (ukuran model ~95MB).</span>
                        </div>
                    `;
                }
            }
        }
        loadModels();

        // Kamera Logic
        btnCamera.onclick = async () => {
            try {
                if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                    throw new Error("Browser Anda tidak mendukung akses kamera di konteks ini. Pastikan Anda menggunakan HTTPS.");
                }
                
                stopCameraStream();

                let stream;
                try {
                    // Coba request kamera depan terlebih dahulu (untuk HP)
                    stream = await navigator.mediaDevices.getUserMedia({
                        video: {
                            facingMode: 'user'
                        }
                    });
                } catch (err) {
                    console.warn("Gagal mengakses kamera dengan facingMode: 'user'. Mencoba fallback ke kamera default...", err);
                    // Fallback: Coba akses kamera apa pun yang tersedia (penting untuk PC/Laptop tanpa kamera depan khusus)
                    stream = await navigator.mediaDevices.getUserMedia({
                        video: true
                    });
                }

                video.srcObject = stream;
                video.style.display = 'block';
                imgPreview.style.display = 'none';
                btnCapture.style.display = 'block';
                document.getElementById('placeholder-text').style.display = 'none';
            } catch (error) {
                console.error('Gagal mengakses kamera:', error);
                
                let detailPesan = error.message;
                if (error.name === 'NotFoundError' || error.message.includes('device not found')) {
                    detailPesan = "Kamera tidak ditemukan. Pastikan perangkat Anda memiliki kamera yang aktif, tersambung, dan tidak sedang digunakan oleh aplikasi lain (seperti Zoom, Meet, atau browser lain).";
                } else if (error.name === 'NotAllowedError' || error.message.includes('Permission denied')) {
                    detailPesan = "Akses kamera ditolak. Silakan berikan izin akses kamera untuk website ini pada pengaturan browser Anda.";
                }

                alert("Gagal mengakses kamera:\n" + detailPesan + "\n\nCatatan: Akses kamera pada perangkat HP memerlukan koneksi HTTPS (Secure Context) jika tidak diakses via localhost.");
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

        // Analisis Gambar dengan Model TFJS
        async function processImage(src) {
            imgPreview.src = src;
            imgPreview.style.display = 'block';
            document.getElementById('placeholder-text').style.display = 'none';
            document.getElementById('status-analisis').classList.remove('d-none');
            document.getElementById('live-bentuk-wajah').innerText = 'Menganalisis...';
            document.getElementById('live-akurasi').innerText = 'Akurasi: 0%';
            if (analysisProgressBar) {
                analysisProgressBar.style.width = '0%';
                analysisProgressBar.setAttribute('aria-valuenow', '0');
            }
            resetResultView();

            if (!aiModel || !faceDetector) {
                document.getElementById('analysis-caption').innerText = 'Menunggu modul AI selesai dimuat di latar belakang...';
                pendingImageSrc = src;
                return;
            }

            document.getElementById('analysis-caption').innerText = 'Wajah sedang dianalisis untuk membaca proporsi terbaik.';

            imgPreview.onload = async () => {
                const faces = await faceDetector.estimateFaces(imgPreview, false);
                if (faces.length > 0) {
                    const face = faces[0];
                    const start = face.topLeft;
                    const end = face.bottomRight;
                    const size = [end[0] - start[0], end[1] - start[1]];

                    const canvas = document.createElement('canvas');
                    canvas.width = 224;
                    canvas.height = 224;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(imgPreview, start[0], start[1], size[0], size[1], 0, 0, 224, 224);

                    const prediction = tf.tidy(() => {
                        let tensor = tf.browser.fromPixels(canvas).toFloat().expandDims();
                        return aiModel.predict(tensor.div(255.0));
                    });

                    const results = await prediction.data();
                    const maxIdx = results.indexOf(Math.max(...results));

                    currentBentukWajah = CLASS_NAMES[maxIdx];
                    currentAkurasi = (results[maxIdx] * 100).toFixed(2);

                    document.getElementById('live-bentuk-wajah').innerText = currentBentukWajah;
                    document.getElementById('live-akurasi').innerText = `Akurasi: ${currentAkurasi}%`;
                    document.getElementById('analysis-caption').innerText = 'Wajah terdeteksi. Tekan tombol di bawah untuk melihat rekomendasi yang lebih detail.';
                    if (analysisProgressBar) {
                        analysisProgressBar.style.width = `${Math.min(currentAkurasi, 100)}%`;
                        analysisProgressBar.setAttribute('aria-valuenow', currentAkurasi);
                    }
                    btnKirim.disabled = false;
                } else {
                    alert("Wajah tidak terdeteksi. Gunakan foto yang lebih jelas.");
                    document.getElementById('analysis-caption').innerText = 'Pastikan wajah terlihat jelas, menghadap ke kamera, dan pencahayaan cukup.';
                }
            };
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
                        alert(data.message || 'Gagal menampilkan rekomendasi.');
                    }
                    btnKirim.disabled = false;
                    btnKirim.innerText = "Tampilkan Rekomendasi";
                })
                .catch(() => {
                    btnKirim.disabled = false;
                    btnKirim.innerText = "Tampilkan Rekomendasi";
                    alert('Terjadi kesalahan server.');
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
                                    <button class="btn btn-outline-dark btn-sm w-100" data-front="${frontUrl}" data-side="${sideUrl}" data-back="${backUrl}" onclick="openGallery(this.dataset)">
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

            // bersihkan UI lama AI (tidak digunakan lagi)
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
