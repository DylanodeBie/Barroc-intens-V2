@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-5">
    <h2 class="text-2xl font-semibold mb-4">Leasecontracten Keuring</h2>

    @if(session('success'))
    <div class="mb-4 p-4 bg-green-500 text-white rounded-lg">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="mb-4 p-4 bg-red-500 text-white rounded-lg">
        {{ session('error') }}
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($leasecontracts as $leasecontract)
        <div class="bg-white rounded-lg shadow-lg p-4">
            <h3 class="text-lg font-semibold mb-2">Leasecontract #{{ $leasecontract->id }}</h3>
            <div class="mb-4">
                <p><strong>Klant:</strong> {{ $leasecontract->customers->company_name ?? 'Geen klant' }}</p>
                <p><strong>Startdatum:</strong> {{ \Carbon\Carbon::parse($leasecontract->start_date)->format('d-m-Y') }}</p>
                <p><strong>Einddatum:</strong> {{ \Carbon\Carbon::parse($leasecontract->end_date)->format('d-m-Y') }}</p>
            </div>

            <div class="mb-4">
                <h4 class="text-md font-medium">Details:</h4>
                <ul class="list-disc list-inside">
                    <li><strong>Totale Prijs:</strong> €{{ number_format($leasecontract->price, 2) }}</li>
                    <li><strong>Status:</strong> {{ ucfirst($leasecontract->status) }}</li>
                </ul>
            </div>

            <!-- Acties -->
            <div class="mt-4 flex justify-between">
                <form action="{{ route('contracts.approve', $leasecontract->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-700">Goedkeuren</button>
                </form>
                <form action="{{ route('contracts.reject', $leasecontract->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-700">Afkeuren</button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center">
            <p class="text-gray-500">Geen leasecontracten in afwachting van goedkeuring.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection