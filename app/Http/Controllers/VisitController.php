<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    // Middleware to ensure only the correct roles can create or assign visits
    public function __construct()
    {
        $this->middleware('role:Sales|Head Sales|CEO'); // Allow Sales, Head Sales, and CEO to create visits
    }

    // Show the form to create a new visit
    public function create()
    {
        $customers = Customer::all(); // Get all customers
        $users = User::whereIn('role_id', [3, 7, 10])->get(); // Get users with roles Sales, Head Sales, and CEO
        return view('visits.create', compact('customers', 'users'));
    }

    // Store a new visit
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'user_id' => 'required|exists:users,id', // Sales, Head Sales, or CEO
            'visit_date' => 'required|date',
            'address' => 'required|string',
            'error_details' => 'nullable|string',
        ]);

        $visit = Visit::create($request->all()); // Create the visit record
        return redirect()->route('visits.index')->with('success', 'Visit scheduled successfully.');
    }

    // Assign a visit to Maintenance team
    public function assignToMaintenance($id)
    {
        $visit = Visit::findOrFail($id);

        // Check if the current user is Head of Maintenance
        if(auth()->user()->role->name !== 'Head Maintenance') {
            abort(403, 'Unauthorized action.');
        }

        $maintenanceUsers = User::where('role_id', 5)->get(); // Get users with Head Maintenance role
        return view('visits.assign', compact('visit', 'maintenanceUsers'));
    }

    // Store the assignment of a visit to a maintenance team member
    public function storeAssignedToMaintenance(Request $request, $id)
    {
        $visit = Visit::findOrFail($id);
        $visit->maintenance_assigned_to = $request->maintenance_assigned_to;
        $visit->save();

        return redirect()->route('visits.index')->with('success', 'Visit assigned to maintenance successfully.');
    }

    // Display visits assigned to maintenance
    public function maintenanceTickets()
    {
        $tickets = Visit::whereNotNull('maintenance_assigned_to')->get(); // Get all visits assigned to maintenance
        return view('visits.maintenance_tickets', compact('tickets'));
    }
}
