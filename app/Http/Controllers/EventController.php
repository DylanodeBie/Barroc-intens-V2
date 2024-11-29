<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::where('user_id', auth()->id())
            ->get(['id', 'title', 'start', 'end', 'description'])
            ->map(function ($event) {
                $event->start = $event->start->setTimezone(auth()->user()->timezone);
                $event->end = $event->end ? $event->end->setTimezone(auth()->user()->timezone) : null;
                return $event;
            });
        return response()->json($events);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'start' => 'required|date',
            'end' => 'nullable|date|after_or_equal:start',
            'description' => 'nullable|string',
        ]);

        $event = Event::create(array_merge($validated, ['user_id' => auth()->id()]));

        return response()->json($event, 201);
    }


    public function update(Request $request, $id)
    {
        $event = Event::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $event->update($request->all());

        return response()->json($event);
    }

    public function destroy($id)
    {
        $event = Event::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $event->delete();

        return response()->json(['message' => 'Event deleted']);
    }
}
