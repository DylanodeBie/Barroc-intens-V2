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

        $hour = now()->format('H');
        $greeting = '';

        if ($hour >= 6 && $hour < 12) {
            $greeting = "Goedemorgen, " . $user->name;
        } elseif ($hour >= 12 && $hour < 18) {
            $greeting = "Goedemiddag, " . $user->name;
        } else {
            $greeting = "Goedenacht, " . $user->name;
        }

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

        return view('dashboard', compact('greeting', 'user'));
    }

    public function finance() {
        $user = Auth::user();

        $hour = now()->format('H');
        $greeting = '';

        if ($hour >= 6 && $hour < 12) {
            $greeting = "Goedemorgen, " . $user->name;
        } elseif ($hour >= 12 && $hour < 18) {
            $greeting = "Goedemiddag, " . $user->name;
        } elseif ($hour >= 18 && $hour < 24) {
            $greeting = "Goedeavond, " . $user->name;
        } else {
            $greeting = "Goedenacht, " . $user->name;
        }
        return view('dashboard.finance.finance', compact('greeting', 'user'));
    }

    public function sales() {
        $user = Auth::user();

        $hour = now()->format('H');
        $greeting = '';

        if ($hour >= 6 && $hour < 12) {
            $greeting = "Goedemorgen, " . $user->name;
        } elseif ($hour >= 12 && $hour < 18) {
            $greeting = "Goedemiddag, " . $user->name;
        } elseif ($hour >= 18 && $hour < 24) {
            $greeting = "Goedeavond, " . $user->name;
        } else {
            $greeting = "Goedenacht, " . $user->name;
        }
        return view('dashboard.sales.sales', compact('greeting', 'user'));
    }

    public function marketing() {
        $user = Auth::user();

        $hour = now()->format('H');
        $greeting = '';

        if ($hour >= 6 && $hour < 12) {
            $greeting = "Goedemorgen, " . $user->name;
        } elseif ($hour >= 12 && $hour < 18) {
            $greeting = "Goedemiddag, " . $user->name;
        } elseif ($hour >= 18 && $hour < 24) {
            $greeting = "Goedeavond, " . $user->name;
        } else {
            $greeting = "Goedenacht, " . $user->name;
        }
        return view('dashboard.marketing.marketing', compact('greeting', 'user'));
    }

    public function maintenance() {
        $user = Auth::user();

        $hour = now()->format('H');
        $greeting = '';

        if ($hour >= 6 && $hour < 12) {
            $greeting = "Goedemorgen, " . $user->name;
        } elseif ($hour >= 12 && $hour < 18) {
            $greeting = "Goedemiddag, " . $user->name;
        } elseif ($hour >= 18 && $hour < 24) {
            $greeting = "Goedeavond, " . $user->name;
        } else {
            $greeting = "Goedenacht, " . $user->name;
        }
        return view('dashboard.maintenance.maintenance', compact('greeting', 'user'));
    }

    public function headFinance() {
        $user = Auth::user();

        $hour = now()->format('H');
        $greeting = '';

        if ($hour >= 6 && $hour < 12) {
            $greeting = "Goedemorgen, " . $user->name;
        } elseif ($hour >= 12 && $hour < 18) {
            $greeting = "Goedemiddag, " . $user->name;
        } elseif ($hour >= 18 && $hour < 24) {
            $greeting = "Goedeavond, " . $user->name;
        } else {
            $greeting = "Goedenacht, " . $user->name;
        }
        return view('dashboard.head-finance.head-finance', compact('greeting', 'user'));
    }

    public function headSales() {
        $user = Auth::user();

        $hour = now()->format('H');
        $greeting = '';

        if ($hour >= 6 && $hour < 12) {
            $greeting = "Goedemorgen, " . $user->name;
        } elseif ($hour >= 12 && $hour < 18) {
            $greeting = "Goedemiddag, " . $user->name;
        } elseif ($hour >= 18 && $hour < 24) {
            $greeting = "Goedeavond, " . $user->name;
        } else {
            $greeting = "Goedenacht, " . $user->name;
        }
        return view('dashboard.head-sales.head-sales', compact('greeting', 'user'));
    }

    public function headMarketing() {
        $user = Auth::user();

        $hour = now()->format('H');
        $greeting = '';

        if ($hour >= 6 && $hour < 12) {
            $greeting = "Goedemorgen, " . $user->name;
        } elseif ($hour >= 12 && $hour < 18) {
            $greeting = "Goedemiddag, " . $user->name;
        } elseif ($hour >= 18 && $hour < 24) {
            $greeting = "Goedeavond, " . $user->name;
        } else {
            $greeting = "Goedenacht, " . $user->name;
        }
        return view('dashboard.head-marketing.head-marketing', compact('greeting', 'user'));
    }

    public function headMaintenance() {
        $user = Auth::user();

        $hour = now()->format('H');
        $greeting = '';

        if ($hour >= 6 && $hour < 12) {
            $greeting = "Goedemorgen, " . $user->name;
        } elseif ($hour >= 12 && $hour < 18) {
            $greeting = "Goedemiddag, " . $user->name;
        } elseif ($hour >= 18 && $hour < 24) {
            $greeting = "Goedeavond, " . $user->name;
        } else {
            $greeting = "Goedenacht, " . $user->name;
        }
        return view('dashboard.head-maintenance.head-maintenance', compact('greeting', 'user'));
    }

    public function ceo() {
        $user = Auth::user();

        $hour = now()->format('H');
        $greeting = '';

        if ($hour >= 6 && $hour < 12) {
            $greeting = "Goedemorgen, " . $user->name;
        } elseif ($hour >= 12 && $hour < 18) {
            $greeting = "Goedemiddag, " . $user->name;
        } elseif ($hour >= 18 && $hour < 24) {
            $greeting = "Goedeavond, " . $user->name;
        } else {
            $greeting = "Goedenacht, " . $user->name;
        }
        return view('dashboard.ceo.ceo', compact('greeting', 'user'));
    }
}