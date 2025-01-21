@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold mb-4">Nieuw Leasecontract</h1>

    <form action="{{ route('leasecontracts.store') }}" method="POST">
        @csrf
        <div class="bg-white shadow-md rounded p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Leasecontractinformatie</h2>
            <div class="mb-4">
                <label for="customer_id" class="block text-gray-700 font-bold">Klant</label>
                <select name="customer_id" id="customer_id" class="w-full border rounded p-2">
                    @foreach($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->company_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="user_id" class="block text-gray-700 font-bold">Medewerker</label>
                <select name="user_id" id="user_id" class="w-full border rounded p-2">
                    @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="start_date" class="block text-gray-700 font-bold">Startdatum</label>
                <input type="date" name="start_date" id="start_date" class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label for="end_date" class="block text-gray-700 font-bold">Einddatum</label>
                <input type="date" name="end_date" id="end_date" class="w-full border rounded p-2">

                @if($errors->has('end_date'))
                    <p class="text-red-500 text-sm mt-2">{{ $errors->first('end_date') }}</p>
                @endif
            </div>

            <div class="mb-4">
                <label for="payment_method" class="block text-gray-700 font-bold">Betalingsmethode</label>
                <select name="payment_method" id="payment_method" class="w-full border rounded p-2">
                    <option value="maandelijks">Maandelijks</option>
                    <option value="per kwartaal">Per kwartaal</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="machine_amount" class="block text-gray-700 font-bold">Aantal Machines</label>
                <input type="number" name="machine_amount" id="machine_amount" class="w-full border rounded p-2">
            </div>

            <div class="mb-4">
                <label for="notice_period" class="block text-gray-700 font-bold">Opzegtermijn</label>
                <input type="text" name="notice_period" id="notice_period" class="w-full border rounded p-2">
            </div>

        </div>

        <div class="bg-white shadow-md rounded p-6">
            <h2 class="text-xl font-semibold mb-4">Producten</h2>
            <div id="products-container">
                <div class="product-row mb-4">
                    <select name="products[0][product_id]" class="w-full border rounded p-2 mb-2 product-select">
                        @foreach($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                            {{ $product->name }}
                            @if($product->type == 'machine')
                            (machine)
                            @elseif($product->type == 'coffee_bean')
                            (koffiebonen)
                            @endif
                        </option>
                        @endforeach
                    </select>
                    <input type="number" name="products[0][amount]" placeholder="Hoeveelheid" class="w-full border rounded p-2 mb-2 amount-input">
                    <input type="number" step="0.01" name="products[0][price]" placeholder="Prijs per stuk" value="{{ $products->first()->price }}" class="w-full border rounded p-2 mb-2 price-input" readonly>
                    <input type="number" step="0.01" name="products[0][total]" placeholder="Totaalprijs" class="w-full border rounded p-2 mb-2 total-input" readonly>
                </div>
            </div>

            <div class="text-right mt-4">
                <span class="font-bold">Totale prijs voor het contract: €<span id="total-contract-price">0.00</span></span>
            </div>

            <button type="button" id="add-product" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 mt-4">Product toevoegen</button>
        </div>

        <div class="mt-6">
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700">Opslaan</button>
        </div>
    </form>
</div>

<script>
    function calculateTotal() {
        const productRows = document.querySelectorAll('.product-row');
        let totalContractPrice = 0;

        productRows.forEach(row => {
            const productSelect = row.querySelector('.product-select');
            const amountInput = row.querySelector('.amount-input');
            const priceInput = row.querySelector('.price-input');
            const totalInput = row.querySelector('.total-input');

            if (productSelect && amountInput && priceInput && totalInput) {
                const unitPrice = parseFloat(productSelect.options[productSelect.selectedIndex].dataset.price || 0);
                const amount = parseInt(amountInput.value || 0);
                const total = unitPrice * amount;

                priceInput.value = unitPrice.toFixed(2);
                totalInput.value = total.toFixed(2);

                totalContractPrice += total;
            }
        });

        document.getElementById('total-contract-price').textContent = totalContractPrice.toFixed(2);
    }

    document.getElementById('products-container').addEventListener('input', function(e) {
        if (e.target.matches('.amount-input') || e.target.matches('.product-select')) {
            calculateTotal();
        }
    });

    document.getElementById('add-product').addEventListener('click', function() {
        const container = document.getElementById('products-container');
        const productCount = container.children.length;

        // Dynamisch HTML genereren voor het nieuwe product
        const newRow = `
        <div class="product-row mb-4">
            <select name="products[${productCount}][product_id]" class="w-full border rounded p-2 mb-2 product-select">
                @foreach($products as $product)
                <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                    {{ $product->name }} 
                    @if($product->type == 'machine')
                        (machine)
                    @elseif($product->type == 'coffee_bean')
                        (koffiebonen)
                    @endif
                </option>
                @endforeach
            </select>
            <input type="number" name="products[${productCount}][amount]" placeholder="Hoeveelheid" class="w-full border rounded p-2 mb-2 amount-input">
            <input type="number" step="0.01" name="products[${productCount}][price]" placeholder="Prijs per stuk" class="w-full border rounded p-2 mb-2 price-input" readonly>
            <input type="number" step="0.01" name="products[${productCount}][total]" placeholder="Totaalprijs" class="w-full border rounded p-2 mb-2 total-input" readonly>
        </div>
    `;

        // Voeg de nieuwe rij toe aan de container
        container.insertAdjacentHTML('beforeend', newRow);

        // Herbereken de totaalprijs
        calculateTotal();
    });
</script>
@endsection