@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Klanteninformatie - {{ $customer->company_name }}</h1>

        <p><strong>Bedrijfsnaam:</strong> {{ $customer->company_name }}</p>
        <p><strong>Contactpersoon:</strong> {{ $customer->contact_person }}</p>
        <p><strong>Telefoonnummer:</strong> {{ $customer->phonenumber }}</p>
        <p><strong>Adres:</strong> {{ $customer->address }}</p>
        <p><strong>Email:</strong> {{ $customer->email }}</p>
        <p><strong>BKR registratie:</strong> {{ $customer->bkr_check ? 'Ja' : 'Nee' }}</p>

        <a href="{{ route('customers.index') }}" class="btn btn-secondary">Terug</a>
    </div>
@endsection
