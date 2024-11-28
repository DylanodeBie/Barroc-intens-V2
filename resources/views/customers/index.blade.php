@section('greeting')
    Klantenlijst
@endsection

@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold mb-4 text-center text-black">Klantenlijst</h1>

        <!-- "Nieuw klant toevoegen" button with #FFD700 color -->
        <div class="flex justify-end mb-4">
            <a href="{{ route('customers.create') }}" class="font-semibold px-6 py-2 rounded-md hover:bg-yellow-500"
                style="background-color: #FFD700; color: black;">
                <i class="fas fa-plus mr-2"></i> Nieuwe klant toevoegen
            </a>
        </div>

        <!-- Search bar with icon -->
        <div class="flex justify-end mb-4">
            <div class="relative">
                <input type="text" placeholder="Zoeken..." class="border border-gray-300 rounded-full px-4 py-2 pr-10">
                <button class="absolute right-3 top-2 text-black">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>

        <!-- Styled table for customer list -->
        <div class="overflow-x-auto border border-gray-200 rounded-lg">
            <table class="min-w-full bg-white border-collapse">
                <thead style="background-color: #FFD700;">
                    <tr>
                        <th class="px-6 py-3 text-left font-semibold text-black">Bedrijfsnaam</th>
                        <th class="px-6 py-3 text-left font-semibold text-black">Contactpersoon</th>
                        <th class="px-6 py-3 text-left font-semibold text-black">Telefoonnummer</th>
                        <th class="px-6 py-3 text-left font-semibold text-black">Email</th>
                        <th class="px-6 py-3 text-left font-semibold text-black">BKR check</th>
                        <th class="px-6 py-3 text-center font-semibold text-black">Acties</th>
                    </tr>
                </thead>
                <tbody class="text-black">
                    @foreach ($customers as $customer)
                        <tr class="border-b hover:bg-gray-100">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $customer->company_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $customer->contact_person }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $customer->phonenumber }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $customer->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="{{ $customer->bkr_check ? 'font-semibold' : 'text-gray-400' }}">
                                    {{ $customer->bkr_check ? 'Ja' : 'Nee' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center flex justify-center gap-4">
                                <!-- Action icons in black -->
                                <a href="{{ route('customers.show', $customer->id) }}" class="hover:text-gray-700"
                                    title="Bekijken" style="color: black;">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <!-- Only show Edit option for CEO, Sales, and Head of Sales -->
                                @if (in_array(auth()->user()->role->name, ['CEO', 'Sales', 'Head Sales']))
                                    <a href="{{ route('customers.edit', $customer->id) }}" class="hover:text-gray-700"
                                        title="Bewerken" style="color: black;">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endif

                                <!-- Placeholder for download icon without functionality -->
                                <span class="hover:text-gray-700 cursor-pointer" title="Download" style="color: black;">
                                    <i class="fas fa-download"></i>
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
