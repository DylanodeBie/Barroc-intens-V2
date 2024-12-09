@section('greeting')
    Nieuwe klant registreren
@endsection

@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-8 border border-gray-200">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">Nieuwe klant registreren</h1>
            <form action="{{ route('customers.store') }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label for="company_name" class="block text-gray-700 font-semibold mb-2">Bedrijfsnaam</label>
                    <input type="text" id="company_name" name="company_name" required
                        class="w-full px-4 py-2 border rounded-md border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                </div>
                <div class="mb-6">
                    <label for="contact_person" class="block text-gray-700 font-semibold mb-2">Contactpersoon</label>
                    <input type="text" id="contact_person" name="contact_person" required
                        class="w-full px-4 py-2 border rounded-md border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                </div>
                <div class="mb-6">
                    <label for="phonenumber" class="block text-gray-700 font-semibold mb-2">Telefoonnummer</label>
                    <input type="text" id="phonenumber" name="phonenumber" required
                        class="w-full px-4 py-2 border rounded-md border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                </div>
                <div class="mb-6">
                    <label for="address" class="block text-gray-700 font-semibold mb-2">Adres</label>
                    <input type="text" id="address" name="address" required
                        class="w-full px-4 py-2 border rounded-md border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                </div>
                <div class="mb-6">
                    <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                    <input type="email" id="email" name="email" required
                        class="w-full px-4 py-2 border rounded-md border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                </div>
                <div class="mb-6">
                    <label for="bkr_check" class="block text-gray-700 font-semibold mb-2">BKR registratie?</label>
                    <input type="checkbox" id="bkr_check" name="bkr_check" value="1"
                        class="h-5 w-5 text-yellow-500 border-gray-300 rounded focus:ring-yellow-400">
                </div>
                <div class="flex justify-end mt-8">
                    <button type="submit" class="bg-yellow-400 text-black px-6 py-2 rounded-md hover:bg-yellow-500">
                        Opslaan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
