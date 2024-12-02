@section('greeting')
    Bezoeken Lijst
@endsection

@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold mb-4 text-center text-black">Bezoeken Lijst</h1>

        <!-- "Nieuw bezoek toevoegen" button with #FFD700 color -->
        @if (in_array(auth()->user()->role_id, [3, 7, 10]))
            <!-- Alleen tonen aan Sales, Head Sales, en CEO -->
            <div class="flex justify-end mb-4">
                <a href="{{ route('visits.create') }}" class="font-semibold px-6 py-2 rounded-md hover:bg-yellow-500"
                    style="background-color: #FFD700; color: black;">
                    <i class="fas fa-plus mr-2"></i> Nieuw Bezoek Toevoegen
                </a>
            </div>
        @endif

        <!-- Search bar with icon -->
        <form action="{{ route('visits.index') }}" method="GET" class="flex justify-end mb-4">
            <div class="relative">
                <input type="text" name="search" value="{{ request()->input('search') }}" placeholder="Zoeken..." class="border border-gray-300 rounded-full px-4 py-2 pr-10">
                <button type="submit" class="absolute right-3 top-2 text-black">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>

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
