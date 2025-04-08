@extends('components.main')

@section('title', $title)

@section('page', 'Daftar Barang Masuk')

@section('content')
    <div class="bg-gradient-to-br from-[#4DA8DA] to-[#A7D6ED] text-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold">Selamat Datang di Daftar Barang Masuk, {{ Auth::user()->username }}</h1>
    </div>

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

    <div class="mt-6 flex flex-col md:flex-row justify-between items-center gap-4">
        <a href="{{ route('barang_masuk.create') }}" class="bg-[#5CB8E4] hover:bg-[#3289B7] text-white px-4 py-2 rounded-lg transition shadow-md">
            Tambah Barang Masuk
        </a>
    </div>

    <div class="relative overflow-x-hidden mt-6 min-h-[550px]">
        <div class="w-full">
            @if(count($barang_masuks) === 0)
                <div class="text-center text-gray-500 py-10 bg-white rounded-lg shadow">
                    <p class="text-lg font-semibold">Daftar Barang Masuk Belum Ada</p>
                    <p class="text-sm">Silakan tambahkan data terlebih dahulu.</p>
                </div>
            @else
                @foreach ($barang_masuks as $tanggal => $barang_list)
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold text-blue-600 mb-2">Tanggal Masuk: {{ \Carbon\Carbon::parse($tanggal)->format('d M Y') }}</h2>
                        
                        <table class="w-full table-auto bg-white shadow-lg rounded-lg">
                            <thead class="bg-[#5CB8E4] text-white">
                                <tr>
                                    <th class="px-4 py-2 text-left">No</th>
                                    <th class="px-4 py-2 text-left">Nama Barang</th>
                                    <th class="px-4 py-2 text-left">Jumlah</th>
                                    <th class="px-4 py-2 text-left">Keterangan</th>
                                    <th class="px-4 py-2 text-left">Nama Supplier</th>
                                    <th class="px-4 py-2 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($barang_list as $index => $barang_masuk)
                                    <tr class="border-t hover:bg-[#f1f1f1]">
                                        <td class="px-4 py-2">{{ $index + 1 }}</td>
                                        <td class="px-4 py-2">{{ $barang_masuk->barang->name_barang ?? 'Data tidak tersedia' }}</td>
                                        <td class="px-4 py-2">{{ $barang_masuk->jumlah }}</td>
                                        <td class="px-4 py-2 text-[12px]">{{ $barang_masuk->keterangan }}</td>
                                        <td class="px-4 py-2">{{ $barang_masuk->supplier->name_supplier ?? 'Tidak ada supplier' }}</td>
                                        <td class="px-4 py-2 text-center">
                                            <a href="{{ route('barang_masuk.edit', $barang_masuk->id) }}" class="bg-[#5CB8E4] hover:bg-blue-700 text-white px-3 py-1 rounded-lg transition">
                                                Update
                                            </a>
                                            <form action="{{ route('barang_masuk.destroy', $barang_masuk->id) }}" method="post" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus {{ $barang_masuk->barang->name_barang }}?')">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white px-3 py-1 rounded-lg transition ml-2">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <div class="mt-4">
        {{ $paginatedTanggal->links() }}
    </div>
@endsection
