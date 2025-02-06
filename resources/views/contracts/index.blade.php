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
    <a style="background-color: #FFD700;" href="{{ route('leasecontracts.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700"><i class="fas fa-plus mr-2"></i>Nieuw contract maken</a>

    <div class="mt-6">
        <table class="min-w-full bg-white shadow rounded-lg">
            <thead style="background-color: #FFD700; rounded-lg">
                <tr>
                    <th class="px-4 py-2 border-b">Klant</th>
                    <th class="px-4 py-2 border-b">Startdatum</th>
                    <th class="px-4 py-2 border-b">Einddatum</th>
                    <th class="px-4 py-2 border-b">Status</th>
                    <th class="px-4 py-2 border-b">Betalingsoptie</th>
                    <th class="px-4 py-2 border-b">Acties</th>
                </tr>
            </thead>
            <tbody>
                @foreach($leasecontracts->sortBy(function($contract) {
                    $order = ['completed' => 1, 'pending' => 2, 'overdue' => 3];
                    return $order[$contract->status] ?? 4;
                }) as $contract)
                @php
                    $status = $contract->status;
                    $statusClass = '';
                    $statusText = '';
                    $circleColor = '';
                    $iconColor = '';
                    $trashIconColor = '';

                    if ($status === 'overdue') {
                        $statusClass = 'bg-red-500 text-white';
                        $statusText = 'Verlopen';
                        $circleColor = 'bg-red-500';
                        $iconColor = 'text-white';
                        $trashIconColor = 'text-white';
                    } elseif ($status === 'pending') {
                        $statusClass = '';
                        $statusText = 'In afwachting';
                        $circleColor = 'bg-yellow-500';
                        $iconColor = 'text-black';
                        $trashIconColor = 'text-black';
                    } elseif ($status === 'completed') {
                        $statusClass = '';
                        $statusText = 'Actief';
                        $circleColor = 'bg-green-500';
                        $iconColor = 'text-black';
                        $trashIconColor = 'text-black';
                    } else {
                        $statusClass = 'bg-gray-300 text-black';
                        $statusText = 'Afgekeurd';
                        $circleColor = 'bg-gray-300';
                        $iconColor = 'text-black';
                        $trashIconColor = 'text-black';
                    }
                @endphp
                <tr class="{{ $statusClass }}">
                    <td class="px-4 py-2 border-b flex items-center">
                        <span>{{ $contract->customers->company_name ?? 'Geen klant' }}</span>
                        <span class="w-3 h-3 rounded-full ml-2 {{ $circleColor }}"></span>
                    </td>
                    <td class="px-4 py-2 border-b">{{ \Carbon\Carbon::parse($contract->start_date)->format('d-m-Y') }}</td>
                    <td class="px-4 py-2 border-b">{{ \Carbon\Carbon::parse($contract->end_date)->format('d-m-Y') }}</td>
                    <td class="px-4 py-2 border-b">{{ $statusText }}</td>
                    <td class="px-4 py-2 border-b">{{ ucfirst($contract->payment_method) }}</td>
                    <td class="px-4 py-2 border-b">
                        <a href="{{ route('leasecontracts.show', $contract->id) }}"
                            class="inline-block mr-2 {{ $iconColor }} hover:text-gray-700"
                            title="Bekijken">
                            <i class="fas fa-eye"></i>
                        </a>

                        <a href="{{ route('leasecontracts.edit', $contract->id) }}"
                            class="inline-block mr-2 {{ $iconColor }} hover:text-gray-700"
                            title="Bewerken">
                            <i class="fas fa-edit"></i>
                        </a>

                        <a href="{{ route('leasecontracts.exportPdf', $contract->id) }}"
                            class="inline-block mr-2 {{ $iconColor }} hover:text-gray-700"
                            title="Download PDF">
                            <i class="fas fa-download"></i>
                        </a>
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
    @foreach($leasecontracts as $contract)
    document.getElementById('username{{ $contract->id }}').addEventListener('input', function(event) {
        const username = event.target.value;
        const deleteButton = document.querySelector("#confirmationModal{{ $contract->id }} button[type='submit']");

        if (username === "{{ Auth::user()->name }}") {
            deleteButton.disabled = false;
            deleteButton.classList.remove('bg-gray-400');
            deleteButton.classList.add('bg-red-500', 'hover:bg-red-700');
        } else {
            deleteButton.disabled = true;
            deleteButton.classList.add('bg-gray-400');
            deleteButton.classList.remove('bg-red-500', 'hover:bg-red-700');
        }
    });
    @endforeach
</script>
@endsection
