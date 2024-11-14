@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Onderhoudsbezoek Inplannen</h1>

        <form action="{{ route('visits.store') }}" method="POST">
            @csrf

            <!-- Customer Selection -->
            <div class="mb-6">
                <label for="customer_id" class="block text-gray-700">Klant</label>
                <select name="customer_id" class="w-full px-4 py-2 border rounded-md border-gray-300" required>
                    <option value="" disabled selected>Selecteer een klant</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->company_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- User Assignment -->
            <div class="mb-6">
                <label for="user_id" class="block text-gray-700">Toegewezen Verkoper</label>
                <select name="user_id" class="w-full px-4 py-2 border rounded-md border-gray-300" required>
                    <option value="" disabled selected>Selecteer een verkoper</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Visit Date Field -->
            <div class="mb-6">
                <label for="visit_date" class="block text-gray-700">Bezoekdatum</label>
                <input type="date" name="visit_date" class="w-full px-4 py-2 border rounded-md border-gray-300" required>
            </div>

            <!-- Start Time Field -->
            <div class="mb-6">
                <label for="start_time" class="block text-gray-700">Starttijd</label>
                <input type="time" name="start_time" class="w-full px-4 py-2 border rounded-md border-gray-300" required>
            </div>

            <!-- End Time Field -->
            <div class="mb-6">
                <label for="end_time" class="block text-gray-700">Eindtijd</label>
                <input type="time" name="end_time" class="w-full px-4 py-2 border rounded-md border-gray-300" required>
            </div>

            <!-- Address Field -->
            <div class="mb-6">
                <label for="address" class="block text-gray-700">Adres</label>
                <input type="text" name="address" class="w-full px-4 py-2 border rounded-md border-gray-300"
                    placeholder="Voer het adres in" required>
            </div>

            <!-- Error Notification Selection -->
            <div class="mb-6">
                <label for="error_notification_id" class="block text-gray-700">Foutmelding</label>
                <select name="error_notification_id" class="w-full px-4 py-2 border rounded-md border-gray-300" required>
                    <option value="" disabled selected>Selecteer een foutmelding</option>
                    @foreach ($errorNotifications as $errorNotification)
                        <option value="{{ $errorNotification->id }}">{{ $errorNotification->description }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Used Parts Field -->
            <div class="mb-6">
                <label for="used_parts" class="block text-gray-700">Gebruikte Onderdelen</label>
                <input type="text" name="used_parts" class="w-full px-4 py-2 border rounded-md border-gray-300"
                    placeholder="Voer de gebruikte onderdelen in" required>
            </div>

            <!-- Error Details Field -->
            <div class="mb-6">
                <label for="error_details" class="block text-gray-700">Foutdetails (optioneel)</label>
                <textarea name="error_details" class="w-full px-4 py-2 border rounded-md border-gray-300" rows="4"
                    placeholder="Voer eventuele foutdetails in"></textarea>
            </div>

            <!-- Buttons -->
            <div class="mt-8 flex justify-between">
                <a href="{{ route('visits.index') }}" class="bg-gray-400 text-white px-6 py-2 rounded-md">Annuleren</a>
                <button type="submit"
                    class="bg-yellow-400 text-black px-6 py-2 rounded-md hover:bg-yellow-500">Opslaan</button>
            </div>
        </form>
    </div>
@endsection