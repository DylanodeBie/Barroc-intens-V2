<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\VisitController;

// Default login route
Route::get('/', function () {
    return view('auth.login');
});

// Logout route
Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Dashboard route for authenticated users
Route::middleware(['auth'])->get('/dashboard', function () {
    return view('dashboard');
});

// Group routes that require authentication
Route::middleware(['auth'])->group(function () {

    // Dashboard routes for different departments
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/finance', [DashboardController::class, 'finance'])->name('dashboard.finance');
    Route::get('/dashboard/sales', [DashboardController::class, 'sales'])->name('dashboard.sales');
    Route::get('/dashboard/marketing', [DashboardController::class, 'marketing'])->name('dashboard.marketing');
    Route::get('/dashboard/maintenance', [DashboardController::class, 'maintenance'])->name('dashboard.maintenance');
    Route::get('/dashboard/head-finance', [DashboardController::class, 'headFinance'])->name('dashboard.head-finance');
    Route::get('/dashboard/head-sales', [DashboardController::class, 'headSales'])->name('dashboard.head-sales');
    Route::get('/dashboard/head-marketing', [DashboardController::class, 'headMarketing'])->name('dashboard.head-marketing');
    Route::get('/dashboard/head-maintenance', [DashboardController::class, 'headMaintenance'])->name('dashboard.head-maintenance');
    Route::get('/dashboard/ceo', [DashboardController::class, 'ceo'])->name('dashboard.ceo');

    // Customer resource routes
    Route::resource('customers', CustomerController::class);

    // Visit resource routes for scheduling and managing visits
    Route::middleware('role:3,7,10')->group(function () {
        // Allow Sales (role 3), Head Sales (role 7), and CEO (role 10) to create and manage visits
        Route::resource('visits', VisitController::class)->except(['destroy']);
    });

    // Visit assignment and maintenance tickets
    Route::middleware('role:9,10')->group(function () {
        // Allow Head Maintenance (role 9) and CEO (role 10) to assign visits and manage tickets
        Route::get('visits/{id}/assign', [VisitController::class, 'assignToMaintenance'])->name('visits.assign');
        Route::post('visits/{id}/assign', [VisitController::class, 'storeAssignedToMaintenance'])->name('visits.store_assigned');
        Route::get('visits/maintenance-tickets', [VisitController::class, 'maintenanceTickets'])->name('visits.maintenance_tickets');
    });
});

// Profile management routes, requiring authentication
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Include authentication routes
require __DIR__ . '/auth.php';
