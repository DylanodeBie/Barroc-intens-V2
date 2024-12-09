<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use App\Models\Customer;
use App\Models\User;
use App\Models\ErrorNotification;
use App\Models\Event;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    // Index method to display a list of visits
    public function index()
    {
        $visits = Visit::all(); // Retrieve all visits
        return view('visits.index', compact('visits'));
    }

    // Show the form to create a new visit
    public function create()
    {
        $customers = Customer::all(); // Retrieve all customers
        $users = User::whereIn('role_id', [3, 7, 10])->get(); // Retrieve users with Sales, Head Sales, and CEO roles
        $errorNotifications = ErrorNotification::all(); // Retrieve all error notifications

        return view('visits.create', compact('customers', 'users', 'errorNotifications'));
    }

    // Store a new visit
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'user_id' => 'required|exists:users,id',
            'visit_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'address' => 'required|string',
            'error_notification_id' => 'required|exists:error_notifications,id',
            'error_details' => 'nullable|string',
            'used_parts' => 'required|string',
        ]);

        Visit::create($request->all()); // Create the visit record
        return redirect()->route('visits.index')->with('success', 'Bezoek succesvol ingepland.');
    }

    // Show method to display details of a specific visit
    public function show($id)
    {
        $visit = Visit::findOrFail($id); // Retrieve visit by ID
        return view('visits.show', compact('visit')); // Show visit details
    }

    // Assign a visit to Maintenance team
    public function assignToMaintenance($id)
    {
        $visit = Visit::findOrFail($id);

        // Check if the current user has role 9 (Head Maintenance) or role 10 (CEO)
        if (!in_array(auth()->user()->role_id, [9, 10])) {
            abort(403, 'Geen toegang tot deze actie.');
        }

        $maintenanceUsers = User::where('role_id', 5)->get(); // Retrieve users with Maintenance role (role_id 5)
        return view('visits.assign', compact('visit', 'maintenanceUsers'));
    }

    // Store the assignment of a visit to a maintenance team member
    public function storeAssignedToMaintenance(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $visit = Visit::findOrFail($id);
        $visit->user_id = $request->user_id; // Assign maintenance user
        $visit->save();

        return redirect()->route('visits.index')->with('success', 'Bezoek succesvol toegewezen aan onderhoud.');
    }

    // Display visits assigned to maintenance
    public function maintenanceTickets()
    {
        $tickets = Visit::whereNotNull('user_id')->get(); // Retrieve all visits assigned to maintenance
        return view('visits.maintenance_tickets', compact('tickets'));
    }

    public function calendar()
    {
        // Formatteer de gegevens voor de frontend
        $events = Event::where('user_id', auth()->id())->get(['id', 'title', 'start', 'end', 'description']);

        $customers = Customer::all();

        // Stuur de geformatteerde events naar de view
        return view('visits.calendar', ['events' => $events, 'customers' => $customers]);
    }
}
