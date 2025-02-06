<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
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
        $roles = Role::all();
        return view('employees.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('employees.index')->with('success', 'Medewerker toegevoegd!');
    }

    public function show(User $employee)
    {
        return view('employees.show', compact('employee'));
    }

    public function edit(User $employee)
    {
        $roles = Role::all();
        $userRoleId = $employee->role_id;

        return view('employees.edit', compact('employee', 'roles', 'userRoleId'));
    }

    public function update(Request $request, User $employee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'roles' => 'required|array|min:1|max:1',
            'roles.*' => 'exists:roles,id',
        ]);

        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->role_id = $request->roles[0];
        $employee->save();

        return redirect()->route('employees.index')
            ->with('success', 'Employee updated successfully.');
    }
}
