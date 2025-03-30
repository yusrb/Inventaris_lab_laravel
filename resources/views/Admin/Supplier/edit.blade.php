@extends('components.main')

@section('title', $settings->name_website)

@section('page', $page)

@section('content')
    <h1 class="text-4xl font-bold">{{ $page }}</h1>

    <div class="mt-6">
        <a href="{{ route('supplier.index') }}" class="text-[#5CB8E4] hover:text-[#3289B7]">Kembali ke Daftar Supplier</a>

        <form action="{{ route('supplier.update', $supplier->id) }}" method="post" class="mt-6 bg-white p-6 rounded-lg shadow-lg">
            @csrf
            @method('put')
            
            <div class="mb-4">
                <label for="name_supplier" class="block text-gray-700 font-semibold">Nama Supplier</label>
                <input type="text" name="name_supplier" value="{{ old('name_supplier', $supplier->name_supplier) }}" id="name_supplier" class="w-full p-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#5CB8E4]">
                @error('name_supplier')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="kontak" class="block text-gray-700 font-semibold">Kontak</label>
                <input type="tel" name="kontak" value="{{ old('kontak', $supplier->kontak) }}" id="kontak" class="w-full p-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#5CB8E4]">
                @error('kontak')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="mb-4">
                <label for="alamat" class="block text-gray-700 font-semibold">Alamat</label>
                <textarea name="alamat" id="alamat" rows="4" class="w-full p-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#5CB8E4]">{{ old('alamat', $supplier->alamat) }}</textarea>
                @error('alamat')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>            

            <button type="submit" class="w-full bg-[#5CB8E4] hover:bg-[#3289B7] text-white p-3 rounded-lg font-semibold transition duration-200">
                Tambah Supplier
            </button>
        </form>
    </div>
@endsection
