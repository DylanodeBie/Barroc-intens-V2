<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HeadMarketing\ProductController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\InvoiceController;
use App\Models\Customer;
use App\Models\Event;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login')->name('login');
});

// Logout route
Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::middleware(['auth'])->get('/dashboard', function () {
    return view('dashboard');
});

// Group routes for authenticated users
Route::middleware(['auth'])->group(function () {
    // Dashboard routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/finance', [DashboardController::class, 'finance'])->name('dashboard.finance');
    Route::get('/dashboard/sales', [DashboardController::class, 'sales'])->name('dashboard.sales');
    Route::get('/dashboard/marketing', [DashboardController::class, 'marketing'])->name('dashboard.marketing');
    Route::get('/dashboard/maintenance', [DashboardController::class, 'maintenance'])->name('dashboard.maintenance');
    Route::get('/dashboard/marketing-head', [DashboardController::class, 'headMarketing'])->name('dashboard.head-marketing');
    Route::get('/dashboard/head-finance', [DashboardController::class, 'headFinance'])->name('dashboard.head-finance');
    Route::get('/dashboard/head-sales', [DashboardController::class, 'headSales'])->name('dashboard.head-sales');
    Route::get('/dashboard/head-maintenance', [DashboardController::class, 'headMaintenance'])->name('dashboard.head-maintenance');
    Route::get('/dashboard/ceo', [DashboardController::class, 'ceo'])->name('dashboard.ceo');

    // Customer routes
    Route::resource('customers', CustomerController::class);

    // Visit routes
    Route::middleware('role:3,7,10')->group(function () {
        Route::resource('visits', VisitController::class)->except(['destroy']);
    });

    Route::middleware('role:9')->group(function () {
        Route::get('visits', [VisitController::class, 'index'])->name('visits.index');
        Route::get('visits/{visit}', [VisitController::class, 'show'])->name('visits.show');
    });

    Route::middleware('role:9,10')->group(function () {
        Route::get('visits/{id}/assign', [VisitController::class, 'assignToMaintenance'])->name('visits.assign');
        Route::post('visits/{id}/assign', [VisitController::class, 'storeAssignedToMaintenance'])->name('visits.store_assigned');
        Route::get('visits/maintenance-tickets', [VisitController::class, 'maintenanceTickets'])->name('visits.maintenance_tickets');
    });

    // Product routes
    Route::resource('products', ProductController::class);

    // Quotes routes restricted to specific roles
    Route::middleware('role:3,7,10')->group(function () {
        Route::resource('quotes', QuoteController::class);
        Route::get('/quotes/{quote}/download', [QuoteController::class, 'downloadPdf'])->name('quotes.download');
    });

    // Invoice routes restricted to Sales, Head Sales, and CEO roles
    Route::middleware('role:3,7,10')->group(function () {
        Route::resource('invoices', InvoiceController::class);
        Route::get('/invoices/{invoice}/download', [InvoiceController::class, 'download'])->name('invoices.download');
    });
});

// Calendar and events routes
Route::get('/agenda', [VisitController::class, 'calendar'])->middleware('auth')->name('agenda');
Route::get('/events', [EventController::class, 'index'])->middleware('auth');
Route::post('/events', [EventController::class, 'store'])->middleware('auth');
Route::put('/events/{id}', [EventController::class, 'update'])->middleware('auth');
Route::delete('/events/{id}', [EventController::class, 'destroy'])->middleware('auth');

// API routes for customers and events
Route::get('/api/events', function () {
    return Event::all();
});

Route::get('/api/customers', function () {
    return Customer::all();
});

// Forbidden route
Route::get('/forbidden', function () {
    return view('errors.forbidden');
})->name('forbidden');

// User profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Include authentication routes
require __DIR__ . '/auth.php';
