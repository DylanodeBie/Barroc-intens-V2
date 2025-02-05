@section('greeting')
Producten
@endsection

@extends('layouts.app')

@section('content')
@if ($error)
    <div class="bg-red-100 text-red-800 p-2 rounded-lg mb-4">
        <p>{{ $error }}</p>
    </div>
@endif
<div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-4">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Producten</h1>
    <form method="GET" action="{{ route('products.index') }}" class="mb-6 flex space-x-4">
        @csrf
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Zoek op merk of beschrijving"
            class="px-4 py-2 border rounded-lg w-full" />
        <button type="submit" class="text-white bg-[#FFD700] hover:bg-[#e6c200] px-4 py-2 rounded-lg">
            Zoeken
        </button>
    </form>

    <a href="{{ route('products.create') }}"
        class="text-white bg-[#FFD700] hover:bg-[#e6c200] px-4 py-2 rounded-lg mb-4 inline-block">
        Nieuw Product
    </a>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded-lg mb-4">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <ul class="space-y-4">
        @foreach($products as $product)
            <li
                class="flex justify-between items-center bg-gray-100 border border-gray-300 rounded-lg p-4 shadow-lg hover:bg-gray-200 transition-all duration-300">
                <div class="flex items-center space-x-4">
                    <div class="flex flex-col justify-between items-start space-y-2">
                        <a href="{{ route('products.show', $product) }}"
                            class="text-xl font-semibold text-gray-900 hover:text-[#FFD700]">
                            {{ $product->name }}
                        </a>
                        <span class="text-sm text-gray-600">{{ $product->brand }}</span>
                        <span class="text-lg text-gray-900 font-bold">{{ number_format($product->price, 2) }} €</span>
                    </div>
                </div>

                <div class="flex flex-col items-end space-y-2">
                    <a href="{{ route('products.edit', $product) }}"
                        class="text-[#FFD700] hover:text-[#e6c200] font-semibold">
                        Bewerken
                    </a>
                    <form action="{{ route('products.destroy', $product) }}" method="POST"
                        onsubmit="return confirmDelete('{{ $product->name }}')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">
                            Verwijderen
                        </button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>
</div>

<script>
    function confirmDelete(productName) {
        return confirm(`Weet u zeker dat u ${productName} wilt verwijderen?`);
    }
</script>
@endsection
