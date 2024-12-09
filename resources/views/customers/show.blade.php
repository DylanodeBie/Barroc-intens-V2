@section('greeting')
    Klanten informatie - {{ $customer->company_name }}
@endsection

@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-8 border border-gray-200">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">Klanteninformatie</h1>
            <p class="text-lg font-semibold text-gray-700 mb-8">{{ $customer->company_name }}</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <p class="text-gray-600"><strong>Contactpersoon:</strong></p>
                    <p class="text-gray-800">{{ $customer->contact_person }}</p>
                </div>
                <div>
                    <p class="text-gray-600"><strong>Telefoonnummer:</strong></p>
                    <p class="text-gray-800">{{ $customer->phonenumber }}</p>
                </div>
                <div>
                    <p class="text-gray-600"><strong>Adres:</strong></p>
                    <p class="text-gray-800">{{ $customer->address }}</p>
                </div>
                <div>
                    <p class="text-gray-600"><strong>Email:</strong></p>
                    <p class="text-gray-800">{{ $customer->email }}</p>
                </div>
                <div>
                    <p class="text-gray-600"><strong>BKR registratie:</strong></p>
                    <p class="text-gray-800">{{ $customer->bkr_check ? 'Ja' : 'Nee' }}</p>
                </div>
            </div>
            <hr class="border-t-2 border-yellow-400 my-4">
            <div class="flex justify-between mt-6">
                <a href="{{ route('customers.index') }}"
                    class="bg-gray-400 text-white px-4 py-2 rounded-md hover:bg-gray-500">
                    Terug
                </a>
                @if (in_array(auth()->user()->role->name, ['Sales', 'Head Sales', 'CEO']))
                    <a href="{{ route('customers.edit', $customer->id) }}"
                        class="bg-yellow-400 text-black px-4 py-2 rounded-md hover:bg-yellow-500">
                        Bewerken
                    </a>
                @endif
            </div>
        </div>
    </div>
@endsection
