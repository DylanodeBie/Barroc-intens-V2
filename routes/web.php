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
use App\Http\Controllers\ProfitDistributionController;
use App\Http\Controllers\MarketingController;
use App\Models\Customer;
use App\Models\Event;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

// Logout route
Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Dashboard routes
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

    Route::middleware('role:5,9,10')->group(function () {
        Route::get('/maintenace-tickets', [VisitController::class, 'myTickets'])->name('visits.my_tickets');
    });

    Route::post('/visits/{id}/sign', [VisitController::class, 'sign'])->name('visits.sign');

    // Visit assignment and maintenance tickets
    Route::middleware('role:3,9,10')->group(function () {
        // Allow Head Maintenance (role 9) and CEO (role 10) to assign visits and manage tickets
        Route::get('visits/{id}/assign', [VisitController::class, 'assignToMaintenance'])->name('visits.assign');
        Route::post('visits/{id}/assign', [VisitController::class, 'storeAssignedToMaintenance'])->name('visits.store_assigned');
        Route::get('visits/maintenance-tickets', [VisitController::class, 'maintenanceTickets'])->name('visits.maintenance_tickets');
    });

    // Product routes
    Route::resource('products', ProductController::class);

    Route::resource('parts', MarketingController::class);
    Route::get('parts/create', [MarketingController::class, 'create'])->name('parts.create');
    Route::post('parts', [MarketingController::class, 'store'])->name('parts.store');
    Route::post('parts/order', [MarketingController::class, 'order'])->name('parts.order');
    Route::post('/order/signature', [MarketingController::class, 'storeSignature'])->name('storeSignature');


    // Quotes resource routes restricted to Sales, Head Sales, and CEO
    Route::middleware('role:3,7,10')->group(function () {
        Route::resource('quotes', QuoteController::class);
        Route::get('/quotes/{quote}/download', [QuoteController::class, 'downloadPdf'])->name('quotes.download');

        // New route to create invoice from quote
        Route::post('/quotes/{quote}/invoice', [InvoiceController::class, 'createFromQuote'])->name('quotes.invoice');
    });

    // Invoice routes restricted to Sales, Head Sales, and CEO roles
    Route::middleware('role:3,7,10')->group(function () {
        Route::resource('invoices', InvoiceController::class);
        Route::get('/invoices/{invoice}/download', [InvoiceController::class, 'download'])->name('invoices.download');
    });

    // Winstverdeling routes (alleen Head Finance, Finance en CEO)
    Route::middleware('role:2,6,10')->group(function () {
        Route::get('/profit-distribution', [ProfitDistributionController::class, 'index'])->name('profit_distribution.index');
        Route::get('/profit-distribution/export', [ProfitDistributionController::class, 'exportToExcel'])->name('profit_distribution.export');
        Route::get('/profit-distribution/pdf', [ProfitDistributionController::class, 'exportToPdf'])->name('profit_distribution.pdf');
    });
});

// Agenda and event routes
Route::get('/agenda', [VisitController::class, 'calendar'])->middleware('auth')->name('agenda');
Route::get('/events', [EventController::class, 'index'])->middleware('auth');
Route::post('/events', [EventController::class, 'store'])->middleware('auth');
Route::put('/events/{id}', [EventController::class, 'update'])->middleware('auth');
Route::delete('/events/{id}', [EventController::class, 'destroy'])->middleware('auth');

// API routes
Route::get('/api/events', function () {
    return Event::all();
});

Route::get('/api/customers', function () {
    return Customer::all();
});

// Forbidden error page
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
