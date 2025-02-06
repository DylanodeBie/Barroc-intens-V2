<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ProfitDistributionController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $customerId = $request->input('customer_id');

        $months = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

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

            $expenses = Order::whereYear('created_at', $year)
                ->whereMonth('created_at', $monthNumber)
                ->sum('quantity') ?? 0;

            $monthlyData[] = [
                'month' => $month,
                'income' => $income,
                'expenses' => $expenses,
            ];
        }

        $totalIncome = array_sum(array_column($monthlyData, 'income'));
        $totalExpenses = array_sum(array_column($monthlyData, 'expenses'));

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

    public function exportToPdf(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $customerId = $request->input('customer_id');

        $months = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

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

            $expenses = Order::whereYear('created_at', $year)
                ->whereMonth('created_at', $monthNumber)
                ->sum('quantity') ?? 0;

            $monthlyData[] = [
                'month' => $month,
                'income' => $income,
                'expenses' => $expenses,
            ];
        }

        $totalIncome = array_sum(array_column($monthlyData, 'income'));
        $totalExpenses = array_sum(array_column($monthlyData, 'expenses'));

        $companyName = $customerId
            ? Customer::find($customerId)?->company_name ?? 'Onbekend Bedrijf'
            : 'Alle Klanten';

        $pdf = Pdf::loadView('profit_distribution.pdf', compact('monthlyData', 'totalIncome', 'totalExpenses', 'year', 'companyName'));

        return $pdf->download('winstverdeling.pdf');
    }
}
