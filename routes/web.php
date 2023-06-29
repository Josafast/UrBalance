<?php

use App\Http\Controllers\BalanceController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('index');

Route::get('/login', [LoginController::class, 'index'])->name('login.view');
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('/register', [LoginController::class, 'index'])->name('register.view');
Route::post('/register', [LoginController::class, 'register'])->name('register');

Route::prefix('/components')->name('components.')->group(function (){
    Route::view('/balance-create', 'components.balance-create')->name('balance-create');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', App\Http\Controllers\DashboardController::class)->name('dashboard');
    Route::prefix('/profile')->name('profile.')->group(function (){
        Route::view('/', 'profile')->name('index');
        Route::put('/{option}', [ProfileController::class, 'index'])->name('update');
        Route::delete('/destroy', [ProfileController::class, 'destroy'])->name('destroy');
    });
    Route::resource('/transactions', App\Http\Controllers\TransactionController::class);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});