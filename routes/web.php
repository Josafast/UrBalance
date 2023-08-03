<?php

use App\Http\Controllers\BalanceController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
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
        Route::put('/change_email', [ProfileController::class, 'change_email'])->name('change_email');
        Route::put('/change_password', [ProfileController::class, 'change_password'])->name('change_password');
        Route::delete('/destroy', [ProfileController::class, 'destroy'])->name('destroy');
        Route::view('/', 'profile')->name('index');
    });
    Route::prefix('/balance')->name('balance.')->group(function (){
        Route::put('/change-main', [BalanceController::class, 'update'])->name('change-main');
        Route::post('/create', [BalanceController::class, 'create'])->name('create');
        Route::delete('/delete', [BalanceController::class, 'destroy'])->name('delete');
    });
    Route::post('/transactions/notes', [TransactionController::class, 'notes'])->name('transactions.notes');
    Route::resource('/transactions', TransactionController::class);
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});