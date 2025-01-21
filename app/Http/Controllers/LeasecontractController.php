<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Leasecontract;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class LeasecontractController extends Controller
{
    public function index()
    {
        $leasecontracts = Leasecontract::with('customers')->get();
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
        ], [
            'end_date.after_or_equal' => 'De einddatum mag niet eerder zijn dan de startdatum!',
        ]);

        $validated['status'] = 'pending';

        $leasecontract = Leasecontract::create($validated);

        if ($request->has('products')) {
            foreach ($request->products as $product) {
                $leasecontract->products()->attach($product['product_id'], [
                    'amount' => $product['amount'],
                    'price' => $product['price'],
                ]);
            }
        }

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
            'notice_period'
        ]));

        // Synchroniseer producten met hun pivot-data
        $products = $request->input('products', []);
        $syncData = [];

        foreach ($products as $productId => $productData) {
            if ($productData['product_id'] != '0') {
                $syncData[$productId] = [
                    'amount' => $productData['amount'] ?? 0,
                    'price' => $productData['price'] ?? 0,
                ];
            }
        }

        $leasecontract->products()->sync($syncData);

        return redirect()->route('leasecontracts.index')->with('success', 'Leasecontract bijgewerkt.');
    }


    public function destroy(Leasecontract $leasecontract)
    {
        $leasecontract->delete();

        return redirect()->route('leasecontracts.index')->with('success', 'Leasecontract succesvol verwijderd.');
    }
}
