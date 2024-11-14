@section('greeting')
    Producten
@endsection

@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-4">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Producten</h1>

        <!-- Search Form -->
        <form method="GET" action="{{ route('products.index') }}" class="mb-6 flex space-x-4">
            @csrf
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Zoek op merk of beschrijving"
                   class="px-4 py-2 border rounded-lg w-full" />
            <button type="submit" class="text-white bg-yellow-500 hover:bg-yellow-600 px-4 py-2 rounded-lg">
                Zoeken
            </button>
        </form>

        <a href="{{ route('products.create') }}" class="text-white bg-yellow-500 hover:bg-yellow-600 px-4 py-2 rounded-lg mb-4 inline-block">
            Nieuw Product
        </a>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-2 rounded-lg mb-4">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <ul class="space-y-4">
            @foreach($products as $product)
                <li class="flex justify-between items-center bg-gray-100 border border-gray-300 rounded-lg p-4 shadow-lg hover:bg-gray-200 transition-all duration-300">
                    <div class="flex items-center space-x-4">
                        <!-- Product afbeelding -->
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-32 h-32 object-cover rounded-lg">

                        <!-- Product informatie -->
                        <div class="flex flex-col justify-between items-start space-y-2">
                            <a href="{{ route('products.show', $product) }}" class="text-xl font-semibold text-gray-900 hover:text-yellow-500">
                                {{ $product->name }}
                            </a>
                            <span class="text-sm text-gray-600">{{ $product->brand }}</span>
                            <span class="text-lg text-gray-900 font-bold">{{ number_format($product->price, 2) }} €</span>
                        </div>
                    </div>

                    <div class="flex flex-col items-end space-y-2">
                        <a href="{{ route('products.edit', $product) }}" class="text-yellow-500 hover:text-yellow-600 font-semibold">Bewerken</a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">Verwijderen</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
