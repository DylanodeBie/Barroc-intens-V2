@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Bezoek Toewijzen</h1>

        @if ($maintenanceUsers->isNotEmpty())
            <form action="{{ route('visits.store_assigned', ['id' => $visit->id]) }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="user_id" class="form-label">Toewijzen aan Onderhoudspersoneel:</label>
                    <select id="user_id" name="user_id" class="form-select" required>
                        <option value="" disabled selected>Kies een medewerker...</option>
                        @foreach ($maintenanceUsers as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Toewijzen</button>
                <a href="{{ route('visits.index') }}" class="btn btn-secondary">Terug naar Bezoeken</a>
            </form>
        @else
            <div class="alert alert-warning" role="alert">
                Er zijn geen onderhoudsmedewerkers beschikbaar om toe te wijzen.
            </div>
            <a href="{{ route('visits.index') }}" class="btn btn-secondary">Terug naar Bezoeken</a>
        @endif
    </div>
@endsection
