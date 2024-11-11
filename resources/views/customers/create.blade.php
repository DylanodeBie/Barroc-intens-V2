@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Nieuwe klant registreren</h1>

        <form action="{{ route('customers.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="company_name" class="form-label">Bedrijfsnaam</label>
                <input type="text" class="form-control" id="company_name" name="company_name" required>
            </div>

            <div class="mb-3">
                <label for="contact_person" class="form-label">Contactpersoon</label>
                <input type="text" class="form-control" id="contact_person" name="contact_person" required>
            </div>

            <div class="mb-3">
                <label for="phonenumber" class="form-label">Telefoonnummer</label>
                <input type="text" class="form-control" id="phonenumber" name="phonenumber" required>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Adres</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="mb-3">
                <label for="bkr_check" class="form-label">BKR registratie?</label>
                <input type="checkbox" id="bkr_check" name="bkr_check" value="1">
            </div>

            <button type="submit" class="btn btn-success">Opslaan</button>
        </form>
    </div>
@endsection
