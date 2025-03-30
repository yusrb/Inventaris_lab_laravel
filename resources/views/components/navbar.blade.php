<nav id="navbar" class="bg-[#4DA8DA] text-white p-4 shadow-md">
    <div class="container mx-auto flex justify-between items-center">
        <a href="{{ route('dashboard.index') }}">
            <h1 class="text-2xl ml-1 font-bold">@yield('title')</h1>
        </a>
        <form action="{{ route('logout.logout') }}" method="post" onsubmit="return confirm('Yakin ingin Logout?')">
            @csrf
            <button type="submit" class="bg-[#3289B7] px-4 py-2 rounded-lg hover:bg-[#2A75A0] transition">
                Logout
            </button>
        </form>
    </div>
</nav>