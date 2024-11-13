<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    // Index method to display a list of visits
    public function index()
    {
        $visits = Visit::all(); // Haal alle bezoeken op
        return view('visits.index', compact('visits'));
    }

    // Show the form to create a new visit
    public function create()
    {
        $customers = Customer::all(); // Haal alle klanten op
        $users = User::whereIn('role_id', [3, 7, 10])->get(); // Haal gebruikers op met de rollen Sales, Head Sales en CEO
        return view('visits.create', compact('customers', 'users'));
    }

    // Store a new visit
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'user_id' => 'required|exists:users,id', // Sales, Head Sales, of CEO
            'visit_date' => 'required|date',
            'address' => 'required|string',
            'error_details' => 'nullable|string',
        ]);

        Visit::create($request->all()); // Maak het bezoekrecord aan
        return redirect()->route('visits.index')->with('success', 'Bezoek succesvol ingepland.');
    }

    // Show method to display details of a specific visit
    public function show($id)
    {
        $visit = Visit::findOrFail($id); // Haal bezoek op per ID
        return view('visits.show', compact('visit')); // Toon de bezoekdetails
    }

    // Assign a visit to Maintenance team
    public function assignToMaintenance($id)
    {
        $visit = Visit::findOrFail($id);
        $maintenanceUsers = User::where('role_id', 5)->get(); // Haal gebruikers op met de rol Onderhoud (rol_id 5)
        return view('visits.assign', compact('visit', 'maintenanceUsers'));
    }

    // Store the assignment of a visit to a maintenance team member
    public function storeAssignedToMaintenance(Request $request, $id)
    {
        $request->validate([
            'maintenance_assigned_to' => 'required|exists:users,id',
        ]);

        $visit = Visit::findOrFail($id);
        $visit->maintenance_assigned_to = $request->maintenance_assigned_to;
        $visit->save();

        return redirect()->route('visits.index')->with('success', 'Bezoek succesvol toegewezen aan onderhoud.');
    }

    // Display visits assigned to maintenance
    public function maintenanceTickets()
    {
        $tickets = Visit::whereNotNull('maintenance_assigned_to')->get(); // Haal alle bezoeken op die aan onderhoud zijn toegewezen
        return view('visits.maintenance_tickets', compact('tickets'));
    }
}
