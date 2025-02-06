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

    <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
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

        <div class="mt-4">
            <label class="block text-gray-700 font-semibold">Afbeelding</label>
            <div class="flex items-center space-x-4 mt-2">
                <img id="imagePreview" src="{{ asset('storage/' . $product->image) }}"
                     alt="Product Afbeelding" class="w-32 h-32 object-cover rounded-lg border">
                <label class="cursor-pointer bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg">
                    <span>Bestand kiezen</span>
                    <input type="file" name="image" class="hidden" onchange="previewImage(event)">
                </label>
            </div>
            <p id="uploadMessage" class="text-green-600 font-semibold mt-2 hidden">Afbeelding geselecteerd!</p>
        </div>

        <div class="flex justify-end mt-6">
            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg">
                Bijwerken
            </button>
        </div>
    </form>
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const img = document.getElementById('imagePreview');
            img.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);

        document.getElementById('uploadMessage').classList.remove('hidden');
    }
</script>
@endsection
