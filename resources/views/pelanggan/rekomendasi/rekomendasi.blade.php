@extends('pelanggan.layouts.app')
@section('title', 'Rekomendasi & Try-On Gaya Rambut')

@section('content')
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="mb-3 text-gold fw-bold">Analisis Bentuk Wajah & AI Try-On</h2>
            <p class="text-muted">Ambil foto langsung atau unggah foto wajah Anda untuk mendapatkan rekomendasi gaya rambut
                dan melihat hasilnya dengan AI Generatif.</p>
        </div>

        <div class="row justify-content-center">
            <!-- Bagian Input Kamera / Foto -->
            <div class="col-md-5 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4 text-center">
                        <div class="mb-4 d-flex justify-content-center">
                            <div id="preview-container"
                                style="position: relative; width: 300px; height: 300px; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 8px rgba(0,0,0,0.2); background-color: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                                <video id="webcam" width="300" height="300" autoplay playsinline
                                    style="display:none; object-fit: cover; transform: scaleX(-1);"></video>
                                <img id="image-preview" style="display:none; width: 100%; height: 100%; object-fit: cover;">
                                <canvas id="ar-canvas" width="300" height="300"
                                    style="position: absolute; left: 0; top: 0; z-index: 10; pointer-events: none;"></canvas>
                                <div id="placeholder-text" class="text-muted p-3">Silakan pilih metode di bawah</div>
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

                        <div id="status-analisis" class="mb-4 p-3 rounded d-none"
                            style="background-color: #f8f9fa; border: 1px dashed #ccc;">
                            <h5 class="text-muted mb-1">Hasil Deteksi:</h5>
                            <h3 id="live-bentuk-wajah" class="text-warning fw-bold text-uppercase">Menganalisis...</h3>
                            <span id="live-akurasi" class="badge bg-secondary">Akurasi: 0%</span>
                        </div>

                        <button type="button" id="btn-kirim" class="btn btn-dark w-100 fw-bold py-2" disabled
                            onclick="kirimHasil()">
                            Tampilkan Rekomendasi
                        </button>
                    </div>
                </div>
            </div>

            <!-- Bagian Hasil Rekomendasi (Card) -->
            <div class="col-md-7 mb-4 d-none" id="hasil-rekomendasi-container">
                <div class="card shadow-sm border-0 h-100" style="background-color: #f8f9fa;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="fw-bold mb-0">Rekomendasi Gaya Rambut</h4>
                            <span class="badge bg-success py-2 px-3">Bentuk Wajah: <span
                                    id="label-bentuk-wajah"></span></span>
                        </div>

                        <div class="row" id="daftar-card-rekomendasi">
                            <!-- Card akan di-generate via JavaScript di sini -->
                        </div>

                        <!-- Area Hasil AI Generatif -->
                        <div id="area-generatif" class="mt-4 p-4 border rounded bg-white text-center d-none shadow-sm">
                            <h5 class="fw-bold mb-3"><i class="fas fa-magic text-warning me-2"></i>Hasil AI Try-On</h5>
                            <div id="loading-generatif" class="d-none py-4">
                                <div class="spinner-border text-dark" role="status"></div>
                                <p class="mt-2 text-muted">AI sedang mengaplikasikan gaya rambut pada foto Anda...</p>
                            </div>
                            <img id="hasil-gambar-ai" src="" class="img-fluid rounded shadow-sm d-none mb-3"
                                style="max-height: 250px; object-fit: cover;">
                            <div>
                                <button class="btn btn-dark fw-bold px-4" id="btn-ambil-antrean">
                                    Gunakan Gaya Ini & Ambil Nomor Antrean
                                </button>
                            </div>
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

        // Load Lokal Model
        async function loadModels() {
            aiModel = await tf.loadGraphModel('{{ asset('ai_model/model.json') }}');
            faceDetector = await blazeface.load();
        }
        loadModels();

        // Kamera Logic
        btnCamera.onclick = async () => {
            const stream = await navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: 'user'
                }
            });
            video.srcObject = stream;
            video.style.display = 'block';
            imgPreview.style.display = 'none';
            btnCapture.style.display = 'block';
            document.getElementById('placeholder-text').style.display = 'none';
        };

        btnCapture.onclick = () => {
            const canvas = document.createElement('canvas');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext('2d').drawImage(video, 0, 0);

            base64Image = canvas.toDataURL('image/jpeg');
            processImage(base64Image);

            video.srcObject.getTracks().forEach(track => track.stop());
            video.style.display = 'none';
            btnCapture.style.display = 'none';
        };

        // Upload Logic
        fileUpload.onchange = (e) => {
            const reader = new FileReader();
            reader.onload = (event) => {
                base64Image = event.target.result;
                processImage(base64Image);
            };
            reader.readAsDataURL(e.target.files[0]);
        };

        // Analisis Gambar dengan Model TFJS
        async function processImage(src) {
            imgPreview.src = src;
            imgPreview.style.display = 'block';
            document.getElementById('placeholder-text').style.display = 'none';
            document.getElementById('status-analisis').classList.remove('d-none');
            document.getElementById('hasil-rekomendasi-container').classList.add('d-none');

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
                    btnKirim.disabled = false;
                } else {
                    alert("Wajah tidak terdeteksi. Gunakan foto yang lebih jelas.");
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
                        tampilkanRekomendasi(data.data.bentuk_wajah, data.data.rekomendasi);
                    }
                    btnKirim.disabled = false;
                    btnKirim.innerText = "Tampilkan Rekomendasi";
                });
        }

        // Render HTML Cards secara dinamis
        function tampilkanRekomendasi(bentukWajah, daftarRekomendasi) {
            document.getElementById('hasil-rekomendasi-container').classList.remove('d-none');
            document.getElementById('label-bentuk-wajah').innerText = bentukWajah.toUpperCase();

            const container = document.getElementById('daftar-card-rekomendasi');
            container.innerHTML = '';

            daftarRekomendasi.forEach(rek => {
                const cardHtml = `
                <div class="col-md-6 mb-3">
                    <div class="card h-100 border text-center shadow-sm">
                        <div class="card-body p-3">
                            <h5 class="fw-bold text-dark">${rek}</h5>
                            <button class="btn btn-outline-dark btn-sm w-100 mt-2" onclick="generateAIGaya('${rek}')">
                                <i class="fas fa-magic me-1"></i> Try-On AI
                            </button>
                        </div>
                    </div>
                </div>
            `;
                container.innerHTML += cardHtml;
            });
        }

        // Trigger AI Generatif ke Backend
        function generateAIGaya(namaGaya) {
            const areaGen = document.getElementById('area-generatif');
            const loadingGen = document.getElementById('loading-generatif');
            const imgHasil = document.getElementById('hasil-gambar-ai');

            areaGen.classList.remove('d-none');
            loadingGen.classList.remove('d-none');
            imgHasil.classList.add('d-none');

            // Scroll otomatis ke bawah
            areaGen.scrollIntoView({
                behavior: 'smooth'
            });

            fetch("{{ route('rekomendasi.generate') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        image_base64: base64Image,
                        gaya_rambut: namaGaya
                    })
                })
                .then(res => res.json())
                .then(data => {
                    loadingGen.classList.add('d-none');
                    if (data.status === 'success') {
                        imgHasil.src = data.image_url;
                        imgHasil.classList.remove('d-none');
                    } else {
                        alert("Gagal melakukan generate gambar AI: " + data.message);
                    }
                })
                .catch(error => {
                    loadingGen.classList.add('d-none');
                    alert("Terjadi kesalahan server.");
                });
        }
    </script>
@endsection
