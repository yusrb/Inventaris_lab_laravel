@extends('components.main')

@section('title', $settings->name_website)

@section('page', $page)

@section('content')
    <h1 class="text-4xl font-bold">{{ $page }}</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg mt-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded-lg mt-4">
            {{ session('error') }}
        </div>
    @endif

    <a href="{{ route('barang_keluar.index') }}" class="text-[#5CB8E4] hover:text-[#3289B7] underline ml-1 relative top-[7px]">
        Kembali ke Daftar Barang Keluar
    </a>

    <div class="mt-6 bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold mb-3 ml-2">Keranjang Barang Keluar</h2>
        <hr class="relative bottom-[6.3px]">

        @php
            $cart = session()->get('cart_keluar', []);
        @endphp

        @if(empty($cart))
            <p class="text-lg font-semibold text-gray-600 ml-3">Keranjang masih kosong!</p>
        @else
            <table class="w-full border-collapse border border-gray-300 mt-4 shadow-md">
                <thead>
                    <tr class="bg-[#5CB8E4] text-white text-left">
                        <th class="border border-gray-300 p-3">Nama Barang</th>
                        <th class="border border-gray-300 p-3">Penerima</th>
                        <th class="border border-gray-300 p-3">Jumlah</th>
                        <th class="border border-gray-300 p-3">Tanggal Keluar</th>
                        <th class="border border-gray-300 p-3">Keterangan</th>
                        <th class="border border-gray-300 p-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $index => $item)
                        <tr class="bg-white transition">
                            <td class="border border-gray-300 p-3">{{ $item['name_barang'] }}</td>
                            <td class="border border-gray-300 p-3">{{ $item['penerima'] }}</td>
                            <td class="border border-gray-300 p-3">{{ $item['jumlah'] }}</td>
                            <td class="border border-gray-300 p-3">{{ $item['tanggal_keluar'] }}</td>
                            <td class="border border-gray-300 p-3">{{ $item['keterangan'] }}</td>
                            <td class="border border-gray-300 p-3">
                                <form action="{{ route('barang_keluar.removeFromCart', $index) }}" method="post">
                                    @csrf
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4 flex gap-3">
                <form action="{{ route('barang_keluar.store') }}" method="post" class="flex-grow">
                    @csrf
                    <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white p-3 rounded-lg font-semibold transition duration-200">
                        Simpan Semua Barang Keluar
                    </button>
                </form>
            </div>
        @endif
    </div>

    <div class="mt-6 bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold mb-3">Tambah Barang Keluar</h2>

        <form action="{{ route('barang_keluar.addToCart') }}" method="post">
            @csrf

            <div class="mb-4">
                <label for="barang_id" class="block text-gray-700 font-semibold">Nama Barang</label>
                <select name="barang_id" id="barang_id" class="w-full p-3 mt-2 border border-gray-300 rounded-lg">
                    <option value="">-- Pilih Barang --</option>
                    @foreach($barangs as $barang)
                        <option value="{{ $barang->id }}">{{ $barang->name_barang }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="penerima" class="block text-gray-700 font-semibold">Penerima</label>
                <input type="text" name="penerima" id="penerima" class="w-full p-3 mt-2 border border-gray-300 rounded-lg">
            </div>

            <div class="mb-4">
                <label for="jumlah" class="block text-gray-700 font-semibold">Jumlah</label>
                <input type="number" name="jumlah" id="jumlah" class="w-full p-3 mt-2 border border-gray-300 rounded-lg">
            </div>

            <div class="mb-4">
                <label for="tanggal_keluar" class="block text-gray-700 font-semibold">Tanggal Keluar</label>
                <input type="date" name="tanggal_keluar" id="tanggal_keluar" class="w-full p-3 mt-2 border border-gray-300 rounded-lg">
            </div>

            <div class="mb-4">
                <label for="keterangan" class="block text-gray-700 font-semibold">Keterangan</label>
                <textarea name="keterangan" id="keterangan" rows="4" class="w-full p-3 mt-2 border border-gray-300 rounded-lg"></textarea>
            </div>

            <div class="mb-4">
                <label for="supplier_id" class="block text-gray-700 font-semibold">Supplier</label>
                <select name="supplier_id" id="supplier_id" class="w-full p-3 mt-2 border border-gray-300 rounded-lg">
                    <option value="">-- Pilih Supplier --</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name_supplier }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="w-full bg-[#5CB8E4] hover:bg-[#3289B7] text-white p-3 rounded-lg font-semibold transition duration-200">
                Tambah ke Keranjang
            </button>
        </form>
    </div>
@endsection