<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EnquiryController;
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

//Get All enquiries for just admin
Route::middleware('auth')->group(function () {
    Route::get('/enquiries', [EnquiryController::class, 'index'])->name('enquiries.index');
    Route::get('/enquiries/{enquiry}/edit', [EnquiryController::class, 'edit'])->name('enquiries.edit');
    Route::put('/enquiries/{enquiry}', [EnquiryController::class, 'update'])->name('enquiries.update');

    //This is route for the Super Admin 
    Route::resource('expenses', ExpenseController::class)->only(['index', 'create', 'store']);
});

//Login Routes 
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');







