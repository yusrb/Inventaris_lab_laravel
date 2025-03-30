@extends('components.main')

@section('title', $settings->name_website)

@section('page', $page)

@section('content')
    <div class="bg-gradient-to-br from-[#4DA8DA] to-[#A7D6ED] text-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold">Selamat Datang di {{ $page }}, {{ Auth::user()->username }}</h1>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg mt-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('update'))
        <div class="bg-blue-100 text-blue-700 p-3 rounded-lg mt-4">
            {{ session('update') }}
        </div>
    @endif

    @if(session('delete'))
        <div class="bg-red-100 text-red-700 p-3 rounded-lg mt-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="mt-6 flex flex-col md:flex-row justify-between items-center gap-4">
        <a href="{{ route('barang_keluar.create') }}" class="bg-[#5CB8E4] hover:bg-[#3289B7] text-white px-4 py-2 rounded-lg transition shadow-md">
            Tambah Barang Keluar
        </a>
    
        <form method="GET" action="{{ route('barang_keluar.index') }}" class="relative w-full md:w-1/3">
            <input 
                type="text" 
                name="search_barang_keluar" 
                value="{{ request('search_barang_keluar') }}"
                class="border border-gray-300 rounded-lg py-2 px-4 pl-10 w-full focus:ring-2 focus:ring-gray-200 focus:shadow-md focus:outline-none shadow-sm"
                placeholder="Cari Barang Keluar..."
            />
            <button type="submit" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                <i class="bx bx-search text-xl"></i>
            </button>
        </form>
    </div>

    <div class="relative overflow-x-auto mt-6 min-h-[550px]">
        @foreach ($pagedTanggal as $tanggal)
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-blue-600 mb-2">Tanggal Keluar: {{ \Carbon\Carbon::parse($tanggal)->format('d M Y') }}</h2>

                <table class="w-full table-auto bg-white shadow-md rounded-lg text-sm">
                    <thead class="bg-[#5CB8E4] text-white text-[13px]">
                        <tr>
                            <th class="px-3 py-2 text-left">No</th>
                            <th class="px-3 py-2 text-left">Nama Barang</th>
                            <th class="px-3 py-2 text-left">Penerima</th>
                            <th class="px-3 py-2 text-left">Keterangan</th>
                            <th class="px-3 py-2 text-left">Jumlah</th>
                            <th class="px-3 py-2 text-left">Supplier</th>
                            <th class="px-3 py-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-[16px]">
                        @foreach ($barangKeluars[$tanggal] as $index => $barang_keluar)
                            <tr class="border-t hover:bg-[#f9f9f9]">
                                <td class="px-3 py-2">{{ $index + 1 }}</td>
                                <td class="px-3 py-2">{{ $barang_keluar->barang->name_barang }}</td>
                                <td class="px-3 py-2">{{ $barang_keluar->penerima }}</td>
                                <td class="px-3 py-2 text-[13px]">{{ $barang_keluar->keterangan }}</td>
                                <td class="px-3 py-2">{{ $barang_keluar->jumlah }}</td>
                                <td class="px-3 py-2">{{ $barang_keluar->supplier->name_supplier ?? '-' }}</td>
                                <td class="px-3 py-2 text-center flex justify-center gap-2">
                                    <a href="{{ route('barang_keluar.edit', $barang_keluar->id) }}" class="bg-[#5CB8E4] hover:bg-blue-700 text-white px-2 py-1 rounded text-xs transition">
                                        Update
                                    </a>
                                    <form action="{{ route('barang_keluar.destroy', $barang_keluar->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white px-2 py-1 rounded text-xs transition">
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
    </div>

    <div class="mt-4">
        {{ $pagedTanggal->links() }}
    </div>
@endsection
