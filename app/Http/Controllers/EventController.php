<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::where('user_id', auth()->id()) // Alleen events van de ingelogde gebruiker
            ->orWhereHas('customer', function ($query) {
                $query->where('user_id', auth()->id()); // Events van gekoppelde klanten tonen
            })
            ->with('customer:id,company_name')
            ->get(['id', 'customer_id', 'title', 'start', 'end', 'description']);

        return response()->json(['events' => $events]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'start' => 'required|date',
            'end' => 'nullable|date|after_or_equal:start',
            'description' => 'nullable|string',
            'customer_id' => 'nullable|exists:customers,id',
        ]);

        $event = Event::create(array_merge($validated, ['user_id' => auth()->id()]));

        return response()->json($event->load('customer'), 201);
    }


    public function update(Request $request, $id)
    {
        $event = Event::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $event->update($request->all());

        return response()->json($event->load('customer'));
    }

    public function destroy($id)
    {
        $event = Event::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $event->delete();

        return response()->json(['message' => 'Event deleted']);
    }
}
