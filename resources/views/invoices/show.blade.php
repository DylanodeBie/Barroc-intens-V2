@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold mb-4 text-center text-black">Factuur #{{ $invoice->id }}</h1>

        <p><strong>Klant:</strong> {{ $invoice->customer?->company_name ?? 'N/A' }}</p>
        <p><strong>Gebruiker:</strong> {{ $invoice->user?->name ?? 'N/A' }}</p>
        <p><strong>Datum:</strong> {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d-m-Y') }}</p>
        <p><strong>Status:</strong> {{ $invoice->is_paid ? 'Betaald' : 'Onbetaald' }}</p>
        <p><strong>Totaalprijs:</strong> € {{ number_format($invoice->price, 2) }}</p>

        <h2 class="text-2xl font-bold mt-6 mb-4 text-black">Producten</h2>
        <div class="overflow-x-auto border border-gray-200 rounded-lg">
            <table class="min-w-full bg-white border-collapse">
                <thead style="background-color: #FFD700;">
                    <tr>
                        <th class="px-6 py-3 text-left font-semibold text-black">Product</th>
                        <th class="px-6 py-3 text-left font-semibold text-black">Aantal</th>
                        <th class="px-6 py-3 text-left font-semibold text-black">Prijs per stuk</th>
                        <th class="px-6 py-3 text-left font-semibold text-black">Subtotaal</th>
                    </tr>
                </thead>
                <tbody class="text-black">
                    @forelse ($invoice->products as $product)
                        <tr class="border-b hover:bg-gray-100">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $product->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $product->pivot->amount }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">€ {{ number_format($product->pivot->price, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">€
                                {{ number_format($product->pivot->amount * $product->pivot->price, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-gray-500">Geen producten gekoppeld aan deze
                                factuur.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <a href="{{ route('invoices.index') }}" class="btn btn-secondary mt-4">Terug naar overzicht</a>
    </div>
@endsection
