@extends('components.main')

@section('title', $settings->name_website)

@section('page', $page)

@section('content')
    <div class="bg-gradient-to-br from-[#4DA8DA] to-[#A7D6ED] text-white p-6 rounded-lg shadow-lg" data-aos="fade-down" data-aos-duration="3000">
        <h1 class="text-2xl font-bold">Selamat Datang di Daftar Barang dari Kategori {{ $page }}, {{ Auth::user()->username }}</h1>
    </div>

    <div class="mt-6 flex flex-col md:flex-row justify-between items-center gap-4" data-aos="fade-up" data-aos-duration="1500">
        <a href="{{ route('kategori.index') }}" class="bg-[#5CB8E4] hover:bg-[#3289B7] text-white px-4 py-2 rounded-lg transition shadow-md">
            Kembali ke Semua Kategori
        </a>

        <form method="GET" action="{{ route('kategori.show', $kategori->id) }}" class="relative w-full md:w-1/3">
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
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kategori->barangs as $barang)
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
                        </tr>
                    @endforeach

                    @forelse ($kategori->barangs as $barang)
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-gray-500 italic">Tidak ada Barang dalam Kategori Ini</td>
                        </tr>
                    @endforelse
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
