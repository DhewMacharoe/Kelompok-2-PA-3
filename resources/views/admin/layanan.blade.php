<!DOCTYPE html>
<html>

<head>
    <title>Layanan</title>
</head>

<body>
    <h1>Layanan Arga Home's</h1>

    <h2>Barber</h2>
    @forelse($barber as $item)
        <div style="margin-bottom: 20px;">
            <p><strong>{{ $item->nama }}</strong></p>
            <p>Harga: Rp{{ number_format($item->harga, 0, ',', '.') }}</p>
            <p>Estimasi: {{ $item->estimasi_waktu ?? '-' }}</p>
            <p>Deskripsi: {{ $item->deskripsi }}</p>

        </div>
    @empty
        <p>Belum ada layanan barber.</p>
    @endforelse

    <h2>Kafe</h2>
    @forelse($kafe as $item)
        <div style="margin-bottom: 20px;">
            <p><strong>{{ $item->nama }}</strong></p>
            <p>Harga: Rp{{ number_format($item->harga, 0, ',', '.') }}</p>
            <p>Deskripsi: {{ $item->deskripsi }}</p>

        </div>
    @empty
        <p>Belum ada menu kafe.</p>
    @endforelse
</body>

</html>
