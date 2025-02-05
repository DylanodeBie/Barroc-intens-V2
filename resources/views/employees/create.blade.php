@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-5">
    <h1 class="text-2xl font-semibold mb-4">Voeg Medewerker Toe</h1>

    <form action="{{ route('employees.store') }}" method="POST">
        @csrf

        <!-- Naam veld -->
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Naam</label>
            <input type="text" id="name" name="name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('name') border-red-500 @enderror" value="{{ old('name') }}" required>
            @error('name')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- E-mail veld -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
            <input type="email" id="email" name="email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('email') border-red-500 @enderror" value="{{ old('email') }}" required>
            @error('email')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Wachtwoord veld -->
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Wachtwoord</label>
            <input type="password" id="password" name="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('password') border-red-500 @enderror" required>
            @error('password')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Rol selectie -->
        <div class="mb-4">
            <label for="role_id" class="block text-sm font-medium text-gray-700">Rol</label>
            <select name="role_id" id="role_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm @error('role_id') border-red-500 @enderror" required>
                <option value="">Selecteer een rol</option>
                @foreach($roles as $role)
                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                @endforeach
            </select>
            @error('role_id')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Submit button -->
        <div class="mb-4">
            <button type="submit" class="px-4 py-2 bg-[#FFD700] text-white rounded-md hover:bg-[#FFD700]">Medewerker Toevoegen</button>
        </div>
    </form>
</div>
@endsection