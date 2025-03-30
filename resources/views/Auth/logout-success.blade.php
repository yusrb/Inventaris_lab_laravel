<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Logout Success</title>
    <link rel="shortcut icon" href="{{ asset('storage/img/' .$settings->logo) }}" type="image/x-icon">
    
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

    <div id="logout-message" class="bg-white p-10 rounded-lg shadow-lg w-[450px] border border-black opacity-0 transform scale-90">
        <div class="flex justify-center mb-4">
            <img id="logo" src="{{ asset('storage/img/' .$settings->logo) }}" alt="Logout Icon" class="w-28 h-28 opacity-0">
        </div>
        <h1 class="text-2xl text-gray-700 font-bold text-primary text-center mb-3">Anda Berhasil Logout!</h1>
        <p class="text-center text-gray-600 text-md mb-6">Silakan login kembali untuk mengakses sistem.</p>
        
        <a href="{{ route('login') }}">
            <button class="w-full bg-primary text-white py-2 rounded-lg bg-[#3388BB] hover:bg-sky-700 transition font-semibold text-lg">
                Login Kembali
            </button>
        </a>
    </div>
    
    <p class="absolute bottom-4 right-4 text-sm text-gray-700">{{ $title }} | {{ $tagline }}</p>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            anime({
                targets: "#logout-message",
                opacity: [0, 1],
                scale: [0.9, 1],
                duration: 2500,
                easing: "easeOutExpo"
            });

            anime({
                targets: "#logo",
                opacity: [0, 1],
                scale: [0.9, 1],
                duration: 2500,
                easing: "easeOutExpo"
            });
        });
    </script>
</body>
</html>
