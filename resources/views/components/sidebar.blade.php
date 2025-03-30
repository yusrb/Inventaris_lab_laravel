<aside id="sidebar" class="w-64 bg-gradient-to-b from-[#4DA8DA] to-[#A7D6ED] text-white min-h-screen p-6 flex flex-col justify-between">
    <!-- Logo -->
    <div class="flex flex-col items-center bg-[#FBF8EF] shadow-lg p-4 py-3 rounded-lg">
        <img id="logo" src="{{ asset('storage/img/' . $settings->logo) }}" alt="Logo Website" class="w-[50%] object-contain">
        <h1 id="logo" class="text-2xl font-bold mt-4 text-gray-800">Dashboard</h1>
    </div>

    <hr style="border: none; height: 1.5px; background-color: white; border-radius: 10px; position: relative; top: 15px;">

    <!-- Navigasi -->
    <nav class="flex-grow mt-6">
        <ul class="space-y-1">
            <li>
                <a href="{{ route('dashboard.index') }}" class="flex items-center gap-3 px-4 py-2 {{ Route::currentRouteName() == 'dashboard.index' ? 'bg-[#5CB8E4]' : '' }} rounded-lg hover:bg-[#3289B7] transition">
                    <i class="bx bx-home"></i> Home
                </a>
            </li>

            @if(Route::has('barang.index'))
                <li>
                    <a href="{{ route('barang.index') }}" class="flex items-center gap-3 px-4 py-2 {{ in_array(Route::currentRouteName(), ['barang.index', 'barang.create', 'barang.edit', 'barang.show']) ? 'bg-[#5CB8E4]' : '' }} rounded-lg hover:bg-[#3289B7] transition">
                        <i class="bx bx-box"></i> Data Barang
                    </a>
                </li>
            @endif

            @if(Route::has('kategori.index'))
                <li>
                    <a href="{{ route('kategori.index') }}" class="flex items-center gap-3 px-4 py-2 {{ in_array(Route::currentRouteName(), ['kategori.index', 'kategori.create', 'kategori.edit', 'kategori.show']) ? 'bg-[#5CB8E4]' : '' }} rounded-lg hover:bg-[#3289B7] transition">
                        <i class="bx bx-folder"></i> Data Kategori
                    </a>
                </li>
            @endif

            @if(Route::has('supplier.index'))
                <li>
                    <a href="{{ route('supplier.index') }}" class="flex items-center gap-3 px-4 py-2 {{ in_array(Route::currentRouteName(), ['supplier.index', 'supplier.create', 'supplier.edit', 'supplier.show']) ? 'bg-[#5CB8E4]' : '' }} rounded-lg hover:bg-[#3289B7] transition">
                        <i class="bx bxs-truck"></i> Data Supplier
                    </a>
                </li>
            @endif

            @if(Route::has('peminjaman.index'))
                <li>
                    <a href="{{ route('peminjaman.index') }}" class="flex items-center gap-3 px-4 py-2 {{ in_array(Route::currentRouteName(), ['peminjaman.index', 'peminjaman.create', 'peminjaman.edit', 'peminjaman.show']) ? 'bg-[#5CB8E4]' : '' }} rounded-lg hover:bg-[#3289B7] transition">
                        <i class="bx bxs-hand"></i> Peminjaman
                    </a>
                </li>
            @endif

            @if(Route::has('peminjam.index'))
            <li>
                <a href="{{ route('peminjam.index') }}" class="flex items-center gap-3 px-4 py-2 {{ in_array(Route::currentRouteName(), ['peminjam.index', 'peminjam.create', 'peminjam.edit', 'peminjam.show']) ? 'bg-[#5CB8E4]' : '' }} rounded-lg hover:bg-[#3289B7] transition">
                    <i class="bx bx-user"></i> Data Peminjam
                </a>
            </li>
            @endif

            @if(Route::has('barang_masuk.index'))
                <li>
                    <a href="{{ route('barang_masuk.index') }}" class="flex items-center gap-3 px-4 py-2 {{ in_array(Route::currentRouteName(), ['barang_masuk.index', 'barang_masuk.create', 'barang_masuk.edit', 'barang_masuk.show']) ? 'bg-[#5CB8E4]' : '' }} rounded-lg hover:bg-[#3289B7] transition">
                        <i class="bx bx-share" style="transform: scaleX(-1);"></i> Barang Masuk
                    </a>
                </li>
            @endif

            @if(Route::has('barang_keluar.index'))
                <li>
                    <a href="{{ route('barang_keluar.index') }}" class="flex items-center gap-3 px-4 py-2 {{ in_array(Route::currentRouteName(), ['barang_keluar.index', 'barang_keluar.create', 'barang_keluar.edit', 'barang_keluar.show']) ? 'bg-[#5CB8E4]' : '' }} rounded-lg hover:bg-[#3289B7] transition">
                        <i class="bx bx-share"></i> Barang Keluar
                    </a>
                </li>
            @endif

            <li class="border-t border-[#fff]"></li>

            @if(Route::has('user.index'))
            <li>
                <a href="{{ route('user.index') }}" class="flex items-center gap-3 px-4 py-2 {{ in_array(Route::currentRouteName(), ['user.index', 'user.create', 'user.edit', 'user.show']) ? 'bg-[#5CB8E4]' : '' }} rounded-lg hover:bg-[#3289B7] transition">
                    <i class="bx bxs-user"></i> Data Petugas
                </a>
            </li>
            @endif

            @if(Route::has('laporan.index'))
                <li>
                    <a href="{{ route('laporan.index') }}" class="flex items-center gap-3 px-4 py-2 {{ Route::currentRouteName() == 'laporan.index' ? 'bg-[#5CB8E4]' : '' }} rounded-lg hover:bg-[#3289B7] transition">
                        <i class="bx bx-file"></i> Laporan
                    </a>
                </li>
            @endif

            @if(Route::has('settings.index'))
                <li>
                    <a href="{{ route('settings.index') }}" class="flex items-center gap-3 px-4 py-2 {{ Route::currentRouteName() == 'settings.index' ? 'bg-[#5CB8E4]' : '' }} rounded-lg hover:bg-[#3289B7] transition">
                        <i class="bx bx-cog"></i> Settings
                    </a>
                </li>
            @endif

            <li>
                <form action="{{ route('logout.logout') }}" method="post" onsubmit="return confirm('Yakin ingin Logout?')">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-[#3289B7] transition">
                        <i class="bx bx-log-out"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </nav>

    <!-- Footer Sidebar -->
    <div class="text-center text-xs mt-6 text-gray-800">
        SMKN 02 Karanganyar Inc.
    </div>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        anime({
                targets: "#logo",
                opacity: [0, 1],
                scale: [0.9, 1],
                duration: 3000,
                easing: "easeOutBack"
            });
    });
</script>