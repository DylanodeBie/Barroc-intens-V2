@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-6 text-center">Factuur Bewerken</h1>

        <form action="{{ route('invoices.update', $invoice->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="customer_id" class="block font-semibold text-gray-700">Klant</label>
                <select name="customer_id" id="customer_id" class="form-control w-full border rounded-md p-2 text-black">
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}" @if ($customer->id == $invoice->customer_id) selected @endif>
                            {{ $customer->company_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="invoice_date" class="block font-semibold text-gray-700">Factuurdatum</label>
                <input type="date" name="invoice_date" id="invoice_date"
                    value="{{ $invoice->invoice_date->format('Y-m-d') }}" class="form-control w-full border rounded-md p-2">
            </div>

            <div class="mb-6">
                <label for="notes" class="block font-semibold text-gray-700">Notities</label>
                <textarea name="notes" id="notes" rows="3" class="form-control w-full border rounded-md p-2">{{ $invoice->notes }}</textarea>
            </div>

            <h2 class="text-2xl font-semibold mb-4">Factuuritems</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($products as $product)
                    @php
                        $existingItem = $invoice->items->firstWhere('description', $product->name);
                    @endphp
                    <div class="border rounded-md shadow p-4 flex flex-col">
                        <label class="flex items-center">
                            <input type="checkbox" name="items[{{ $product->id }}][selected]" value="1" class="mr-2"
                                @if ($existingItem) checked @endif>
                            <span class="font-semibold">{{ $product->name }}</span>
                        </label>
                        <p class="text-sm text-gray-600">{{ $product->description }}</p>
                        <p class="text-sm text-gray-600">
                            Prijs: €{{ number_format($product->price, 2, ',', '.') }}
                        </p>
                        <label class="mt-2 text-sm text-gray-700">
                            Aantal:
                            <input type="number" name="items[{{ $product->id }}][quantity]" min="1"
                                class="form-control w-full border rounded-md p-1 mt-1"
                                value="{{ $existingItem ? $existingItem->quantity : 1 }}">
                        </label>
                    </div>
                @endforeach
            </div>

            <div class="flex justify-between mt-6">
                <a href="{{ route('invoices.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                    Annuleren
                </a>
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
                    Opslaan en Bijwerken
                </button>
            </div>
        </form>
    </div>

    <script>
        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const quantityInput = this.closest('div').querySelector('input[type="number"]');
                quantityInput.disabled = !this.checked;
                if (!this.checked) quantityInput.value = 1;
            });
        });
    </script>
@endsection
