@section('greeting')
Nieuw product
@endsection

@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-4">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Nieuw Product</h1>

    <form action="{{ route('products.store') }}" method="POST">
        @csrf
        <div class="space-y-4">
            <div>
                <label class="block text-gray-700 font-semibold">Naam</label>
                <input type="text" name="name" class="w-full border-gray-300 rounded-lg p-2 mt-1" required>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold">Merk</label>
                <input type="text" name="brand" class="w-full border-gray-300 rounded-lg p-2 mt-1" required>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold">Omschrijving</label>
                <textarea name="description" class="w-full border-gray-300 rounded-lg p-2 mt-1" required></textarea>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold">Voorraad</label>
                <input type="number" name="stock" class="w-full border-gray-300 rounded-lg p-2 mt-1" required>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold">Prijs</label>
                <input type="number" name="price" class="w-full border-gray-300 rounded-lg p-2 mt-1" step="0.01" required>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold">Afbeelding</label>
                <input type="file" name="image" accept="image/*" class="border-gray-300 rounded-lg p-2 mt-1">
            </div>

            <div class="flex justify-end mt-4">
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg">
                    Opslaan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
