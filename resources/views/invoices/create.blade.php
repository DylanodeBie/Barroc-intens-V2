@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-6 text-center">Factuur Maken</h1>

        <form action="{{ route('invoices.store') }}" method="POST">
            @csrf

            <!-- Customer Dropdown -->
            <div class="mb-4">
                <label for="customer_id" class="block font-semibold text-gray-700">Klant</label>
                <select name="customer_id" id="customer_id" class="form-control w-full border rounded-md p-2 text-black">
                    <option value="" disabled selected>Kies een klant</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}" style="color: black;">{{ $customer->company_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Invoice Date -->
            <div class="mb-4">
                <label for="invoice_date" class="block font-semibold text-gray-700">Factuurdatum</label>
                <input type="date" name="invoice_date" id="invoice_date"
                    class="form-control w-full border rounded-md p-2">
            </div>

            <!-- Items Section -->
            <div class="mb-6">
                <label class="block font-semibold text-gray-700 mb-2">Items</label>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($items as $item)
                        <div class="border rounded-md shadow p-4 flex flex-col items-start">
                            <label class="flex items-center">
                                <input type="checkbox" name="items[{{ $item->id }}][selected]" value="1"
                                    class="mr-2">
                                <span class="font-semibold">{{ $item->name }}</span>
                            </label>
                            <p class="text-sm text-gray-600">Prijs: €{{ number_format($item->price, 2, ',', '.') }}</p>
                            <label class="mt-2 text-sm text-gray-700">
                                Aantal:
                                <input type="number" name="items[{{ $item->id }}][quantity]" min="1"
                                    value="1" class="form-control w-full border rounded-md p-1 mt-1">
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Notes -->
            <div class="mb-4">
                <label for="notes" class="block font-semibold text-gray-700">Notities</label>
                <textarea name="notes" id="notes" rows="3" class="form-control w-full border rounded-md p-2"
                    placeholder="Optioneel..."></textarea>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-between mt-6">
                <a href="{{ route('invoices.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                    Terug
                </a>
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
                    Opslaan en Verzenden
                </button>
            </div>
        </form>
    </div>
@endsection
