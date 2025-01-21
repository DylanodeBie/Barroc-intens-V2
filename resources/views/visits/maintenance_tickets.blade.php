@extends('layouts.app')

@section('content')

@if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="modal fade" id="signatureModal" tabindex="-1" aria-labelledby="signatureModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="signatureModalLabel">Ondertekenen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <canvas id="signatureCanvas" class="border border-gray-300 rounded" width="500" height="300"></canvas>
                <div class="mt-4">
                    <button id="clearSignature" class="btn btn-warning">Handtekening Wissen</button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuleren</button>
                <button type="button" id="saveSignature" class="btn btn-primary">Opslaan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="maintenanceReportModal" tabindex="-1" aria-labelledby="maintenanceReportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="maintenanceReportModalLabel">Maak Storingsmelding</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="maintenanceReportForm" method="POST" action="{{ route('maintenance-reports.store') }}">
                    @csrf
                    <input type="hidden" name="visit_id" id="currentVisitId">

                    <div class="mb-3">
                        <label for="issueDescription" class="form-label">Probleembeschrijving</label>
                        <textarea class="form-control" id="issueDescription" name="issue_description" rows="4" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="usedParts" class="form-label">Gebruikte Onderdelen</label>
                        <textarea class="form-control" id="usedParts" name="used_parts" rows="4" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="followUpNotes" class="form-label">Opvolgnotities (optioneel)</label>
                        <textarea class="form-control" id="followUpNotes" name="follow_up_notes" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuleren</button>
                <button type="submit" form="maintenanceReportForm" class="btn btn-primary">Opslaan</button>
            </div>
        </div>
    </div>
</div>

<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Mijn Bezoeken</h1>
    <form method="GET" action="{{ route('visits.my_tickets') }}" class="bg-gray-100 p-6 rounded-lg shadow-md mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="company_name" class="block text-sm font-medium text-gray-700 mb-1">Bedrijf</label>
                <input type="text" name="company_name" id="company_name" value="{{ request('company_name') }}" class="w-full p-2 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500" placeholder="Zoek op bedrijf">
            </div>
            <!-- Filter op type -->
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Afdeling</label>
                <select name="type" id="type" class="w-full p-2 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                    <option value="">Alle</option>
                    <option value="sales" {{ request('type') == 'sales' ? 'selected' : '' }}>Sales</option>
                    <option value="maintenance" {{ request('type') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                </select>
            </div>

            <!-- Filter op medewerker -->
            <div>
                <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Medewerker</label>
                <select name="user_id" id="user_id" class="w-full p-2 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                    <option value="">Alle</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter op status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" id="status" class="w-full p-2 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                    <option value="">Alle</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>


        </div>

        <div class="mt-4 text-right">
            <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded-md shadow hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                Filter
            </button>
        </div>
    </form>


    @if ($visits->isEmpty())
        <p class="text-center text-gray-500">Je hebt momenteel geen toegewezen bezoeken.</p>
    @else

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow">
                <thead class="bg-yellow-500 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left">ID</th>
                        <th class="px-6 py-3 text-left">Klant</th>
                        <th class="px-6 py-3 text-left">Bezoekdatum</th>
                        <th class="px-6 py-3 text-left">Starttijd</th>
                        <th class="px-6 py-3 text-left">Eindtijd</th>
                        <th class="px-6 py-3 text-left">Adres</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        @if(in_array(auth()->user()->role_id, [9, 10]))
                            <th class="px-6 py-3 text left">Medewerker</th>
                        @endif
                        <th class="px-6 py-3 text-left">Acties</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($visits as $visit)
                        <tr class="hover:bg-gray-100">
                            <td class="px-6 py-4 border-t">{{ $visit->id }}</td>
                            <td class="px-6 py-4 border-t">{{ $visit->customer->company_name ?? 'Geen klant gekoppeld' }}</td>
                            <td class="px-6 py-4 border-t">{{ $visit->visit_date }}</td>
                            <td class="px-6 py-4 border-t">{{ $visit->start_time }}</td>
                            <td class="px-6 py-4 border-t">{{ $visit->end_time }}</td>
                            <td class="px-6 py-4 border-t">{{ $visit->address }}</td>
                            <td class="px-6 py-4 border-t capitalize">{{ $visit->status }}</td>
                            @if(in_array(auth()->user()->role_id, [9, 10]))
                                <td class="px-6 py-4 border-t">{{ $visit->user->name ?? "Geen medewerker"}}</th>
                            @endif
                            <td class="px-6 py-4 border-t flex space-x-4">
                                @if ($visit->maintenanceReport)
                                    <a href="{{ route('maintenance-reports.show', $visit->maintenanceReport->id) }}" class="bg-gray-700 text-white px-4 py-2 rounded hover:bg-gray-600">
                                        Bekijk Storingsmelding
                                    </a>
                                @else
                                    <button type="button" class="bg-yellow-500 text-black px-4 py-2 rounded hover:bg-yellow-400"
                                        data-bs-toggle="modal" data-bs-target="#maintenanceReportModal"
                                        data-visit-id="{{ $visit->id }}">
                                        Maak Storingsmelding
                                    </button>
                                @endif

                                @if ($visit->status === 'pending')
                                    <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-400"
                                        data-bs-toggle="modal" data-bs-target="#signatureModal"
                                        data-visit-id="{{ $visit->id }}">
                                        Ondertekenen
                                    </button>
                                @else
                                    <span class="text-green-600 font-medium">Voltooid</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<script>
    let signaturePad;

    document.addEventListener('DOMContentLoaded', () => {
    const signaturePad = new SignaturePad(document.getElementById('signatureCanvas'));
    let currentVisitId = null;

    document.querySelectorAll('[data-bs-toggle="modal"]').forEach(button => {
        button.addEventListener('click', event => {
            currentVisitId = button.getAttribute('data-visit-id');
            signaturePad.clear();
        });
    });

    document.getElementById('clearSignature').addEventListener('click', () => {
        signaturePad.clear();
    });

    document.getElementById('saveSignature').addEventListener('click', () => {
        if (signaturePad.isEmpty()) {
            alert('Geen handtekening gevonden!');
            return;
        }

        const signatureData = signaturePad.toDataURL();
        fetch(`/visits/${currentVisitId}/sign`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({ signature: signatureData }),
        })
            .then(response => response.json())
            .then(data => {
                if (data.message === 'Bezoek succesvol ondertekend') {
                    alert('Handtekening opgeslagen!');
                    location.reload();
                } else {
                    alert('Er ging iets mis.');
                }
            })
            .catch(error => {
                console.error('Fout:', error);
                alert('Er ging iets mis.');
            });
    });
});

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-bs-toggle="modal"]').forEach(button => {
        button.addEventListener('click', event => {
            const visitId = button.getAttribute('data-visit-id');
            document.getElementById('currentVisitId').value = visitId;
        });
    });
});


</script>


@endsection

