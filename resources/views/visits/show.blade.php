@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Visit Details</h1>

        <div class="card mt-4">
            <div class="card-body">
                <p><strong>Customer:</strong>
                    @if ($visit->customer)
                        {{ $visit->customer->company_name }}
                    @else
                        <em>No customer linked</em>
                    @endif
                </p>
                <p><strong>Assigned User:</strong>
                    @if ($visit->user)
                        {{ $visit->user->name }}
                    @else
                        <em>No user assigned</em>
                    @endif
                </p>
                <p><strong>Address:</strong> {{ $visit->address }}</p>
                <p><strong>Visit Date:</strong> {{ $visit->visit_date }}</p>
                <p><strong>Start Time:</strong> {{ $visit->start_time }}</p>
                <p><strong>End Time:</strong> {{ $visit->end_time }}</p>
                <p><strong>Error Details:</strong> {{ $visit->error_details }}</p>
                <p><strong>Used Parts:</strong> {{ $visit->used_parts }}</p>
            </div>
        </div>

        <a href="{{ route('visits.index') }}" class="btn btn-secondary mt-3">Back to Visits</a>
    </div>
@endsection
