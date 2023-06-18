<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('index');

Route::get('/login', [LoginController::class, 'index'])->name('login.view');
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('/register', [LoginController::class, 'index'])->name('register.view');
Route::post('/register', [LoginController::class, 'register'])->name('register');

Route::middleware(['auth'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::prefix('/profile')->name('profile.')->group(function (){
        Route::view('/', 'profile')->name('index');
        Route::put('/{option}', [ProfileController::class, 'index'])->name('update');
        Route::delete('/destroy', [ProfileController::class, 'destroy'])->name('destroy');
    });
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});