@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Wijzig Medewerker</h1>

    <form action="{{ route('employees.update', $employee->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Naam</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $employee->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $employee->email) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Rol</label><br>
            @foreach($roles as $role)
                <div class="form-check">
                    <input class="form-check-input role-checkbox" type="checkbox" 
                           name="roles[]" 
                           value="{{ $role->id }}" 
                           id="role_{{ $role->id }}"
                           {{ in_array($role->id, old('roles', [$userRoleId])) ? 'checked' : '' }}
                           {{ $userRoleId && $userRoleId != $role->id ? 'disabled' : '' }}>
                    <label class="form-check-label" for="role_{{ $role->id }}">
                        {{ $role->name }}
                    </label>
                </div>
            @endforeach
            @error('roles')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Opslaan</button>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const checkboxes = document.querySelectorAll('.role-checkbox');
        let selectedRole = null;

        // Zet de eerste rol met de actieve rol alvast geselecteerd
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                selectedRole = checkbox; // Bewaar de geselecteerde rol
            }
        });

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                // Als de checkbox is aangevinkt
                if (this.checked) {
                    // Als er al een rol geselecteerd is, deselecteer deze
                    if (selectedRole && selectedRole !== this) {
                        selectedRole.checked = false; // Deselectioneer de vorige geselecteerde rol
                    }
                    selectedRole = this; // Bewaar de huidige geselecteerde rol
                    // Zet alle andere checkboxes uit
                    checkboxes.forEach(c => {
                        if (c !== selectedRole) {
                            c.disabled = true; // Deactiveer de andere checkboxes
                        }
                    });
                } else {
                    // Als de huidige rol wordt gedeselecteerd
                    selectedRole = null; // Reset de geselecteerde rol
                    // Maak alle checkboxes weer aanklikbaar
                    checkboxes.forEach(c => {
                        c.disabled = false; // Maak alle checkboxes weer aanklikbaar
                        c.checked = false; // Deselecteer alle andere checkboxes
                    });
                }
            });
        });
    });
</script>

@endsection