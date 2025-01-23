<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HeadMarketing\ProductController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MarketingController;
use App\Models\Customer;
use App\Models\Event;

Route::get('/', function () {
    return view('auth.login');
});

// Logout route
Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::middleware(['auth'])->get('/dashboard', function () {
    return view('dashboard');
});

// Group routes for authenticated users
Route::middleware(['auth'])->group(function () {

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

    Route::resource('customers', CustomerController::class);

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

    // Product resource routes
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    Route::resource('parts', MarketingController::class);
    Route::get('parts/create', [MarketingController::class, 'create'])->name('parts.create');
    Route::post('parts', [MarketingController::class, 'store'])->name('parts.store');
    Route::post('parts/order', [MarketingController::class, 'order'])->name('parts.order');
    Route::post('/order/signature', [MarketingController::class, 'storeSignature'])->name('storeSignature');


    // Quotes resource routes restricted to Sales, Head Sales, and CEO
    Route::middleware('role:3,7,10')->group(function () {
        Route::resource('quotes', QuoteController::class);
        Route::get('/quotes/{quote}/download', [QuoteController::class, 'downloadPdf'])->name('quotes.download');
    });
});

Route::get('/agenda', [VisitController::class, 'calendar'])->middleware('auth')->name('agenda');
Route::get('/events', [EventController::class, 'index'])->middleware('auth');
Route::post('/events', [EventController::class, 'store'])->middleware('auth');
Route::put('/events/{id}', [EventController::class, 'update'])->middleware('auth');
Route::delete('/events/{id}', [EventController::class, 'destroy'])->middleware('auth');

Route::get('/api/events', function(){
    return Event::all();
});

Route::get('/api/customers', function(){
    return Customer::all();
});

Route::get('/forbidden', function () {
    return view('errors.forbidden');
})->name('forbidden');

// User Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Include authentication routes
require __DIR__ . '/auth.php';
