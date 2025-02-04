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
    public function index()
    {
        $visits = Visit::all();
        return view('visits.index', compact('visits'));
    }

    public function create()
    {
        $customers = Customer::all();
        $users = User::whereIn('role_id', [3, 7, 10])->get();
        $errorNotifications = ErrorNotification::all();

        return view('visits.create', compact('customers', 'users', 'errorNotifications'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'user_id' => 'required|exists:users,id',
            'visit_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'address' => 'required|string',
            'error_notification_id' => 'required|exists:error_notifications,id',
            'error_details' => 'nullable|string',
            'used_parts' => 'required|string',
        ], [
            'end_time.after' => 'De eindtijd moet later zijn dan de starttijd.',
            'start_time.date_format' => 'De starttijd moet in 24-uurs formaat zijn (HH:MM).',
            'end_time.date_format' => 'De eindtijd moet in 24-uurs formaat zijn (HH:MM).',
        ]);

        // Bezoek opslaan
        $visit = Visit::create($request->all());

        // Event voor de verkoper aanmaken
        Event::create([
            'user_id' => $request->user_id, // Toegewezen verkoper
            'customer_id' => $request->customer_id,
            'title' => "Bezoek aan " . $visit->customer->company_name,
            'start' => $visit->visit_date . " " . $visit->start_time,
            'end' => $visit->visit_date . " " . $visit->end_time,
            'description' => "Bezoek gepland op " . $visit->address,
        ]);

        return redirect()->route('visits.index')->with('success', 'Bezoek succesvol ingepland en toegevoegd aan de kalender.');
    }

    public function show($id)
    {
        $visit = Visit::findOrFail($id);
        return view('visits.show', compact('visit'));
    }

    public function assignToMaintenance($id)
    {
        $visit = Visit::findOrFail($id);

        if (!in_array(auth()->user()->role_id, [9, 10])) {
            abort(403, 'Geen toegang tot deze actie.');
        }

        $maintenanceUsers = User::where('role_id', 5)->get();
        return view('visits.assign', compact('visit', 'maintenanceUsers'));
    }

    public function storeAssignedToMaintenance(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $visit = Visit::findOrFail($id);
        $visit->user_id = $request->user_id;
        $visit->save();

        return redirect()->route('visits.index')->with('success', 'Bezoek succesvol toegewezen aan onderhoud.');
    }

    public function maintenanceTickets()
    {
        $tickets = Visit::whereNotNull('user_id')->get();
        return view('visits.maintenance_tickets', compact('tickets'));
    }

    public function calendar()
    {
        $events = Event::where('user_id', auth()->id())->get(['id', 'title', 'start', 'end', 'description']);

        $customers = Customer::all();

        return view('visits.calendar', ['events' => $events, 'customers' => $customers]);
    }

    public function destroy($id)
    {
        $visit = Visit::findOrFail($id);

        // Verwijder het gekoppelde event
        Event::where('customer_id', $visit->customer_id)
            ->where('start', $visit->visit_date . " " . $visit->start_time)
            ->where('end', $visit->visit_date . " " . $visit->end_time)
            ->delete();

        $visit->delete();

        return redirect()->route('visits.index')->with('success', 'Bezoek en bijbehorend evenement succesvol verwijderd.');
    }
}
