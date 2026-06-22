<?php

use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\InvoiceController as AdminInvoiceController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\OrderController as UserOrderController;
use Illuminate\Support\Facades\Route;

// ─── Halaman utama ────────────────────────────────────────────────────────────

Route::get('/', fn () => view('welcome'));

// ─── Redirect setelah login (berdasarkan role) ────────────────────────────────

Route::get('/dashboard', function () {
    return auth()->user()->isAdmin()
        ? redirect()->route('admin.dashboard')
        : redirect()->route('user.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ─── Profile ──────────────────────────────────────────────────────────────────

Route::middleware('auth')->group(function () {
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ─── Admin ────────────────────────────────────────────────────────────────────

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Orders
    Route::resource('orders', AdminOrderController::class)->except(['show']);
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::get('/orders/{order}/print',    [AdminOrderController::class, 'print'])->name('orders.print');

    // Customers
    Route::resource('customers', AdminCustomerController::class)->except(['edit', 'update']);

    // Invoices
    Route::get('/invoices',              [AdminInvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/{invoice}',    [AdminInvoiceController::class, 'show'])->name('invoices.show');
    Route::get('/invoices/{invoice}/print', [AdminInvoiceController::class, 'print'])->name('invoices.print');

    // Services (BARU)
    Route::resource('services', AdminServiceController::class)->except(['show']);

    // Reports + export PDF (BARU)
    Route::get('/reports',         [AdminReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export',  [AdminReportController::class, 'exportPdf'])->name('reports.export');

    Route::get('/orders/{order}/edit-estimated',    [AdminOrderController::class, 'editEstimated'])->name('orders.edit-estimated');
    Route::patch('/orders/{order}/update-estimated', [AdminOrderController::class, 'updateEstimated'])->name('orders.update-estimated');
});

// ─── User ─────────────────────────────────────────────────────────────────────

Route::middleware(['auth', 'user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::resource('orders', UserOrderController::class)->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);
});

require __DIR__ . '/auth.php';
