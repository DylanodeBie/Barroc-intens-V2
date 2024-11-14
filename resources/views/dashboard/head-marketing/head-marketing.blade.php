@extends('layouts.app')

@section('content')
<div class="flex">
    <div class="flex flex-grow">
        <!-- Sidebar Navigation -->
        <nav class="bg-gray-800 text-white w-50 p-4">
            <ul class="space-y-4">
                <li class="bg-blue-600 p-2 rounded"><a href="#">Home</a></li>
                <li class="p-2 rounded hover:bg-gray-700"><a href="{{ route('products.index') }}">Producten</a></li>
                <li class="p-2 rounded hover:bg-gray-700"><a href="#">Bestellen</a></li>
            </ul>
        </nav>
    </div>
</div>

@endsection
