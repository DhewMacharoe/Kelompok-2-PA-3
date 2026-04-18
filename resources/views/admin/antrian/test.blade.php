<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Realtime Antrean</title>
    @vite(['resources/js/app.js'])

    <style>
        body {
            font-family: Arial;
            background: #f3f4f6;
            text-align: center;
        }

        .card {
            background: white;
            margin: 20px auto;
            padding: 20px;
            width: 300px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .status {
            font-weight: bold;
        }

        .selesai {
            color: green;
        }

        .batal {
            color: red;
        }
    </style>
</head>
<body>

    <h1>📢 Daftar Antrean</h1>

    <div id="list-antrian">
        @if($antrian)
            <div class="card" id="antrian-{{ $antrian->id }}">
                <h3>{{ $antrian->nomor_antrian }}</h3>
                <p>{{ $antrian->nama_pelanggan }}</p>
                <p class="status {{ $antrian->status }}" id="status-{{ $antrian->id }}">
                    {{ strtoupper($antrian->status) }}
                </p>
            </div>
        @else
            <p>Tidak ada antrian</p>
        @endif
    </div>

    <script type="module">
        document.addEventListener('DOMContentLoaded', function () {
            window.Echo.channel('Antrian-channel')
                .listen('AntreanUpadate', (e) => {

                    console.log('DATA MASUK:', e);

                    let antrian = e.antrean;
                    let id = antrian.id;
                    let statusEl = document.getElementById('status-' + id);
                    let card = document.getElementById('antrian-' + id);

                    const listAntrian = document.getElementById('list-antrian');

                    if (statusEl && card) {
                        statusEl.innerText = antrian.status.toUpperCase();
                        statusEl.className = 'status ' + antrian.status;

                        if (antrian.status === 'selesai') {
                            card.style.background = '#d1fae5';
                        } else if (antrian.status === 'batal') {
                            card.style.background = '#fee2e2';
                        } else {
                            card.style.background = 'white';
                        }
                    } else {
                        const newCard = document.createElement('div');
                        newCard.className = 'card';
                        newCard.id = 'antrian-' + id;
                        newCard.innerHTML = `
                            <h3>${antrian.nomor_antrian}</h3>
                            <p>${antrian.nama_pelanggan}</p>
                            <p class="status ${antrian.status}" id="status-${id}">
                                ${antrian.status.toUpperCase()}
                            </p>
                        `;
                        listAntrian.innerHTML = '';
                        listAntrian.appendChild(newCard);
                    }
                });
        });
    </script>

</body>
</html>
