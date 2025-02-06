@extends('layouts.app')

@section('greeting')
Nieuw product
@endsection

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-4">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Nieuw Product</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" onsubmit="return validateFields()" enctype="multipart/form-data">
        @csrf
        <div class="space-y-4">
            <div>
                <label class="block text-gray-700 font-semibold">Naam</label>
                <input type="text" name="name" id="name" class="w-full border-gray-300 rounded-lg p-2 mt-1" required>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold">Merk</label>
                <input type="text" name="brand" id="brand" class="w-full border-gray-300 rounded-lg p-2 mt-1" required>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold">Omschrijving</label>
                <textarea name="description" id="description" class="w-full border-gray-300 rounded-lg p-2 mt-1" required></textarea>
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
                <label class="cursor-pointer bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg">
                    <span>Bestand kiezen</span>
                    <input type="file" name="image" class="hidden" onchange="previewImage(event)">
                </label>
                <div class="mt-2">
                    <img id="imagePreview" class="w-32 h-32 object-cover hidden">
                </div>
                <p id="uploadMessage" class="text-green-600 font-semibold mt-2 hidden">Afbeelding geselecteerd!</p>
            </div>

            <div class="flex justify-end mt-4">
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg">
                    Opslaan
                </button>
            </div>
        </div>
    </form>
</div>

<script>
function validateFields() {
    const name = document.getElementById('name').value;
    const brand = document.getElementById('brand').value;
    const description = document.getElementById('description').value;
    const regex = /\d/;

    if (regex.test(name) || regex.test(brand) || regex.test(description)) {
        return confirm("Weet u zeker dat hier nummers gebruikt moeten worden?");
    }

    return true;
}

function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function() {
        const img = document.getElementById('imagePreview');
        img.src = reader.result;
        img.classList.remove('hidden');
    }
    reader.readAsDataURL(event.target.files[0]);

    document.getElementById('uploadMessage').classList.remove('hidden');

}


</script>
@endsection
