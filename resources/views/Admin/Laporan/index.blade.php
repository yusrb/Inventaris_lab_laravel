@extends('components.main')

@section('title', $settings->name_website)
@section('page', $page)

@section('styles')
<style>
    @media print {
        .filter-section, .sidebar, .no-print, #sidebar, #navbar {
            display: none !important;
        }
        .container {
            width: 100% !important;
            padding: 0 !important;
        }
        body {
            font-size: 10pt;
            line-height: 1.4;
        }
        table {
            width: 100%;
            page-break-inside: auto;
            border-collapse: collapse;
        }
        th, td {
            font-size: 10pt;
            padding: 6px;
            border: 1px solid #ccc;
        }
        h1, h3 {
            page-break-inside: avoid;
        }
        .page {
            page-break-before: always;
        }
    }
</style>
@endsection

@section('content')
<div class="container mx-auto mt-10 px-4">
    <!-- Judul -->
    <h1 class="text-3xl font-bold text-center mb-8">Laporan Inventaris Sekolah</h1>

    <!-- Filter -->
    <div class="filter-section mb-8">
        <form method="GET" action="{{ route('laporan.index') }}">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <input type="date" name="tanggal_start" class="p-2 border rounded-md w-full" value="{{ request('tanggal_start') }}">
                <input type="date" name="tanggal_end" class="p-2 border rounded-md w-full" value="{{ request('tanggal_end') }}">
                <select name="filter_by" class="p-2 border rounded-md w-full">
                    <option value="">Filter Berdasarkan</option>
                    <option value="hari" {{ request('filter_by') == 'hari' ? 'selected' : '' }}>Hari Ini</option>
                    <option value="bulan" {{ request('filter_by') == 'bulan' ? 'selected' : '' }}>Bulan Ini</option>
                    <option value="tahun" {{ request('filter_by') == 'tahun' ? 'selected' : '' }}>Tahun Ini</option>
                </select>
                <div class="flex gap-2">
                    <a href="{{ route('laporan.index') }}" class="w-full bg-gray-400 text-white p-2 rounded-md text-center">Reset</a>
                    <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded-md">Terapkan</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Laporan Data Barang -->
    <div class="mb-12">
        <h3 class="text-xl font-semibold mb-2">Laporan Data Barang</h3>
        <div class="mb-4 space-y-1">
            <p>Total Seluruh Barang: <strong>{{ $totalBarang }}</strong></p>
            <p>Barang Baik: <strong>{{ $barangBaik }}</strong></p>
            <p>Barang Rusak: <strong>{{ $barangRusak }}</strong></p>
            <p>Barang Hilang: <strong>{{ $barangHilang }}</strong></p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full bg-white shadow-sm rounded-md">
                <thead class="bg-gray-100">
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                        <th>Kondisi</th>
                        <th>Stok Minimum</th>
                        <th>Deskripsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($barangs as $barang)
                    <tr class="odd:bg-gray-50">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $barang->kode_barang }}</td>
                        <td>{{ $barang->name_barang }}</td>
                        <td>{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                        <td>{{ $barang->jumlah }}</td>
                        <td>{{ $barang->kondisi }}</td>
                        <td>{{ $barang->stok_minimum }}</td>
                        <td>{{ $barang->deskripsi }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Laporan Peminjaman -->
    <div class="mb-12">
        <h3 class="text-xl font-semibold mb-2">Laporan Peminjaman</h3>
        <div class="mb-4 space-y-1">
            <p>Total Dipinjam: <strong>{{ $totalDipinjam }}</strong></p>
            <p>Total Dikembalikan: <strong>{{ $totalDikembalikan }}</strong></p>
            <p>Total Hilang: <strong>{{ $totalHilang }}</strong></p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full bg-white shadow-sm rounded-md">
                <thead class="bg-gray-100">
                    <tr>
                        <th>No</th>
                        <th>Peminjam</th>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($peminjamans as $peminjaman)
                    <tr class="odd:bg-gray-50">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $peminjaman->peminjam->name_peminjam }}</td>
                        <td>{{ $peminjaman->barang->name_barang }}</td>
                        <td>{{ $peminjaman->jumlah }}</td>
                        <td>{{ $peminjaman->status }}</td>
                        <td>{{ $peminjaman->tanggal_pinjam }}</td>
                        <td>{{ $peminjaman->tanggal_kembali ?? 'Belum Kembali' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Laporan Barang Masuk -->
    <div class="mb-12">
        <h3 class="text-xl font-semibold mb-2">Laporan Barang Masuk</h3>
        <div class="overflow-x-auto">
            <table class="w-full bg-white shadow-sm rounded-md">
                <thead class="bg-gray-100">
                    <tr>
                        <th>No</th>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Tanggal Masuk</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($barangMasuks as $masuk)
                    <tr class="odd:bg-gray-50">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $masuk->barang->name_barang }}</td>
                        <td>{{ $masuk->jumlah }}</td>
                        <td>{{ $masuk->tanggal_masuk }}</td>
                        <td>{{ $masuk->keterangan }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Laporan Barang Keluar -->
    <div class="mb-12">
        <h3 class="text-xl font-semibold mb-2">Laporan Barang Keluar</h3>
        <div class="overflow-x-auto">
            <table class="w-full bg-white shadow-sm rounded-md">
                <thead class="bg-gray-100">
                    <tr>
                        <th>No</th>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Tanggal Keluar</th>
                        <th>Penerima</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($barangKeluars as $keluar)
                    <tr class="odd:bg-gray-50">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $keluar->barang->name_barang }}</td>
                        <td>{{ $keluar->jumlah }}</td>
                        <td>{{ $keluar->tanggal_keluar }}</td>
                        <td>{{ $keluar->penerima }}</td>
                        <td>{{ $keluar->keterangan }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tombol Cetak -->
    <div class="mt-6 flex justify-center gap-4 no-print">
        <a href="#" onclick="window.print()" 
        class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 transition-all">
            Cetak Laporan
        </a>

        <a href="{{ route('laporan.export.pdf') }}"
        class="bg-red-600 text-white px-6 py-2 rounded-md hover:bg-red-700 transition-all">
            Download PDF
        </a>
    </div>

</div>
@endsection
