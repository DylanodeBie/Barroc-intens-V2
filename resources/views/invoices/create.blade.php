@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-6 text-center">Factuur Maken</h1>

        <form action="{{ route('invoices.store') }}" method="POST" id="invoiceForm">
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

            <!-- Factuurdatum -->
            <div class="mb-4">
                <label for="invoice_date" class="block font-semibold text-gray-700">Factuurdatum</label>
                <input type="date" name="invoice_date" id="invoice_date"
                    class="form-control w-full border rounded-md p-2">
            </div>

            <!-- Producten met Aantal en Prijs -->
            <div class="mb-6">
                <label class="block font-semibold text-gray-700 mb-2">Producten</label>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($products as $product)
                        <div class="border rounded-md shadow p-4 flex flex-col items-start">
                            <label class="flex items-center">
                                <input type="checkbox" name="products[{{ $product->id }}][selected]" value="1"
                                    class="mr-2 product-checkbox" data-price="{{ $product->price }}">
                                <span class="font-semibold">{{ $product->name }}</span>
                            </label>
                            <p class="text-sm text-gray-600">Prijs: €{{ number_format($product->price, 2, ',', '.') }}</p>
                            <label class="mt-2 text-sm text-gray-700">
                                Aantal:
                                <input type="number" name="products[{{ $product->id }}][quantity]" min="1"
                                    value="1" class="form-control w-full border rounded-md p-1 mt-1 product-quantity"
                                    data-price="{{ $product->price }}" disabled>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Totaal Prijs -->
            <div class="mb-4">
                <label for="total_price" class="block font-semibold text-gray-700">Totaal Prijs</label>
                <input type="text" name="total_price" id="total_price" class="form-control w-full border rounded-md p-2"
                    placeholder="Bijvoorbeeld: €100,00">
                <small class="text-gray-600">De prijs wordt automatisch berekend, maar je kunt deze handmatig
                    aanpassen.</small>
            </div>

            <!-- Betaald Checkbox -->
            <div class="mb-4">
                <label for="is_paid" class="block font-semibold text-gray-700">Betaald</label>
                <input type="checkbox" name="is_paid" id="is_paid" class="form-checkbox h-5 w-5 text-yellow-500">
            </div>

            <!-- Actieknoppen -->
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const productCheckboxes = document.querySelectorAll('.product-checkbox');
            const productQuantities = document.querySelectorAll('.product-quantity');
            const totalPriceInput = document.getElementById('total_price');
            let manualOverride = false;

            function updateTotalPrice() {
                if (manualOverride) return;

                let total = 0;

                productCheckboxes.forEach((checkbox, index) => {
                    if (checkbox.checked) {
                        const price = parseFloat(checkbox.dataset.price);
                        const quantityInput = productQuantities[index];
                        const quantity = parseInt(quantityInput.value) || 1;

                        total += price * quantity;
                    }
                });

                totalPriceInput.value = `€ ${total.toFixed(2).replace('.', ',')}`;
            }

            productCheckboxes.forEach((checkbox, index) => {
                checkbox.addEventListener('change', function() {
                    const quantityInput = productQuantities[index];
                    quantityInput.disabled = !checkbox.checked;
                    if (!checkbox.checked) {
                        quantityInput.value = 1;
                    }
                    updateTotalPrice();
                });
            });

            productQuantities.forEach(quantityInput => {
                quantityInput.addEventListener('input', function() {
                    if (parseInt(quantityInput.value) < 1 || isNaN(quantityInput.value)) {
                        quantityInput.value = 1;
                    }
                    updateTotalPrice();
                });
            });

            totalPriceInput.addEventListener('input', function() {
                manualOverride = true;
            });

            updateTotalPrice(); // Initiële berekening
        });
    </script>
@endsection
