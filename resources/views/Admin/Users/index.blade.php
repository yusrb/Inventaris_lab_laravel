    @extends('components.main')

    @section('title', $settings->name_website)

    @section('page', $page)

    @section('content')
        <div class="bg-gradient-to-br from-[#4DA8DA] to-[#A7D6ED] text-white p-6 rounded-lg shadow-lg" data-aos="fade-down" data-aos-duration="3000">
            <h1 class="text-2xl font-bold">Selamat Datang di Users Page, {{ Auth::user()->username }}</h1>
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
            <a href="{{ route('user.create') }}" class="bg-[#5CB8E4] hover:bg-[#3289B7] text-white px-4 py-2 rounded-lg transition shadow-md">
                Tambah User
            </a>
        
            <form method="GET" action="{{ route('user.index') }}" class="relative w-full md:w-1/3">
                <input 
                    type="text" 
                    id="search-user"
                    name="user_search" 
                    value="{{ request('user_search') }}"
                    class="border border-gray-300 rounded-lg py-2 px-4 pl-10 w-full focus:ring-2 focus:ring-gray-200 focus:shadow-md focus:outline-none shadow-sm"
                    placeholder="Cari User..."
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
                            <th class="px-4 py-2 text-left">Nama</th>
                            <th class="px-4 py-2 text-left">Username</th>
                            <th class="px-4 py-2 text-left">Email</th>
                            <th class="px-4 py-2 text-left">Role</th>
                            <th class="px-4 py-2 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="border-t hover:bg-[#f1f1f1]" data-aos="fade-up" data-aos-duration="1500">
                                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2">{{ $user->name }}</td>
                                <td class="px-4 py-2">{{ $user->username }}</td>
                                <td class="px-4 py-2">{{ $user->email }}</td>
                                <td class="px-4 py-2">
                                    @if ($user->role == 0)
                                        Admin
                                    @else
                                        Petugas
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-center">
                                    <div class="flex flex-wrap justify-center items-center gap-2">
                                        <a href="{{ route('user.edit', $user->id) }}"
                                            class="bg-blue-500 hover:bg-blue-700 text-white px-3 py-1 rounded-lg transition"
                                            data-aos="fade-up" data-aos-duration="1500">
                                            Update
                                        </a>

                                        <a href="{{ route('user.show', $user->id) }}"
                                            class="bg-yellow-500 hover:bg-yellow-700 text-white px-3 py-1 rounded-lg transition"
                                            data-aos="fade-up" data-aos-duration="1500">
                                            Riwayat
                                        </a>

                                        <form action="{{ route('user.destroy', $user->id) }}" method="post"
                                            onsubmit="return confirm('Yakin ingin menghapus {{ $user->username }}?')"
                                            data-aos="fade-up" data-aos-duration="1500">
                                            @csrf
                                            @method('delete')
                                            <button type="submit"
                                                class="bg-red-500 hover:bg-red-700 text-white px-3 py-1 rounded-lg transition">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6 flex justify-center">
            {{ $users->links() }}
        </div>
    @endsection
