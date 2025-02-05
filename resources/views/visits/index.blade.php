@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-4 text-center text-black">Bezoeken Lijst</h1>

        <form method="GET" action="{{ route('visits.index') }}" class="bg-gray-100 p-6 rounded-lg shadow-md mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="company_name" class="block text-sm font-medium text-gray-700 mb-1">Bedrijf</label>
                    <input type="text" name="company_name" id="company_name" value="{{ request('company_name') }}" class="w-full p-2 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500" placeholder="Zoek op bedrijf">
                </div>
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Afdeling</label>
                    <select name="type" id="type" class="w-full p-2 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                        <option value="">Alle</option>
                        <option value="sales" {{ request('type') == 'sales' ? 'selected' : '' }}>Sales</option>
                        <option value="maintenance" {{ request('type') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    </select>
                </div>
                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Medewerker</label>
                    <select name="user_id" id="user_id" class="w-full p-2 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                        <option value="">Alle</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status" class="w-full p-2 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
                        <option value="">Alle</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mt-4 text-right">
                <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded-md shadow hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                    Filter
                </button>
            </div>
        </form>

        @if (in_array(auth()->user()->role_id, [3, 7, 10]))
            <div class="flex justify-end mb-4">
                <a href="{{ route('visits.create') }}" class="font-semibold px-6 py-2 rounded-md hover:bg-yellow-500" style="background-color: #FFD700; color: black;">
                    <i class="fas fa-plus mr-2"></i> Nieuw Bezoek Toevoegen
                </a>
            </div>
        @endif

    @if (session('success'))
    <div class="bg-green-500 text-white p-4 mb-4">
        {{ session('success') }}
    </div>
    @endif
    <div class="flex justify-end mb-4">
        <div class="relative">
            <input type="text" placeholder="Zoeken..." class="border border-gray-300 rounded-full px-4 py-2 pr-10">
            <button class="absolute right-3 top-2 text-black">
                <i class="fas fa-search"></i>
            </button>
        <div class="overflow-x-auto border border-gray-200 rounded-lg hidden sm:block">
            <table class="min-w-full bg-white border-collapse">
                <thead style="background-color: #FFD700;">
                    <tr>
                        <th class="px-6 py-3 text-left font-semibold text-black">Klant</th>
                        <th class="px-6 py-3 text-left font-semibold text-black">Toegewezen Gebruiker</th>
                        <th class="px-6 py-3 text-left font-semibold text-black hidden md:table-cell">Bezoekdatum</th>
                        <th class="px-6 py-3 text-left font-semibold text-black hidden lg:table-cell">Starttijd</th>
                        <th class="px-6 py-3 text-left font-semibold text-black hidden lg:table-cell">Eindtijd</th>
                        <th class="px-6 py-3 text-left font-semibold text-black hidden xl:table-cell">Adres</th>
                        <th class="px-6 py-3 text-center font-semibold text-black">Acties</th>
                    </tr>
                </thead>
                <tbody class="text-black">
                    @foreach ($visits as $visit)
                        <tr class="border-b hover:bg-gray-100">
                            <td class="px-6 py-4">{{ $visit->customer ? $visit->customer->company_name : 'Geen klant' }}</td>
                            <td class="px-6 py-4">{{ $visit->user ? $visit->user->name : 'Geen gebruiker' }}</td>
                            <td class="px-6 py-4 hidden md:table-cell">{{ $visit->visit_date }}</td>
                            <td class="px-6 py-4 hidden lg:table-cell">{{ $visit->start_time }}</td>
                            <td class="px-6 py-4 hidden lg:table-cell">{{ $visit->end_time }}</td>
                            <td class="px-6 py-4 hidden xl:table-cell">{{ $visit->address }}</td>
                            <td class="px-6 py-4 text-center flex justify-center gap-4">
                                <a href="{{ route('visits.show', $visit->id) }}" class="hover:text-gray-700" title="Bekijken" style="color: black;">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if (in_array(auth()->user()->role_id, [9, 10]))
                                    <a href="{{ route('visits.assign', $visit->id) }}" class="hover:text-gray-700" title="Toewijzen" style="color: black;">
                                        <i class="fas fa-tasks"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="sm:hidden">
            @foreach ($visits as $visit)
                <div class="border border-gray-200 rounded-lg p-4 mb-4 bg-white">
                    <p><strong>Klant:</strong> {{ $visit->customer ? $visit->customer->company_name : 'Geen klant' }}</p>
                    <p><strong>Toegewezen:</strong> {{ $visit->user ? $visit->user->name : 'Geen gebruiker' }}</p>
                    <p><strong>Datum:</strong> {{ $visit->visit_date }}</p>
                    <div class="flex justify-between items-center mt-2">
                        <a href="{{ route('visits.show', $visit->id) }}" class="text-black hover:text-gray-700" title="Bekijken">
                            <i class="fas fa-eye"></i>
                        </a>
                        @if (in_array(auth()->user()->role_id, [9, 10]))
                            <a href="{{ route('visits.assign', $visit->id) }}" class="text-black hover:text-gray-700" title="Toewijzen">
                                <i class="fas fa-tasks"></i>
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Styled table for visits list -->
    <div class="overflow-x-auto border border-gray-200 rounded-lg">
        <table class="min-w-full bg-white border-collapse">
            <thead style="background-color: #FFD700;">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold text-black">Klant</th>
                    <th class="px-6 py-3 text-left font-semibold text-black">Toegewezen Gebruiker</th>
                    <th class="px-6 py-3 text-left font-semibold text-black">Bezoekdatum</th>
                    <th class="px-6 py-3 text-left font-semibold text-black">Starttijd</th>
                    <th class="px-6 py-3 text-left font-semibold text-black">Eindtijd</th>
                    <th class="px-6 py-3 text-left font-semibold text-black">Adres</th>
                    <th class="px-6 py-3 text-center font-semibold text-black">Acties</th>
                </tr>
            </thead>
            <tbody class="text-black">
                @foreach ($visits as $visit)
                <tr class="border-b hover:bg-gray-100">
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $visit->customer ? $visit->customer->company_name : 'Geen klant gekoppeld' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $visit->user ? $visit->user->name : 'Geen gebruiker gekoppeld' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $visit->visit_date }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $visit->start_time }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $visit->end_time }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $visit->address }}</td>
                    <td class="px-6 py-4 text-center flex justify-center gap-4">
                        <!-- "Bekijken" actie altijd tonen -->
                        <a href="{{ route('visits.show', $visit->id) }}" class="hover:text-gray-700"
                            title="Bekijken" style="color: black;">
                            <i class="fas fa-eye"></i>
                        </a>

                        <!-- "Toewijzen" actie tonen aan Head Maintenance (rol_id 9) en CEO (rol_id 10) -->
                        @if (in_array(auth()->user()->role_id, [9, 10]))
                        <a href="{{ route('visits.assign', $visit->id) }}" class="hover:text-gray-700"
                            title="Toewijzen" style="color: black;">
                            <i class="fas fa-tasks"></i>
                        </a>
                        @endif

                        @if (in_array(auth()->user()->role_id, [7, 10]))
                        <form action="{{ route('visits.destroy', $visit->id) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je dit bezoek wilt verwijderen?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="hover:text-gray-700" title="Verwijderen" style="color: black;">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection