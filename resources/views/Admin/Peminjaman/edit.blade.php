@extends('components.main')

@section('title', $settings->name_website)

@section('page', $page)

@section('content')
    <h1 class="text-4xl font-bold">Update Peminjaman</h1>

    <div class="mt-6">
        <a href="{{ route('peminjaman.index') }}" class="text-[#5CB8E4] hover:text-[#3289B7]">Kembali ke Daftar Peminjaman</a>

        <form action="{{ route('peminjaman.update', $peminjaman->id) }}" method="post" class="mt-6 bg-white p-6 rounded-lg shadow-lg">
            @csrf
            @method('put')
            
            <div class="mb-4">
                <label for="peminjam_id" class="block text-gray-700 font-semibold">Peminjam</label>
                <select name="peminjam_id" id="peminjam_id" class="w-full p-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#5CB8E4]">
                    @foreach ($peminjams as $peminjam)
                        <option value="{{ $peminjam->id }}" {{ $peminjaman->peminjam_id == $peminjam->id ? 'selected' : '' }}>{{ $peminjam->name_peminjam }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-4">
                <label for="barang_id" class="block text-gray-700 font-semibold">Barang</label>
                <select name="barang_id" id="barang_id" class="w-full p-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#5CB8E4]">
                    @foreach ($barangs as $barang)
                        <option value="{{ $barang->id }}" {{ $peminjaman->barang_id == $barang->id ? 'selected' : '' }}>{{ $barang->name_barang }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-4">
                <label for="jumlah" class="block text-gray-700 font-semibold">Jumlah</label>
                <input type="number" name="jumlah" value="{{ $peminjaman->jumlah }}" id="jumlah" class="w-full p-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#5CB8E4]">
            </div>
            
            <div class="mb-4">
                <label for="tanggal_pinjam" class="block text-gray-700 font-semibold">Tanggal Pinjam</label>
                <input type="date" name="tanggal_pinjam" value="{{ $peminjaman->tanggal_pinjam }}" id="tanggal_pinjam" class="w-full p-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#5CB8E4]">
            </div>
            
            <div class="mb-4">
                <label for="tanggal_kembali" class="block text-gray-700 font-semibold">Tanggal Kembali</label>
                <input type="date" name="tanggal_kembali" value="{{ $peminjaman->tanggal_kembali }}" id="tanggal_kembali" class="w-full p-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#5CB8E4]">
            </div>
            
            <div class="mb-4">
                <label for="status" class="block text-gray-700 font-semibold">Status</label>
                <select name="status" id="status" class="w-full p-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#5CB8E4]">
                    <option value="Dipinjam" {{ $peminjaman->status == 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="Dikembalikan" {{ $peminjaman->status == 'Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                    <option value="Hilang" {{ $peminjaman->status == 'Hilang' ? 'selected' : '' }}>Hilang</option>
                </select>
            </div>
            
            <button type="submit" class="w-full bg-[#5CB8E4] hover:bg-[#3289B7] text-white p-3 rounded-lg font-semibold transition duration-200">
                Update Peminjaman
            </button>
        </form>
    </div>
@endsection