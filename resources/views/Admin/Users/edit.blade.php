@extends('components.main')

@section('title', $settings->name_website)

@section('page', $page)

@section('content')
    <h1 class="text-4xl font-bold">Edit User</h1>

    <div class="mt-6">
        <a href="{{ route('user.index') }}" class="text-[#5CB8E4] hover:text-[#3289B7]">Kembali ke User</a>

        <form action="{{ route('user.update', $user->id) }}" method="post" class="mt-6 bg-white p-6 rounded-lg shadow-lg">
            @csrf
            @method('put')
            
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-semibold">Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" id="name" class="w-full p-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#5CB8E4]">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="username" class="block text-gray-700 font-semibold">Username</label>
                <input type="text" name="username" value="{{ old('username', $user->username) }}" id="username" class="w-full p-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#5CB8E4]">
                @error('username')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-semibold">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" id="email" class="w-full p-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#5CB8E4]">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-semibold">Password</label>
                <input type="password" name="password" id="password" class="w-full p-3 mt-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#5CB8E4]">
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-[#5CB8E4] hover:bg-[#3289B7] text-white p-3 rounded-lg font-semibold transition duration-200">
                Update User
            </button>
        </form>
    </div>
@endsection
