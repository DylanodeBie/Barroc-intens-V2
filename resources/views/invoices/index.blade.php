@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold mb-4 text-center text-black">Facturen Lijst</h1>

        <!-- "Nieuwe factuur maken" button -->
        <div class="flex justify-end mb-4">
            <a href="{{ route('invoices.create') }}" class="font-semibold px-6 py-2 rounded-md hover:bg-yellow-500"
                style="background-color: #FFD700; color: black;">
                <i class="fas fa-plus mr-2"></i> Nieuwe factuur maken
            </a>
        </div>

        <!-- Search bar -->
        <div class="flex justify-end mb-4">
            <div class="relative">
                <input type="text" placeholder="Zoeken..." class="border border-gray-300 rounded-full px-4 py-2 pr-10">
                <button class="absolute right-3 top-2 text-black">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>

        <!-- Invoices table -->
        <div class="overflow-x-auto border border-gray-200 rounded-lg">
            <table class="min-w-full bg-white border-collapse">
                <thead style="background-color: #FFD700;">
                    <tr>
                        <th class="px-6 py-3 text-left font-semibold text-black">Klant</th>
                        <th class="px-6 py-3 text-left font-semibold text-black">Factuurnummer</th>
                        <th class="px-6 py-3 text-left font-semibold text-black">Datum</th>
                        <th class="px-6 py-3 text-left font-semibold text-black">Totaal</th>
                        <th class="px-6 py-3 text-center font-semibold text-black">Acties</th>
                    </tr>
                </thead>
                <tbody class="text-black">
                    @forelse ($invoices as $invoice)
                        <tr class="border-b hover:bg-gray-100">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $invoice->customer?->company_name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $invoice->invoice_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $invoice->invoice_date ? $invoice->invoice_date->format('d-m-Y') : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                €{{ number_format($invoice->total_amount, 2, ',', '.') }}</td>
                            <td class="px-6 py-4 text-center flex justify-center gap-4">
                                <!-- View Invoice -->
                                <a href="{{ route('invoices.show', $invoice->id) }}" class="hover:text-gray-700"
                                    title="Bekijken" style="color: black;">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <!-- Edit Invoice -->
                                @if (in_array(auth()->user()->role->name, ['CEO', 'Admin']))
                                    <a href="{{ route('invoices.edit', $invoice->id) }}" class="hover:text-gray-700"
                                        title="Bewerken" style="color: black;">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endif

                                <!-- Download PDF -->
                                <a href="{{ route('invoices.download', $invoice->id) }}" class="hover:text-gray-700"
                                    title="Download PDF" style="color: black;">
                                    <i class="fas fa-download"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500">Geen facturen gevonden.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
