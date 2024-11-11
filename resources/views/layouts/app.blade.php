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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://kit.fontawesome.com/bd40200337.js" crossorigin="anonymous"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex flex-col">
        <!-- Header Component -->
        <x-header />

        <div class="flex flex-grow">
            <!-- Sidebar Navigation -->
            <nav class="bg-gray-800 text-white w-1/5 p-4">
                <ul class="space-y-4">
                    <li class="bg-blue-600 p-2 rounded">Home</li>
                    <li class="p-2 rounded hover:bg-gray-700">Offerte maken</li>
                    <li class="p-2 rounded hover:bg-gray-700">Offertes</li>
                    <li class="p-2 rounded hover:bg-gray-700">Klant registreren</li>
                    <li class="p-2 rounded hover:bg-gray-700">Klanten</li>
                    <li class="p-2 rounded hover:bg-gray-700">Agenda</li>
                </ul>
            </nav>

            <!-- Main Content Area -->
            <main class="flex-grow p-8">
                @isset($header)
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                @endisset

                <div class="grid grid-cols-3 gap-4">
                    <!-- Nieuws Section -->
                    <section class="col-span-2 bg-white p-4 rounded shadow">
                        <h2 class="text-2xl font-bold mb-4">Nieuws</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
                    </section>

                    <!-- Agenda Section -->
                    <aside class="bg-white p-4 rounded shadow">
                        <h2 class="text-lg font-semibold">Agenda</h2>
                        <!-- Agenda content here -->
                    </aside>
                </div>
            </main>
        </div>

        <!-- Footer Component -->
        <x-footer />
    </div>
</body>

</html>
