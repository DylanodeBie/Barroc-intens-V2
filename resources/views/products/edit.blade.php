@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-4">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Product Bewerken</h1>
     @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
            <strong class="font-bold">Er zijn fouten!</strong>
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.update', $product) }}" method="POST">
        @method('PUT')
        @csrf
        <div>
            <label class="block text-gray-700 font-semibold">Naam</label>
            <input type="text" name="name" class="w-full border-gray-300 rounded-lg p-2 mt-1" value="{{ $product->name }}" required>
        </div>

        <div>
            <label class="block text-gray-700 font-semibold">Merk</label>
            <input type="text" name="brand" class="w-full border-gray-300 rounded-lg p-2 mt-1" value="{{ $product->brand }}" required>
        </div>
        <div>
            <label class="block text-gray-700 font-semibold">Omschrijving</label>
            <textarea name="description" class="w-full border-gray-300 rounded-lg p-2 mt-1" required>{{ $product->description }}</textarea>
        </div>
        <div>
            <label class="block text-gray-700 font-semibold">Voorraad</label>
            <input type="number" name="stock" class="w-full border-gray-300 rounded-lg p-2 mt-1" value="{{ $product->stock }}" required>
        </div>
        <div>
            <label class="block text-gray-700 font-semibold">Prijs</label>
            <input type="number" name="price" class="w-full border-gray-300 rounded-lg p-2 mt-1" value="{{ $product->price }}" step="0.01" required>
        </div>
        <div class="flex justify-end mt-4">
            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg">
                Bijwerken
            </button>
        </div>
    </form>
</div>
@endsection