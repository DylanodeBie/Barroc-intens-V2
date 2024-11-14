<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use App\Models\Customer;
use App\Models\User;
use App\Models\ErrorNotification;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    // Index method to display a list of visits
    public function index()
    {
        $visits = Visit::with(['customer', 'user'])->get(); // Laad de relaties 'customer' en 'user' in
        return view('visits.index', compact('visits'));
    }

    // Show the form to create a new visit
    public function create()
    {
        $customers = Customer::all(); // Haal alle klanten op
        $users = User::whereIn('role_id', [3, 7, 10])->get(); // Haal gebruikers op met de rollen Sales, Head Sales en CEO
        $errorNotifications = ErrorNotification::all(); // Haal alle foutmeldingen op
        return view('visits.create', compact('customers', 'users', 'errorNotifications'));
    }

    // Store a new visit
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'user_id' => 'required|exists:users,id',
            'error_notification_id' => 'required|exists:error_notifications,id',
            'visit_date' => 'required|date', // Validatie voor de bezoekdatum
            'start_time' => 'required|date_format:H:i', // Zorgt ervoor dat het in het juiste tijdformaat is
            'end_time' => 'required|date_format:H:i|after:start_time', // Eindtijd moet na de starttijd liggen
            'address' => 'required|string',
            'used_parts' => 'required|string',
            'error_details' => 'nullable|string',
        ]);

        Visit::create($request->all()); // Maak het bezoekrecord aan
        return redirect()->route('visits.index')->with('success', 'Bezoek succesvol ingepland.');
    }

    // Show method to display details of a specific visit
    public function show($id)
    {
        $visit = Visit::with(['customer', 'user'])->findOrFail($id); // Laad 'customer' en 'user' relaties
        return view('visits.show', compact('visit')); // Toon de bezoekdetails
    }

    // Assign a visit to Maintenance team
    public function assignToMaintenance($id)
    {
        $visit = Visit::findOrFail($id);

        // Controleer of de huidige gebruiker rol 9 (Head Maintenance) of rol 10 (CEO) heeft
        if (!in_array(auth()->user()->role_id, [9, 10])) {
            abort(403, 'Geen toegang tot deze actie.');
        }

        $maintenanceUsers = User::where('role_id', 5)->get(); // Haal gebruikers op met de rol Onderhoud (rol_id 5)
        return view('visits.assign', compact('visit', 'maintenanceUsers'));
    }

    // Store the assignment of a visit to a maintenance team member
    public function storeAssignedToMaintenance(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $visit = Visit::findOrFail($id);
        $visit->user_id = $request->user_id; // Gebruik user_id voor toewijzing
        $visit->save();

        return redirect()->route('visits.index')->with('success', 'Bezoek succesvol toegewezen aan onderhoud.');
    }

    // Display visits assigned to maintenance
    public function maintenanceTickets()
    {
        $tickets = Visit::whereNotNull('user_id')->get(); // Haal alle bezoeken op die aan onderhoud zijn toegewezen
        return view('visits.maintenance_tickets', compact('tickets'));
    }
}
