<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExpenseController;

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
});


//Payment Related Routes 
Route::prefix('dashboard')->middleware('auth')->group(function () {
    Route::get('/enquiries/{id}/payments', [PaymentController::class, 'index'])->name('payments.index'); // View history
    Route::get('/enquiries/{id}/payments/create', [PaymentController::class, 'create'])->name('payments.create'); // Show add form
    Route::post('/enquiries/{id}/payments', [PaymentController::class, 'store'])->name('payments.store'); // Save new payment
});

//Login Routes 
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
// Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard')->middleware('auth');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route::get('/dashboard', function () {
//     return "Welcome! You're logged in.";
// })->middleware('auth');






