@extends('layouts.app')

@section('content')
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
                        <th class="px-6 py-3 text-center font-semibold text-black">Acties</th>
                    </tr>
                </thead>
                <tbody class="text-black">
                    @foreach ($parts as $part)
                        <tr class="border-b hover:bg-gray-100">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $part->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $part->stock }}</td>
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

    <!-- Bestel Modal -->
    <div id="orderModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
            <h2 class="text-2xl font-bold mb-4">Bestelling plaatsen</h2>
            <form id="orderForm" action="{{ route('parts.order') }}" method="POST">
                @csrf
                <input type="hidden" id="partId" name="part_id">
                <p id="partName" class="mb-4"></p>
                <div class="mb-4">
                    <label for="quantity" class="block font-semibold mb-2">Aantal</label>
                    <input type="number" id="quantity" name="quantity" min="1" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div class="flex justify-end gap-4">
                    <button type="button" onclick="closeOrderModal()"
                        class="px-4 py-2 rounded-md bg-gray-300 hover:bg-gray-400">
                        Annuleren
                    </button>
                    <button type="submit"
                        class="px-4 py-2 rounded-md text-white bg-blue-600 hover:bg-blue-500">
                        Bestellen
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openOrderModal(partId, partName) {
            document.getElementById('partId').value = partId;
            document.getElementById('partName').innerText = `Onderdeel: ${partName}`;
            document.getElementById('orderModal').classList.remove('hidden');
        }

        function closeOrderModal() {
            document.getElementById('orderModal').classList.add('hidden');
        }
    </script>
@endsection
