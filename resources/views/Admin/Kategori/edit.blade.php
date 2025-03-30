@extends('components.main')

@section('title', $settings->name_website)

@section('page', $page)

@section('content')
    <h1 class="text-4xl font-bold">Update Kategori</h1>

    <div class="mt-6">
        <a href="{{ route('kategori.index') }}" class="text-[#5CB8E4] hover:text-[#3289B7]">Kembali ke Daftar Kategori</a>

        <form action="{{ route('kategori.update', $kategori->id) }}" method="post" class="mt-6 bg-white p-6 rounded-lg shadow-lg">
            @csrf
            @method('put')
            <div class="mb-4">
                <label for="name_kategori" class="block text-gray-700 font-semibold">Nama Kategori</label>
                <input type="text" name="name_kategori" value="{{ old('name_kategori', $kategori->name_kategori) }}" id="name_kategori" class="w-full p-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#5CB8E4]">
                @error('name_kategori')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-[#5CB8E4] hover:bg-[#3289B7] text-white p-3 rounded-lg font-semibold transition duration-200">
                Update Kategori
            </button>
        </form>
    </div>
@endsection
