<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Quote;
use App\Models\Customer;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    // Ensure user authentication
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
        return view('invoices.create', compact('customers'));
    }

    // Store a newly created invoice in the database
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_date' => 'required|date',
            'price' => 'required|numeric|min:0',
        ]);

        $invoice = Invoice::create([
            'customer_id' => $request->customer_id,
            'user_id' => auth()->id(),
            'invoice_date' => $request->invoice_date,
            'price' => $request->price,
            'is_paid' => $request->has('is_paid'),
        ]);

        return redirect()->route('invoices.show', $invoice->id)
            ->with('success', 'Factuur succesvol aangemaakt.');
    }

    // Display a specific invoice
    public function show($id)
    {
        $invoice = Invoice::with(['customer', 'user', 'quote'])->findOrFail($id);
        return view('invoices.show', compact('invoice'));
    }

    // Show the form for editing an existing invoice
    public function edit($id)
    {
        $invoice = Invoice::findOrFail($id);
        $customers = Customer::all();
        return view('invoices.edit', compact('invoice', 'customers'));
    }

    // Update the specified invoice in the database
    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_date' => 'required|date',
            'price' => 'required|numeric|min:0',
        ]);

        $invoice = Invoice::findOrFail($id);
        $invoice->update([
            'customer_id' => $request->customer_id,
            'invoice_date' => $request->invoice_date,
            'price' => $request->price,
            'is_paid' => $request->has('is_paid'),
        ]);

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

    // Create an invoice based on a quote
    public function createFromQuote($quoteId)
    {
        $quote = Quote::findOrFail($quoteId);

        $invoice = Invoice::create([
            'customer_id' => $quote->customer_id,
            'user_id' => auth()->id(),
            'quote_id' => $quote->id,
            'invoice_date' => now()->toDateString(),
            'price' => $quote->price,
            'is_paid' => false,
        ]);

        return redirect()->route('invoices.show', $invoice->id)
            ->with('success', 'Factuur succesvol aangemaakt op basis van offerte.');
    }
}
