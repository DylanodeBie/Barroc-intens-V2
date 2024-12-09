<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user || !$user->role) {
            logger('User has no role assigned.');
            return view('dashboard');
        }

        logger('User Role: ' . $user->role->name);

        $roleRoutes = [
            'Finance' => 'dashboard.finance',
            'Sales' => 'dashboard.sales',
            'Maintenance' => 'dashboard.maintenance',
            'Marketing' => 'dashboard.marketing',
            'Head Finance' => 'dashboard.head-finance',
            'Head Sales' => 'dashboard.head-sales',
            'Head Marketing' => 'dashboard.head-marketing',
            'Head Maintenance' => 'dashboard.head-maintenance',
            'CEO' => 'dashboard.ceo',
        ];

        $userRole = $user->role->name;

        if (array_key_exists($userRole, $roleRoutes)) {
            return redirect()->route($roleRoutes[$userRole]);
        }

        return view('dashboard');
    }

    public function finance() {
        return view('dashboard.finance.finance');
    }

    public function sales() {
        return view('dashboard.sales.sales');
    }

    public function marketing() {
        return view('dashboard.marketing.marketing');
    }

    public function maintenance() {
        return view('dashboard.maintenance.maintenance');
    }

    public function headFinance() {
        return view('dashboard.head-finance.head-finance');
    }

    public function headSales() {
        return view('dashboard.head-sales.head-sales');
    }

    public function headMarketing() {
        return view('dashboard.head-marketing.head-marketing');
    }

    public function headMaintenance() {
        return view('dashboard.head-maintenance.head-maintenance');
    }

    public function ceo() {
        return view('dashboard.ceo.ceo');
    }
}