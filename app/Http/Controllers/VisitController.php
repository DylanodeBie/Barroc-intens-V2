<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use App\Models\Customer;
use App\Models\User;
use App\Models\ErrorNotification;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VisitController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $companyName = $request->input('company_name');
        $type = $request->input('type');
        $userId = $request->input('user_id');
        $status = $request->input('status');

        $visits = Visit::with('customer', 'user')
            ->when($search, function ($query, $search) {
                return $query->whereHas('customer', function ($q) use ($search) {
                    $q->where('company_name', 'like', "%{$search}%");
                })
                ->orWhere('address', 'like', "%{$search}%")
                ->orWhere('visit_date', 'like', "%{$search}%");
            })
            ->when($companyName, function ($query, $companyName) {
                return $query->whereHas('customer', function ($q) use ($companyName) {
                    $q->where('company_name', 'like', "%{$companyName}%");
                });
            })
            ->when($type, function ($query, $type) {
                return $query->where('type', $type);
            })
            ->when($userId, function ($query, $userId) {
                return $query->where('user_id', $userId);
            })
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->get();

        $users = User::whereIn('role_id', [5, 9, 10])->get();
        $statuses = Visit::select('status')->distinct()->pluck('status');

        return view('visits.index', compact('visits', 'users', 'statuses'));
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
            'type' => 'required|in:maintenance,sales',
        ]);

        $visit = Visit::create($request->all());

        Event::create([
            'user_id' => $request->user_id,
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

    public function myTickets(Request $request)
    {
        $user = auth()->user();

        if (!in_array($user->role_id, [5, 9, 10])) {
            abort(403, 'Geen toegang tot deze pagina.');
        }

        $query = auth()->user()->role_id === 9 || auth()->user()->role_id === 10
            ? Visit::query()
            : Visit::where('user_id', $user->id);

        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('company_name')) {
            $query->whereHas('customer', function ($q) use ($request) {
                $q->where('company_name', 'like', '%' . $request->input('company_name') . '%');
            });
        }

        $visits = $query->get();

        $users = User::whereIn('role_id', [5, 9, 10])->get();
        $statuses = Visit::select('status')->distinct()->pluck('status');

        return view('visits.maintenance_tickets', compact('visits', 'users', 'statuses'));
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

        Event::where('customer_id', $visit->customer_id)
            ->where('start', $visit->visit_date . " " . $visit->start_time)
            ->where('end', $visit->visit_date . " " . $visit->end_time)
            ->delete();

        $visit->delete();

        return redirect()->route('visits.index')->with('success', 'Bezoek en bijbehorend evenement succesvol verwijderd.');
    }

    public function sign(Request $request, $id)
    {
        $visit = Visit::find($id);

        if (!$visit) {
            return response()->json(['message' => 'Bezoek niet gevonden'], 404);
        }

        $signatureData = $request->input('signature');
        if (!$signatureData) {
            return response()->json(['message' => 'Geen handtekening ontvangen'], 400);
        }

        $signatureImage = str_replace('data:image/png;base64,', '', $signatureData);
        $signatureImage = str_replace(' ', '+', $signatureImage);
        $decodedImage = base64_decode($signatureImage);

        $fileName = 'signatures/' . uniqid() . '.png';
        Storage::disk('public')->put($fileName, $decodedImage);

        $visit->signature_path = $fileName;
        $visit->status = 'completed';
        $visit->save();

        return response()->json(['message' => 'Bezoek succesvol ondertekend', 'path' => $fileName]);
    }
}
