@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Klantenlijst</h1>

        <a href="{{ route('customers.create') }}" class="btn btn-primary">Nieuw klant toevoegen</a>

        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Bedrijfsnaam</th>
                    <th>Contactpersoon</th>
                    <th>Telefoonnummer</th>
                    <th>Email</th>
                    <th>BKR check</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $customer)
                    <tr>
                        <td>{{ $customer->company_name }}</td>
                        <td>{{ $customer->contact_person }}</td>
                        <td>{{ $customer->phonenumber }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->bkr_check ? 'Ja' : 'Nee' }}</td>
                        <td>
                            <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-info">Bekijken</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
