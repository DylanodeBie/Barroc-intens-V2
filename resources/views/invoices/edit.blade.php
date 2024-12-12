@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Factuur Bewerken</h1>
        <form action="{{ route('invoices.update', $invoice->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="customer_id" class="form-label">Klant:</label>
                <select name="customer_id" id="customer_id" class="form-select">
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}" {{ $customer->id == $invoice->customer_id ? 'selected' : '' }}>
                            {{ $customer->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="invoice_date" class="form-label">Factuurdatum:</label>
                <input type="date" name="invoice_date" id="invoice_date" class="form-control"
                    value="{{ $invoice->invoice_date }}" required>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Prijs:</label>
                <input type="number" name="price" id="price" class="form-control" step="0.01"
                    value="{{ $invoice->price }}" required>
            </div>

            <div class="mb-3">
                <label for="is_paid" class="form-label">Betaald:</label>
                <input type="checkbox" name="is_paid" id="is_paid" {{ $invoice->is_paid ? 'checked' : '' }}>
            </div>

            <button type="submit" class="btn btn-primary">Factuur Bijwerken</button>
        </form>
    </div>
@endsection
