@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Bezoek Toewijzen</h1>

        <form action="{{ route('visits.store_assigned', ['id' => $visit->id]) }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="maintenance_assigned_to" class="form-label">Toewijzen aan Onderhoudspersoneel:</label>
                <select id="maintenance_assigned_to" name="maintenance_assigned_to" class="form-select" required>
                    @foreach ($maintenanceUsers as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Toewijzen</button>
            <a href="{{ route('visits.index') }}" class="btn btn-secondary">Terug naar Bezoeken</a>
        </form>
    </div>
@endsection
