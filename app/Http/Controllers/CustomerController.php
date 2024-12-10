<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();  // Haal customers op
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'phonenumber' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'bkr_check' => 'required|boolean',
        ]);

        Customer::create($request->all());
        return redirect()->route('customers.index')->with('success', 'Customer registered successfully.');
    }

    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        return view('customers.show', compact('customer'));
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);

        if (!in_array(auth()->user()->role->name, ['Sales', 'Head Sales', 'CEO'])) {
            abort(403, 'Unauthorized action.');
        }

        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        if (!in_array(auth()->user()->role->name, ['Sales', 'Head Sales', 'CEO'])) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'company_name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'phonenumber' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'bkr_check' => 'required|boolean',
        ]);

        $customer->update($request->all());

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);

        if (!in_array(auth()->user()->role->name, ['Sales', 'Head Sales', 'CEO'])) {
            abort(403, 'Unauthorized action.');
        }

        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}
