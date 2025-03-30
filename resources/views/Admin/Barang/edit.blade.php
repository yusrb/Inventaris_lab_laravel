@extends('components.main')

@section('title', $settings->name_website)

@section('page', $page)

@section('content')
    <h1 class="text-4xl font-bold">{{ $page }}</h1>

    <div class="mt-6">
        <a href="{{ route('barang.index') }}" class="text-[#5CB8E4] hover:text-[#3289B7]">Kembali ke Daftar Barang</a>

        <form action="{{ route('barang.update', $barang->id) }}" method="post" class="mt-6 bg-white p-6 rounded-lg shadow-lg">
            @csrf
            @method('put')

            <div class="mb-4">
                <label for="kode_barang" class="block text-gray-700 font-semibold">Kode Barang</label>
                <input type="text" name="kode_barang" value="{{ old('kode_barang', $barang->kode_barang) }}" id="kode_barang" class="w-full p-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#5CB8E4]">
                @error('kode_barang')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="name_barang" class="block text-gray-700 font-semibold">Nama Barang</label>
                <input type="text" name="name_barang" value="{{ old('name_barang', $barang->name_barang) }}" id="name_barang" class="w-full p-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#5CB8E4]">
                @error('name_barang')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="kategori_id" class="block text-gray-700 font-semibold">Kategori</label>
                <select name="kategori_id" id="kategori_id" class="w-full p-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#5CB8E4]">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ old('kategori_id', $barang->kategori_id) == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->name_kategori }}
                        </option>
                    @endforeach
                </select>
                @error('kategori_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="jumlah" class="block text-gray-700 font-semibold">Jumlah</label>
                <input type="number" name="jumlah" value="{{ old('jumlah', $barang->jumlah) }}" id="jumlah" class="w-full p-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#5CB8E4]">
                @error('jumlah')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="kondisi" class="block text-gray-700 font-semibold">Kondisi</label>
                <select name="kondisi" id="kondisi" class="w-full p-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#5CB8E4]">
                    <option value="Baik" {{ old('kondisi', $barang->kondisi) == 'Baik' ? 'selected' : '' }}>Baik</option>
                    <option value="Rusak" {{ old('kondisi', $barang->kondisi) == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                </select>
                @error('kondisi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="stok_minimum" class="block text-gray-700 font-semibold">Stok Minimum</label>
                <input type="number" name="stok_minimum" value="{{ old('stok_minimum', $barang->stok_minimum) }}" id="stok_minimum" class="w-full p-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#5CB8E4]">
                @error('stok_minimum')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="deskripsi" class="block text-gray-700 font-semibold">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="4" class="w-full p-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#5CB8E4]">{{ old('deskripsi', $barang->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>  

            <button type="submit" class="w-full bg-[#5CB8E4] hover:bg-[#3289B7] text-white p-3 rounded-lg font-semibold transition duration-200">
                Update Barang
            </button>
        </form>
    </div>
@endsection
