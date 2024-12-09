<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Authenticate the user
        $request->authenticate();

        // Regenerate the session to prevent session fixation attacks
        $request->session()->regenerate();

        $user = Auth::user();
        
        switch ($user->role->id) {
            case '2':
                return redirect()->route('dashboard.finance');
            case '3':
                return redirect()->route('dashboard.sales');
            case '4':
                return redirect()->route('dashboard.marketing');
            case '5':
                return redirect()->route('dashboard.maintenance');
            case '6':
                return redirect()->route('dashboard.head-finance');
            case '7':
                return redirect()->route('dashboard.head-sales');
            case '8':
                return redirect()->route('dashboard.head-marketing');
            case '9':
                return redirect()->route('dashboard.head-maintenance');
            case '10':
                return redirect()->route('dashboard.ceo');
            default:
                return redirect()->route('dashboard');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}