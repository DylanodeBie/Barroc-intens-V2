@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-4 text-center text-black">Offertes Lijst</h1>

    <div class="flex justify-end mb-4">
        <a href="{{ route('quotes.create') }}" class="font-semibold px-6 py-2 rounded-md hover:bg-yellow-500"
            style="background-color: #FFD700; color: black;">
            <i class="fas fa-plus mr-2"></i> Nieuwe offerte maken
        </a>
    </div>

    <form method="GET" action="{{ route('quotes.index') }}" class="bg-gray-100 p-6 rounded-lg shadow-md mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

            <div>
                <label for="customer" class="block text-sm font-medium text-gray-700 mb-1">Klant</label>
                <input type="text" name="customer" id="customer" value="{{ request('customer') }}" class="w-full p-2 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500" placeholder="Zoek op klant">
            </div>

            <div>
                <label for="user" class="block text-sm font-medium text-gray-700 mb-1">Gebruiker</label>
                <select name="user" id="user" class="w-full p-2 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                    <option value="">Alle gebruikers</option>
                    @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ request('user') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" id="status" class="w-full p-2 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                    <option value="">Alle statussen</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>

            <div>
                <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Datum</label>
                <input type="date" name="date" id="date" value="{{ request('date') }}" class="w-full p-2 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
            </div>

        </div>

        <div class="mt-4 text-right">
            <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded-md shadow hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                Filter
            </button>
        </div>
    </form>

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

    <div class="overflow-x-auto border border-gray-200 rounded-lg">
        <table class="min-w-full bg-white border-collapse">
            <thead style="background-color: #FFD700;">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold text-black">Klant</th>
                    <th class="px-6 py-3 text-left font-semibold text-black">Gebruiker</th>
                    <th class="px-6 py-3 text-left font-semibold text-black">Status</th>
                    <th class="px-6 py-3 text-left font-semibold text-black">Datum</th>
                    <th class="px-6 py-3 text-center font-semibold text-black">Acties</th>
                </tr>
            </thead>
            <tbody class="text-black">
                @forelse ($quotes as $quote)
                <tr class="border-b hover:bg-gray-100">
                    <td class="px-6 py-4 whitespace-nowrap">{{ $quote->customer?->company_name ?? 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $quote->user?->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($quote->status) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $quote->quote_date ? $quote->quote_date->format('d-m-Y') : 'N/A' }}
                    </td>
                    <td class="px-6 py-4 text-center flex justify-center gap-4">
                        <a href="{{ route('quotes.show', $quote->id) }}" class="hover:text-gray-700" title="Bekijken" style="color: black;">
                            <i class="fas fa-eye"></i>
                        </a>
                        @if (in_array(auth()->user()->role->name, ['CEO', 'Sales', 'Head Sales']))
                        <a href="{{ route('quotes.edit', $quote->id) }}" class="hover:text-gray-700" title="Bewerken" style="color: black;">
                            <i class="fas fa-edit"></i>
                        </a>
                        @endif
                        <a href="{{ route('quotes.download', $quote->id) }}" class="hover:text-gray-700" title="Download PDF" style="color: black;">
                            <i class="fas fa-download"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-gray-500">Geen offertes gevonden.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</div>
@endsection