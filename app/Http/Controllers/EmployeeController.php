<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role; // Voeg dit toe om de rollen op te halen
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = User::all();
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        $roles = Role::all(); // Verkrijg alle rollen
        return view('employees.create', compact('roles'));
    }

    public function store(Request $request)
    {

        // Validatie voor de invoer
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role_id' => 'required|exists:roles,id', // Rol validatie
        ]);

        // Maak een nieuwe gebruiker aan
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Versleuteling van het wachtwoord
            'role_id' => $request->role_id, // De rol wordt hier opgeslagen
        ]);

        // Redirect naar de index met succesbericht
        return redirect()->route('employees.index')->with('success', 'Medewerker toegevoegd!');
    }

    public function show(User $employee)
    {
        return view('employees.show', compact('employee'));
    }

    // Nieuwe edit methode om de gebruiker te bewerken
    public function edit(User $employee)
    {
        $roles = Role::all(); // Verkrijg alle rollen
        $userRoleId = $employee->role_id; // Verkrijg de role_id van de werknemer

        return view('employees.edit', compact('employee', 'roles', 'userRoleId'));
    }

    // Nieuwe update methode om de gegevens van de gebruiker op te slaan
    public function update(Request $request, User $employee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'roles' => 'required|array|min:1|max:1', // Minimaal één en maximaal één rol vereist
            'roles.*' => 'exists:roles,id', // Controleer of de rol bestaat
        ]);

        // Werk de basisgegevens van de werknemer bij
        $employee->name = $request->name;
        $employee->email = $request->email;

        // Werk de rol bij
        $employee->role_id = $request->roles[0]; // Aangezien we slechts één rol verwachten
        $employee->save();

        return redirect()->route('employees.index')
            ->with('success', 'Employee updated successfully.');
    }
}
