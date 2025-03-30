@extends('components.main')

@section('title', $settings->name_website)

@section('page', $page)

@section('content')
    <div class="bg-gradient-to-br from-[#4DA8DA] to-[#A7D6ED] text-white p-6 rounded-lg shadow-lg" data-aos-duration="2000" data-aos="fade-down">
        <h1 class="text-2xl font-bold">Selamat Datang di {{ $page }}, {{ Auth::user()->username }}</h1>
    </div>
    
    <div class="mt-6 mb-20 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <a href="{{ route('barang.index') }}" class="bg-green-600 p-6 rounded-lg shadow-md text-white duration-3000 hover:bg-green-700 flex justify-between items-center" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="100">
            <div>
                <h2 class="text-lg font-semibold">Model Barang</h2>
                <p>Total barang: {{ $total_barang }}</p>
            </div>
            <i class='bx bx-package text-4xl'></i>
        </a>

        <a href="{{ route('user.index') }}" class="bg-orange-500 p-6 rounded-lg shadow-md text-white duration-3000 hover:bg-orange-600 flex justify-between items-center" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="200">
            <div>
                <h2 class="text-lg font-semibold">Pengguna</h2>
                <p>Jumlah Pengguna: {{ $total_user }}</p>
            </div>
            <i class='bx bx-user text-4xl'></i>
        </a>

        <a href="{{ route('supplier.index') }}" class="bg-red-500 p-6 rounded-lg shadow-md text-white duration-3000 hover:bg-red-600 flex justify-between items-center" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="300">
            <div>
                <h2 class="text-lg font-semibold">Supplier</h2>
                <p>Jumlah Supplier: {{ $total_supplier }}</p>
            </div>
            <i class='bx bxs-truck text-4xl'></i>
        </a>

        <a href="{{ route('barang_masuk.index') }}" class="bg-blue-400 p-6 rounded-lg shadow-md text-white duration-3000 hover:bg-blue-500 flex justify-between items-center" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="400">
            <div>
                <h2 class="text-lg font-semibold">Total Barang Masuk</h2>
                <p>Total Barang Masuk: {{ $total_barang_masuk }}</p>
            </div>
            <i class='bx bx-log-in text-4xl'></i>
        </a>

        <a href="{{ route('barang_keluar.index') }}" class="bg-blue-500 p-6 rounded-lg shadow-md text-white duration-3000 hover:bg-blue-600 flex justify-between items-center" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="500">
            <div>
                <h2 class="text-lg font-semibold">Total Barang Keluar</h2>
                <p>Total Barang Keluar: {{ $total_barang_keluar }}</p>
            </div>
            <i class='bx bx-log-out text-4xl'></i>
        </a>

        <br>

        <a href="{{ route('barang_masuk.index') }}" class="bg-indigo-500 p-6 rounded-lg shadow-md text-white duration-3000 hover:bg-indigo-600 flex justify-between items-center" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="600">
            <div>
                <h2 class="text-[14px] font-semibold">Total Transaksi Barang Masuk</h2>
                <p class="text-sm">Total Transaksi Barang Masuk: {{ $total_transaksi_barang_masuk }}</p>
            </div>
            <i class='bx bx-transfer text-4xl'></i>
        </a>

        <a href="{{ route('barang_masuk.index') }}" class="bg-orange-600 p-6 rounded-lg shadow-md text-white duration-3000 hover:bg-orange-700 flex justify-between items-center" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="700">
            <div>
                <h2 class="text-[14px] font-semibold">Total Transaksi Barang Keluar</h2>
                <p class="text-sm">Total Transaksi Barang Keluar: {{ $total_transaksi_barang_keluar }}</p>
            </div>
            <i class='bx bx-refresh text-4xl'></i>
        </a>

        <br>

        <a href="{{ route('peminjaman.index') }}" class="bg-blue-700 p-6 rounded-lg shadow-md text-white duration-3000 hover:bg-blue-800 flex justify-between items-center" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="800">
            <div>
                <h2 class="text-[14px] font-semibold">Transaksi Peminjaman</h2>
                <p class="text-sm">Jumlah Transaksi Peminjaman: {{ $total_peminjaman }}</p>
            </div>
            <i class='bx bx-file text-4xl'></i>
        </a>

        <a href="{{ route('peminjaman.index') }}" class="bg-green-500 p-6 rounded-lg shadow-md text-white duration-3000 hover:bg-green-600 flex justify-between items-center" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="900">
            <div>
                <h2 class="text-[14px] font-semibold">Peminjaman Dikembalikan</h2>
                <p class="text-sm">Total Peminjaman Telah Dikembalikan: {{ $total_peminjaman_dikembalikan }}</p>
            </div>
            <i class='bx bx-check-circle text-4xl'></i>
        </a>

        <a href="{{ route('peminjaman.index') }}" class="bg-red-400 p-6 rounded-lg shadow-md text-white duration-3000 hover:bg-red-500 flex justify-between items-center" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="1000">
            <div>
                <h2 class="text-[13px] font-semibold">Peminjaman Belum Dikembalikan</h2>
                <p class="text-sm">Total Peminjaman Belum Dikembalikan: {{ $total_peminjaman_belum_dikembalikan }}</p>
            </div>
            <i class='bx bx-time-five text-4xl'></i>
        </a>
    </div>
@endsection