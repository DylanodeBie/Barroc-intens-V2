@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-5">

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

    <h2 class="text-2xl font-semibold mb-4">Overzicht Leasecontracten</h2>
    <a href="{{ route('leasecontracts.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Nieuw Contract</a>

    <div class="mt-6">
        <table class="min-w-full bg-white shadow rounded-lg">
            <thead>
                <tr>
                    <th class="px-4 py-2 border-b">Klant</th>
                    <th class="px-4 py-2 border-b">Startdatum</th>
                    <th class="px-4 py-2 border-b">Einddatum</th>
                    <th class="px-4 py-2 border-b">Betalingsoptie</th>
                    <th class="px-4 py-2 border-b">Acties</th>
                </tr>
            </thead>
            <tbody>
                @foreach($leasecontracts as $contract)
                @php
                $isExpired = \Carbon\Carbon::parse($contract->end_date)->isPast();
                @endphp
                <tr class="{{ $isExpired ? 'bg-red-500 text-white' : '' }}">
                    <td class="px-4 py-2 border-b">{{ $contract->customers->company_name }}</td>
                    <td class="px-4 py-2 border-b">{{ $contract->start_date }}</td>
                    <td class="px-4 py-2 border-b">{{ $contract->end_date }}</td>
                    <td class="px-4 py-2 border-b">{{ ucfirst($contract->payment_method) }}</td>
                    <td class="px-4 py-2 border-b">
                        @if($isExpired)
                        <span class="mr-2">⚠️</span>
                        @endif
                        <a href="{{ route('leasecontracts.show', $contract->id) }}" class="text-blue-500 hover:underline inline-block mr-2">Bekijken</a>
                        <a href="{{ route('leasecontracts.edit', $contract->id) }}" class="text-yellow-500 hover:underline inline-block mr-2">Bewerken</a>
                        <button type="button" class="inline-block {{ $isExpired ? 'text-black hover:underline' : 'text-red-500 hover:underline' }}" data-bs-toggle="modal" data-bs-target="#confirmationModal{{ $contract->id }}">
                            Beëindigen
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@foreach($leasecontracts as $contract)
<div class="modal fade" id="confirmationModal{{ $contract->id }}" tabindex="-1" aria-labelledby="confirmationModalLabel{{ $contract->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel{{ $contract->id }}">Weet je zeker dat je dit contract wilt beëindigen?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Vul je naam in om de beëindigactie te bevestigen:</p>
                <p><strong>Ingelogde gebruiker:</strong> {{ Auth::user()->name }}</p>
                <input type="text" id="username{{ $contract->id }}" class="form-control" placeholder="Vul je naam in om te bevestigen" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="bg-gray-300 text-black px-4 py-2 rounded hover:bg-gray-400" data-bs-dismiss="modal">Annuleren</button>
                <form action="{{ route('leasecontracts.destroy', $contract->id) }}" method="POST" id="deleteForm{{ $contract->id }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700">Ja, beëindig het contract</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

<script>
    // Validatie om ervoor te zorgen dat de naam van de ingelogde gebruiker overeenkomt
    @foreach($leasecontracts as $contract)
    document.getElementById('deleteForm{{ $contract->id }}').addEventListener('submit', function(event) {
        const username = document.getElementById('username{{ $contract->id }}').value;

        if (username !== "{{ Auth::user()->name }}") {
            event.preventDefault();
            alert('De naam komt niet overeen met de ingelogde gebruiker.');
        }
    });
    @endforeach
</script>
@endsection