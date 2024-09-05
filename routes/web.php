<?php

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard/customer')->middleware('authCustomer');

Route::get('/dashboard/customer', function () {
    return view('customer.index');
})->name('dashboardCustomer')->middleware('authCustomer');
Route::get('/dashboard/admin', function () {
    return view('admin.index');
})->name('dashboardAdmin')->middleware('authAdmin');

Route::get('/login/customer', [SessionController::class, 'createCustomer'])->name('loginCustomer.create');
Route::get('/register/customer', [RegisterController::class, 'createCustomer'])->name('registerCustomer.create');

Route::get('/register/admin', [RegisterController::class, 'createAdmin'])->name('registerAdmin.create');
Route::get('/login/admin', [SessionController::class, 'createAdmin'])->name('loginAdmin.create');