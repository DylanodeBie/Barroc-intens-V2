@extends('layouts.app')

@section('content')
<div class="flex">
    <div class="flex flex-grow">
        <!-- Sidebar Navigation -->
        <nav class="bg-gray-800 text-white w-50 p-4">
            <ul class="space-y-4">
                <li class="bg-blue-600 p-2 rounded"><a href="#">Home</a></li>
                <li class="p-2 rounded hover:bg-gray-700"><a href="#">Meldingen</a></li>
                <li class="p-2 rounded hover:bg-gray-700"><a href="#">Klanten</a></li>
                <li class="p-2 rounded hover:bg-gray-700"><a href="#">Agenda</a></li>
            </ul>
        </nav>
    </div>

    <div class="flex-grow p-4">
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
    </div>
</div>

@endsection
