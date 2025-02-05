<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://kit.fontawesome.com/bd40200337.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen flex flex-col">
        @include('components.header')

        <div class="flex flex-grow">
            <nav class="bg-gray-800 text-white w-20 md:w-64 p-4 space-y-6">
                <ul class="space-y-4">
                    <li class="bg-blue-600 p-2 rounded text-center">
                        <a href="#">Home</a>
                    </li>
                    <li class="p-2 rounded hover:bg-gray-700">
                        <a href="#">Offerte maken</a>
                    </li>
                    <li class="p-2 rounded hover:bg-gray-700">
                        <a href="#">Offertes</a>
                    </li>
                    <li class="p-2 rounded hover:bg-gray-700">
                        <a href="#">Klant registreren</a>
                    </li>
                    <li class="p-2 rounded hover:bg-gray-700">
                        <a href="#">Klanten</a>
                    </li>
                    <li class="p-2 rounded hover:bg-gray-700">
                        <a href="#">Agenda</a>
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
