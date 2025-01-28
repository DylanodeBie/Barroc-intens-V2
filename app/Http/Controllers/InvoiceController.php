<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use App\Models\Customer;
use App\Models\User;
use App\Models\Quote;
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
        $machines = Product::where('type', 'machine')->get();
        $beans = Product::where('type', 'coffee_bean')->get();

        return view('invoices.create', compact('customers', 'users', 'machines', 'beans'));
    }

    /**
     * Create an invoice from a quote.
     */
    public function createFromQuote(Quote $quote)
    {
        $invoiceData = [
            'customer_id' => $quote->customer_id,
            'user_id' => $quote->user_id,
            'invoice_date' => now()->toDateString(),
            'notes' => 'Factuur aangemaakt op basis van offerte #' . $quote->id,
            'agreement_length' => $quote->agreement_length,
            'maintenance_agreement' => $quote->maintenance_agreement,
        ];

        // Haal de machines en bonen van de offerte op
        $machines = $quote->machines->map(function ($machine) {
            return [
                'id' => $machine->id,
                'name' => $machine->name,
                'lease_price' => $machine->pivot->lease_price,
                'installation_cost' => $machine->pivot->installation_cost,
                'quantity' => $machine->pivot->quantity,
            ];
        });

        $beans = $quote->beans->map(function ($bean) {
            return [
                'id' => $bean->id,
                'name' => $bean->name,
                'price' => $bean->pivot->price,
                'quantity' => $bean->pivot->quantity,
            ];
        });

        return redirect()->route('invoices.create')
            ->withInput($invoiceData)
            ->with(['machines' => $machines, 'beans' => $beans]);
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

        $invoiceNumber = 'INV-' . now()->timestamp;

        $invoice = Invoice::create([
            'customer_id' => $validated['customer_id'],
            'user_id' => auth()->id(),
            'invoice_number' => $invoiceNumber,
            'invoice_date' => $validated['invoice_date'],
            'notes' => $validated['notes'],
            'total_amount' => 0,
        ]);

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
        $products = Product::all();
        $invoice->load('items');

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

        $invoice->update([
            'customer_id' => $validated['customer_id'],
            'invoice_date' => $validated['invoice_date'],
            'notes' => $validated['notes'],
        ]);

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
