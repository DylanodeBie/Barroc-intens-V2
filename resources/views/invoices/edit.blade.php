@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-6 text-center">Factuur Bewerken</h1>

        <form action="{{ route('invoices.update', $invoice->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Customer Dropdown -->
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

            <!-- Invoice Date -->
            <div class="mb-4">
                <label for="invoice_date" class="block font-semibold text-gray-700">Factuurdatum</label>
                <input type="date" name="invoice_date" id="invoice_date"
                    value="{{ $invoice->invoice_date->format('Y-m-d') }}" class="form-control w-full border rounded-md p-2">
            </div>

            <!-- Notes -->
            <div class="mb-4">
                <label for="notes" class="block font-semibold text-gray-700">Notities</label>
                <textarea name="notes" id="notes" rows="3" class="form-control w-full border rounded-md p-2">{{ $invoice->notes }}</textarea>
            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
                    Opslaan
                </button>
            </div>
        </form>
    </div>
@endsection
