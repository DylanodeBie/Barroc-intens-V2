<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts, Tailwind, Alpine, FontAwesome, Bootstrap, etc. -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://kit.fontawesome.com/bd40200337.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen flex flex-col">
        {{-- Include the header --}}
        @include('components.header')

        {{-- Optional page header --}}
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <div class="flex flex-grow">
            {{-- Sidebar Navigation --}}
            @php
                // Retrieve the current user's role; default to 'Guest' if not logged in.
                $user = auth()->user();
                $role = $user ? $user->role->name : 'Guest';
            @endphp

            <nav class="bg-white text-black w-20 md:w-64 p-4 space-y-4 border-r">
                <ul class="space-y-2">
                    @if($role === 'CEO')
                        <!-- CEO: Unified navigation with all links -->
                        <li
                            class="p-2 rounded text-center {{ Request::is('dashboard/ceo*') ? 'bg-gray-200' : 'hover:bg-[#FFD700]' }}">
                            <a href="{{ route('dashboard.ceo') }}" class="flex items-center justify-center space-x-2">
                                <i class="fas fa-home"></i>
                                <span class="hidden md:block">Home</span>
                            </a>
                        </li>
                        <li class="p-2 rounded hover:bg-[#FFD700]">
                            <a href="{{ route('quotes.index') }}">Offertes</a>
                        </li>
                        <li class="p-2 rounded hover:bg-[#FFD700]">
                            <a href="{{ route('quotes.create') }}">Offerte Maken</a>
                        </li>
                        <li class="p-2 rounded hover:bg-[#FFD700]">
                            <a href="{{ route('invoices.index') }}">Facturen</a>
                        </li>
                        <li class="p-2 rounded hover:bg-[#FFD700]">
                            <a href="{{ route('leasecontracts.index') }}">Contracten</a>
                        </li>
                        <li class="p-2 rounded hover:bg-[#FFD700]">
                            <a href="{{ route('contracts.approval') }}">Contracten keuring</a>
                        </li>
                        <li class="p-2 rounded hover:bg-[#FFD700]">
                            <a href="{{ route('customers.index') }}">Klanten</a>
                        </li>
                        <li class="p-2 rounded hover:bg-[#FFD700]">
                            <a href="{{ route('profit_distribution.index') }}">Winstverdeling</a>
                        </li>
                        <li class="p-2 rounded hover:bg-[#FFD700]">
                            <a href="{{ route('agenda') }}">Agenda</a>
                        </li>
                        <li class="p-2 rounded hover:bg-[#FFD700]">
                            <a href="{{ route('products.index') }}">Producten</a>
                        </li>
                        <li class="p-2 rounded hover:bg-[#FFD700]">
                            <a href="{{ route('parts.index') }}">Voorraad</a>
                        </li>
                        <li class="p-2 rounded hover:bg-[#FFD700]">
                            <a href="{{ url('parts') }}">Bestellingen</a>
                        </li>
                        <li class="p-2 rounded hover:bg-[#FFD700]">
                            <a href="{{ route('visits.index') }}">Bezoeken</a>
                        </li>

                    @elseif($role === 'Finance' || $role === 'Head Finance')
                        <!-- Finance Navigation -->
                        <li
                            class="p-2 rounded text-center {{ Request::is('dashboard/finance*') ? 'bg-gray-200' : 'hover:bg-[#FFD700]' }}">
                            <a href="{{ route('dashboard.finance') }}" class="flex items-center justify-center space-x-2">
                                <i class="fas fa-home"></i>
                                <span class="hidden md:block">Home</span>
                            </a>
                        </li>
                        <li class="p-2 rounded hover:bg-[#FFD700]">
                            <a href="{{ route('quotes.index') }}">Offertes</a>
                        </li>
                        <li class="p-2 rounded hover:bg-[#FFD700]">
                            <a href="{{ route('invoices.index') }}">Facturen</a>
                        </li>
                        <li class="p-2 rounded hover:bg-[#FFD700]">
                            <a href="{{ route('leasecontracts.index') }}">Contracten</a>
                        </li>
                        <li class="p-2 rounded hover:bg-[#FFD700]">
                            <a href="{{ route('customers.index') }}">Klanten</a>
                        </li>
                        <li class="p-2 rounded hover:bg-[#FFD700]">
                            <a href="{{ route('profit_distribution.index') }}">Winstverdeling</a>
                        </li>

                    @elseif($role === 'Sales' || $role === 'Head Sales')
                        <!-- Sales Navigation -->
                        <li
                            class="p-2 rounded text-center {{ Request::is('dashboard/sales*') ? 'bg-gray-200' : 'hover:bg-[#FFD700]' }}">
                            <a href="{{ route('dashboard.sales') }}" class="flex items-center justify-center space-x-2">
                                <i class="fas fa-home"></i>
                                <span class="hidden md:block">Home</span>
                            </a>
                        </li>
                        <li class="p-2 rounded hover:bg-[#FFD700]">
                            <a href="{{ route('quotes.create') }}">Offerte Maken</a>
                        </li>
                        <li class="p-2 rounded hover:bg-[#FFD700]">
                            <a href="{{ route('quotes.index') }}">Offertes</a>
                        </li>
                        <li class="p-2 rounded hover:bg-[#FFD700]">
                            <a href="{{ route('customers.create') }}">Klant registreren</a>
                        </li>
                        <li class="p-2 rounded hover:bg-[#FFD700]">
                            <a href="{{ route('customers.index') }}">Klanten</a>
                        </li>
                        <li class="p-2 rounded hover:bg-[#FFD700]">
                            <a href="{{ route('agenda') }}">Agenda</a>
                        </li>
                        <!-- For Sales, "Meldingen" is handled via visits -->
                        <li class="p-2 rounded hover:bg-[#FFD700]">
                            <a href="{{ route('visits.index') }}">Meldingen</a>
                        </li>

                    @elseif($role === 'Marketing' || $role === 'Inkoop')
                        <!-- Inkoop Navigation -->
                        <li
                            class="p-2 rounded text-center {{ Request::is('dashboard/marketing*') ? 'bg-gray-200' : 'hover:bg-[#FFD700]' }}">
                            <a href="{{ route('dashboard.marketing') }}" class="flex items-center justify-center space-x-2">
                                <i class="fas fa-home"></i>
                                <span class="hidden md:block">Home</span>
                            </a>
                        </li>
                        <li class="p-2 rounded hover:bg-[#FFD700]">
                            <a href="{{ route('products.index') }}">Producten</a>
                        </li>
                        <li class="p-2 rounded hover:bg-[#FFD700]">
                            <a href="{{ route('parts.index') }}">Voorraad</a>
                        </li>
                        <li class="p-2 rounded hover:bg-[#FFD700]">
                            <a href="{{ url('parts') }}">Bestellingen</a>
                        </li>

                    @elseif($role === 'Maintenance' || $role === 'Head Maintenance')
                        <!-- Maintenance Navigation -->
                        <li
                            class="p-2 rounded text-center {{ Request::is('dashboard/maintenance*') ? 'bg-gray-200' : 'hover:bg-[#FFD700]' }}">
                            <a href="{{ route('dashboard.maintenance') }}"
                                class="flex items-center justify-center space-x-2">
                                <i class="fas fa-home"></i>
                                <span class="hidden md:block">Home</span>
                            </a>
                        </li>
                        <li class="p-2 rounded hover:bg-[#FFD700]">
                            <a href="{{ route('products.index') }}">Producten</a>
                        </li>
                        <!-- For Maintenance, "Meldingen" points to maintenance tickets -->
                        <li class="p-2 rounded hover:bg-[#FFD700]">
                            <a href="{{ route('visits.my_tickets') }}">Meldingen</a>
                        </li>
                        <li class="p-2 rounded hover:bg-[#FFD700]">
                            <a href="{{ route('customers.index') }}">Klanten</a>
                        </li>
                        <li class="p-2 rounded hover:bg-[#FFD700]">
                            <a href="{{ route('agenda') }}">Agenda</a>
                        </li>

                    @else
                        <!-- Default fallback -->
                        <li class="p-2 rounded text-center">
                            <a href="{{ route('dashboard') }}" class="flex items-center justify-center space-x-2">
                                <i class="fas fa-home"></i>
                                <span class="hidden md:block">Home</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>

            <!-- Main Content Area -->
            <div class="flex-grow p-6 overflow-auto">
                @yield('content')
            </div>
        </div>

        {{-- Include the footer --}}
        @include('components.footer')
    </div>
</body>

</html>
