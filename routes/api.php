<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\RegisterController;

Route::middleware('throttle:api')->group(function () {
    Route::post('/login/customer', [SessionController::class, 'storeCustomer'])->name('api.loginCustomer.store');
    Route::post('/register/customer', [RegisterController::class, 'storeCustomer'])->name('api.registerCustomer.store');
    Route::post('/login/admin', [SessionController::class, 'storeAdmin'])->name('api.loginAdmin.store');
    Route::post('/register/admin', [RegisterController::class, 'storeAdmin'])->name('api.registerAdmin.store');
    Route::post('/logout', [SessionController::class, 'destroy'])->name('api.logout');
});
