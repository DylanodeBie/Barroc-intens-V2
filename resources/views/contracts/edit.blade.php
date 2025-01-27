@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Leasecontract Bewerken</h1>
    <form action="{{ route('leasecontracts.update', $leasecontract->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="customer_id">Klant</label>
            <select name="customer_id" id="customer_id" class="form-control">
                @foreach($customers as $customer)
                <option value="{{ $customer->id }}" {{ $leasecontract->customer_id == $customer->id ? 'selected' : '' }}>
                    {{ $customer->company_name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="user_id">Gebruiker</label>
            <select name="user_id" id="user_id" class="form-control">
                @foreach($users as $user)
                <option value="{{ $user->id }}" {{ $leasecontract->user_id == $user->id ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="start_date">Startdatum</label>
            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $leasecontract->start_date }}">
        </div>

        <div class="form-group">
            <label for="end_date">Einddatum</label>
            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $leasecontract->end_date }}">
        </div>

        <div class="form-group">
            <label for="payment_method">Betaalmethode</label>
            <input type="text" name="payment_method" id="payment_method" class="form-control" value="{{ $leasecontract->payment_method }}">
        </div>

        <div class="form-group">
            <label for="machine_amount">Aantal Machines</label>
            <input type="number" name="machine_amount" id="machine_amount" class="form-control" value="{{ $leasecontract->machine_amount }}">
        </div>

        <div class="form-group">
            <label for="notice_period">Opzegtermijn</label>
            <input type="text" name="notice_period" id="notice_period" class="form-control" value="{{ $leasecontract->notice_period }}">
        </div>

        <h4>Gekoppelde Producten</h4>
        <div id="products-container">
            @foreach($linkedProducts as $product)
            <div class="form-check">
                <input type="hidden" name="products[{{ $product->id }}][product_id]" value="0">
                <input type="checkbox" name="products[{{ $product->id }}][product_id]" value="{{ $product->id }}" checked>
                <label>{{ $product->name }}</label>
                <input type="number" name="products[{{ $product->id }}][amount]" placeholder="Aantal" value="{{ $product->pivot->amount ?? '' }}">
                <input type="number" step="0.01" name="products[{{ $product->id }}][price]" placeholder="Prijs" value="{{ $product->pivot->price ?? '' }}">
            </div>
            @endforeach
        </div>

        <div class="text-right mt-4">
            <span class="font-bold">Extra voor het contract: €<span id="total-contract-price">0.00</span></span>
        </div>

        <button type="button" id="add-product" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 mt-4">Product toevoegen</button>

        <button type="submit" class="btn btn-primary mt-4">Opslaan</button>
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
                const unitPrice = parseFloat(productSelect.options[productSelect.selectedIndex]?.dataset.price || 0);
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

        const newRow = `
            <div class="product-row mb-4">
                <select name="products[${productCount}][product_id]" class="w-full border rounded p-2 mb-2 product-select">
                    @foreach($unlinkedProducts as $product)
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

        container.insertAdjacentHTML('beforeend', newRow);
        calculateTotal();
    });

    // Bereken de initiële totale prijs
    calculateTotal();
</script>
@endsection