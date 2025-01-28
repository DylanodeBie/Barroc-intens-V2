<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Leasecontract;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

class LeasecontractController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->role_id == 10) { // role_id 1 = Admin
            // Admin ziet ALLE contracten, ongeacht de status
            $leasecontracts = Leasecontract::with(['customers', 'products'])->get();
        } elseif (in_array($request->user()->role_id, [2])) { // role_id 2 = Finance, 10 = Manager
            // Finance en Manager zien alleen de contracten met status 'pending' voor goedkeuring
            $leasecontracts = Leasecontract::where('status', 'pending')
                ->with(['customers', 'products']) // Voeg producten toe via de relatie
                ->get();
        }

        return view('contracts.index', compact('leasecontracts'));
    }

    public function create()
    {
        $users = User::all();
        $customers = Customer::all();
        $products = Product::all();

        return view('contracts.create', compact('users', 'customers', 'products'));
    }

    public function show(Leasecontract $leasecontract)
    {
        $leasecontract = Leasecontract::with(['customers', 'users', 'products'])->findOrFail($leasecontract->id);
        return view('contracts.show', compact('leasecontract'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'user_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'payment_method' => 'required|string',
            'machine_amount' => 'required|integer|min:1',
            'notice_period' => 'required|string',
            'total_price' => 'required|numeric',
        ], [
            'end_date.after_or_equal' => 'De einddatum mag niet eerder zijn dan de startdatum!',
        ]);

        $validated['status'] = 'pending';

        $leasecontract = Leasecontract::create($validated);

        $totalPrice = 0;

        if ($request->has('products')) {
            foreach ($request->products as $product) {
                $leasecontract->products()->attach($product['product_id'], [
                    'amount' => $product['amount'],
                    'price' => $product['price'],
                ]);
                $totalPrice += $product['amount'] * $product['price'];
            }
        }
        $leasecontract->update(['total_price' => $totalPrice]);

        return redirect()->route('leasecontracts.index')->with('success', 'Leasecontract succesvol aangemaakt.');
    }

    public function edit($id)
    {
        $leasecontract = LeaseContract::with('products')->findOrFail($id);
        $customers = Customer::all();
        $users = User::all();

        // Haal de producten op die al gekoppeld zijn aan het contract
        $linkedProducts = $leasecontract->products;

        // Haal de producten op die niet gekoppeld zijn aan het contract
        $unlinkedProducts = Product::whereNotIn('id', $linkedProducts->pluck('id'))->get();

        return view('contracts.edit', compact(
            'leasecontract',
            'customers',
            'users',
            'linkedProducts',
            'unlinkedProducts'
        ));
    }


    public function update(Request $request, $id)
    {
        $leasecontract = LeaseContract::findOrFail($id);

        // Update leasecontract details
        $leasecontract->update($request->only([
            'customer_id',
            'user_id',
            'start_date',
            'end_date',
            'payment_method',
            'machine_amount',
            'notice_period',
        ]));

        // Synchroniseer producten met hun pivot-data
        $products = $request->input('products', []);
        $syncData = [];
        $totalPrice = 0;

        foreach ($products as $productId => $productData) {
            if ($productData['product_id'] != '0') {
                $syncData[$productId] = [
                    'amount' => $productData['amount'] ?? 0,
                    'price' => $productData['price'] ?? 0,
                ];

                $totalPrice += ($productData['amount'] ?? 0) * ($productData['price'] ?? 0);
            }
        }

        $leasecontract->products()->sync($syncData);
        $leasecontract->update(['total_price' => $totalPrice]);

        return redirect()->route('leasecontracts.index')->with('success', 'Leasecontract bijgewerkt.');
    }


    public function destroy(Leasecontract $leasecontract)
    {
        $leasecontract->delete();

        return redirect()->route('leasecontracts.index')->with('success', 'Leasecontract succesvol verwijderd.');
    }

    public function exportPdf(Leasecontract $leasecontract)
    {
        // Haal het leasecontract op met gerelateerde gegevens
        $leasecontract = Leasecontract::with(['customers', 'users', 'products'])->findOrFail($leasecontract->id);

        // Maak een PDF-weergave met de gegevens
        $pdf = \PDF::loadView('contracts.pdf', compact('leasecontract'));

        // Geef het PDF-bestand terug als download
        return $pdf->download('leasecontract-' . $leasecontract->id . '.pdf');
    }

    public function pendingContracts()
    {
        // Haal de laatste 5 goedgekeurde of afgekeurde contracten op
        $recentContracts = Leasecontract::whereIn('status', ['completed', 'rejected'])
            ->latest()  // Zorg ervoor dat je de meest recente contracten haalt
            ->take(5)   // Beperk het aantal contracten tot 5
            ->get();

        $leasecontracts = Leasecontract::with('products')->where('status', 'pending')->get();

        return view('contracts.approval', compact('leasecontracts', 'recentContracts'));
    }

    public function approve(Request $request, Leasecontract $leasecontract)
    {
        $leasecontract->update([
            'status' => 'completed',
        ]);

        return redirect()->route('contracts.approval')->with('success', 'Contract goedgekeurd.');
    }

    public function reject(Request $request, Leasecontract $leasecontract)
    {
        $leasecontract->update([
            'status' => 'rejected',
        ]);

        return redirect()->route('contracts.approval')->with('error', 'Contract afgekeurd.');
    }
}
