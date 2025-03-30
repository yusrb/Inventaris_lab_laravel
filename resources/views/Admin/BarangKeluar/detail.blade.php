@extends('components.main')

@section('title', 'Detail Barang Keluar')

@section('page', 'Detail Barang Keluar')

@section('content')
    <div class="bg-gradient-to-br from-[#4DA8DA] to-[#A7D6ED] text-white p-6 rounded-lg shadow-lg" data-aos="fade-down" data-aos-duration="3000">
        <h1 class="text-2xl font-bold">Detail Barang Keluar</h1>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg mt-4" data-aos="fade-up" data-aos-duration="1500">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded-lg mt-4" data-aos="fade-up" data-aos-duration="1500">
            {{ session('error') }}
        </div>
    @endif

    <div class="mt-6 bg-white p-6 rounded-lg shadow-lg" data-aos="fade-up" data-aos-duration="1500">
        <table class="w-full table-auto border-collapse border border-gray-300">
            <thead class="bg-[#4DA8DA] text-white">
                <tr>
                    <th class="px-4 py-2 border">No</th>
                    <th class="px-4 py-2 border">Nama Barang</th>
                    <th class="px-4 py-2 border">Jumlah</th>
                    <th class="px-4 py-2 border">Penerima</th>
                    <th class="px-4 py-2 border">Keterangan</th>
                    <th class="px-4 py-2 border">Tanggal Keluar</th>
                    <th class="px-4 py-2 border text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($barang_keluar_list as $index => $barang_keluar)
                    <tr class="border hover:bg-gray-100">
                        <td class="px-4 py-2 border text-center">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 border">{{ $barang_keluar->barang->name_barang }}</td>
                        <td class="px-4 py-2 border text-center">{{ $barang_keluar->jumlah }}</td>
                        <td class="px-4 py-2 border">{{ $barang_keluar->penerima }}</td>
                        <td class="px-4 py-2 border">{{ $barang_keluar->keterangan }}</td>
                        <td class="px-4 py-2 border text-center">{{ $barang_keluar->tanggal_keluar }}</td>
                        <td class="px-4 py-2 border text-center">
                            <form action="{{ route('barang_keluar.cancel', $barang_keluar->id) }}" method="post" onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white px-3 py-1 rounded-lg transition shadow-md text-sm">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6 flex justify-between items-center" data-aos="fade-up" data-aos-duration="1500">
        <a href="{{ route('barang_keluar.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition shadow-md">
            Kembali
        </a>

        <form action="{{ route('barang_keluar.cancel_all', ['ids' => implode(',', $barang_keluar_list->pluck('id')->toArray())]) }}" method="post" onsubmit="return confirm('Yakin ingin menghapus seluruh transaksi ini? Semua barang dalam transaksi akan dihapus.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 hover:bg-red-800 text-white px-4 py-2 rounded-lg transition shadow-md">
                Hapus Seluruh Transaksi
            </button>
        </form>
    </div>
@endsection