@extends('components.main')

@section('title', $settings->name_website)

@section('page', $page)

@section('content')
    <h1 class="text-4xl font-bold">{{ $page }}</h1>

    <div class="mt-6">
        <a href="{{ route('barang_masuk.index') }}" class="text-[#5CB8E4] hover:text-[#3289B7]">Kembali ke Daftar Barang Masuk</a>

        <form action="{{ route('barang_masuk.update',$barang_masuk->id) }}" method="post" class="mt-6 bg-white p-6 rounded-lg shadow-lg">
            @csrf
            @method('put')

            <div class="mb-4">
                <label for="barang_id" class="block text-gray-700 font-semibold">Nama Barang</label>
                <select name="barang_id" id="barang_id" class="w-full p-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#5CB8E4]">
                    <option value="">-- Pilih Barang --</option>
                    @foreach($barangs as $barang)
                        <option value="{{ $barang->id }}" {{ old('barang_id', $barang_masuk->barang_id) == $barang->id ? 'selected' : '' }}>
                            {{ $barang->name_barang }}
                        </option>
                    @endforeach
                </select>
                @error('barang_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="jumlah" class="block text-gray-700 font-semibold">Jumlah</label>
                <input type="text" name="jumlah" value="{{ old('jumlah', $barang_masuk->jumlah ) }}" id="jumlah" class="w-full p-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#5CB8E4]">
                @error('jumlah')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="keterangan" class="block text-gray-700 font-semibold">Keterangan</label>
                <textarea name="keterangan" id="keterangan" rows="4" class="w-full p-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#5CB8E4]">{{ old('keterangan', $barang_masuk->keterangan) }}</textarea>
                @error('keterangan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>  

            <div class="mb-4">
                <label for="tanggal_masuk" class="block text-gray-700 font-semibold">Tanggal Masuk</label>
                <input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk', $barang_masuk->tanggal_masuk) }}" id="tanggal_masuk" class="w-full p-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#5CB8E4]">
                @error('tanggal_masuk')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="supplier_id" class="block text-gray-700 font-semibold">Supplier</label>
                <select name="supplier_id" id="supplier_id" class="w-full p-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#5CB8E4]">
                    <option value="">-- Pilih Supplier --</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ old('supplier_id', $barang_masuk->supplier_id) == $supplier->id ? 'selected' : '' }}>
                            {{ $supplier->name_supplier }}
                        </option>
                    @endforeach
                </select>
                @error('supplier_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-[#5CB8E4] hover:bg-[#3289B7] text-white p-3 rounded-lg font-semibold transition duration-200">
                {{ $page }}
            </button>
        </form>
    </div>
@endsection
