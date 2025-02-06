<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Part;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class MarketingController extends Controller
{
    public function index()
    {
        $parts = Part::all();
        $lowStockParts = Part::where('stock', '<', 10)->get();
        $orders = Order::with('part', 'user')->latest()->paginate(10);

        foreach ($orders as $order) {
            $order->total_price = $order->part->price * $order->quantity;
        }

        return view('marketing.dashboard', compact('parts', 'lowStockParts', 'orders'));
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

        $part = Part::findOrFail($request->part_id);
        $totalPrice = $part->price * $request->quantity;
        $part->stock += $request->quantity;
        $part->save();

        $order = Order::create([
            'part_id' => $part->id,
            'user_id' => Auth::id(),
            'quantity' => $request->quantity,
            'requires_signature' => $totalPrice > 500,
        ]);

        if ($order->requires_signature) {
            return redirect()->route('parts.index')->with('totalPrice', $totalPrice)->with('requiresSignature', true);
        }

        return redirect()->route('parts.index')->with('success', 'De bestelling is succesvol geplaatst!');
    }

    public function storeSignature(Request $request)
    {
        $order = Order::where('user_id', Auth::id())->latest()->first();

        if ($order) {
            $signatureData = $request->input('signature');

            if ($signatureData) {
                $signaturePath = 'signatures/' . uniqid() . '.png';
                file_put_contents(storage_path('app/public/' . $signaturePath), base64_decode(preg_replace('/^data:image\/png;base64,/', '', $signatureData)));
                $order->update(['signature_path' => $signaturePath]);

                return redirect()->route('parts.index')->with('success', 'De bestelling is succesvol geplaatst met een handtekening.');
            }

            return redirect()->back()->with('error', 'Handtekening ontbreekt, probeer opnieuw.');
        }

        return redirect()->back()->with('error', 'Geen bestelling gevonden om een handtekening aan toe te voegen.');
    }

    public function destroy(Part $part)
    {
        $part->delete();
        return redirect()->back()->with('success', 'Onderdeel verwijderd.');
    }
}
