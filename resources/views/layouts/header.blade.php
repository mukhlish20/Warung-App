<header class="bg-white border-b fixed top-0 w-full z-50">
    <div class="h-16 px-4 flex items-center justify-between">

        {{-- KIRI --}}
        <div class="flex items-center gap-3">
            <button id="menuBtn" class="md:hidden text-2xl">
                ☰
            </button>

            <span class="font-semibold text-lg">
                Warung App
            </span>
        </div>

        {{-- MENU DESKTOP --}}
        <nav class="hidden md:flex gap-6 text-sm">
            <a href="#" class="hover:text-blue-600">Dashboard</a>
            <a href="#" class="hover:text-blue-600">Cabang</a>
        </nav>
    </div>

    {{-- MENU MOBILE (SATU-SATUNYA) --}}
    <div id="mobileMenu" class="hidden md:hidden border-t bg-white">
        <a href="#" class="block px-4 py-3 text-sm hover:bg-gray-100">Dashboard</a>
        <a href="#" class="block px-4 py-3 text-sm hover:bg-gray-100">Cabang</a>
    </div>
</header>

<script>
document.getElementById('menuBtn')
    ?.addEventListener('click', function () {
        document.getElementById('mobileMenu')
            .classList.toggle('hidden')
    })
</script>
