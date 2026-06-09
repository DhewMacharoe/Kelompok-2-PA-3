@extends('admin.layouts.app')

@section('title', 'Rekap Pemasukan')

@push('styles')
    @include('admin.galeri.style-index')
    <style>
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .stat-box {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border: 1px solid #eee;
            position: relative;
            overflow: hidden;
        }

        .stat-box::before {
            content: '';
            position: absolute;
            top: 0; left: 0; bottom: 0;
            width: 4px;
            background: #2F80ED;
        }

        .stat-box.primary-big::before { background: #2F80ED; }
        .stat-box.accent::before { background: #2C3E50; }
        .stat-box.info::before { background: #0ea5e9; }

        .stat-label {
            font-size: 12px;
            font-weight: 700;
            color: #7f8c8d;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 800;
            color: #2C3E50;
            margin-bottom: 5px;
        }
        
        .stat-value-sm {
            font-size: 18px;
        }

        .stat-sub {
            font-size: 12px;
            color: #95a5a6;
        }

        .layanan-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            justify-content: center;
        }

        .layanan-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            font-size: 12px;
            color: #495057;
            font-weight: 600;
        }

        .text-end {
            text-align: right !important;
        }

        .custom-table tfoot tr {
            background-color: #f8fbff;
            border-top: 2px solid #2C3E50;
        }

        .custom-table tfoot td {
            font-weight: 800;
            color: #2C3E50;
        }

        @media (max-width: 768px) {
            .stat-grid {
                grid-template-columns: 1fr;
            }
            .text-end {
                text-align: left !important;
            }
            .layanan-badges {
                justify-content: flex-end;
            }
            
            .custom-table tfoot {
                display: block;
            }
            .custom-table tfoot tr {
                display: block;
                padding: 10px;
            }
            .custom-table tfoot td {
                display: flex;
                justify-content: space-between;
                padding: 5px 0;
                border: none;
            }
            .custom-table tfoot td::before {
                content: attr(data-label);
                font-weight: 600;
            }
            .hide-on-mobile {
                display: none !important;
            }
        }
    </style>
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

    <div class="main-container" data-total-transaksi="{{ $totalTransaksi }}">
        
        <div class="filter-bar" role="tablist">
            <a href="{{ route('admin.rekap', ['periode' => 'hari']) }}" class="filter-btn {{ $hariActive }}">Hari Ini</a>
            <a href="{{ route('admin.rekap', ['periode' => 'minggu']) }}" class="filter-btn {{ $mingguActive }}">Minggu Ini</a>
            <a href="{{ route('admin.rekap', ['periode' => 'bulan']) }}" class="filter-btn {{ $bulanActive }}">Bulan Ini</a>
            <a href="{{ route('admin.rekap', ['periode' => 'tahun']) }}" class="filter-btn {{ $tahunActive }}">Tahun Ini</a>
        </div>

        <form method="GET" action="{{ route('admin.rekap') }}" class="search-filter-wrap" style="align-items: flex-end; margin-bottom: 20px;">
            <input type="hidden" name="periode" value="custom">

            <div style="flex: 1; min-width: 150px;">
                <label for="dari" style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px; color: #2C3E50;">Dari</label>
                <input type="date" id="dari" name="dari" class="search-filter-input" style="width: 100%;" value="{{ request('dari', $mulai->format('Y-m-d')) }}">
            </div>

            <div style="flex: 1; min-width: 150px;">
                <label for="sampai" style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px; color: #2C3E50;">Sampai</label>
                <input type="date" id="sampai" name="sampai" class="search-filter-input" style="width: 100%;" value="{{ request('sampai', $selesai->format('Y-m-d')) }}">
            </div>

            <div style="flex: 1; min-width: 150px;">
                <label for="bulan_pilih" style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 14px; color: #2C3E50;">Atau Pilih Bulan</label>
                <input type="month" id="bulan_pilih" name="bulan_pilih" class="search-filter-input" style="width: 100%;" value="{{ request('bulan_pilih') }}" placeholder="YYYY-MM">
            </div>

            <button type="submit" class="btn-tambah" style="margin-bottom: 0; height: 43px; padding: 0 20px;">Terapkan</button>
        </form>

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
                    {{ $mulai->translatedFormat('d M') }} — {{ $selesai->translatedFormat('d M Y') }}
                </div>
            </div>
        </div>

        <div class="search-filter-wrap">
            <label for="tableSearch">Cari Transaksi:</label>
            <input type="text" id="tableSearch" class="search-filter-input" placeholder="Masukkan nama atau nomor antrean..." oninput="filterTable(this.value)">
        </div>

        <div class="table-container">
            <table class="custom-table" id="rekapTable">
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
                        <tr>
                            <td data-label="Pelanggan">
                                <div><strong>{{ $antrean->nama_pelanggan }}</strong></div>
                                <div style="font-size: 12px; color: #7f8c8d;">{{ $antrean->nomor_antrean_seq }}</div>
                            </td>
                            <td data-label="Layanan">
                                <div class="layanan-badges">
                                    @foreach ($layanans as $layanan)
                                        <span class="layanan-badge">{{ $layanan->nama }}</span>
                                    @endforeach
                                </div>
                            </td>
                            <td data-label="Total Harga" class="text-end">
                                <span style="font-weight: 700;">{{ $formatter($totalAntrean) }}</span>
                            </td>
                            <td data-label="Tanggal Selesai">
                                <div>{{ $antrean->updated_at->translatedFormat('d M Y') }}</div>
                                <div style="font-size: 12px; color: #7f8c8d;">{{ $antrean->updated_at->format('H:i') }} WIB</div>
                            </td>
                        </tr>
                    @empty
                        <tr class="empty-row-row">
                            <td colspan="4" class="empty-row-cell" style="padding: 40px; color: #999;">
                                Tidak ada transaksi selesai pada periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

                @if ($antreans->count())
                    <tfoot>
                        <tr>
                            <td colspan="2" class="text-end hide-on-mobile">Total Keseluruhan</td>
                            <td data-label="Total Keseluruhan" class="text-end">{{ $formatter($totalPemasukan) }}</td>
                            <td class="hide-on-mobile"></td>
                        </tr>
                    </tfoot>
                @endif
            </table>
            <div id="noSearchResult" style="display: none; text-align: center; padding: 20px; color: #7f8c8d;">Tidak ada hasil yang cocok dengan pencarian Anda.</div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const totalTransaksi = Number(document.querySelector('.main-container')?.dataset.totalTransaksi || 0);

        function filterTable(query) {
            const rows = document.querySelectorAll('#rekapTbody tr:not(.empty-row-row)');
            const noRes = document.getElementById('noSearchResult');
            const q = query.trim().toLowerCase();
            let visible = 0;

            rows.forEach((row) => {
                const text = row.innerText.toLowerCase();
                const match = !q || text.includes(q);
                row.style.display = match ? '' : 'none';

                if (match) {
                    visible += 1;
                }
            });

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
