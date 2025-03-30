@extends('components.main')

@section('title', $settings->name_website)

@section('page', $page)

@section('content')
    <div class="bg-gradient-to-br from-[#4DA8DA] to-[#A7D6ED] text-white p-6 rounded-lg shadow-lg" data-aos="fade-down" data-aos-duration="3000">
        <h1 class="text-2xl font-bold">Selamat Datang di {{ $page }}, {{ Auth::user()->username }}</h1>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg mt-4" data-aos="fade-up" data-aos-duration="1500">
            {{ session('success') }}
        </div>
    @endif

    @if(session('update'))
        <div class="bg-blue-100 text-blue-700 p-3 rounded-lg mt-4" data-aos="fade-up" data-aos-duration="1500">
            {{ session('update') }}
        </div>
    @endif

    @if(session('delete'))
        <div class="bg-red-100 text-red-700 p-3 rounded-lg mt-4" data-aos="fade-up" data-aos-duration="1500">
            {{ session('delete') }}
        </div>
    @endif

    <div class="mt-6 flex flex-col md:flex-row justify-between items-center gap-4" data-aos="fade-up" data-aos-duration="1500">
        <a href="{{ route('barang.create') }}" class="bg-[#5CB8E4] hover:bg-[#3289B7] text-white px-4 py-2 rounded-lg transition shadow-md">
            Tambah Barang
        </a>
    
        <form method="GET" action="{{ route('barang.index') }}" class="relative w-full md:w-1/3">
            <input 
                type="text" 
                id="search-barang"
                name="barang_search" 
                value="{{ request('barang_search') }}"
                class="border border-gray-300 rounded-lg py-2 px-4 pl-10 w-full focus:ring-2 focus:ring-gray-200 focus:shadow-md focus:outline-none shadow-sm"
                placeholder="Cari barang..."
            />
            
            <button type="submit" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                <i class="bx bx-search text-xl"></i>
            </button>
        </form>
        
    </div>

    <div class="relative overflow-x-hidden mt-6 min-h-[550px]" data-aos="fade-up" data-aos-duration="1500">
        <div class="w-full">
            <table class="w-full table-auto bg-white shadow-lg rounded-lg">
                <thead class="bg-[#5CB8E4] text-white">
                    <tr>
                        <th class="px-4 py-2 text-left">No</th>
                        <th class="px-4 py-2 text-left">Kode Barang</th>
                        <th class="px-4 py-2 text-left">Nama Barang</th>
                        <th class="px-4 py-2 text-left">Kategori</th>
                        <th class="px-4 py-2 text-left">Jumlah</th>
                        <th class="px-4 py-2 text-left">Kondisi</th>
                        <th class="px-4 py-2 text-left">Deskripsi</th>
                        <th class="px-4 py-2 text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($barangs as $barang)
                        <tr class="border-t hover:bg-[#f1f1f1]" data-aos="fade-up" data-aos-duration="1500">
                            <td class="px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2">{{ $barang->kode_barang }}</td>
                            <td class="px-4 py-2">{{ $barang->name_barang }}</td>
                            <td class="px-4 py-2">{{ $barang->kategori->name_kategori }}</td>
                            <td class="px-4 py-2 text-center">
                                @if ($barang->jumlah < $barang->stok_minimum)
                                    <span class="flex items-center justify-center relative">
                                        <i class="warning-icon cursor-pointer text-red-600 text-lg">
                                            <

                                            <span class="relative right-[3.5px] text-black not-italic">{{ $barang->jumlah }}</span>
                                        </i>

                                        <span class="tooltip absolute left-1/2 transform -translate-x-1/2 -translate-y-8 bg-white  text-black text-xs rounded-md px-2 py-1 whitespace-nowrap shadow-lg hidden">
                                            Stok kurang dari stok minimum ({{ $barang->stok_minimum }}) ! 
                                        </span>
                                    </span>
                                @else
                                    {{ $barang->jumlah }}
                                @endif
                            </td>
                            
                            
                            <td class="px-4 py-2">{{ $barang->kondisi }}</td>
                            <td class="px-4 py-2">
                                @if (!$barang->deskripsi)
                                    Belum diisi
                                @else
                                {{ $barang->deskripsi }}
                                @endif
                            </td>
                            <td class="px-4 py-2 text-center">
                                <a href="{{ route('barang.edit', $barang->id) }}" class="bg-[#5CB8E4] hover:bg-blue-700 text-white px-3 py-1 rounded-lg transition" data-aos="fade-up" data-aos-duration="1500">
                                    Update
                                </a>

                                <form action="{{ route('barang.destroy', $barang->id) }}" method="post" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus {{ $barang->name_barang }}?')" data-aos="fade-up" data-aos-duration="1500">
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
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const warningIcons = document.querySelectorAll(".warning-icon");
    
            warningIcons.forEach(icon => {
                const tooltip = icon.nextElementSibling;
                
                icon.addEventListener("mouseenter", function () {
                    tooltip.style.display = "block";
                });
    
                icon.addEventListener("mouseleave", function () {
                    tooltip.style.display = "none";
                });
            });
        });
    </script>
    
@endsection
