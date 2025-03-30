@extends('components.main')

@section('title', $settings->name_website)

@section('page', $page)

@section('content')
    <h1 class="text-4xl font-bold">Edit Peminjam</h1>

    <div class="mt-6">
        <a href="{{ route('peminjam.index') }}" class="text-[#5CB8E4] hover:text-[#3289B7]">Kembali ke Daftar Peminjam</a>

        <form action="{{ route('peminjam.update', $peminjam->id) }}" method="post" class="mt-6 bg-white p-6 rounded-lg shadow-lg">
            @csrf
            @method('put')
            
            <div class="mb-4">
                <label for="name_peminjam" class="block text-gray-700 font-semibold">Nama Peminjam</label>
                <input type="text" name="name_peminjam" value="{{ old('name_peminjam', $peminjam->name_peminjam) }}" id="name_peminjam" class="w-full p-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#5CB8E4]">
                @error('name_peminjam')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="kontak_peminjam" class="block text-gray-700 font-semibold">kontak_peminjam</label>
                <input type="text" name="kontak_peminjam" value="{{ old('kontak_peminjam', $peminjam->kontak_peminjam) }}" id="kontak_peminjam" class="w-full p-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#5CB8E4]">
                @error('kontak_peminjam')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-[#5CB8E4] hover:bg-[#3289B7] text-white p-3 rounded-lg font-semibold transition duration-200">
                Update peminjam
            </button>
        </form>
    </div>
@endsection
