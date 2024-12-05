@extends('layouts.app')

@section('content')

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container">
    <h1 class="text-3xl font-bold mb-4 text-center text-black">Mijn Bezoeken</h1>
    <div class="modal fade" id="maintenanceReportModal" tabindex="-1" aria-labelledby="maintenanceReportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="maintenanceReportModalLabel">Storingsmelding</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('maintenance-reports.store') }}" method="POST">
                        @csrf
                        <input type="hidden" id="currentVisitId" name="visit_id">
                        <div class="mb-3">
                            <label for="issueDescription" class="form-label">Beschrijving van de storing</label>
                            <textarea id="issueDescription" name="issue_description" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="usedParts" class="form-label">Gebruikte onderdelen</label>
                            <textarea id="usedParts" name="used_parts" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="followUpNotes" class="form-label">Vervolgafspraken</label>
                            <textarea id="followUpNotes" name="follow_up_notes" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuleren</button>
                            <button type="submit" class="btn btn-primary">Opslaan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="signatureModal" tabindex="-1" aria-labelledby="signatureModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="signatureModalLabel">Ondertekenen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <canvas id="signatureCanvas" width="450" height="200" style="border: 1px solid #000;"></canvas>
                    <button id="clearSignature" class="btn btn-secondary mt-2">Handtekening wissen</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuleren</button>
                    <button id="saveSignature" type="button" class="btn btn-primary">Opslaan</button>
                </div>
            </div>
        </div>
    </div>
    @if ($visits->isEmpty())
        <p class="text-gray-500">Je hebt momenteel geen toegewezen bezoeken.</p>
    @else
    <table class="table-auto w-full border-collapse border border-gray-200">
        <thead style="background-color: #FFD700;">
            <tr>
                <th class="px-6 py-3 text-left font-semibold text-black">ID</th>
                <th class="px-6 py-3 text-left font-semibold text-black">Klant</th>
                <th class="px-6 py-3 text-left font-semibold text-black">Bezoekdatum</th>
                <th class="px-6 py-3 text-left font-semibold text-black">Starttijd</th>
                <th class="px-6 py-3 text-left font-semibold text-black">Eindtijd</th>
                <th class="px-6 py-3 text-left font-semibold text-black">Adres</th>
                <th class="px-6 py-3 text-left font-semibold text-black">Status</th>
                <th class="px-6 py-3 text-left font-semibold text-black">Acties</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($visits as $visit)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $visit->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $visit->customer->company_name ?? 'Geen klant gekoppeld' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $visit->visit_date }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $visit->start_time }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $visit->end_time }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $visit->address }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($visit->status) }}</td>
                    <td class="px-6 py-4 text-center flex flex-start gap-4">
                        <button type="button" class="btn btn-info" style="background-color: #FFD700; border: none; color: #000;" data-bs-toggle="modal" data-bs-target="#maintenanceReportModal" data-visit-id="{{ $visit->id }}">
                            Storingsmelding
                        </button>
                        @if ($visit->status === 'pending')
                            <button type="button" class="btn btn-primary" style="background-color: #FFD700; border: none; color: #000;" data-bs-toggle="modal" data-bs-target="#signatureModal" data-visit-id="{{ $visit->id }}">
                                Ondertekenen
                            </button>
                        @else
                            <span>Voltooid</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

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

