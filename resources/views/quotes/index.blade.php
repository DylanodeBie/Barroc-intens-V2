@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold mb-4 text-center text-black">Offertes Lijst</h1>

        <!-- "Nieuwe offerte maken" button -->
        <div class="flex justify-end mb-4">
            <a href="{{ route('quotes.create') }}" class="font-semibold px-6 py-2 rounded-md hover:bg-yellow-500"
                style="background-color: #FFD700; color: black;">
                <i class="fas fa-plus mr-2"></i> Nieuwe offerte maken
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

        <!-- Quotes table -->
        <div class="overflow-x-auto border border-gray-200 rounded-lg">
            <table class="min-w-full bg-white border-collapse">
                <thead style="background-color: #FFD700;">
                    <tr>
                        <th class="px-6 py-3 text-left font-semibold text-black">Klant</th>
                        <th class="px-6 py-3 text-left font-semibold text-black">Gebruiker</th>
                        <th class="px-6 py-3 text-left font-semibold text-black">Status</th>
                        <th class="px-6 py-3 text-left font-semibold text-black">Datum</th>
                        <th class="px-6 py-3 text-center font-semibold text-black">Acties</th>
                    </tr>
                </thead>
                <tbody class="text-black">
                    @forelse ($quotes as $quote)
                        <tr class="border-b hover:bg-gray-100">
                            <!-- Updated to display company_name -->
                            <td class="px-6 py-4 whitespace-nowrap">{{ $quote->customer?->company_name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $quote->user?->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($quote->status) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $quote->quote_date ? $quote->quote_date->format('d-m-Y') : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 text-center flex justify-center gap-4">
                                <!-- View icon -->
                                <a href="{{ route('quotes.show', $quote->id) }}" class="hover:text-gray-700"
                                    title="Bekijken" style="color: black;">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <!-- Edit action for specific roles -->
                                @if (in_array(auth()->user()->role->name, ['CEO', 'Sales', 'Head Sales']))
                                    <a href="{{ route('quotes.edit', $quote->id) }}" class="hover:text-gray-700"
                                        title="Bewerken" style="color: black;">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endif

                                <!-- Download action -->
                                <a href="{{ route('quotes.download', $quote->id) }}" class="hover:text-gray-700"
                                    title="Download PDF" style="color: black;">
                                    <i class="fas fa-download"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500">Geen offertes gevonden.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
