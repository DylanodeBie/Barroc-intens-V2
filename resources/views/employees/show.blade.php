@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-5">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-2xl font-semibold mb-4">Werknemer Details</h1>

        <div class="mb-4">
            <strong class="text-gray-700">Naam:</strong>
            <span class="ml-2">{{ $employee->name }}</span>
        </div>

        <div class="mb-4">
            <strong class="text-gray-700">Email:</strong>
            <span class="ml-2">{{ $employee->email }}</span>
        </div>

        <div class="mb-4">
            <strong class="text-gray-700">Rol:</strong>
            <span class="ml-2">{{ $employee->role ? $employee->role->name : 'Onbekend' }}</span>
        </div>

        <div class="mt-6 flex space-x-4">
            <a href="{{ route('employees.edit', $employee->id) }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                <i class="fas fa-edit mr-2"></i>Bewerken
            </a>

            <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je deze werknemer wilt verwijderen?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                    <i class="fa-solid fa-trash-can mr-2"></i>Verwijderen
                </button>
            </form>
        </div>

        <div class="mt-6">
            <a href="{{ route('employees.index') }}" class="text-blue-500 hover:underline"><i class="fas fa-arrow-left"></i> Terug naar overzicht</a>
        </div>
    </div>
</div>
@endsection