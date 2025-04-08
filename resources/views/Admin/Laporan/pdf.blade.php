<!DOCTYPE html>
<html>
<head>
    <title>Laporan PDF Inventaris</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 10pt;
            margin: 30px;
        }
        h1, h3 {
            text-align: center;
            margin-bottom: 10px;
        }
        p {
            margin: 5px 0;
        }
        .section {
            margin-top: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #999;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .logo-wrapper {
            text-align: center;
            margin-bottom: 10px;
        }
        .logo {
            width: 80px;
            height: auto;
        }
    </style>
</head>
<body>

    {{-- Logo Sekolah --}}
    @if($settings->logo)
    <div class="logo-wrapper">
        <img src="{{ public_path('storage/img/' . $settings->logo) }}" alt="Logo Sekolah" class="logo">
    </div>
    @endif

    <h1>Laporan Inventaris Sekolah</h1>

    {{-- Data Barang --}}
    <div class="section">
        <h3>Data Barang</h3>
        <p>Total Barang: <strong>{{ $totalBarang }}</strong> |
           Baik: <strong>{{ $barangBaik }}</strong> |
           Rusak: <strong>{{ $barangRusak }}</strong> |
           Hilang: <strong>{{ $barangHilang }}</strong></p>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Jumlah</th>
                    <th>Kondisi</th>
                    <th>Stok Minimum</th>
                    <th>Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($barangs as $barang)
                <tr>
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

    {{-- Peminjaman --}}
    <div class="section">
        <h3>Laporan Peminjaman</h3>
        <p>Total Dipinjam: <strong>{{ $totalDipinjam }}</strong> |
           Dikembalikan: <strong>{{ $totalDikembalikan }}</strong> |
           Hilang: <strong>{{ $totalHilang }}</strong></p>

        <table>
            <thead>
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
                @foreach($peminjamans as $peminjaman)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $peminjaman->peminjam->name_peminjam }}</td>
                    <td>{{ $peminjaman->barang->name_barang }}</td>
                    <td>{{ $peminjaman->jumlah }}</td>
                    <td>{{ $peminjaman->status }}</td>
                    <td>{{ $peminjaman->tanggal_pinjam }}</td>
                    <td>{{ $peminjaman->tanggal_kembali ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Barang Masuk --}}
    <div class="section">
        <h3>Laporan Barang Masuk</h3>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Barang</th>
                    <th>Jumlah</th>
                    <th>Tanggal Masuk</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($barangMasuks as $masuk)
                <tr>
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

    {{-- Barang Keluar --}}
    <div class="section">
        <h3>Laporan Barang Keluar</h3>
        <table>
            <thead>
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
                @foreach($barangKeluars as $keluar)
                <tr>
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

</body>
</html>
