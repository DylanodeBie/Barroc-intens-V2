<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Customer;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProfitDistributionController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->input('year', date('Y')); // Huidig jaar als standaard
        $customerId = $request->input('customer_id'); // Filter voor specifieke klant

        // Lijst met maandnamen
        $months = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

        // Maandelijkse inkomsten en uitgaven berekenen
        $monthlyData = [];
        foreach ($months as $index => $month) {
            $monthNumber = $index + 1;

            $income = Invoice::where('status', 'paid')
                ->whereYear('invoice_date', $year)
                ->whereMonth('invoice_date', $monthNumber)
                ->when($customerId, function ($query) use ($customerId) {
                    $query->where('customer_id', $customerId);
                })
                ->sum('total_amount') ?? 0;

            $expenses = 0; // Voeg hier je uitgavenlogica toe indien nodig

            $monthlyData[] = [
                'month' => $month,
                'income' => $income,
                'expenses' => $expenses,
            ];
        }

        // Totale inkomsten en uitgaven
        $totalIncome = array_sum(array_column($monthlyData, 'income'));
        $totalExpenses = array_sum(array_column($monthlyData, 'expenses'));

        // Alle klanten ophalen
        $customers = Customer::all();

        return view('profit_distribution.index', compact(
            'monthlyData',
            'totalIncome',
            'totalExpenses',
            'year',
            'customerId',
            'customers'
        ));
    }
}
