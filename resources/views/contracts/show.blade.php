@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-bold mb-4">Leasecontract Details</h1>

    <div class="bg-white shadow-md rounded p-6">
        <h2 class="text-xl font-semibold mb-2">Contractinformatie</h2>
        <p><strong>Klant:</strong> {{ $leasecontract->customers->company_name }}</p>
        <p><strong>Medewerker:</strong> {{ $leasecontract->users->name }}</p>
        <p><strong>Startdatum:</strong> {{ $leasecontract->start_date }}</p>
        <p><strong>Einddatum:</strong> {{ $leasecontract->end_date }}</p>
        <p><strong>Betalingsmethode:</strong> {{ $leasecontract->payment_method }}</p>
        <p><strong>Aantal Machines:</strong> {{ $leasecontract->machine_amount }}</p>
        <p><strong>Opzegtermijn:</strong> {{ $leasecontract->notice_period }}</p>
        <p><strong>Status:</strong> {{ ucfirst($leasecontract->status) }}</p>
    </div>

    <div class="mt-6">
        <h2 class="text-xl font-semibold mb-4">Gekoppelde Producten</h2>
        @if($leasecontract->products->count())
        <table class="table-auto w-full border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2">Product</th>
                    <th class="border px-4 py-2">Hoeveelheid</th>
                    <th class="border px-4 py-2">Prijs per stuk</th>
                    <th class="border px-4 py-2">Totaalprijs</th>
                </tr>
            </thead>
            <tbody>
                @php $totalContractPrice = 0; @endphp
                @foreach($leasecontract->products as $product)
                @php $totalProductPrice = $product->pivot->amount * $product->pivot->price; @endphp
                <tr>
                    <td class="border px-4 py-2">{{ $product->name }}</td>
                    <td class="border px-4 py-2">{{ $product->pivot->amount }}</td>
                    <td class="border px-4 py-2">€{{ number_format($product->pivot->price, 2) }}</td>
                    <td class="border px-4 py-2">€{{ number_format($totalProductPrice, 2) }}</td>
                </tr>
                @php $totalContractPrice += $totalProductPrice; @endphp
                @endforeach
            </tbody>
        </table>
        <div class="text-right mt-4">
            <span class="font-bold">Totale prijs voor het contract: €{{ number_format($totalContractPrice, 2) }}</span>
        </div>
        @else
        <p>Geen producten gekoppeld aan dit contract.</p>
        @endif
    </div>

    <div class="mt-6 space-x-4">
        <a href="{{ route('leasecontracts.index') }}" class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-700">Terug naar overzicht</a>
        <a href="{{ route('leasecontracts.edit', $leasecontract->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Bewerken</a>
        <button type="button" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700" data-bs-toggle="modal" data-bs-target="#confirmationModal">
            Beëindigen
        </button>
    </div>
</div>

<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Weet je zeker dat je dit contract wilt beëindigen?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Vul je naam in om de beëindigactie te bevestigen:</p>
                <p><strong>Ingelogde gebruiker:</strong> {{ Auth::user()->name }}</p> <!-- Laat de naam van de ingelogde gebruiker zien -->
                <input type="text" id="username" class="form-control" placeholder="Vul je naam in om te bevestigen" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400" data-bs-dismiss="modal">Annuleren</button>
                <form action="{{ route('leasecontracts.destroy', $leasecontract) }}" method="POST" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700">Ja, beëindig het contract</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('deleteForm').addEventListener('submit', function(event) {
        const username = document.getElementById('username').value;

        if (username !== "{{ Auth::user()->name }}") {
            event.preventDefault();
            alert('De naam komt niet overeen met de ingelogde gebruiker.');
        }
    });
</script>
@endsection