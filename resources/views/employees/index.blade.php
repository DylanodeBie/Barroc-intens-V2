@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-semibold mb-4">Employees</h1>

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

    <a href="{{ route('employees.create') }}" class="px-4 py-2 bg-[#FFD700] text-white rounded-md hover:bg-[#FFD700] mb-4">
        <i class="fas fa-plus mr-2"></i>Voeg medewerker toe
    </a>

    <div class="mt-6 bg-white shadow rounded-lg overflow-hidden">
        <table class="w-full border-collapse">
            <thead class="bg-[#FFD700] text-left text-black">
                <tr>
                    <th class="px-4 py-2 border-b">ID</th>
                    <th class="px-4 py-2 border-b">Naam</th>
                    <th class="px-4 py-2 border-b">Email</th>
                    <th class="px-4 py-2 border-b">Rol</th>
                    <th class="px-4 py-2 border-b">Acties</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                <tr class="border-b hover:bg-gray-100">
                    <td class="px-4 py-2">{{ $employee->id }}</td>
                    <td class="px-4 py-2">{{ $employee->name }}</td>
                    <td class="px-4 py-2">{{ $employee->email }}</td>
                    <td class="px-4 py-2">{{ $employee->role ? $employee->role->name : 'Onbekend' }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('employees.show', $employee->id) }}" class="text-black-500 hover:text-gray-500" title="Bekijken">
                            <i class="fas fa-eye"></i></a>
                        <a href="{{ route('employees.edit', $employee->id) }}" class="text-black-500 hover:text-gray-500" title="Bewerken">
                            <i class="fas fa-edit"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection