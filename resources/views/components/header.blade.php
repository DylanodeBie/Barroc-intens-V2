<nav class="">
    <div class="bg-gray-100 border-b border-gray-200 shadow-sm w-full">
        <div class="container mx-auto flex items-center justify-between py-3 px-4 max-w-screen-xl mx-auto">
            <div class="flex items-center">
                <img src="{{ asset('img/logo1_groot.png') }}" alt="Logo" class="h-12 w-auto">
            </div>


            <h1 class="text-lg font-semibold text-gray-800 mx-auto">
                @yield('greeting', 'Goedemorgen')
            </h1>

            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="p-2 rounded bg-yellow-500 text-white focus:outline-none">
                    <div class="flex items-center space-x-2">
                        <i class="fa-solid fa-user"></i>
                        <i class="fa-solid fa-bars"></i>
                    </div>
                </button>

                <div x-show="open" @click.away="open = false"
                    class="absolute right-0 mt-2 w-48 bg-yellow-500 rounded-md shadow-lg py-2">
                    <a href="#" class="block px-4 py-2 text-white hover:bg-yellow-700">Inloggen</a>
                    <a href="#" class="block px-4 py-2 text-white hover:bg-yellow-700">Registreren</a>
                    <a href="{{ url('/contact') }}" class="block px-4 py-2 text-white hover:bg-yellow-700">Contact</a>
                </div>
            </div>
        </div>
    </div>

</nav>
