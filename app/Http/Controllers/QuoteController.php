<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Machine;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class QuoteController extends Controller
{
    /**
     * Display a listing of the quotes.
     */
    public function index()
    {
        $quotes = Quote::with(['customer', 'user', 'machines', 'beans'])->get(); // Added 'beans'
        return view('quotes.index', compact('quotes'));
    }

    /**
     * Show the form for creating a new quote.
     */
    public function create()
    {
        $customers = Customer::all();
        $users = User::whereIn('role_id', [3, 7, 10])->get();
        $machines = Machine::all();
        $products = Product::where('type', 'coffee_bean')->get(); // Only coffee beans

        return view('quotes.create', compact('customers', 'users', 'machines', 'products'));
    }

    /**
     * Store a newly created quote in the database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'user_id' => [
                'required',
                'exists:users,id',
                function ($attribute, $value, $fail) {
                    $user = User::find($value);
                    if (!in_array($user->role_id, [3, 7, 10])) {
                        $fail('The selected user is not allowed for this action.');
                    }
                },
            ],
            'agreement_length' => 'nullable|integer|min:1',
            'maintenance_agreement' => 'nullable|string|in:basic,premium',
            'machines' => 'required|array',
            'machines.*.selected' => 'boolean',
            'machines.*.quantity' => 'required_with:machines.*.selected|integer|min:1',
            'beans.*.selected' => 'boolean',
            'beans.*.quantity' => 'required_with:beans.*.selected|integer|min:1',
        ]);

        $quote = Quote::create([
            'customer_id' => $validated['customer_id'],
            'user_id' => $validated['user_id'],
            'status' => 'pending',
            'quote_date' => now(),
            'agreement_length' => $validated['agreement_length'] ?? null,
            'maintenance_agreement' => $validated['maintenance_agreement'] ?? null,
        ]);

        // Attach machines to the quote
        foreach ($validated['machines'] as $machineId => $machineData) {
            if (!empty($machineData['selected'])) {
                $quote->machines()->attach($machineId, [
                    'quantity' => $machineData['quantity'] ?? 1,
                ]);
            }
        }

        // Attach beans to the quote
        if (!empty($validated['beans'])) {
            foreach ($validated['beans'] as $beanId => $beanData) {
                if (!empty($beanData['selected'])) {
                    $quote->beans()->attach($beanId, [
                        'quantity' => $beanData['quantity'] ?? 1,
                    ]);
                }
            }
        }

        return redirect()->route('quotes.index')->with('success', 'Quote created successfully!');
    }

    /**
     * Display the specified quote.
     */
    public function show(Quote $quote)
    {
        $quote->load(['customer', 'user', 'machines', 'beans']);
        return view('quotes.show', compact('quote'));
    }

    /**
     * Show the form for editing the specified quote.
     */
    public function edit(Quote $quote)
    {
        $customers = Customer::all();
        $users = User::whereIn('role_id', [3, 7, 10])->get();
        $machines = Machine::all();
        $products = Product::where('type', 'coffee_bean')->get();
        $quote->load(['machines', 'beans']);

        return view('quotes.edit', compact('quote', 'customers', 'users', 'machines', 'products'));
    }

    /**
     * Update the specified quote in the database.
     */
    public function update(Request $request, Quote $quote)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'user_id' => [
                'required',
                'exists:users,id',
                function ($attribute, $value, $fail) {
                    $user = User::find($value);
                    if (!in_array($user->role_id, [3, 7, 10])) {
                        $fail('The selected user is not allowed for this action.');
                    }
                },
            ],
            'agreement_length' => 'nullable|integer|min:1',
            'maintenance_agreement' => 'nullable|string|in:basic,premium',
            'machines' => 'required|array',
            'machines.*.selected' => 'boolean',
            'machines.*.quantity' => 'required_with:machines.*.selected|integer|min:1',
            'beans.*.selected' => 'boolean',
            'beans.*.quantity' => 'required_with:beans.*.selected|integer|min:1',
        ]);

        $quote->update([
            'customer_id' => $validated['customer_id'],
            'user_id' => $validated['user_id'],
            'agreement_length' => $validated['agreement_length'] ?? null,
            'maintenance_agreement' => $validated['maintenance_agreement'] ?? null,
        ]);

        // Sync machines
        $machines = [];
        foreach ($validated['machines'] as $machineId => $machineData) {
            if (!empty($machineData['selected'])) {
                $machines[$machineId] = ['quantity' => $machineData['quantity'] ?? 1];
            }
        }
        $quote->machines()->sync($machines);

        // Sync beans
        $beans = [];
        if (!empty($validated['beans'])) {
            foreach ($validated['beans'] as $beanId => $beanData) {
                if (!empty($beanData['selected'])) {
                    $beans[$beanId] = ['quantity' => $beanData['quantity'] ?? 1];
                }
            }
        }
        $quote->beans()->sync($beans);

        return redirect()->route('quotes.index')->with('success', 'Quote updated successfully!');
    }

    /**
     * Remove the specified quote from the database.
     */
    public function destroy(Quote $quote)
    {
        $quote->delete();
        return redirect()->route('quotes.index')->with('success', 'Quote deleted successfully!');
    }

    /**
     * Generate and download a PDF for the specified quote.
     */
    public function downloadPdf(Quote $quote)
    {
        $quote->load(['customer', 'user', 'machines', 'beans']);

        $pdf = Pdf::loadView('quotes.pdf', compact('quote'));
        return $pdf->download("quote-{$quote->id}.pdf");
    }
}
