<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HeadMarketing\ProductController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProfitDistributionController;
use App\Http\Controllers\LeasecontractController;
use App\Http\Controllers\MarketingController;
use App\Models\Customer;
use App\Models\Event;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MaintenanceReportController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::middleware(['auth'])->get('/dashboard', function () {
    return view('dashboard');
});

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

    Route::resource('employees', EmployeeController::class);

    Route::middleware('role:3,7,10')->group(function () {
        Route::resource('visits', VisitController::class);
    });

    Route::middleware('role:3,7,9')->group(function () {
        Route::get('visits', [VisitController::class, 'index'])->name('visits.index');
        Route::get('visits/{visit}', [VisitController::class, 'show'])->name('visits.show');
    });

    Route::middleware('role:5,9,10')->group(function () {
        Route::get('/maintenace-tickets', [VisitController::class, 'myTickets'])->name('visits.my_tickets');
    });

    Route::post('/visits/{id}/sign', [VisitController::class, 'sign'])->name('visits.sign');

    Route::middleware('role:3,9,10')->group(function () {
        Route::get('visits/{id}/assign', [VisitController::class, 'assignToMaintenance'])->name('visits.assign');
        Route::post('visits/{id}/assign', [VisitController::class, 'storeAssignedToMaintenance'])->name('visits.store_assigned');
    });

    Route::resource('products', ProductController::class);

    Route::resource('parts', MarketingController::class);
    Route::get('parts/create', [MarketingController::class, 'create'])->name('parts.create');
    Route::post('parts', [MarketingController::class, 'store'])->name('parts.store');
    Route::post('parts/order', [MarketingController::class, 'order'])->name('parts.order');
    Route::post('/order/signature', [MarketingController::class, 'storeSignature'])->name('storeSignature');

    Route::middleware('role:2,6,3,7,10')->group(function () {
        Route::resource('quotes', QuoteController::class);
        Route::get('/quotes/{quote}/download', [QuoteController::class, 'downloadPdf'])->name('quotes.download');


        Route::post('/quotes/{quote}/invoice', [InvoiceController::class, 'createFromQuote'])->name('quotes.invoice');
    });

    Route::middleware('role:2,3,6,7,10')->group(function () {
        Route::resource('invoices', InvoiceController::class);
        Route::get('/invoices/{invoice}/download', [InvoiceController::class, 'download'])->name('invoices.download');
    });

    Route::middleware('role:2,6,10')->group(function () {
        Route::get('/profit-distribution', [ProfitDistributionController::class, 'index'])->name('profit_distribution.index');
        Route::get('/profit-distribution/export', [ProfitDistributionController::class, 'exportToExcel'])->name('profit_distribution.export');
        Route::get('/profit-distribution/pdf', [ProfitDistributionController::class, 'exportToPdf'])->name('profit_distribution.pdf');
    });


    Route::middleware(['role:2,6,10'])->group(function () {
        Route::get('/contracts', [LeasecontractController::class, 'index'])->name('leasecontracts.index');
        Route::get('/contracts/create', [LeasecontractController::class, 'create'])->name('leasecontracts.create');
        Route::get('leasecontracts/{leasecontract}', [LeasecontractController::class, 'show'])->name('leasecontracts.show');
        Route::post('/contracts', [LeasecontractController::class, 'store'])->name('leasecontracts.store');
        Route::get('/leasecontracts/{leasecontract}/edit', [LeasecontractController::class, 'edit'])->name('leasecontracts.edit');
        Route::put('/leasecontracts/{leasecontract}', [LeasecontractController::class, 'update'])->name('leasecontracts.update');
        Route::delete('/leasecontracts/{leasecontract}', [LeasecontractController::class, 'destroy'])->name('leasecontracts.destroy');
        Route::get('/leasecontracts/{leasecontract}/export-pdf', [LeasecontractController::class, 'exportPdf'])->name('leasecontracts.exportPdf');
    });

    Route::middleware(['role:2,10'])->group(function () {
        Route::get('/contracts/approval', [LeasecontractController::class, 'pendingContracts'])->name('contracts.approval');
        Route::post('/contracts/{id}/approve', [LeaseContractController::class, 'approve'])->name('contracts.approve')->middleware('auth');
        Route::post('/contracts/{id}/reject', [LeaseContractController::class, 'reject'])->name('contracts.reject')->middleware('auth');
    });
    Route::post('/maintenance-reports', [MaintenanceReportController::class, 'store'])->name('maintenance-reports.store');
    Route::get('/maintenance-reports/{id}', [MaintenanceReportController::class, 'show'])->name('maintenance-reports.show');
});

Route::get('/agenda', [VisitController::class, 'calendar'])->middleware('auth')->name('agenda');
Route::get('/events', [EventController::class, 'index'])->middleware('auth');
Route::post('/events', [EventController::class, 'store'])->middleware('auth');
Route::put('/events/{id}', [EventController::class, 'update'])->middleware('auth');
Route::delete('/events/{id}', [EventController::class, 'destroy'])->middleware('auth');

Route::get('/api/events', function () {
    return Event::all();
});

Route::get('/api/customers', function () {
    return Customer::all();
});

Route::get('/forbidden', function () {
    return view('errors.forbidden');
})->name('forbidden');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
