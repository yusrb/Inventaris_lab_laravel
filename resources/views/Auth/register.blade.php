<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register Page</title>
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
<body class="flex flex-col items-center justify-center min-h-screen bg-gradient relative py-12">

    <div id="register-form" class="bg-white p-8 rounded-lg shadow-lg w-[500px] border border-black opacity-0 transform scale-90">
        <div class="flex justify-center mb-4">
            <img id="logo" src="{{ asset('storage/img/' . $settings->logo) }}" alt="Register Icon" class="w-24 h-24 opacity-0">
        </div>
        <h1 class="text-2xl text-gray-700 font-bold text-primary text-center mb-4">Register</h1>
        
        <form action="{{ route('register.register') }}" method="post">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-medium">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" id="name" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
            </div>
            
            <div class="mb-4">
                <label for="username" class="block text-gray-700 font-medium">Username</label>
                <input type="text" name="username" value="{{ old('username') }}" id="username" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-medium">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" id="email" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-medium">Password</label>
                <input type="password" name="password" id="password" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
            </div>

            <button type="submit" class="w-full bg-primary text-white py-2 rounded-lg bg-[#3388BB] hover:bg-sky-700 transition font-semibold">Register</button>
        </form>

        <p class="text-center text-gray-600 mt-4">Sudah punya akun? 
            <a href="{{ route('login') }}" class="text-primary font-semibold hover:underline">Login</a>
        </p>
    </div>

    <p class="absolute bottom-4 right-4 text-sm text-gray-700">{{ $settings->name_website }} | {{ $settings->tagline }}</p>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            anime({
                targets: "#register-form",
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
        });
    </script>
</body>
</html>
