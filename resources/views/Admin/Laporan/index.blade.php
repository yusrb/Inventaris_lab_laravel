@extends('components.main')

@section('title', $settings->name_website)

@section('page', $page)

@section('styles')
    <style>
    @media print {
        .filter-section,
        .sidebar,
        .no-print,
        #sidebar,
        #navbar {
            display: none;
        }

        .container {
            width: 100%;
            padding: 0;
        }

        body {
            font-size: 10pt;
            line-height: 1.4;
        }

        table {
            width: 100%;
            page-break-inside: auto;
        }

        th, td {
            font-size: 10pt;
            padding: 4px;
            border: 1px solid #ccc;
        }

        h1 {
            page-break-before: auto;
            page-break-inside: avoid;
        }

        h3 {
            page-break-before: auto;
            page-break-inside: avoid;
        }

        .filter-section {
            display: none;
        }

        .page {
            page-break-before: always;
        }

        .content-section {
            page-break-before: auto;
        }
    }
    </style>
@endsection

@section('content')
    <div class="container mx-auto mt-10 px-4">
        <h1 class="text-3xl font-bold text-center mb-6">Laporan Peminjaman, Barang Masuk, dan Barang Keluar</h1>

        <div class="filter-section">
            <form method="GET" action="{{ route('laporan.index') }}" class="mb-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="col-span-1">
                        <input type="date" name="tanggal_start" class="w-full p-2 border rounded-md shadow-sm" placeholder="Tanggal Mulai" value="{{ request('tanggal_start') }}">
                    </div>
                    <div class="col-span-1">
                        <input type="date" name="tanggal_end" class="w-full p-2 border rounded-md shadow-sm" placeholder="Tanggal Selesai" value="{{ request('tanggal_end') }}">
                    </div>
                    <div class="col-span-1">
                        <select name="filter_by" class="w-full p-2 border rounded-md shadow-sm">
                            <option value="">Filter Berdasarkan</option>
                            <option value="hari" {{ request('filter_by') == 'hari' ? 'selected' : '' }}>Hari Ini</option>
                            <option value="bulan" {{ request('filter_by') == 'bulan' ? 'selected' : '' }}>Bulan Ini</option>
                            <option value="tahun" {{ request('filter_by') == 'tahun' ? 'selected' : '' }}>Tahun Ini</option>
                        </select>
                    </div>
                    <div class="col-span-1 flex items-center justify-center">
                        <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-md shadow-md hover:bg-blue-600">Filter</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Laporan Peminjaman -->
        <h3 class="text-xl font-semibold mb-4">Laporan Peminjaman</h3>
        <p>Total Peminjaman Dipinjam: <span class="font-bold">{{ $totalDipinjam }}</span></p>
        <p>Total Peminjaman Dikembalikan: <span class="font-bold">{{ $totalDikembalikan }}</span></p>
        <p>Total Peminjaman Hilang: <span class="font-bold">{{ $totalHilang }}</span></p>

        <table class="table-auto w-full mt-4 border-collapse">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border text-left">No</th>
                    <th class="px-4 py-2 border text-left">Peminjam</th>
                    <th class="px-4 py-2 border text-left">Barang</th>
                    <th class="px-4 py-2 border text-left">Jumlah</th>
                    <th class="px-4 py-2 border text-left">Status</th>
                    <th class="px-4 py-2 border text-left">Tanggal Pinjam</th>
                    <th class="px-4 py-2 border text-left">Tanggal Kembali</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($peminjamans as $peminjaman)
                    <tr class="odd:bg-gray-50">
                        <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 border">{{ $peminjaman->peminjam->name_peminjam }}</td>
                        <td class="px-4 py-2 border">{{ $peminjaman->barang->name_barang }}</td>
                        <td class="px-4 py-2 border">{{ $peminjaman->jumlah }}</td>
                        <td class="px-4 py-2 border">{{ $peminjaman->status }}</td>
                        <td class="px-4 py-2 border">{{ $peminjaman->tanggal_pinjam }}</td>
                        <td class="px-4 py-2 border">{{ $peminjaman->tanggal_kembali ?? 'Belum Kembali' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Laporan Barang Masuk -->
        <h3 class="text-xl font-semibold mt-10 mb-4">Laporan Barang Masuk</h3>
        <table class="table-auto w-full mt-4 border-collapse">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border text-left">No</th>
                    <th class="px-4 py-2 border text-left">Barang</th>
                    <th class="px-4 py-2 border text-left">Jumlah</th>
                    <th class="px-4 py-2 border text-left">Tanggal Masuk</th>
                    <th class="px-4 py-2 border text-left">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($barangMasuks as $barangMasuk)
                    <tr class="odd:bg-gray-50">
                        <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 border">{{ $barangMasuk->barang->name_barang }}</td>
                        <td class="px-4 py-2 border">{{ $barangMasuk->jumlah }}</td>
                        <td class="px-4 py-2 border">{{ $barangMasuk->tanggal_masuk }}</td>
                        <td class="px-4 py-2 border">{{ $barangMasuk->keterangan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Laporan Barang Keluar -->
        <h3 class="text-xl font-semibold mt-10 mb-4">Laporan Barang Keluar</h3>
        <table class="table-auto w-full mt-4 border-collapse">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border text-left">No</th>
                    <th class="px-4 py-2 border text-left">Barang</th>
                    <th class="px-4 py-2 border text-left">Jumlah</th>
                    <th class="px-4 py-2 border text-left">Tanggal Keluar</th>
                    <th class="px-4 py-2 border text-left">Penerima</th>
                    <th class="px-4 py-2 border text-left">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($barangKeluars as $barangKeluar)
                    <tr class="odd:bg-gray-50">
                        <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 border">{{ $barangKeluar->barang->name_barang }}</td>
                        <td class="px-4 py-2 border">{{ $barangKeluar->jumlah }}</td>
                        <td class="px-4 py-2 border">{{ $barangKeluar->tanggal_keluar }}</td>
                        <td class="px-4 py-2 border">{{ $barangKeluar->penerima }}</td>
                        <td class="px-4 py-2 border">{{ $barangKeluar->keterangan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Cetak Laporan-->
        <div class="mt-6 text-center no-print">
            <a href="#" class="inline-block bg-green-500 text-white px-6 py-2 rounded-md shadow-md hover:bg-green-600" onclick="window.print()">Cetak Laporan</a>
        </div>
    </div>
@endsection
