@extends('components.main')

@section('title', $settings->name_website)
@section('page', $page)

@section('content')
    <div class="bg-gradient-to-br from-[#4DA8DA] to-[#A7D6ED] text-white p-6 rounded-lg shadow-lg" data-aos="fade-down" data-aos-duration="3000">
        <h1 class="text-2xl font-bold">Detail Record Transaksi Supplier dari {{ $supplier->name_supplier }}</h1>
    </div>

    <div class="mt-6 bg-white p-6 rounded-lg shadow-md" data-aos="fade-up" data-aos-duration="1500">
        <h2 class="text-xl font-semibold mb-3 border-b pb-2">Informasi Supplier</h2>
    
        <div class="space-y-3 text-gray-700">
            <p><strong>Nama:</strong> {{ $supplier->name_supplier }}</p>
            <p><strong>Kontak:</strong> {{ $supplier->kontak }}</p>
            <p><strong>Alamat:</strong> {{ $supplier->alamat }}</p>
        </div>
    </div>
    

    <div class="mt-6 flex justify-start" data-aos="fade-up" data-aos-duration="1500">
        <a href="{{ route('supplier.index') }}" class="bg-[#5CB8E4] hover:bg-[#3289B7] text-white px-4 py-2 rounded-lg transition shadow-md">
            Kembali ke Daftar Supplier
        </a>
    </div>

    @foreach ([['Barang Masuk', 'barang_masuks', 'barang_masuk_search', 'tanggal_masuk'], ['Barang Keluar', 'barang_keluars', 'barang_keluar_search', 'tanggal_keluar']] as [$title, $relation, $searchName, $dateField])
        <div class="mt-10" data-aos="fade-up" data-aos-duration="1500">
            <h2 class="text-xl font-semibold mb-3">{{ $title }}</h2>
            <form method="GET" action="{{ route('supplier.show', $supplier->id) }}" class="relative w-full md:w-1/3 mb-4">
                <input 
                    type="text" 
                    name="{{ $searchName }}" 
                    value="{{ request($searchName) }}"
                    class="border border-gray-300 rounded-lg py-2 px-4 pl-10 w-full focus:ring-2 focus:ring-gray-200 focus:shadow-md focus:outline-none shadow-sm"
                    placeholder="Cari {{ strtolower($settings->name_website) }}..."
                />
                <button type="submit" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">
                    <i class="bx bx-search text-xl"></i>
                </button>
            </form>

            <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
                <table class="w-full table-auto">
                    <thead class="bg-[#5CB8E4] text-white">
                        <tr>
                            <th class="px-4 py-2 text-left">No</th>
                            <th class="px-4 py-2 text-left">Kode Barang</th>
                            <th class="px-4 py-2 text-left">Nama Barang</th>
                            <th class="px-4 py-2 text-left">Tanggal</th>
                            <th class="px-4 py-2 text-left">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($supplier->$relation as $barang)
                            <tr class="border-t hover:bg-[#f1f1f1]">
                                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2">{{ $barang->barang->kode_barang }}</td>
                                <td class="px-4 py-2">{{ $barang->barang->name_barang }}</td>
                                <td class="px-4 py-2">{{ $barang->$dateField ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $barang->jumlah }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-gray-500 italic">
                                    Tidak ada {{ strtolower('Barang di ' . $supplier->name_supplier) }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
@endsection