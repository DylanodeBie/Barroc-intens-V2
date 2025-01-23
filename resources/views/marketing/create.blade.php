@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-4 text-center text-black">Nieuw Onderdeel Toevoegen</h1>
    <form action="{{ route('parts.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="name" class="block font-semibold mb-2">Naam</label>
            <input type="text" id="name" name="name" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        </div>
        <div class="mb-4">
            <label for="stock" class="block font-semibold mb-2">Voorraad</label>
            <input type="number" id="stock" name="stock" min="0" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        </div>
        <div class="mb-4">
            <label for="price" class="block font-semibold mb-2">Prijs</label>
            <input type="number" id="price" name="price" min="0" step="0.01" required
                class="w-full px-4 py-2 border border-gray-300 rounded-lg">
        </div>
        <button type="submit" class="px-6 py-2 rounded-md text-white bg-blue-600 hover:bg-blue-500">
            Onderdeel Opslaan
        </button>
    </form>
</div>
@endsection
