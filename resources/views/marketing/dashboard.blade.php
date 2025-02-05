@extends('layouts.app')

@section('content')
<style>
    #signatureCanvas {
        border: 1px solid #ccc;
        width: 100%;
        height: 200px;
    }
    .button {
        margin-top: 10px;
    }
</style>

<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-4 text-center text-black">Onderdelenbeheer</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Succes!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
            <button onclick="this.parentElement.style.display='none'" class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <span class="text-green-500">&times;</span>
            </button>
        </div>
    @endif

    @if ($lowStockParts->isNotEmpty())
        <div class="mb-4">
            @foreach ($lowStockParts as $part)
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-2" role="alert">
                    <strong class="font-bold">{{ $part->name }}</strong> heeft een lage voorraad:
                    <span>{{ $part->stock }}</span>.
                    <button type="button" onclick="this.parentElement.remove();" class="float-right text-red-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endforeach
        </div>
    @endif

    <div class="flex justify-end mb-4">
        <a href="{{ route('parts.create') }}" class="font-semibold px-6 py-2 rounded-md hover:bg-yellow-500"
            style="background-color: #FFD700; color: black;">
            <i class="fas fa-plus mr-2"></i> Nieuw onderdeel toevoegen
        </a>
    </div>

    <div class="overflow-x-auto border border-gray-200 rounded-lg">
        <table class="min-w-full bg-white border-collapse">
            <thead style="background-color: #FFD700;">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold text-black">Naam</th>
                    <th class="px-6 py-3 text-left font-semibold text-black">Voorraad</th>
                    <th class="px-6 py-3 text-left font-semibold text-black">Prijs</th>
                    <th class="px-6 py-3 text-center font-semibold text-black">Acties</th>
                </tr>
            </thead>
            <tbody class="text-black">
                @foreach ($parts as $part)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="px-6 py-4 whitespace-nowrap">{{ $part->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $part->stock }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $part->price }} €</td>
                        <td class="px-6 py-4 text-center">
                            <button
                                class="px-4 py-2 rounded-md mr-10 text-white bg-blue-600 hover:bg-blue-500"
                                onclick="openOrderModal({{ $part->id }}, '{{ $part->name }}')">
                                Bestellen
                            </button>
                            <form action="{{ route('parts.destroy', $part->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash-alt"></i> Verwijderen
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<h2 class="text-2xl font-bold mt-8 mb-4">Bestellingslog</h2>
<div class="overflow-x-auto border border-gray-200 rounded-lg">
    <table class="min-w-full bg-white border-collapse">
        <thead style="background-color: #FFD700;">
            <tr>
                <th class="px-6 py-3 text-left font-semibold text-black">Onderdeel</th>
                <th class="px-6 py-3 text-left font-semibold text-black">Gebruiker</th>
                <th class="px-6 py-3 text-left font-semibold text-black">Aantal</th>
                <th class="px-6 py-3 text-left font-semibold text-black">Handtekening</th>
                <th class="px-6 py-3 text-left font-semibold text-black">Totaalprijs</th>
                <th class="px-6 py-3 text-left font-semibold text-black">Datum</th>
            </tr>
        </thead>
        <tbody class="text-black">
            @foreach ($orders as $order)
                <tr class="border-b hover:bg-gray-100">
                    <td class="px-6 py-4">{{ $order->part->name }}</td>
                    <td class="px-6 py-4">{{ $order->user->name ?? 'Onbekend' }}</td>
                    <td class="px-6 py-4">{{ $order->quantity }}</td>
                    <td class="px-6 py-4">
                        @if ($order->requires_signature && $order->signature_path)
                            <img src="{{ asset('storage/' . $order->signature_path) }}" alt="Handtekening" class="h-16">
                        @elseif($order->requires_signature)
                            Handtekening vereist
                        @else
                            N.v.t.
                        @endif
                    </td>
                    <td class="px-6 py-4">{{ number_format($order->total_price, 2) }} €</td>
                    <td class="px-6 py-4">{{ $order->created_at->format('d-m-Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $orders->links() }}
</div>

<div id="orderModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
        <h2 class="text-2xl font-bold mb-4">Bestelling plaatsen</h2>
        <form id="orderForm" action="{{ route('parts.order') }}" method="POST">
            @csrf
            <input type="hidden" name="part_id" id="orderPartId">
            <div class="mb-4">
                <label for="orderPartName" class="block text-sm font-medium text-gray-700">Onderdeel</label>
                <input type="text" id="orderPartName" class="mt-1 p-2 w-full border rounded" readonly>
            </div>
            <div class="mb-4">
                <label for="quantity" class="block text-sm font-medium text-gray-700">Aantal</label>
                <input type="number" name="quantity" id="quantity" class="mt-1 p-2 w-full border rounded" min="1" required>
            </div>
            <div class="flex justify-end gap-4">
                <button type="button" onclick="closeOrderModal()" class="px-4 py-2 rounded-md bg-gray-300 hover:bg-gray-400">
                    Annuleren
                </button>
                <button type="submit" class="px-4 py-2 rounded-md text-white bg-blue-600 hover:bg-blue-500">
                    Bestellen
                </button>
            </div>
        </form>
    </div>
</div>

@if (session('totalPrice') > 500)
<div id="signatureModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
        <h2 class="text-2xl font-bold mb-4">Bestelling boven de 500 euro, handtekening vereist</h2>
        <form id="signatureForm" method="POST" action="{{ route('storeSignature') }}">
            @csrf
            <canvas id="signatureCanvas"></canvas>
            <button type="button" id="clearButton" class="button">Wis handtekening</button>
            <button type="submit" id="submitButton" class="button">Versturen</button>
        </form>
    </div>
</div>
@endif

<script>
    function openOrderModal(partId, partName) {
        const modal = document.getElementById('orderModal');
        document.getElementById('orderPartId').value = partId;
        document.getElementById('orderPartName').value = partName;
        modal.classList.remove('hidden');
    }

    function closeOrderModal() {
        document.getElementById('orderModal').classList.add('hidden');
    }

    document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('signatureCanvas');
    const clearButton = document.getElementById('clearButton');
    const submitButton = document.getElementById('submitButton');
    const form = document.getElementById('signatureForm');

    // Initialiseer SignaturePad
    const signaturePad = new SignaturePad(canvas);

    // Canvas dynamisch schalen
    function resizeCanvas() {
        const ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = 200 * ratio; // Zelfde als CSS hoogte
        canvas.getContext('2d').scale(ratio, ratio);
        signaturePad.clear(); // Canvas leegmaken
    }
    resizeCanvas();
    window.addEventListener('resize', resizeCanvas);

    // Handtekening wissen
    clearButton.addEventListener('click', function () {
        signaturePad.clear();
    });

    // Formulier verzenden
    submitButton.addEventListener('click', function (e) {
        e.preventDefault();

        if (signaturePad.isEmpty()) {
            alert('Voeg een handtekening toe!');
            return;
        }

        // Voeg de Base64-handtekening toe aan het formulier
        const signatureInput = document.createElement('input');
        signatureInput.type = 'hidden';
        signatureInput.name = 'signature';
        signatureInput.value = signaturePad.toDataURL('image/png');
        form.appendChild(signatureInput);

        form.submit();
    });
});

</script>
@endsection
