<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\AdminActivityController;
use App\Http\Controllers\AdminManagementController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\ExpenseCategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| These routes are loaded by the RouteServiceProvider within a group
| which contains the "web" middleware group.
|--------------------------------------------------------------------------
*/

/*-----------------------------------------
| Public Routes (No Authentication Required)
------------------------------------------*/

// Redirect root URL to enquiry form
Route::get('/', function () {
    return redirect('/enquiry');
});

// Enquiry form
Route::get('/enquiry', [EnquiryController::class, 'create']);
Route::post('/enquiry', [EnquiryController::class, 'store'])->name('enquiry.store');

// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// Logout
Route::post('/logout', function () {
    \Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');


/*----------------------------
| Protected Routes (Requires Auth)
-----------------------------*/

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /*--------------------
    | Enquiry Management
    ---------------------*/
    Route::get('/dashboard/enquiries', [EnquiryController::class, 'index'])->name('enquiries.index');
    Route::get('/dashboard/enquiries/{id}/edit', [EnquiryController::class, 'edit'])->name('enquiries.edit');
    Route::get('/dashboard/enquiries/{id}', [EnquiryController::class, 'show'])->name('enquiries.show');
    Route::put('/dashboard/enquiries/{id}', [EnquiryController::class, 'update'])->name('enquiries.update');

    /*---------------------
    | Expense Management
    ----------------------*/
    Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses.index');
    Route::get('/expenses/create', [ExpenseController::class, 'create'])->name('expenses.create');
    Route::post('/expenses/store', [ExpenseController::class, 'store'])->name('expenses.store');
    Route::get('/expenses/{id}/edit', [ExpenseController::class, 'edit'])->name('expenses.edit');
    Route::put('/expenses/{id}', [ExpenseController::class, 'update'])->name('expenses.update');
    Route::delete('/expenses/{id}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');

    // Revenue Summary
    Route::get('/revenue-summary', [ExpenseController::class, 'revenueSummary'])->name('revenue.summary');

    // Reports Dashboard
    Route::get('/dashboard/reports', [ReportsController::class, 'index'])->name('reports.index');

    /*-----------------------
    | Admin Management
    ------------------------*/
    Route::get('/admin-management', [AdminManagementController::class, 'index'])->name('admin.management');
    Route::get('/admin/change-password/{id}', [AdminManagementController::class, 'editPassword'])->name('admin.password.edit');
    Route::post('/admin/change-password/{id}', [AdminManagementController::class, 'updatePassword'])->name('admin.password.update');

    // Admin Activities (Superadmin)
    Route::get('/admin-activities', [AdminActivityController::class, 'index'])->name('admin.activities');

    /*------------------------
    | Confirmed Admissions
    -------------------------*/
    Route::get('/confirmed-admissions', [EnquiryController::class, 'confirmedAdmissions'])->name('enquiries.confirmed');

    // Delete Unconfirmed Enquiry (with safeguard)
    Route::get('/enquiries/{id}/delete', [EnquiryController::class, 'destroy'])->name('enquiries.destroy');
});


/*-----------------------------
| Payments Routes (With Prefix)
------------------------------*/

Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::get('/enquiries/{id}/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/enquiries/{id}/payments/create', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('/enquiries/{id}/payments', [PaymentController::class, 'store'])->name('payments.store');
});


/*------------------------------
| Reports Routes (With Prefix)
-------------------------------*/

Route::prefix('dashboard/reports')->middleware(['auth'])->group(function () {
    Route::get('/', [ReportsController::class, 'index'])->name('reports.index');
    Route::get('/revenue', [ReportsController::class, 'revenue'])->name('reports.revenue');
    Route::get('/expenses', [ReportsController::class, 'expenses'])->name('reports.expenses');
});


/*----------------------------------
| Expense Category  Operations
-----------------------------------*/

Route::post('/expense-categories', [ExpenseCategoryController::class, 'store'])->name('expense-categories.store');
Route::put('/expense-categories/{id}', [ExpenseCategoryController::class, 'update'])->name('expense-categories.update');
Route::delete('/expense-categories/{id}', [ExpenseCategoryController::class, 'destroy'])->name('expense-categories.destroy');


/*----------------------
| Discount Assignment
-----------------------*/

Route::post('/payments/{id}/discount', [PaymentController::class, 'setDiscount'])->name('discount.update');
