<nav>
    <div class="bg-white border-b border-gray-200 shadow-sm w-full">
        <div class="container mx-auto flex items-center justify-between py-3 px-4 max-w-screen-xl">
            <div class="flex items-center">
                <a href="{{ route('login') }}">
                    <img src="{{ asset('img/logo1_groot.png') }}" alt="Logo" class="h-12 w-auto">
                </a>
            </div>

            <h1 class="text-lg font-semibold text-gray-800 mx-auto">
                {{ $greeting }}
            </h1>

            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="p-2 rounded bg-[#FFD700] text-black focus:outline-none">
                    <div class="flex items-center space-x-2">
                        <i class="fa-solid fa-user"></i>
                        <i class="fa-solid fa-bars"></i>
                    </div>
                </button>

                <div x-show="open" @click.away="open = false"
                    class="absolute right-0 mt-2 w-48 bg-[#FFD700] rounded-md shadow-lg py-2">
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <a href="{{ route('logout') }}"
                            class="block px-4 py-2 text-black hover:bg-[#e6c200]">Uitloggen</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>