<?php

use App\Http\Controllers\TodoController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AuthController;


Route::get('/', [WelcomeController::class, 'index'])->name('index');


Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/dashboard', function () {
    if (!session()->has('user')) {
        return redirect('/login')->withErrors(['msg' => 'Harus login dulu']);
    }
    return view('dashboard');
});

Route::get('/logout', [AuthController::class, 'logout']);
