@extends('pelanggan.layouts.app')
@section('content')
    <div class="container py-5 rekomendasi-shell">
        <div class="row justify-content-center g-4">
            <div class="col-md-5 col-lg-4 mb-4">
                <div class="card preview-card h-100">
                    <div class="card-body p-4 text-center">
                        <div class="mb-3 text-start">
                            <h5 class="fw-bold mb-1">Analisis Wajah AI</h5>
                            <p class="text-muted small mb-0">Deteksi wajah instan di browser Anda.</p>
                        </div>

                        <div class="mb-4 d-flex justify-content-center">
                            <div class="preview-shell">
                                <div id="ai-loading-overlay"
                                    class="position-absolute flex-column align-items-center justify-content-center"
                                    style="top:0; left:0; width:100%; height:100%; z-index: 100; background: rgba(255,255,255,0.8); display: none;">
                                    <div class="spinner-border text-warning mb-2" role="status"></div>
                                    <div class="fw-bold small text-dark mb-1">AI Sedang Berpikir...</div>
                                </div>

                                <div id="preview-container"
                                    class="d-flex align-items-center justify-content-center w-100 h-100">
                                    <video id="webcam" width="320" height="320" autoplay playsinline
                                        style="display:none; object-fit: cover; transform: scaleX(-1);"></video>
                                    <img id="image-preview"
                                        style="display:none; width: 100%; height: 100%; object-fit: cover;">
                                    <div id="placeholder-text" class="text-muted p-3 text-center">
                                        <div class="rekomendasi-preview-label mb-2"><i class="fas fa-image"></i> Preview
                                            Foto</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mb-3">
                            <button type="button" id="btn-camera" class="btn btn-outline-dark"><i
                                    class="fas fa-camera me-2"></i>Buka Kamera</button>
                            <button type="button" id="btn-capture" class="btn btn-dark" style="display:none;"><i
                                    class="fas fa-circle me-2"></i>Jepret & Analisis</button>
                            <input type="file" id="file-upload" accept="image/*" class="d-none">
                            <button type="button" id="btn-upload-trigger" class="btn btn-outline-secondary"><i
                                    class="fas fa-upload me-2"></i>Unggah Foto</button>
                        </div>

                        <div id="status-analisis" class="mb-4 p-3 analysis-box d-none text-start">
                            <div class="d-flex justify-content-between align-items-start gap-3 mb-2">
                                <div>
                                    <div class="text-muted small fw-semibold text-uppercase mb-1">HASIL DETEKSI</div>
                                    <h3 id="live-bentuk-wajah" class="text-warning fw-bold text-uppercase mb-1">...</h3>
                                </div>
                                <span id="live-akurasi" class="badge bg-dark">0%</span>
                            </div>
                            <div class="analysis-progress mb-2">
                                <div id="analysis-progress-bar" class="progress-bar" style="width: 0%"></div>
                            </div>
                            <p id="analysis-caption" class="text-muted small mb-0">Siap menganalisis.</p>
                        </div>

                        <button type="button" id="btn-kirim" class="btn btn-dark w-100 fw-bold py-2" disabled>Tampilkan
                            Rekomendasi</button>
                    </div>
                </div>
            </div>

            <div class="col-md-7 col-lg-7 mb-4 d-none" id="hasil-rekomendasi-container">
                <div class="card result-card h-100 bg-light">
                    <div class="card-body p-4">
                        <div class="result-banner p-3 p-md-4 mb-4">
                            <h4 class="fw-bold mb-2">Rekomendasi Gaya Rambut</h4>
                            <p class="text-muted mb-0">Berdasarkan wajah <span id="label-bentuk-wajah"
                                    class="fw-bold text-uppercase"></span> Anda.</p>
                        </div>
                        <div class="row g-3" id="daftar-card-rekomendasi"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tryonModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0" style="border-radius: 24px;">
                <div class="modal-header bg-dark text-white border-0">
                    <h5 class="modal-title fw-bold">AI Try-On Generatif</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <h6 class="fw-bold mb-3">Model: <span id="nama-rambut-target" class="text-warning"></span></h6>
                    <div class="tryon-workspace mb-3"
                        style="min-height: 200px; display:flex; align-items:center; justify-content:center; background:#eee; border-radius:15px;">
                        <div id="tryon-loading">
                            <div class="spinner-grow text-warning mb-2"></div>
                            <div class="fw-bold">AI Sedang Menggambar...</div>
                        </div>
                        <img id="tryon-result-img" src="" class="d-none w-100" style="border-radius:15px;">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@latest/dist/tf.min.js"></script>

    <script>
        // 1. Variabel Global
        let faceModel;
        const CLASS_NAMES = ['Heart', 'Oblong', 'Oval', 'Round', 'Square'];
        let base64UserImage = '';
        let currentBentukWajah = '';
        let currentAkurasi = 0;

        // =========================================================
        // JURUS BYPASS DATA AUGMENTATION (Agar TF.js tidak error membaca RandomFlip dkk)
        // =========================================================
        class RandomFlip extends tf.layers.Layer {
            constructor(config) {
                super(config);
            }
            computeOutputShape(inputShape) {
                return inputShape;
            }
            call(inputs) {
                return Array.isArray(inputs) ? inputs[0] : inputs;
            }
            static get className() {
                return 'RandomFlip';
            }
        }
        tf.serialization.registerClass(RandomFlip);

        class RandomRotation extends tf.layers.Layer {
            constructor(config) {
                super(config);
            }
            computeOutputShape(inputShape) {
                return inputShape;
            }
            call(inputs) {
                return Array.isArray(inputs) ? inputs[0] : inputs;
            }
            static get className() {
                return 'RandomRotation';
            }
        }
        tf.serialization.registerClass(RandomRotation);

        class RandomZoom extends tf.layers.Layer {
            constructor(config) {
                super(config);
            }
            computeOutputShape(inputShape) {
                return inputShape;
            }
            call(inputs) {
                return Array.isArray(inputs) ? inputs[0] : inputs;
            }
            static get className() {
                return 'RandomZoom';
            }
        }
        tf.serialization.registerClass(RandomZoom);
        // =========================================================


        // 2. Inisialisasi DOM (Pastikan semua ID terdeteksi)
        document.addEventListener('DOMContentLoaded', async () => {
            console.log("DOM siap. Memulai inisialisasi...");

            const btnCamera = document.getElementById('btn-camera');
            const btnCapture = document.getElementById('btn-capture');
            const btnUploadTrigger = document.getElementById('btn-upload-trigger');
            const fileUpload = document.getElementById('file-upload');
            const video = document.getElementById('webcam');
            const imgPreview = document.getElementById('image-preview');
            const loadingOverlay = document.getElementById('ai-loading-overlay');
            const btnKirim = document.getElementById('btn-kirim');

            // --- LOAD MODEL ---
            try {
                const modelUrl = '/model_web/model.json?v=' + new Date().getTime();
                faceModel = await tf.loadLayersModel(modelUrl);
                console.log("✅ AI Model Loaded!");
            } catch (err) {
                console.error("❌ Model Load Failed:", err);
                alert("AI gagal dimuat. Cek Console.");
            }

            // --- TOMBOL BUKA KAMERA ---
            btnCamera.onclick = async () => {
                console.log("Membuka Kamera...");
                try {
                    const stream = await navigator.mediaDevices.getUserMedia({
                        video: true
                    });
                    video.srcObject = stream;
                    video.style.display = 'block';
                    imgPreview.style.display = 'none';
                    document.getElementById('placeholder-text').style.display = 'none';
                    btnCamera.style.display = 'none';
                    btnCapture.style.display = 'inline-block';
                } catch (e) {
                    alert("Kamera Error: " + e.message);
                }
            };

            // --- TOMBOL JEPRET ---
            btnCapture.onclick = () => {
                console.log("Menjepret...");
                const canvas = document.createElement('canvas');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                const ctx = canvas.getContext('2d');
                ctx.translate(canvas.width, 0);
                ctx.scale(-1, 1);
                ctx.drawImage(video, 0, 0);

                base64UserImage = canvas.toDataURL('image/jpeg');

                // Matikan Kamera
                video.srcObject.getTracks().forEach(t => t.stop());
                video.style.display = 'none';
                btnCapture.style.display = 'none';
                btnCamera.style.display = 'inline-block';
                btnCamera.innerHTML = '<i class="fas fa-camera me-2"></i>Ulangi Foto';

                jalankanAI(base64UserImage);
            };

            // --- TOMBOL UPLOAD ---
            btnUploadTrigger.onclick = () => fileUpload.click();
            fileUpload.onchange = (e) => {
                if (e.target.files[0]) {
                    console.log("File dipilih...");
                    const reader = new FileReader();
                    reader.onload = (event) => {
                        base64UserImage = event.target.result;
                        jalankanAI(base64UserImage);
                    };
                    reader.readAsDataURL(e.target.files[0]);
                }
            };

            // --- TOMBOL KIRIM KE LARAVEL ---
            btnKirim.onclick = () => {
                btnKirim.disabled = true;
                btnKirim.innerText = "Memuat Rekomendasi...";

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
                            document.getElementById('hasil-rekomendasi-container').classList.remove(
                                'd-none');
                            document.getElementById('label-bentuk-wajah').innerText =
                            currentBentukWajah;
                            const container = document.getElementById('daftar-card-rekomendasi');
                            container.innerHTML = '';
                            data.data.rekomendasi.forEach(rek => {
                                container.innerHTML += `
                                <div class="col-6">
                                    <div class="card p-3 text-center h-100">
                                        <h6 class="fw-bold">${rek.name || rek}</h6>
                                        <img src="${rek.images ? rek.images.front : ''}" style="height:80px; object-fit:contain;" class="my-2">
                                        <button class="btn btn-sm btn-dark" onclick="prosesTryOn('${rek.name || rek}')">Try On</button>
                                    </div>
                                </div>`;
                            });
                        }
                        btnKirim.disabled = false;
                        btnKirim.innerText = "Tampilkan Rekomendasi";
                    });
            };

            // --- FUNGSI INTI AI ---
            async function jalankanAI(imgBase64) {
                console.log("Memulai Analisis AI...");
                imgPreview.src = imgBase64;
                imgPreview.style.display = 'block';
                document.getElementById('status-analisis').classList.remove('d-none');
                loadingOverlay.style.display = 'flex';

                try {
                    const img = new Image();
                    img.src = imgBase64;
                    await img.decode();

                    const tensor = tf.browser.fromPixels(img)
                        .resizeNearestNeighbor([224, 224])
                        .toFloat()
                        .div(255.0)
                        .expandDims(0);

                    const pred = faceModel.predict(tensor);
                    const results = await pred.data();
                    const idx = pred.argMax(1).dataSync()[0];

                    currentBentukWajah = CLASS_NAMES[idx];
                    currentAkurasi = Math.round(results[idx] * 100);

                    console.log("Hasil:", currentBentukWajah, currentAkurasi + "%");

                    document.getElementById('live-bentuk-wajah').innerText = currentBentukWajah;
                    document.getElementById('live-akurasi').innerText = currentAkurasi + "%";
                    document.getElementById('analysis-progress-bar').style.width = currentAkurasi + "%";

                    loadingOverlay.style.display = 'none';
                    btnKirim.disabled = false;

                    tensor.dispose();
                    pred.dispose();
                } catch (err) {
                    console.error("AI Error:", err);
                    alert("Analisis Gagal: " + err.message);
                    loadingOverlay.style.display = 'none';
                }
            }
        }); // <-- Tutup dari DOMContentLoaded yang tadi hilang

        // Fitur TryOn (Luar DOMContentLoaded agar bisa dipanggil dari HTML string)
        async function prosesTryOn(nama) {
            const modal = new bootstrap.Modal(document.getElementById('tryonModal'));
            document.getElementById('nama-rambut-target').innerText = nama;
            document.getElementById('tryon-loading').classList.remove('d-none');
            document.getElementById('tryon-result-img').classList.add('d-none');
            modal.show();

            fetch("{{ route('rekomendasi.generate') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        image: base64UserImage,
                        hairstyle: nama
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        document.getElementById('tryon-result-img').src = data.generated_image_url;
                        document.getElementById('tryon-result-img').classList.remove('d-none');
                        document.getElementById('tryon-loading').classList.add('d-none');
                    } else {
                        alert("Gagal: " + data.message);
                        modal.hide();
                    }
                });
        }
    </script>
@endsection
