@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-5">
    <h2 class="text-2xl font-semibold mb-4">Leasecontracten Keuring</h2>

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

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse($leasecontracts as $leasecontract)
        <div class="bg-white rounded-lg shadow-lg p-4">
            <h3 class="text-lg font-semibold mb-2">Leasecontract #{{ $leasecontract->id }}</h3>
            <div class="mb-4">
                <p><strong>Klant:</strong> {{ $leasecontract->customers->company_name ?? 'Geen klant' }}</p>
                <p><strong>Startdatum:</strong> {{ \Carbon\Carbon::parse($leasecontract->start_date)->format('d-m-Y') }}</p>
                <p><strong>Einddatum:</strong> {{ \Carbon\Carbon::parse($leasecontract->end_date)->format('d-m-Y') }}</p>
            </div>

            <div class="mb-4">
                <h4 class="text-md font-medium">Details:</h4>
                <ul class="list-disc list-inside">
                    <li><strong>Totale Prijs:</strong> €{{ number_format($leasecontract->total_price, 2) }}</li>
                    <li><strong>Status:</strong> {{ ucfirst($leasecontract->status) }}</li>
                </ul>
            </div>

            <div class="mt-4">
                <form action="{{ route('contracts.approve', $leasecontract->id) }}" method="POST" class="mb-4">
                    @csrf
                    <label for="approve-reason-{{ $leasecontract->id }}" class="block text-sm font-medium text-gray-700 mb-2">Reden voor goedkeuring:</label>
                    <textarea name="approval_reason" id="approve-reason-{{ $leasecontract->id }}" rows="2" class="w-full p-2 border rounded-md mb-2" required></textarea>
                    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-700 w-full">Goedkeuren</button>
                </form>

                <form action="{{ route('contracts.reject', $leasecontract->id) }}" method="POST">
                    @csrf
                    <label for="reject-reason-{{ $leasecontract->id }}" class="block text-sm font-medium text-gray-700 mb-2">Reden voor afkeuring:</label>
                    <textarea name="rejection_reason" id="reject-reason-{{ $leasecontract->id }}" rows="2" class="w-full p-2 border rounded-md mb-2" required></textarea>
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-700 w-full">Afkeuren</button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center">
            <p class="text-gray-500">Geen leasecontracten in afwachting van goedkeuring.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll("form").forEach(form => {
            form.addEventListener("submit", function (event) {
                const textarea = this.querySelector("textarea");
                if (textarea && textarea.value.trim() === "") {
                    event.preventDefault();
                    alert("Vul een reden in voordat je dit contract goedkeurt of afkeurt.");
                }
            });
        });
    });
</script>