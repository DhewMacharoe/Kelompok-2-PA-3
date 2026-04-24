<!DOCTYPE html>
<html>

<head>
    <title>Layanan</title>
</head>

<body>
    <h1>Layanan Arga's Home</h1>

    <h2>Barber</h2>
    @forelse($barber as $item)
        <div style="margin-bottom: 20px;">
            <p><strong>{{ $item->nama }}</strong></p>
            <p>Harga: Rp{{ number_format($item->harga, 0, ',', '.') }}</p>
            <p>Estimasi: {{ $item->estimasi_waktu ?? '-' }}</p>
            <p>Deskripsi: {{ $item->deskripsi }}</p>

            @if ($item->foto)
                @php
                    // Sementara: dukung URL eksternal dari seeder API gambar.
                    // <img src="{{ asset('storage/' . $item->foto) }}" width="150">
                    $fotoBarber = \Illuminate\Support\Str::startsWith($item->foto, ['http://', 'https://'])
                        ? $item->foto
                        : asset('storage/' . $item->foto);
                @endphp
                <img src="{{ $fotoBarber }}" width="150">
            @endif
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

            @if ($item->foto)
                @php
                    // Sementara: dukung URL eksternal dari seeder API gambar.
                    // <img src="{{ asset('storage/' . $item->foto) }}" width="150">
                    $fotoKafe = \Illuminate\Support\Str::startsWith($item->foto, ['http://', 'https://'])
                        ? $item->foto
                        : asset('storage/' . $item->foto);
                @endphp
                <img src="{{ $fotoKafe }}" width="150">
            @endif
        </div>
    @empty
        <p>Belum ada menu kafe.</p>
    @endforelse
</body>

</html>
