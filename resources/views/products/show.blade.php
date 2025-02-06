@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-4 flex">
        <div class="flex-1">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>

            <p class="text-lg text-gray-700 mb-4">{{ $product->brand }}</p>

            <p class="text-lg text-gray-700 mb-4">{{ $product->description }}</p>

            <div class="text-sm text-gray-600 mb-4">
                <p><span class="font-semibold">Voorraad:</span> {{ $product->stock }}</p>
                <p><span class="font-semibold">Prijs:</span> {{ number_format($product->price, 2) }} €</p>
            </div>

            <div class="flex space-x-4">
                <a href="{{ route('products.edit', $product) }}" class="text-yellow-500 hover:text-yellow-600 bg-gray-100 px-4 py-2 rounded-lg">
                    Bewerken
                </a>
                <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-800 bg-gray-100 px-4 py-2 rounded-lg">
                        Verwijderen
                    </button>
                </form>
            </div>
        </div>
        <div class="flex-shrink-0 ml-6">
            <img src="{{ asset('storage/' . $product->image) }}" alt="Product afbeelding" class="w-64 h-64 object-cover rounded">
        </div>
    </div>
@endsection
