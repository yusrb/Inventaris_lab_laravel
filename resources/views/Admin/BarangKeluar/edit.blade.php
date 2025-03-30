@extends('components.main')

@section('title', $settings->name_website)

@section('page', 'Edit Barang Keluar')

@section('content')
    <h1 class="text-4xl font-bold">Edit Barang Keluar</h1>

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
        <h2 class="text-2xl font-semibold mb-3">Edit Barang Keluar</h2>

        <form action="{{ route('barang_keluar.update', $barangKeluar->id) }}" method="post">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="barang_id" class="block text-gray-700 font-semibold">Nama Barang</label>
                <select name="barang_id" id="barang_id" class="w-full p-3 mt-2 border border-gray-300 rounded-lg">
                    @foreach($barangs as $barang)
                        <option value="{{ $barang->id }}" {{ $barangKeluar->barang_id == $barang->id ? 'selected' : '' }}>
                            {{ $barang->name_barang }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="penerima" class="block text-gray-700 font-semibold">Penerima</label>
                <input type="text" name="penerima" id="penerima" value="{{ $barangKeluar->penerima }}"
                    class="w-full p-3 mt-2 border border-gray-300 rounded-lg">
            </div>

            <div class="mb-4">
                <label for="jumlah" class="block text-gray-700 font-semibold">Jumlah</label>
                <input type="number" name="jumlah" id="jumlah" value="{{ $barangKeluar->jumlah }}"
                    class="w-full p-3 mt-2 border border-gray-300 rounded-lg">
            </div>

            <div class="mb-4">
                <label for="tanggal_keluar" class="block text-gray-700 font-semibold">Tanggal Keluar</label>
                <input type="date" name="tanggal_keluar" id="tanggal_keluar" value="{{ $barangKeluar->tanggal_keluar }}"
                    class="w-full p-3 mt-2 border border-gray-300 rounded-lg">
            </div>

            <div class="mb-4">
                <label for="keterangan" class="block text-gray-700 font-semibold">Keterangan</label>
                <textarea name="keterangan" id="keterangan" rows="4"
                    class="w-full p-3 mt-2 border border-gray-300 rounded-lg">{{ $barangKeluar->keterangan }}</textarea>
            </div>

            <div class="mb-4">
                <label for="supplier_id" class="block text-gray-700 font-semibold">Supplier</label>
                <select name="supplier_id" id="supplier_id" class="w-full p-3 mt-2 border border-gray-300 rounded-lg">
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ $barangKeluar->supplier_id == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->name_supplier }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="w-full bg-[#5CB8E4] hover:bg-[#3289B7] text-white p-3 rounded-lg font-semibold transition duration-200">
                Update Barang Keluar
            </button>
        </form>
    </div>
@endsection