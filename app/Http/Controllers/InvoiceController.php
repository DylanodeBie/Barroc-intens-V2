<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
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

        // Fetch machines and coffee beans from the Product table
        $machines = Product::where('type', 'machine')->get();
        $beans = Product::where('type', 'coffee_bean')->get();

        return view('invoices.create', compact('customers', 'users', 'machines', 'beans'));
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
            'items.*.selected' => 'nullable|in:1',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        // Generate a unique invoice number
        $invoiceNumber = 'INV-' . now()->timestamp;

        // Create the invoice
        $invoice = Invoice::create([
            'customer_id' => $validated['customer_id'],
            'user_id' => auth()->id(),
            'invoice_number' => $invoiceNumber,
            'invoice_date' => $validated['invoice_date'],
            'notes' => $validated['notes'],
            'total_amount' => 0,
        ]);

        // Handle invoice items and calculate total amount
        $totalAmount = 0;

        foreach ($validated['items'] as $productId => $itemData) {
            if (isset($itemData['selected'])) {
                $product = Product::findOrFail($productId);
                $quantity = $itemData['quantity'];
                $subtotal = $product->price * $quantity;

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'description' => $product->name,
                    'quantity' => $quantity,
                    'unit_price' => $product->price,
                    'subtotal' => $subtotal,
                ]);

                $totalAmount += $subtotal;
            }
        }

        // Update the total amount for the invoice
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

        $pdf = PDF::loadView('invoices.pdf', compact('invoice'));

        return $pdf->download("invoice-{$invoice->invoice_number}.pdf");
    }

    /**
     * Show the form for editing the specified invoice.
     */
    public function edit(Invoice $invoice)
{
    $customers = Customer::all();
    $products = Product::all(); // Fetch all machines and beans
    $invoice->load('items'); // Load existing invoice items

    return view('invoices.edit', compact('invoice', 'customers', 'products'));
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
            'items' => 'required|array',
            'items.*.selected' => 'nullable|in:1',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        // Update the invoice details
        $invoice->update([
            'customer_id' => $validated['customer_id'],
            'invoice_date' => $validated['invoice_date'],
            'notes' => $validated['notes'],
        ]);

        // Recalculate invoice items
        $invoice->items()->delete();

        $totalAmount = 0;

        foreach ($validated['items'] as $productId => $itemData) {
            if (isset($itemData['selected'])) {
                $product = Product::findOrFail($productId);
                $quantity = $itemData['quantity'];
                $subtotal = $product->price * $quantity;

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'description' => $product->name,
                    'quantity' => $quantity,
                    'unit_price' => $product->price,
                    'subtotal' => $subtotal,
                ]);

                $totalAmount += $subtotal;
            }
        }

        // Update the total amount
        $invoice->update(['total_amount' => $totalAmount]);

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
