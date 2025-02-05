@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6 bg-white shadow-md rounded-lg">
        <h1 class="text-3xl font-bold text-center mb-6 text-black">Offerte Details</h1>

        <div class="mb-6">
            <p class="text-lg">
                <span class="font-semibold">Bedrijfsnaam:</span> {{ $quote->customer->company_name ?? 'Onbekend' }}
            </p>
            <p class="text-lg">
                <span class="font-semibold">Klantnr.:</span> {{ $quote->customer->id ?? 'Onbekend' }}
            </p>
            <p class="text-lg">
                <span class="font-semibold">Gebruiker:</span> {{ $quote->user->name ?? 'Onbekend' }}
            </p>
            <p class="text-lg">
                <span class="font-semibold">Status:</span> <span
                    class="capitalize">{{ $quote->status ?? 'Onbekend' }}</span>
            </p>
            <p class="text-lg">
                <span class="font-semibold">Looptijd Overeenkomst:</span>
                {{ $quote->agreement_length ?? 'Niet Gespecificeerd' }}
            </p>
            <p class="text-lg">
                <span class="font-semibold">Onderhoudsovereenkomst:</span>
                {{ $quote->maintenance_agreement ?? 'Niet Gespecificeerd' }}
            </p>
        </div>

        <div class="mb-6">
            <h3 class="text-2xl font-semibold mb-3">Machines</h3>
            @if ($quote->machines && $quote->machines->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($quote->machines as $machine)
                        <div class="p-4 border rounded-md shadow-sm bg-gray-50">
                            <p class="font-semibold">{{ $machine->name }}</p>
                            <p class="text-gray-700">Aantal: {{ $machine->pivot->quantity }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-600">Geen machines gekoppeld aan deze offerte.</p>
            @endif
        </div>

        <div class="mb-6">
            <h3 class="text-2xl font-semibold mb-3">Bonen</h3>
            @if ($quote->beans && $quote->beans->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($quote->beans as $bean)
                        <div class="p-4 border rounded-md shadow-sm bg-gray-50">
                            <p class="font-semibold">{{ $bean->name }}</p>
                            <p class="text-gray-700">Aantal: {{ $bean->pivot->quantity }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-600">Geen bonen gekoppeld aan deze offerte.</p>
            @endif
        </div>

        <div class="text-center">
            <a href="{{ route('quotes.index') }}" class="px-6 py-2 font-semibold rounded-md hover:bg-yellow-500"
                style="background-color: #FFD700; color: black;">Terug naar Offertes</a>
        </div>
    </div>
@endsection
