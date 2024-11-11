<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Automatisch inloggen
Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware(['auth', 'role:2'])->group(function () {
    Route::get('/dashboard/finance', [DashboardController::class, 'finance'])->name('dashboard.finance');
});

Route::middleware(['auth', 'role:3'])->group(function () {
    Route::get('/dashboard/sales', [DashboardController::class, 'sales'])->name('dashboard.sales');
});

Route::middleware(['auth', 'role:4'])->group(function () {
    Route::get('/dashboard/marketing', [DashboardController::class, 'marketing'])->name('dashboard.marketing');
});

Route::middleware(['auth', 'role:5'])->group(function () {
    Route::get('/dashboard/maintenance', [DashboardController::class, 'maintenance'])->name('dashboard.maintenance');
});

Route::middleware(['auth', 'role:6'])->group(function () {
    Route::get('/dashboard/head-finance', [DashboardController::class, 'headFinance'])->name('dashboard.head-finance');
});

Route::middleware(['auth', 'role:7'])->group(function () {
    Route::get('/dashboard/head-sales', [DashboardController::class, 'headSales'])->name('dashboard.head-sales');
});

Route::middleware(['auth', 'role:8'])->group(function () {
    Route::get('/dashboard/head-marketing', [DashboardController::class, 'headMarketing'])->name('dashboard.head-marketing');
});

Route::middleware(['auth', 'role:9'])->group(function () {
    Route::get('/dashboard/head-maintenance', [DashboardController::class, 'headMaintenance'])->name('dashboard.head-maintenance');
});

Route::middleware(['auth', 'role:10'])->group(function () {
    Route::get('/dashboard/ceo', [DashboardController::class, 'ceo'])->name('dashboard.ceo');
});

Route::get('/forbidden', function () {
    return view('errors.forbidden');
})->name('forbidden');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth routes
require __DIR__.'/auth.php';