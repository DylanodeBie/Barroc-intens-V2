<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://kit.fontawesome.com/bd40200337.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>



    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen flex flex-col">
        @include('components.header')

        @isset($header)
        <header class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endisset

        <div class="flex flex-grow">
            <nav class="bg-gray-800 text-white w-20 md:w-64 p-4 space-y-6">
                <ul class="space-y-4">
                    <li class="p-2 rounded text-center {{ Request::is('dashboard*') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                        <a href="{{ route('dashboard') }}" class="flex items-center justify-center space-x-2">
                            <i class="fas fa-home"></i> <span class="hidden md:block">Home</span>
                        </a>
                    </li>
                    <li class="p-2 rounded {{ Route::is('offerte.maken') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                        <a href="#" class="flex items-center justify-center space-x-2">
                            <i class="fas fa-file-signature"></i> <span class="hidden md:block">Offerte maken</span>
                        </a>
                    </li>
                    <li class="p-2 rounded {{ Route::is('offertes') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                        <a href="#" class="flex items-center justify-center space-x-2">
                            <i class="fas fa-file-alt"></i> <span class="hidden md:block">Offertes</span>
                        </a>
                    </li>
                    <li class="p-2 rounded {{ Route::is('klant.registreren') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                        <a href="#" class="flex items-center justify-center space-x-2">
                            <i class="fas fa-user-plus"></i> <span class="hidden md:block">Klant registreren</span>
                        </a>
                    </li>
                    <li class="p-2 rounded {{ Route::is('klanten') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                        <a href="#" class="flex items-center justify-center space-x-2">
                            <i class="fas fa-users"></i> <span class="hidden md:block">Klanten</span>
                        </a>
                    </li>
                    <li class="p-2 rounded {{ Route::is('agenda') ? 'bg-blue-600' : 'hover:bg-gray-700' }}">
                        <a href="{{ route('agenda') }}" class="flex items-center justify-center space-x-2">
                            <i class="fas fa-calendar"></i> <span class="hidden md:block">Agenda</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="flex-grow p-6 overflow-auto">
                @yield('content')
            </div>
        </div>

        @include('components.footer')
    </div>
</body>

</html>
