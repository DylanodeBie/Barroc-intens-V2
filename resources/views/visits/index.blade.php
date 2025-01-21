@section('greeting')
    Bezoeken Lijst
@endsection

@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
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
                    <label for="status" class="block text
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
                <a href="{{ route('visits.create') }}" class="font-semibold px-6 py-2 rounded-md hover:bg-yellow-500"
                    style="background-color: #FFD700; color: black;">
                    <i class="fas fa-plus mr-2"></i> Nieuw Bezoek Toevoegen
                </a>
            </div>
        @endif

        @if($visits->isEmpty())
        <div class="flex items-center bg-red-100 border border-red-400 text-red-800 p-4 mb-4 rounded-md mt-4">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            <strong>Geen bezoeken gevonden!</strong> Er zijn geen bezoeken die overeenkomen met je zoekopdracht.
        </div>
        @endif
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
                        @if (in_array(auth()->user()->role_id, [10]))
                            <th class="px-6 py-3 text-left font-semibold text-black">Type</th>
                        @endif
                        <th class="px-6 py-3 text-left font-semibold text-black">Status</th>
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
                            @if (in_array(auth()->user()->role_id, [10]))
                                <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($visit->type) }}</td>
                            @endif
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $visit->status == 'scheduled' ? 'yellow' : ($visit->status == 'completed' ? 'green' : 'red') }}-100 text-{{ $visit->status == 'scheduled' ? 'yellow' : ($visit->status == 'completed' ? 'green' : 'red') }}-800">
                                    {{ ucfirst($visit->status) }}
                                </span>

                            <td class="px-6 py-4 text-center flex justify-center gap-4">
                                <a href="{{ route('visits.show', $visit->id) }}" class="hover:text-gray-700"
                                    title="Bekijken" style="color: black;">
                                    <i class="fas fa-eye"></i>
                                </a>

                                @if (in_array(auth()->user()->role_id, [9, 10]))
                                    <a href="{{ route('visits.assign', $visit->id) }}" class="hover:text-gray-700"
                                        title="Toewijzen" style="color: black;">
                                        <i class="fas fa-tasks"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection
