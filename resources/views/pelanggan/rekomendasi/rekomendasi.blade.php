@extends('pelanggan.layouts.app')
@section('title', 'Rekomendasi Gaya Rambut')

@section('content')
    <div class="container py-5">
        <div class="text-center mb-5">
            <h2 class="mb-3 text-gold fw-bold">Analisis Bentuk Wajah (Face Shape)</h2>
            <p class="text-muted">Unggah foto wajah Anda secara lurus ke depan untuk mendapatkan rekomendasi gaya rambut
                terbaik dari AI.</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <form id="form-ai-rekomendasi">
                            @csrf
                            <div class="mb-4">
                                <label for="foto_wajah" class="form-label fw-bold">Pilih Foto Wajah</label>
                                <input class="form-control" type="file" id="foto_wajah" accept="image/*" required
                                    onchange="previewImage(event)">
                                <div class="form-text mt-2">Pastikan pencahayaan terang dan wajah tidak tertutup aksesoris.
                                </div>
                            </div>

                            <div class="mb-4 text-center">
                                <img id="preview" src="#" alt="Preview Foto" class="img-fluid rounded d-none"
                                    style="max-height: 300px; object-fit: cover;">
                            </div>

                            <button type="submit" id="btn-analisis" class="btn btn-dark w-100 fw-bold py-2" disabled>
                                <i class="fas fa-spinner fa-spin me-2" id="loading-icon"></i> Sedang Memuat Otak AI...
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            @if (session('hasil_analisis'))
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm" style="background-color: #f8f9fa;">
                        <div class="card-body p-4 text-center">
                            <h4 class="fw-bold mb-3">Hasil Analisis</h4>

                            <div class="mb-4">
                                <h5 class="text-muted mb-1">Bentuk Wajah Anda:</h5>
                                <h2 class="text-gold fw-bold text-uppercase">{{ session('hasil_analisis')['bentuk_wajah'] }}
                                </h2>
                                <span class="badge bg-success">Akurasi AI:
                                    {{ session('hasil_analisis')['akurasi_sistem'] }}%</span>
                            </div>

                            <hr>

                            <div class="mt-4 text-start">
                                <h5 class="fw-bold mb-3"><i class="fas fa-cut me-2"></i>Rekomendasi Potongan:</h5>
                                <ul class="list-group list-group-flush bg-transparent">
                                    @foreach (session('hasil_analisis')['rekomendasi'] as $rek)
                                        <li class="list-group-item bg-transparent"><i
                                                class="fas fa-check text-success me-2"></i> {{ $rek }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs@latest"></script>
    <script>
        const CLASS_NAMES = ['Heart', 'Oblong', 'Oval', 'Round', 'Square'];
        let aiModel = null;

        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('preview');
                output.src = reader.result;
                output.classList.remove('d-none');
            }
            reader.readAsDataURL(event.target.files[0]);
        }

        async function loadModel() {
            try {
                aiModel = await tf.loadGraphModel('{{ asset("ai_model/model.json") }}');
                const btn = document.getElementById('btn-analisis');
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-magic me-2"></i> Analisis Bentuk Wajah';
            } catch (error) {
                console.error("DETAIL ERROR AI:", error);
                alert("Gagal memuat AI: " + error.message);
            }
        }

        loadModel();

        document.getElementById('form-ai-rekomendasi').addEventListener('submit', async function(event) {
            event.preventDefault();

            const imgElement = document.getElementById('preview');
            if (imgElement.classList.contains('d-none')) {
                alert("Tunggu gambar muncul terlebih dahulu.");
                return;
            }

            const btn = document.getElementById('btn-analisis');
            const textAsli = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> AI Sedang Menganalisis...';
            btn.disabled = true;

            try {
                let tensor = tf.browser.fromPixels(imgElement)
                    .resizeNearestNeighbor([224, 224])
                    .toFloat()
                    .expandDims();
                tensor = tensor.div(255.0);

                const predictions = await aiModel.predict(tensor).data();

                let bestIdx = 0;
                let highestConf = 0;
                for (let i = 0; i < predictions.length; i++) {
                    if (predictions[i] > highestConf) {
                        highestConf = predictions[i];
                        bestIdx = i;
                    }
                }

                const bentukWajah = CLASS_NAMES[bestIdx];
                const akurasi = (highestConf * 100).toFixed(2);

                kirimKeBackend(bentukWajah, akurasi);
            } catch (error) {
                alert("Terjadi kesalahan saat menganalisis gambar.");
                btn.innerHTML = textAsli;
                btn.disabled = false;
            }
        });

        function kirimKeBackend(bentukWajah, akurasi) {
            fetch("{{ route('rekomendasi.process') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        bentuk_wajah: bentukWajah,
                        akurasi_sistem: akurasi
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        window.location.reload();
                    } else {
                        alert("Gagal mencatat ke server.");
                    }
                })
                .catch(error => {
                    alert("Gagal menghubungi server.");
                });
        }
    </script>
@endsection
