<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Customer;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProfitDistributionExport;

class ProfitDistributionController extends Controller
{
    /**
     * Display the profit distribution overview.
     */
    public function index(Request $request)
    {
        $year = $request->input('year', date('Y')); // Huidig jaar als standaard
        $customerId = $request->input('customer_id'); // Filter voor specifieke klant

        // Query voor betaalde facturen
        $query = Invoice::where('status', 'paid')->whereYear('invoice_date', $year);

        if ($customerId) {
            $query->where('customer_id', $customerId);
        }

        $invoices = $query->get();

        // Bereken totale inkomsten voor het geselecteerde jaar
        $totalIncome = $query->sum('total_amount');

        // Bereken totale uitgaven (placeholder)
        $totalExpenses = 0; // Hier voeg je logica toe als je uitgaven hebt

        // Bereken inkomsten voor de huidige maand
        $currentMonthIncome = Invoice::where('status', 'paid')
            ->whereYear('invoice_date', Carbon::now()->year)
            ->whereMonth('invoice_date', Carbon::now()->month)
            ->sum('total_amount');

        // Placeholder voor maandelijkse uitgaven
        $currentMonthExpenses = 0;

        // Bereken inkomsten per maand
        $monthlyIncome = $invoices->groupBy(function ($invoice) {
            return Carbon::parse($invoice->invoice_date)->format('F'); // Maandnaam
        })->map->sum('total_amount');

        // Placeholder voor maandelijkse uitgaven
        $monthlyExpenses = [];

        // Lijst met maandnamen
        $months = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

        // Haal alle klanten op
        $customers = Customer::all();

        return view('profit_distribution.index', compact(
            'invoices',
            'totalIncome',
            'totalExpenses',
            'currentMonthIncome',
            'currentMonthExpenses',
            'monthlyIncome',
            'monthlyExpenses',
            'months',
            'year',
            'customerId',
            'customers'
        ));
    }

    /**
     * Export profit distribution data to Excel.
     */
    public function exportToExcel(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $customerId = $request->input('customer_id');

        return Excel::download(new ProfitDistributionExport($year, $customerId), 'profit_distribution.xlsx');
    }
}
