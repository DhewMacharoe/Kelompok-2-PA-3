@extends('admin.layouts.app')

@section('title', 'Rekap Pemasukan')

@push('styles')
    @include('admin.rekap.style')
@endpush

@section('content')
    @php
        $formatter = fn($nilai) => 'Rp ' . number_format($nilai, 0, ',', '.');
        $totalTransaksi = $antreans->count();
        $hariActive = $periode === 'hari' ? 'active' : '';
        $mingguActive = $periode === 'minggu' ? 'active' : '';
        $bulanActive = $periode === 'bulan' ? 'active' : '';
        $tahunActive = $periode === 'tahun' ? 'active' : '';
        $rataRata = $totalTransaksi > 0 ? $totalPemasukan / $totalTransaksi : 0;
    @endphp

    <div class="rekap-wrap" data-total-transaksi="{{ $totalTransaksi }}">
        <div class="filter-card">
            <div class="filter-label">Filter Periode</div>

            <div class="filter-row">
                <div class="quick-pills">
                    <a href="{{ route('admin.rekap', ['periode' => 'hari']) }}" class="pill {{ $hariActive }}">Hari Ini</a>
                    <a href="{{ route('admin.rekap', ['periode' => 'minggu']) }}" class="pill {{ $mingguActive }}">Minggu
                        Ini</a>
                    <a href="{{ route('admin.rekap', ['periode' => 'bulan']) }}" class="pill {{ $bulanActive }}">Bulan
                        Ini</a>
                    <a href="{{ route('admin.rekap', ['periode' => 'tahun']) }}" class="pill {{ $tahunActive }}">Tahun
                        Ini</a>
                </div>

                <div class="filter-divider"></div>

                <form method="GET" action="{{ route('admin.rekap') }}" class="range-group">
                    <input type="hidden" name="periode" value="custom">

                    <div>
                        <label for="dari">Dari</label>
                        <input type="date" id="dari" name="dari"
                            value="{{ request('dari', $mulai->format('Y-m-d')) }}">
                    </div>

                    <div>
                        <label for="sampai">Sampai</label>
                        <input type="date" id="sampai" name="sampai"
                            value="{{ request('sampai', $selesai->format('Y-m-d')) }}">
                    </div>

                    <div>
                        <label for="bulan_pilih">Atau Pilih Bulan</label>
                        <input type="month" id="bulan_pilih" name="bulan_pilih" value="{{ request('bulan_pilih') }}"
                            placeholder="YYYY-MM">
                    </div>

                    <button type="submit" class="btn-filter-apply">Terapkan</button>
                </form>

                @if ($periode === 'custom' || $periode === 'tahun')
                    <span class="active-range-badge">
                        📅 {{ $mulai->translatedFormat('d M Y') }} — {{ $selesai->translatedFormat('d M Y') }}
                    </span>
                @endif
            </div>
        </div>

        <div class="stat-grid">
            <div class="stat-box primary-big">

                <div class="stat-label">Total Pemasukan</div>
                <div class="stat-value">{{ $formatter($totalPemasukan) }}</div>
                <div class="stat-sub">{{ $labelPeriode }}</div>
            </div>

            <div class="stat-box accent">

                <div class="stat-label">Total Transaksi</div>
                <div class="stat-value">{{ $totalTransaksi }}</div>
                <div class="stat-sub">Antrean selesai</div>
            </div>

            <div class="stat-box info">

                <div class="stat-label">Rata-rata / Transaksi</div>
                <div class="stat-value">{{ $formatter($rataRata) }}</div>
                <div class="stat-sub">Per antrean selesai</div>
            </div>

            <div class="stat-box">

                <div class="stat-label">Rentang Periode</div>
                <div class="stat-value stat-value-sm">{{ ucfirst($labelPeriode) }}</div>
                <div class="stat-sub">
                    {{ $mulai->translatedFormat('d M') }} – {{ $selesai->translatedFormat('d M Y') }}
                </div>
            </div>
        </div>

        <div class="table-card">
            <div class="table-card-header">
                <div class="title">
                    Daftar Transaksi

                </div>

                <div class="tbl-search-wrap">
                    <input type="text" id="tableSearch" placeholder="Cari nama /nomor antrean…"
                        oninput="filterTable(this.value)">
                </div>
            </div>

            <div class="table-scroll">
                <table class="rekap-table" id="rekapTable">
                    <thead>
                        <tr>
                            <th>Pelanggan</th>
                            <th>Layanan</th>
                            <th class="text-end">Total Harga</th>
                            <th>Tanggal Selesai</th>
                        </tr>
                    </thead>

                    <tbody id="rekapTbody">
                        @forelse ($antreans as $antrean)
                            @php
                                $layanans = $antrean->layananUntukRekap();
                                $totalAntrean = $antrean->totalPemasukanRekap();
                            @endphp
                            <tr class="rekap-row">
                                <td data-label="Pelanggan">
                                    <div class="pelanggan-name">{{ $antrean->nama_pelanggan }}</div>
                                    <div class="pelanggan-no">{{ $antrean->nomor_antrean }}</div>
                                </td>
                                <td data-label="Layanan">
                                    <div class="layanan-badges">
                                        @foreach ($layanans as $layanan)
                                            <span class="layanan-badge">{{ $layanan->nama }}</span>
                                        @endforeach
                                    </div>
                                </td>
                                <td data-label="Total Harga" class="text-end">
                                    <span class="harga-cell">{{ $formatter($totalAntrean) }}</span>
                                </td>
                                <td data-label="Tanggal Selesai">
                                    <div class="tanggal-main">{{ $antrean->updated_at->translatedFormat('d M Y') }}</div>
                                    <div class="tanggal-time">{{ $antrean->updated_at->format('H:i') }}</div>
                                </td>
                            </tr>
                        @empty
                            <tr id="emptyRow" class="rekap-empty-row">
                                <td colspan="4" class="rekap-empty-cell">
                                    <div class="empty-state">
                                        <p>Tidak ada transaksi selesai pada periode ini.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                    @if ($antreans->count())
                        <tfoot>
                            <tr>
                                <td colspan="2" class="text-end rekap-total-label">Total Keseluruhan</td>
                                <td class="text-end grand-total">{{ $formatter($totalPemasukan) }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>

            <div id="noSearchResult" class="no-search-result">Tidak ada hasil yang cocok dengan pencarian Anda.</div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const totalTransaksi = Number(document.querySelector('.rekap-wrap')?.dataset.totalTransaksi || 0);

        function filterTable(query) {
            const rows = document.querySelectorAll('#rekapTbody tr');
            const noRes = document.getElementById('noSearchResult');
            const counter = document.getElementById('visibleCount');
            const q = query.trim().toLowerCase();
            let visible = 0;

            rows.forEach((row) => {
                if (!row.id) {
                    const text = row.innerText.toLowerCase();
                    const match = !q || text.includes(q);
                    row.style.display = match ? '' : 'none';

                    if (match) {
                        visible += 1;
                    }
                }
            });

            counter.textContent = q ? visible : totalTransaksi;
            noRes.style.display = (q && visible === 0) ? 'block' : 'none';
        }

        document.getElementById('bulan_pilih')?.addEventListener('change', function() {
            if (!this.value) return;

            const [year, month] = this.value.split('-');
            const firstDay = `${year}-${month}-01`;
            const lastDay = new Date(year, month, 0);
            const day = String(lastDay.getDate()).padStart(2, '0');

            document.getElementById('dari').value = firstDay;
            document.getElementById('sampai').value = `${year}-${month}-${day}`;
        });
    </script>
@endpush
