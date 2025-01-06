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

    public function destroy(Leasecontract $leasecontract)
    {
        $leasecontract->delete();

        return redirect()->route('leasecontracts.index')->with('success', 'Leasecontract succesvol verwijderd.');
    }
}
