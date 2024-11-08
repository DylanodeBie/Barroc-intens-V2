<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Check of de gebruiker een rol heeft
        if (!$user || !$user->role) {
            logger('User has no role assigned.');
            return view('dashboard'); // Laadt het standaard dashboard
        }

        logger('User Role: ' . $user->role->name); // Controleer de output in Laravel's log file

        // Definieer rol-to-route mappings
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

        // Bepaal de rol van de gebruiker
        $userRole = $user->role->name;

        // Controleer of de rol een route heeft en redirect naar de juiste route
        if (array_key_exists($userRole, $roleRoutes)) {
            return redirect()->route($roleRoutes[$userRole]);
        }

        // Als er geen specifieke route is voor de rol, toon het algemene dashboard
        return view('dashboard');
    }

    public function finance() {
        return view('dashboard.finance');
    }

    public function sales() {
        return view('dashboard.sales');
    }

    public function marketing() {
        return view('dashboard.marketing');
    }

    public function maintenance() {
        return view('dashboard.maintenance');
    }

    public function headFinance() {
        return view('dashboard.head-finance');
    }

    public function headSales() {
        return view('dashboard.head-sales');
    }

    public function headMarketing() {
        return view('dashboard.head-marketing');
    }

    public function headMaintenance() {
        return view('dashboard.head-maintenance');
    }

    public function ceo() {
        return view('dashboard.ceo');
    }
}