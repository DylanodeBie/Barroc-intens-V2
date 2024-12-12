@section('greeting')
    Bezoek bekijken
@endsection

@extends('layouts.app')

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="container">
    <strong>Onderhoudsbezoek Details</strong>

    <div class="card mt-4">
        <div class="card-body">
            <p><strong>Klant:</strong>
                @if ($visit->customer)
                    {{ $visit->customer->company_name }}
                @else
                    <em>Geen klant gekoppeld</em>
                @endif
            </p>
            <p><strong>Toegewezen Gebruiker:</strong>
                @if ($visit->user)
                    {{ $visit->user->name }}
                @else
                    <em>Geen gebruiker toegewezen</em>
                @endif
            </p>
            <p><strong>Adres:</strong> {{ $visit->address }}</p>
            <p><strong>Bezoekdatum:</strong> {{ $visit->visit_date }}</p>
            <p><strong>Starttijd:</strong> {{ $visit->start_time }}</p>
            <p><strong>Eindtijd:</strong> {{ $visit->end_time }}</p>
            <p><strong>Sales details:</strong> {{ $visit->error_details }}</p>
            <p><strong>Gebruikte Onderdelen:</strong> {{ $visit->used_parts }}</p>


            @if ($visit->maintenanceReport)
                <div class="mt-4">
                    <h2 class="text-xl font-semibold mb-2">Onderhoudsrapport</h2>
                    <p><strong>Probleembeschrijving:</strong> {{ $visit->maintenanceReport->issue_description }}</p>
                    <p><strong>Gebruikte Onderdelen:</strong> {{ $visit->maintenanceReport->used_parts }}</p>
                    <p><strong>Opvolgnotities:</strong>
                        @if ($visit->maintenanceReport->follow_up_notes)
                            {{ $visit->maintenanceReport->follow_up_notes }}
                        @else
                            <em>Geen opvolgnotities beschikbaar.</em>
                        @endif
                    </p>
                </div>
            @endif

            <div class="mt-4">
                <h2 class="text-xl font-semibold mb-2">Handtekening</h2>
                @if ($visit->signature_path)
                    <img src="{{ asset('storage/' . $visit->signature_path) }}" alt="Handtekening" class="border rounded-md w-1/2">
                @else
                    <p class="text-gray-500">Geen handtekening beschikbaar.</p>
                @endif
            </div>
        </div>
    </div>

    <a href="{{ route('visits.index') }}" class="btn btn-secondary mt-3">Back to Visits</a>
</div>

@endsection
