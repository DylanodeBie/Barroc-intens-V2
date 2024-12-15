<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use PDF;

class InvoiceController extends Controller
{
    /**
     * Display a listing of invoices.
     */
    public function index()
    {
        $invoices = Invoice::with('customer', 'user')->latest()->get();
        return view('invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new invoice.
     */
    public function create()
    {
        $customers = Customer::all();
        $users = User::all();
        $items = [
            ['id' => 1, 'name' => 'Koffiemachine 1', 'price' => 2600.75],
            ['id' => 2, 'name' => 'Koffieboon type 1', 'price' => 43.55],
        ];

        return view('invoices.create', compact('customers', 'users', 'items'));
    }

    /**
     * Store a newly created invoice in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_date' => 'required|date',
            'notes' => 'nullable|string',
            'items' => 'required|array',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        // Generate unique invoice number
        $invoiceNumber = 'INV-' . time();

        // Create the invoice
        $invoice = Invoice::create([
            'customer_id' => $validated['customer_id'],
            'user_id' => auth()->id(),
            'invoice_number' => $invoiceNumber,
            'invoice_date' => $validated['invoice_date'],
            'total_amount' => 0,
            'notes' => $validated['notes'],
        ]);

        // Add items to invoice
        $totalAmount = 0;
        foreach ($validated['items'] as $itemData) {
            $subtotal = $itemData['quantity'] * $itemData['price'];
            $totalAmount += $subtotal;

            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'description' => $itemData['description'] ?? 'Item',
                'quantity' => $itemData['quantity'],
                'unit_price' => $itemData['price'],
                'subtotal' => $subtotal,
            ]);
        }

        // Update total amount
        $invoice->update(['total_amount' => $totalAmount]);

        return redirect()->route('invoices.index')->with('success', 'Factuur succesvol aangemaakt!');
    }

    /**
     * Display the specified invoice.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load('customer', 'items', 'user');
        return view('invoices.show', compact('invoice'));
    }

    /**
     * Generate and download a PDF for the specified invoice.
     */
    public function download(Invoice $invoice)
    {
        $invoice->load('customer', 'items', 'user');

        // Load the PDF view
        $pdf = PDF::loadView('invoices.pdf', ['invoice' => $invoice]);

        // Return the PDF for download
        return $pdf->download("invoice-{$invoice->invoice_number}.pdf");
    }

    /**
     * Show the form for editing the specified invoice.
     */
    public function edit(Invoice $invoice)
    {
        $customers = Customer::all();
        $users = User::all();
        $invoice->load('items');
        return view('invoices.edit', compact('invoice', 'customers', 'users'));
    }

    /**
     * Update the specified invoice in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $invoice->update($validated);
        return redirect()->route('invoices.index')->with('success', 'Factuur succesvol bijgewerkt!');
    }

    /**
     * Remove the specified invoice from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Factuur succesvol verwijderd!');
    }
}
