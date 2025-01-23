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
            'price' => 'required|numeric|min:0',
        ]);

        Part::create($request->only('name', 'stock', 'price'));
        return redirect()->route('parts.index')->with('success', 'Nieuw onderdeel toegevoegd!');
    }

    public function order(Request $request)
{
    $request->validate([
        'part_id' => 'required|exists:parts,id',
        'quantity' => 'required|integer|min:1',
    ]);

    // Haal het onderdeel op en bereken de totale prijs
    $part = Part::findOrFail($request->part_id);
    $totalPrice = $part->price * $request->quantity;

    // Verhoog de voorraad ongeacht de prijs
    $part->stock += $request->quantity;
    $part->save();

    // Als de prijs boven de 500 euro is, vragen we om een handtekening
    if ($totalPrice > 500) {
        return redirect()->route('parts.index')->with('totalPrice', $totalPrice)->with('requiresSignature', true);
    }

    // Als de prijs onder de 500 euro is, bevestig de bestelling
    return redirect()->route('parts.index')->with('success', 'De bestelling is succesvol geplaatst!');
}


    public function storeSignature(Request $request)
    {
        $signatureData = $request->input('signature');

        // Bewaar de handtekening, bijv. in de database of als bestand
        // Hier sla ik de handtekening op als een bestand (je kunt dit aanpassen naar je eigen situatie)
        $signaturePath = storage_path('app/public/signatures/').uniqid().'.png';
        file_put_contents($signaturePath, base64_decode(preg_replace('/^data:image\/png;base64,/', '', $signatureData)));

        return redirect()->route('parts.index')->with('success', 'De bestelling is succesvol geplaatst met een handtekening.');
    }




    public function destroy(Part $part)
    {
        $part->delete();
        return redirect()->back()->with('success', 'Onderdeel verwijderd.');
    }
}
