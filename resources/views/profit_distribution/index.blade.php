@extends('layouts.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-4 text-center text-black">Winstverdeling</h1>

    <!-- Filters -->
    <form method="GET" action="{{ route('profit_distribution.index') }}" class="mb-4">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label for="year" class="block text-sm font-medium text-gray-700">Jaar:</label>
                <select name="year" id="year" class="form-select border-gray-300 rounded-md w-full">
                    @for ($y = date('Y'); $y >= 2015; $y--)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </div>
            <div>
                <label for="customer_id" class="block text-sm font-medium text-gray-700">Klant:</label>
                <select name="customer_id" id="customer_id" class="form-select border-gray-300 rounded-md w-full">
                    <option value="">Alle klanten</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}" {{ $customerId == $customer->id ? 'selected' : '' }}>
                            {{ $customer->company_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit"
                    class="w-full bg-yellow-500 text-black font-semibold px-4 py-2 rounded-md hover:bg-yellow-600">
                    Filteren
                </button>
            </div>
        </div>
    </form>

    <!-- PDF Export Button -->
    <div class="flex justify-end mb-4">
        <a href="{{ route('profit_distribution.pdf', ['year' => $year, 'customer_id' => $customerId]) }}"
            class="font-semibold px-6 py-2 rounded-md hover:bg-yellow-500"
            style="background-color: #FFD700; color: black;">
            <i class="fas fa-download mr-2"></i> PDF Exporteren
        </a>
    </div>

    <!-- Tabel -->
    <div class="overflow-x-auto border border-gray-200 rounded-lg">
        <table class="min-w-full bg-white border-collapse">
            <thead style="background-color: #FFD700;">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold text-black">Maand</th>
                    <th class="px-6 py-3 text-left font-semibold text-black">Inkomsten (€)</th>
                    <th class="px-6 py-3 text-left font-semibold text-black">Uitgaven (€)</th>
                    <th class="px-6 py-3 text-left font-semibold text-black">Winst (€)</th>
                </tr>
            </thead>
            <tbody class="text-black">
                @foreach ($monthlyData as $data)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="px-6 py-4 whitespace-nowrap">{{ $data['month'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            €{{ number_format($data['income'], 2, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            €{{ number_format($data['expenses'], 2, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap font-bold
                                {{ $data['income'] - $data['expenses'] < 0 ? 'text-red-600' : 'text-green-600' }}">
                            €{{ number_format($data['income'] - $data['expenses'], 2, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-bold" style="background-color: #FFD700;">
                    <td class="px-6 py-3">Totaal</td>
                    <td class="px-6 py-3">€{{ number_format($totalIncome, 2, ',', '.') }}</td>
                    <td class="px-6 py-3">€{{ number_format($totalExpenses, 2, ',', '.') }}</td>
                    <td class="px-6 py-3
                        {{ $totalIncome - $totalExpenses < 0 ? 'text-red-600' : 'text-green-600' }}">
                        €{{ number_format($totalIncome - $totalExpenses, 2, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection
