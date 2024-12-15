<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Quote;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Display a list of all invoices
    public function index()
    {
        $invoices = Invoice::with(['customer', 'user'])->orderBy('invoice_date', 'desc')->paginate(10);
        return view('invoices.index', compact('invoices'));
    }

    // Show the form for creating a new invoice
    public function create()
    {
        $customers = Customer::all();
        $quotes = Quote::whereDoesntHave('invoice')->get(); // Offertes zonder gekoppelde factuur
        $products = Product::all(); // Alle beschikbare producten
        return view('invoices.create', compact('customers', 'quotes', 'products'));
    }

    // Store a newly created invoice in the database
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_date' => 'required|date',
            'price' => 'required|numeric|min:0',
            'quote_id' => 'nullable|exists:quotes,id',
            'products' => 'required|array', // Array van producten
            'products.*.id' => 'exists:products,id', // Elk product moet bestaan
            'products.*.amount' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ]);

        $invoiceData = [
            'customer_id' => $request->customer_id,
            'user_id' => auth()->id(),
            'quote_id' => $request->quote_id,
            'invoice_date' => $request->invoice_date,
            'price' => $request->price,
            'is_paid' => $request->has('is_paid'),
        ];

        $invoice = Invoice::create($invoiceData);

        // Koppel producten aan de factuur
        foreach ($request->products as $product) {
            $invoice->products()->attach($product['id'], [
                'amount' => $product['amount'],
                'price' => $product['price'],
            ]);
        }

        return redirect()->route('invoices.show', $invoice->id)
            ->with('success', 'Factuur succesvol aangemaakt.');
    }

    // Display a specific invoice
    public function show($id)
    {
        $invoice = Invoice::with(['customer', 'user', 'products'])->findOrFail($id);
        return view('invoices.show', compact('invoice'));
    }

    // Show the form for editing an existing invoice
    public function edit($id)
    {
        $invoice = Invoice::with('products')->findOrFail($id);
        $customers = Customer::all();
        $products = Product::all();
        return view('invoices.edit', compact('invoice', 'customers', 'products'));
    }

    // Update the specified invoice in the database
    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_date' => 'required|date',
            'price' => 'required|numeric|min:0',
            'products' => 'required|array',
            'products.*.id' => 'exists:products,id',
            'products.*.amount' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ]);

        $invoice = Invoice::findOrFail($id);

        $invoice->update([
            'customer_id' => $request->customer_id,
            'invoice_date' => $request->invoice_date,
            'price' => $request->price,
            'is_paid' => $request->has('is_paid'),
        ]);

        // Werk producten bij
        $invoice->products()->detach();
        foreach ($request->products as $product) {
            $invoice->products()->attach($product['id'], [
                'amount' => $product['amount'],
                'price' => $product['price'],
            ]);
        }

        return redirect()->route('invoices.show', $invoice->id)
            ->with('success', 'Factuur succesvol bijgewerkt.');
    }

    // Delete the specified invoice from the database
    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();

        return redirect()->route('invoices.index')
            ->with('success', 'Factuur succesvol verwijderd.');
    }
}


