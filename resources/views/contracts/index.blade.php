@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">

    @if(session('success'))
    <div class="mb-4 p-4 bg-green-500 text-white rounded-lg">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="mb-4 p-4 bg-red-500 text-white rounded-lg">
        {{ session('error') }}
    </div>
    @endif


    <h2 class="text-2xl font-semibold mb-4">Overzicht Leasecontracten</h2>
    <a href="{{ route('leasecontracts.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Nieuw Contract</a>
    <div class="mt-6">
        <table class="min-w-full bg-white shadow rounded-lg">
            <thead>
                <tr>
                    <th class="px-4 py-2 border-b">Klant</th>
                    <th class="px-4 py-2 border-b">Startdatum</th>
                    <th class="px-4 py-2 border-b">Einddatum</th>
                    <th class="px-4 py-2 border-b">Betalingsoptie</th>
                    <th class="px-4 py-2 border-b">Acties</th>
                </tr>
            </thead>
            <tbody>
                @foreach($leasecontracts as $contract)
                <tr>
                    <td class="px-4 py-2 border-b">{{ $contract->customers->company_name }}</td>
                    <td class="px-4 py-2 border-b">{{ $contract->start_date }}</td>
                    <td class="px-4 py-2 border-b">{{ $contract->end_date }}</td>
                    <td class="px-4 py-2 border-b">{{ ucfirst($contract->payment_method) }}</td>
                    <td class="px-4 py-2 border-b">
                        <a href="{{ route('leasecontracts.show', $contract->id) }}" class="text-blue-500 hover:underline">Bekijken</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection