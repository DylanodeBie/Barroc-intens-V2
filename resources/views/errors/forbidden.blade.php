<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Toegang Geweigerd</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="text-center">
        <h1 class="text-4xl font-bold text-red-600">403 - Toegang Geweigerd</h1>
        <p class="mt-4 text-gray-700">Sorry, je hebt geen rechten om deze pagina te bekijken.</p>
        <p class="mt-4 text-gray-700">Je wordt doorgestuurd naar het juiste dashboard op basis van je rol.</p>

        @php
            $userRole = Auth::user()->role->id;
            $dashboardRoute = match($userRole) {
                2 => route('dashboard.finance'),
                3 => route('dashboard.sales'),
                4 => route('dashboard.marketing'),
                5 => route('dashboard.maintenance'),
                6 => route('dashboard.head-finance'),
                7 => route('dashboard.head-sales'),
                8 => route('dashboard.head-marketing'),
                9 => route('dashboard.head-maintenance'),
                10 => route('dashboard.ceo'),
                default => route('dashboard'),
            };
        @endphp

        <a href="{{ $dashboardRoute }}" class="mt-6 inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">
            Ga Terug naar Dashboard
        </a>
    </div>
</body>
</html>