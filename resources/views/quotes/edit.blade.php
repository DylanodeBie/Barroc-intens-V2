@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-3xl font-bold mb-6">Offerte Bewerken</h1>

    @if (session('success'))
    <div class="bg-green-500 text-white p-3 rounded-md mb-4">
        {{ session('success') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="bg-red-500 text-white p-3 rounded-md mb-4">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('quotes.update', $quote->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Customer Dropdown -->
        <div class="mb-4">
            <label for="customer_id" class="block font-semibold">Klant</label>
            <select name="customer_id" id="customer_id" class="form-control w-full border rounded-md p-2">
                @foreach ($customers as $customer)
                <option value="{{ $customer->id }}" {{ $customer->id == $quote->customer_id ? 'selected' : '' }}>
                    {{ $customer->company_name }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- User Dropdown -->
        <div class="mb-4">
            <label for="user_id" class="block font-semibold">Gebruiker</label>
            <select name="user_id" id="user_id" class="form-control w-full border rounded-md p-2">
                @foreach ($users as $user)
                <option value="{{ $user->id }}" {{ $user->id == $quote->user_id ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Machines with Quantity -->
        <div class="mb-6">
            <label class="block font-semibold">Machines</label>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($machines as $machine)
                <div class="border rounded-md shadow p-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="machines[{{ $machine->id }}][selected]" value="1"
                            {{ $quote->machines->contains('id', $machine->id) ? 'checked' : '' }} class="mr-2">
                        <span class="font-semibold">{{ $machine->name }}</span>
                    </label>
                    <label class="mt-2 text-sm">
                        Aantal:
                        <input type="number" name="machines[{{ $machine->id }}][quantity]" min="1"
                            value="{{ $quote->machines->contains('id', $machine->id) ? $quote->machines->find($machine->id)->pivot->quantity : 1 }}"
                            class="form-control w-full border rounded-md p-1">
                    </label>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Beans with Quantity -->
        <div class="mb-6">
            <label class="block font-semibold">Bonen</label>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($products as $bean)
                <div class="border rounded-md shadow p-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="beans[{{ $bean->id }}][selected]" value="1"
                            {{ $quote->beans->contains('id', $bean->id) ? 'checked' : '' }} class="mr-2">
                        <span class="font-semibold">{{ $bean->name }}</span>
                    </label>
                    <label class="mt-2 text-sm">
                        Aantal:
                        <input type="number" name="beans[{{ $bean->id }}][quantity]" min="1"
                            value="{{ $quote->beans->contains('id', $bean->id) ? $quote->beans->find($bean->id)->pivot->quantity : 1 }}"
                            class="form-control w-full border rounded-md p-1">
                    </label>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Agreement Length -->
        <div class="mb-4">
            <label for="agreement_length" class="block font-semibold">Looptijd Overeenkomst (maanden)</label>
            <input type="number" name="agreement_length" id="agreement_length"
                class="form-control w-full border rounded-md p-2" value="{{ $quote->agreement_length }}">
        </div>

        <!-- Maintenance Agreement -->
        <div class="mb-4">
            <label for="maintenance_agreement" class="block font-semibold">Onderhoudsovereenkomst</label>
            <select name="maintenance_agreement" id="maintenance_agreement"
                class="form-control w-full border rounded-md p-2">
                <option value="basic" {{ $quote->maintenance_agreement == 'basic' ? 'selected' : '' }}>Basic</option>
                <option value="premium" {{ $quote->maintenance_agreement == 'premium' ? 'selected' : '' }}>Premium
                </option>
            </select>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-between mt-6">
            <a href="{{ route('quotes.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                Terug
            </a>
            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
                Offerte Bijwerken
            </button>
        </div>
    </form>
</div>
@endsection