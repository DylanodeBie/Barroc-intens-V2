@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-3xl font-bold mb-4 text-center">Storingsmelding Details</h1>

    <div class="card">
        <div class="card-body">
            <p><strong>Bezoek ID:</strong> {{ $report->visit_id }}</p>
            <p><strong>Beschrijving:</strong> {{ $report->issue_description }}</p>
            <p><strong>Gebruikte Onderdelen:</strong> {{ $report->used_parts }}</p>
            <p><strong>Vervolgafspraken:</strong> {{ $report->follow_up_notes }}</p>
        </div>
    </div>

    <a href="{{ route('visits.my_tickets') }}" class="btn btn-secondary mt-3">Terug naar Bezoeken</a>
</div>
@endsection
