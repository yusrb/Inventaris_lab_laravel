@extends('components.main')

@section('title', $settings->name_website)
@section('page', $page)

@section('content')
    <div class="bg-gradient-to-br from-[#4DA8DA] to-[#A7D6ED] text-white p-6 rounded-lg shadow-lg mb-6" data-aos="fade-down" data-aos-duration="3000">
        <h1 class="text-2xl font-bold">
            Riwayat Aktivitas - {{ $user ? $user->name . ' (' . $user->username . ')' : 'User Tidak Ditemukan' }}
        </h1>
        @if ($user)
            <p class="mt-1 text-sm">Email: {{ $user->email }} | Role: {{ $user->role == 0 ? 'Admin' : 'Petugas' }}</p>
        @endif
    </div>

    <div class="mb-4">
        <a href="{{ route('user.index') }}"
           class="inline-block bg-[#5CB8E4] hover:bg-[#3289B7] text-white px-4 py-2 rounded-lg transition shadow-md"
           data-aos="fade-up" data-aos-duration="1500">
            ← Kembali ke Daftar User
        </a>
    </div>

    <div class="relative overflow-x-auto min-h-[500px]" data-aos="fade-up" data-aos-duration="1500">
        <table class="w-full table-auto bg-white shadow-lg rounded-lg">
            <thead class="bg-[#5CB8E4] text-white">
                <tr>
                    <th class="px-4 py-2 text-left">Tanggal</th>
                    <th class="px-4 py-2 text-left">Aksi</th>
                    <th class="px-4 py-2 text-left">Modul</th>
                    <th class="px-4 py-2 text-left">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr class="border-t hover:bg-gray-100">
                        <td class="px-4 py-2 text-sm text-gray-800">
                          {{ $log->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }} WIB
                        </td>
                        <td class="px-4 py-2 text-sm">
                            @php
                                $badgeColor = match($log->aksi) {
                                    'create' => 'bg-green-100 text-green-800',
                                    'update' => 'bg-yellow-100 text-yellow-800',
                                    'delete' => 'bg-red-100 text-red-800',
                                    default => 'bg-gray-100 text-gray-800',
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
                        <td colspan="4" class="px-4 py-6 text-center text-sm text-gray-500">
                            Tidak ada log aktivitas untuk 
                            <span class="font-semibold">
                                {{ $user ? $user->name : 'user yang tidak dikenal' }}
                            </span>.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6 flex justify-center">
        {{ $logs->links() }}
    </div>
@endsection