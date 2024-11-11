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
        <a href="{{ route('dashboard') }}" class="mt-6 inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">
            Ga Terug naar Dashboard
        </a>
    </div>
</body>
</html>