@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-6 text-center">Offerte Maken</h1>

        <form action="{{ route('quotes.store') }}" method="POST">
            @csrf

            <!-- Customer Dropdown -->
            <div class="mb-4">
                <label for="customer_id" class="block font-semibold text-gray-700">Klant</label>
                <select name="customer_id" id="customer_id" class="form-control w-full border rounded-md p-2 text-black">
                    <option value="" disabled selected>Kies een klant</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}" style="color: black;">{{ $customer->company_name }}</option>
                    @endforeach
                </select>
            </div>



            <!-- User Dropdown -->
            <div class="mb-4">
                <label for="user_id" class="block font-semibold text-gray-700">Gebruiker</label>
                <select name="user_id" id="user_id" class="form-control w-full border rounded-md p-2">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" style="color: black;">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Machines with Quantity -->
            <div class="mb-6">
                <label class="block font-semibold text-gray-700 mb-2">Machines</label>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($machines as $machine)
                        <div class="border rounded-md shadow p-4 flex flex-col items-start">
                            <label class="flex items-center">
                                <input type="checkbox" name="machines[{{ $machine->id }}][selected]" value="1"
                                    class="mr-2">
                                <span class="font-semibold">{{ $machine->name }}</span>
                            </label>
                            <p class="text-sm text-gray-600">Lease: €{{ number_format($machine->lease_price, 2, ',', '.') }}
                                p/m</p>
                            <p class="text-sm text-gray-600">Installatie:
                                €{{ number_format($machine->installation_cost, 2, ',', '.') }}</p>
                            <label class="mt-2 text-sm text-gray-700">
                                Aantal:
                                <input type="number" name="machines[{{ $machine->id }}][quantity]" min="1"
                                    value="1" class="form-control w-full border rounded-md p-1 mt-1">
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Beans with Quantity -->
            <div class="mb-6">
                <label class="block font-semibold text-gray-700 mb-2">Bonen</label>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($products as $bean)
                        <div class="border rounded-md shadow p-4 flex flex-col items-start">
                            <label class="flex items-center">
                                <input type="checkbox" name="beans[{{ $bean->id }}][selected]" value="1"
                                    class="mr-2">
                                <span class="font-semibold">{{ $bean->name }}</span>
                            </label>
                            <p class="text-sm text-gray-600">Prijs: €{{ number_format($bean->price, 2, ',', '.') }}</p>
                            <label class="mt-2 text-sm text-gray-700">
                                Aantal:
                                <input type="number" name="beans[{{ $bean->id }}][quantity]" min="1"
                                    value="1" class="form-control w-full border rounded-md p-1 mt-1">
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Agreement Length -->
            <div class="mb-4">
                <label for="agreement_length" class="block font-semibold text-gray-700">Looptijd Overeenkomst
                    (maanden)</label>
                <input type="number" name="agreement_length" id="agreement_length"
                    class="form-control w-full border rounded-md p-2" placeholder="Bijvoorbeeld: 12">
            </div>

            <!-- Maintenance Agreement -->
            <div class="mb-4">
                <label for="maintenance_agreement" class="block font-semibold text-gray-700">Onderhoudsovereenkomst</label>
                <select name="maintenance_agreement" id="maintenance_agreement"
                    class="form-control w-full border rounded-md p-2">
                    <option value="basic" style="color: black;">Standaard</option>
                    <option value="premium" style="color: black;">Premium</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-between mt-6">
                <a href="{{ route('quotes.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                    Terug
                </a>
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
                    Opslaan en Verzenden
                </button>
            </div>
        </form>
    </div>
@endsection
