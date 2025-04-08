@extends('components.main')

@section('title', $settings->name_website)

@section('page', $page)

@section('content')
    <div class="bg-gradient-to-br from-[#4DA8DA] to-[#A7D6ED] text-white p-6 rounded-lg shadow-lg" data-aos="fade-down" data-aos-duration="3000">
        <h1 class="text-2xl font-bold">Riwayat Aktivitas</h1>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg mt-4" data-aos="fade-up" data-aos-duration="1500">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-end mt-6" data-aos="fade-up" data-aos-duration="1500">
        <form action="{{ route('log_aktivitas.clear') }}" method="POST" onsubmit="return confirm('Apakah kamu yakin ingin menghapus semua riwayat aktivitas?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg">
                Hapus Semua Log
            </button>
        </form>
    </div>

    <div class="relative overflow-x-hidden mt-6 min-h-[550px]" data-aos="fade-up" data-aos-duration="1500">
        <div class="w-full">
            <table class="w-full table-auto bg-white shadow-lg rounded-lg">
                <thead class="bg-[#5CB8E4] text-white">
                    <tr>
                        <th class="px-4 py-2 text-left">Tanggal</th>
                        <th class="px-4 py-2 text-left">User</th>
                        <th class="px-4 py-2 text-left">Aksi</th>
                        <th class="px-4 py-2 text-left">Modul</th>
                        <th class="px-4 py-2 text-left">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $log)
                        <tr class="border-t" data-aos="fade-up" data-aos-duration="1500">
                            <td class="px-4 py-2 text-sm text-gray-800">
                                {{ $log->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }} WIB
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-800">{{ $log->user->name }}</td>
                            <td class="px-4 py-2 text-sm">
                                @php
                                    $badgeColor = match($log->aksi) {
                                        'create' => 'bg-green-100 text-green-800',
                                        'update' => 'bg-yellow-100 text-yellow-800',
                                        'delete' => 'bg-red-100 text-red-800',
                                        default => 'bg-gray-100 text-gray-800'
                                    };
                                @endphp
                                <span class="px-2 py-1 rounded-lg text-xs font-medium {{ $badgeColor }}">
                                    {{ ucfirst($log->aksi) }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-800">{{ ucfirst($log->modul) }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $log->keterangan }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-4 text-center text-sm text-gray-500">Tidak ada aktivitas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6 flex justify-center">
        {{ $logs->links() }}
    </div>
@endsection
