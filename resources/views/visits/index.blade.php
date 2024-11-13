@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Visits List</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Assigned User</th>
                    <th>Visit Date</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($visits as $visit)
                    <tr>
                        <td>{{ $visit->id }}</td>
                        <td>{{ $visit->customers->company_name }}</td>
                        <td>{{ $visit->users->name }}</td>
                        <td>{{ $visit->visit_date }}</td>
                        <td>{{ $visit->address }}</td>
                        <td>
                            <a href="{{ route('visits.assign', $visit->id) }}" class="btn btn-primary">Assign</a>
                            <a href="{{ route('visits.show', $visit->id) }}" class="btn btn-info">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
