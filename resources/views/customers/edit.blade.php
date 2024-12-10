@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-8 border border-gray-200">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">Bewerk Klant - {{ $customer->company_name }}</h1>

            <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="mb-6">
                    <label for="company_name" class="block text-gray-700 font-semibold mb-2">Bedrijfsnaam</label>
                    <input type="text" id="company_name" name="company_name"
                        value="{{ old('company_name', $customer->company_name) }}" required
                        class="w-full px-4 py-2 border rounded-md border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                </div>
                <div class="mb-6">
                    <label for="contact_person" class="block text-gray-700 font-semibold mb-2">Contactpersoon</label>
                    <input type="text" id="contact_person" name="contact_person"
                        value="{{ old('contact_person', $customer->contact_person) }}" required
                        class="w-full px-4 py-2 border rounded-md border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                </div>
                <div class="mb-6">
                    <label for="phonenumber" class="block text-gray-700 font-semibold mb-2">Telefoonnummer</label>
                    <input type="text" id="phonenumber" name="phonenumber"
                        value="{{ old('phonenumber', $customer->phonenumber) }}" required
                        class="w-full px-4 py-2 border rounded-md border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                </div>
                <div class="mb-6">
                    <label for="address" class="block text-gray-700 font-semibold mb-2">Adres</label>
                    <input type="text" id="address" name="address" value="{{ old('address', $customer->address) }}"
                        required
                        class="w-full px-4 py-2 border rounded-md border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                </div>
                <div class="mb-6">
                    <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $customer->email) }}"
                        required
                        class="w-full px-4 py-2 border rounded-md border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                </div>
                <div class="mb-6">
                    <label for="bkr_check" class="block text-gray-700 font-semibold mb-2">BKR registratie</label>
                    <select id="bkr_check" name="bkr_check" required
                        class="w-full px-4 py-2 border rounded-md border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                        <option value="1" {{ $customer->bkr_check ? 'selected' : '' }}>Ja</option>
                        <option value="0" {{ !$customer->bkr_check ? 'selected' : '' }}>Nee</option>
                    </select>
                </div>
                <div class="flex justify-between mt-8">
                    <a href="{{ route('customers.index') }}"
                        class="bg-gray-400 text-white px-6 py-2 rounded-md hover:bg-gray-500">
                        Annuleren
                    </a>
                    <button type="submit" class="bg-yellow-400 text-black px-6 py-2 rounded-md hover:bg-yellow-500">
                        Opslaan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
