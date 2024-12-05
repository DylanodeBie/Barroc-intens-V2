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

<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Mijn Bezoeken</h1>

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

