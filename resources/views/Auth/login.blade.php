<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Page</title>
    <link rel="shortcut icon" href="{{ asset('img/smkn02kra.jpg') }}" type="image/x-icon">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <style>
        .bg-gradient {
            background: linear-gradient(to bottom right, #3388BB, #ffffff);
        }
        .text-primary { color: #3388BB; }
    </style>
</head>
<body class="flex flex-col items-center justify-center min-h-screen bg-gradient relative">

    @if(session('success'))
        <div id="success-alert" class="absolute top-5 right-5 bg-green-500 text-white px-4 py-2 rounded shadow-lg opacity-0 flex items-center justify-between w-72">
            <span>{{ session('success') }}</span>
            <button id="close-alert" class="ml-4 text-lg font-bold"></button>
        </div>
    @endif

    <div id="login-form" class="bg-white p-8 rounded-lg shadow-lg w-96 border border-black opacity-0 transform scale-90">
        <div class="flex justify-center mb-4">
            <img id="logo" src="{{ asset('storage/img/' . $settings->logo) }}" alt="Login Icon" class="w-24 h-24 opacity-0">
        </div>
        <h1 class="text-2xl text-gray-700 font-bold text-primary text-center mb-4">Login</h1>
        
        <form action="{{ route('login.login') }}" method="post">
            @csrf
            <div class="mb-4">
                <label for="username" class="block text-gray-700 font-medium">Username</label>
                <input type="text" name="username" value="{{ old('username') }}" id="username" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary transition-transform">
                @error('username')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-medium">Password</label>
                <input type="password" name="password" id="password" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary transition-transform">
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-primary text-white py-2 rounded-lg bg-[#3388BB] hover:bg-sky-700 transition font-semibold">Login</button>
        </form>

        <p class="text-center text-gray-600 mt-4">Belum punya akun? 
            <a href="#" id="open-modal" class="text-primary font-semibold hover:underline">Hubungi Admin!</a>
        </p>
    </div>

    <!-- Modal Hubungi Admin -->
    <div id="admin-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white w-full max-w-lg rounded-lg shadow-lg p-6 relative">
            <h2 class="text-2xl font-bold text-primary text-black mb-4">Hubungi Admin</h2>

            <hr class="border-[1.5px] relative bottom-[10px]">

            <button id="close-modal" class="absolute top-3 right-4 text-gray-700 text-xl hover:text-red-600">&times;</button>

            @forelse($usersAdmin as $admin)
            <div class="mb-3 border-b pb-3 flex items-center justify-between">
                <div>
                    <p class="text-gray-800 font-semibold">{{ $admin->name }}</p>
                    <p class="text-sm text-gray-600">{{ $admin->email }}</p>
                </div>
                <a href="mailto:{{ $admin->email }}"
                   class="text-sm bg-primary text-white px-3 py-1 rounded bg-sky-600 hover:bg-sky-700 ml-4">
                    Hubungi
                </a>
            </div>
        @empty
            <p class="text-gray-600">Tidak ada admin yang terdaftar.</p>
        @endforelse
        </div>
    </div>

    
    <p class="absolute bottom-4 right-4 text-sm text-gray-700">{{ $settings->name_website }} | {{ $settings->tagline }}</p>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            anime({
                targets: "#login-form",
                opacity: [0, 1],
                scale: [0.9, 1],
                duration: 3000,
                easing: "easeOutExpo"
            });

            anime({
                targets: "#logo",
                opacity: [0, 1],
                rotate: [30, 0],
                translateX: [-8, 8, -3, 3, 0],
                duration: 2000,
                easing: "easeOutBack"
            });

            if (document.getElementById("success-alert")) {
                anime({
                    targets: "#success-alert",
                    opacity: [0, 1],
                    translateX: [50, 0],
                    duration: 2000,
                    easing: "easeOutExpo"
                });
            }
        });

        document.getElementById("open-modal").addEventListener("click", function (e) {
            e.preventDefault();
            document.getElementById("admin-modal").classList.remove("hidden");
        });

        document.getElementById("close-modal").addEventListener("click", function () {
            document.getElementById("admin-modal").classList.add("hidden");
        });
    </script>
</body>
</html>