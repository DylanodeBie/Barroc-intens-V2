@extends('layouts.app')
@vite(['resources/css/app.css', 'resources/js/calendar.js'])

@section('content')
<div class="mb-4">
    <button id="addEventButton" class="bg-green-500 text-white px-4 py-2 rounded">Add Event</button>
</div>
<div id="calendar"></div>

<!-- Modal -->
<div id="eventModal" class="modal hidden fixed top-0 left-0 w-full h-full bg-black bg-opacity-50 flex justify-center items-center">
    <div class="modal-content bg-white p-6 rounded-lg w-1/3">
        <h2 id="modalTitle" class="text-xl font-semibold mb-4">Add Event</h2>
        <form id="eventForm">
            <div class="mb-4">
                <label for="eventName" class="block font-semibold">Event Title</label>
                <input type="text" id="eventName" class="w-full border border-gray-300 rounded p-2" required />
            </div>
            <div class="mb-4">
                <label for="eventCustomer" class="block font-semibold">Klant (optioneel)</label>
                <select id="eventCustomer" class="w-full border border-gray-300 rounded p-2">
                    <option value="">Geen klant</option>
                  
                </select>
            </div>
            <div class="mb-4">
                <label for="eventStartTime" class="block font-semibold">Start Time</label>
                <input type="datetime-local" id="eventStartTime" class="w-full border border-gray-300 rounded p-2" required />
            </div>
            <div class="mb-4">
                <label for="eventEndTime" class="block font-semibold">End Time</label>
                <input type="datetime-local" id="eventEndTime" class="w-full border border-gray-300 rounded p-2" />
            </div>
            <div class="mb-4">
                <label for="eventDescription" class="block font-semibold">Description</label>
                <textarea id="eventDescription" class="w-full border border-gray-300 rounded p-2"></textarea>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded mr-2">Save</button>
                <button type="button" id="deleteEventButton" class="bg-red-500 text-white px-4 py-2 rounded mr-2">Delete</button>
                <button type="button" id="closeModal" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    window.events = @json($events);
    window.customers = @json($customers);
</script>

@endsection