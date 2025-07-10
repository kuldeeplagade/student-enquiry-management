<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\AdminActivityController;
use App\Http\Controllers\AdminManagementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//Direct Open The Enquiry form for users 
Route::get('/', function () {
    return redirect('/enquiry');
});

//Home Page 
Route::get('/enquiry', [EnquiryController::class, 'create']);
Route::post('/enquiry', [EnquiryController::class, 'store'])->name('enquiry.store');

// Enquiry Management Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    //Enquiries Related Routes 
    Route::get('/dashboard/enquiries', [EnquiryController::class, 'index'])->name('enquiries.index');
    Route::get('/dashboard/enquiries/{id}/edit', [EnquiryController::class, 'edit'])->name('enquiries.edit');
    Route::get('/dashboard/enquiries/{id}', [EnquiryController::class, 'show'])->name('enquiries.show');
    Route::put('/dashboard/enquiries/{id}', [EnquiryController::class, 'update'])->name('enquiries.update');

    //Expenses Related Routes Access:Superadmin
    Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses.index');
    Route::get('/expenses/create', [ExpenseController::class, 'create'])->name('expenses.create');
    Route::post('/expenses/store', [ExpenseController::class, 'store'])->name('expenses.store');
    Route::get('/expenses/{id}/edit', [ExpenseController::class, 'edit'])->name('expenses.edit');
    Route::put('/expenses/{id}', [ExpenseController::class, 'update'])->name('expenses.update');
    Route::delete('/expenses/{id}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');

    Route::get('/revenue-summary', [ExpenseController::class, 'revenueSummary'])->name('revenue.summary');


    //Admin Management 
    Route::get('/admin-management', [AdminManagementController::class, 'index'])->name('admin.management');

    Route::get('/admin/change-password/{id}', [AdminManagementController::class, 'editPassword'])->name('admin.password.edit');
    Route::post('/admin/change-password/{id}', [AdminManagementController::class, 'updatePassword'])->name('admin.password.update');


});

//Payment Related Routes 
Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::get('/enquiries/{id}/payments', [PaymentController::class, 'index'])->name('payments.index'); // View history
    Route::get('/enquiries/{id}/payments/create', [PaymentController::class, 'create'])->name('payments.create'); // Show add form
    Route::post('/enquiries/{id}/payments', [PaymentController::class, 'store'])->name('payments.store'); // Save new payment
});


//SuperAdmin Check the Activity in All Admins
Route::get('/admin-activities', [AdminActivityController::class, 'index'])
    ->middleware('auth')
    ->name('admin.activities');


//Login Routes 
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
// Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard')->middleware('auth');
Route::post('/logout', function () {
    \Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');








