@extends('components.main')

@section('title', $settings->name_website)

@section('page', $page)

@section('content')
    <div class="bg-gradient-to-br from-[#4DA8DA] to-[#A7D6ED] text-white p-6 rounded-lg shadow-lg" data-aos="fade-down" data-aos-duration="3000">
        <h1 class="text-2xl font-bold">Selamat Datang di Settings Page, {{ Auth::user()->username }}</h1>
    </div>

    @if(session('update'))
    <div class="bg-blue-100 text-blue-700 p-3 rounded-lg mt-4" data-aos="fade-up" data-aos-duration="1500">
        {{ session('update') }}
    </div>
    @endif

    <div class="mt-6 p-6 bg-white rounded-lg shadow-lg" data-aos="fade-up" data-aos-duration="1500">
        <form action="{{ route('settings.update', 1) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
        
            <div class="mb-4">
                <label for="name_website" class="block text-gray-700 font-semibold">Nama Website</label>
                <input type="text" name="name_website" value="{{ old('name_website', $settings->name_website) }}" id="name_website"
                    class="w-full p-3 mt-2 border border-gray-300 rounded-lg">
                @error('name_website')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        
            <div class="mb-4">
                <label for="tagline" class="block text-gray-700 font-semibold">Tagline</label>
                <input type="text" name="tagline" value="{{ old('tagline', $settings->tagline) }}" id="tagline"
                    class="w-full p-3 mt-2 border border-gray-300 rounded-lg">
                @error('tagline')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="logo" class="block text-gray-700 font-semibold">Logo</label>

                <div class="mb-3">
                    <img id="preview-logo" 
                         src="{{ $settings->logo ? asset('storage/img/' . $settings->logo) : asset('img/default-logo.png') }}" 
                         alt="Logo" 
                         class="w-32 h-32 object-contain border border-gray-300 rounded-lg">
                </div>

                <!-- Input Upload Gambar -->
                <input type="file" name="logo" id="logo"
                    class="w-full p-2 mt-2 border border-gray-300 rounded-lg" accept="image/*"
                    onchange="previewImage(event)">
                
                @error('logo')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        
            <div class="mb-4">
                <button type="submit" class="w-full text-white py-3 rounded-lg bg-[#5CB8E4] hover:bg-[#3289B7] transition">
                    Update Settings
                </button>
            </div>
        </form>
    </div>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function(){
                const output = document.getElementById('preview-logo');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endsection
