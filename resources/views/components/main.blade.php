<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('storage/img/' .$settings->logo) }}" type="image/x-icon">
    
    {{-- Tailwind Cdn --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- BoxIcons Cdn --}}
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    {{-- AnimeJs Cdn --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>

    {{-- AosJs Cdn --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <title>@yield('title') | @yield('page')</title>

    @yield('styles')
</head>
<body class="flex bg-base-200">
    
    @include('components.sidebar')

    <div class="flex-1">
        @include('components.navbar')

        <div class="p-6">
            @yield('content')
        </div>
    </div>

    @include('components.footer')

    {{-- Aos Js Cdn --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>
