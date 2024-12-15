@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-4">Factuur Details</h1>

        <!-- Invoice Details -->
        <div class="border p-4 rounded-md shadow-md">
            <p><strong>Factuurnummer:</strong> {{ $invoice->invoice_number }}</p>
            <p><strong>Klant:</strong> {{ $invoice->customer->company_name }}</p>
            <p><strong>Factuurdatum:</strong> {{ $invoice->invoice_date->format('d-m-Y') }}</p>
            <p><strong>Totaalbedrag:</strong> €{{ number_format($invoice->total_amount, 2, ',', '.') }}</p>
            <p><strong>Status:</strong> {{ ucfirst($invoice->status) }}</p>
            <p><strong>Notities:</strong> {{ $invoice->notes ?? 'Geen' }}</p>
        </div>

        <!-- Invoice Items -->
        <h2 class="text-2xl font-semibold mt-6">Items</h2>
        <table class="min-w-full mt-4 bg-white border rounded-md">
            <thead>
                <tr>
                    <th class="py-2 px-4 border">Omschrijving</th>
                    <th class="py-2 px-4 border">Aantal</th>
                    <th class="py-2 px-4 border">Prijs per stuk</th>
                    <th class="py-2 px-4 border">Subtotaal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoice->items as $item)
                    <tr>
                        <td class="py-2 px-4 border">{{ $item->description }}</td>
                        <td class="py-2 px-4 border">{{ $item->quantity }}</td>
                        <td class="py-2 px-4 border">€{{ number_format($item->unit_price, 2, ',', '.') }}</td>
                        <td class="py-2 px-4 border">€{{ number_format($item->subtotal, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Back Button -->
        <div class="mt-6">
            <a href="{{ route('invoices.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded">
                Terug naar overzicht
            </a>
        </div>
    </div>
@endsection
