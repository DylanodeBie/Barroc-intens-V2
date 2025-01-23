<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Part;

class MarketingController extends Controller
{
    public function index()
    {
        $parts = Part::all();
        $lowStockParts = Part::where('stock', '<', 10)->get();
        return view('marketing.dashboard', compact('parts', 'lowStockParts'));
    }

    public function create()
    {
        return view('marketing.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
        ]);

        Part::create($request->only('name', 'stock'));
        return redirect()->route('parts.index')->with('success', 'Nieuw onderdeel toegevoegd!');
    }

    public function order(Request $request)
    {
        $request->validate([
            'part_id' => 'required|exists:parts,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $part = Part::findOrFail($request->part_id);
        $part->stock += $request->quantity; // Voorraad verhogen
        $part->save();

        return redirect()->route('parts.index')->with('success', 'De bestelling is succesvol geplaatst!');
    }


    public function destroy(Part $part)
    {
        $part->delete();
        return redirect()->back()->with('success', 'Onderdeel verwijderd.');
    }
}
