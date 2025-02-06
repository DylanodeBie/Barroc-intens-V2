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
        if ($request->user()->role_id == 10) {
            $leasecontracts = Leasecontract::with(['customers', 'products'])->get();
        } elseif (in_array($request->user()->role_id, [2,6])) {
            $leasecontracts = Leasecontract::where('status', 'pending')
                ->with(['customers', 'products'])
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
        ], [
            'end_date.after_or_equal' => 'De einddatum mag niet eerder zijn dan de startdatum!',
        ]);

        $validated['status'] = 'pending';

        $totalPrice = 0;
        $products = collect($request->input('products', []));

        foreach ($products as $product) {
            if (!empty($product['amount']) && !empty($product['price'])) {
                $totalPrice += $product['amount'] * $product['price'];
            }
        }

        $validated['total_price'] = $totalPrice;

        $leasecontract = Leasecontract::create($validated);

        if ($products->isNotEmpty()) {
            foreach ($products as $product) {
                if (!empty($product['product_id'])) {
                    $leasecontract->products()->attach($product['product_id'], [
                        'amount' => $product['amount'],
                        'price' => $product['price'],
                    ]);
                }
            }
        }

        return redirect()->route('leasecontracts.index')->with('success', 'Leasecontract succesvol aangemaakt.');
    }

    public function edit($id)
    {
        $leasecontract = LeaseContract::with('products')->findOrFail($id);
        $customers = Customer::all();
        $users = User::all();

        $linkedProducts = $leasecontract->products;
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

        $leasecontract->update($validated);

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
        $leasecontract = Leasecontract::with(['customers', 'users', 'products'])->findOrFail($leasecontract->id);

        $pdf = \PDF::loadView('contracts.pdf', compact('leasecontract'));

        return $pdf->download('leasecontract-' . $leasecontract->id . '.pdf');
    }

    public function pendingContracts()
    {
        $recentContracts = Leasecontract::whereIn('status', ['completed', 'rejected'])
            ->latest()
            ->take(5)
            ->get();

        $leasecontracts = Leasecontract::with('products')->where('status', 'pending')->get();

        return view('contracts.approval', compact('leasecontracts', 'recentContracts'));
    }

    public function approve(Request $request, $id)
    {
        $request->validate([
            'approval_reason' => 'required|string|min:3',
        ], [
            'approval_reason.required' => 'Een reden voor goedkeuring is verplicht!',
            'approval_reason.min' => 'De reden moet minimaal 3 tekens bevatten.',
        ]);

        $leasecontract = LeaseContract::findOrFail($id);

        $leasecontract->status = 'approved';
        $leasecontract->approval_reason = $request->input('approval_reason');
        $leasecontract->approved_by = auth()->id();
        $leasecontract->save();

        return redirect()->back()->with('success', 'Contract succesvol goedgekeurd met reden: ' . $request->input('approval_reason'));
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|min:3',
        ], [
            'rejection_reason.required' => 'Een reden voor afkeuring is verplicht!',
            'rejection_reason.min' => 'De reden moet minimaal 3 tekens bevatten.',
        ]);

        $leasecontract = LeaseContract::findOrFail($id);

        $leasecontract->status = 'rejected';
        $leasecontract->rejection_reason = $request->input('rejection_reason');
        $leasecontract->rejected_by = auth()->id();
        $leasecontract->save();

        return redirect()->back()->with('success', 'Contract succesvol afgekeurd met reden: ' . $request->input('rejection_reason'));
    }
}
