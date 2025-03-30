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
        <a href="{{ route('peminjam.create') }}" class="bg-[#5CB8E4] hover:bg-[#3289B7] text-white px-4 py-2 rounded-lg transition shadow-md">
            Tambah Peminjam
        </a>
    
        <form method="GET" action="{{ route('peminjam.index') }}" class="relative w-full md:w-1/3">
            <input 
                type="text" 
                id="search-peminjam"
                name="peminjam_search" 
                value="{{ request('peminjam_search') }}"
                class="border border-gray-300 rounded-lg py-2 px-4 pl-10 w-full focus:ring-2 focus:ring-gray-200 focus:shadow-md focus:outline-none shadow-sm"
                placeholder="Cari Peminjam..."
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
                        <th class="px-4 py-2 text-left">Nama Peminjam</th>
                        <th class="px-4 py-2 text-left">Kontak Peminjam</th>
                        <th class="px-4 py-2 text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($peminjams as $peminjam)
                        <tr class="border-t hover:bg-[#f1f1f1]" data-aos="fade-up" data-aos-duration="1500">
                            <td class="px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2">{{ $peminjam->name_peminjam }}</td>
                            <td class="px-4 py-2">{{ $peminjam->kontak_peminjam }}</td>
                            <td class="px-4 py-2 text-center">
                                <a href="{{ route('peminjam.edit', $peminjam->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white px-3 py-1 rounded-lg transition" data-aos="fade-up" data-aos-duration="1500">
                                    Update
                                </a>

                                <form action="{{ route('peminjam.destroy', $peminjam->id) }}" method="post" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus {{ $peminjam->name_peminjam }}?')" data-aos="fade-up" data-aos-duration="1500">
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

    <div class="mt-6 flex justify-center">
        {{ $peminjams->links() }}
    </div>
@endsection
