<?php

use App\Http\Controllers\TodoController;
use App\Http\Controllers\WelcomeController;

Route::get('/', [WelcomeController::class, 'index'])->name('index');
Route::get('/create', [TodoController::class, 'create'])->name('create');
Route::post('/store', [TodoController::class, 'store'])->name('store'); // <- ini wajib ada
Route::get('/edit/{todo}', [TodoController::class, 'edit'])->name('edit');
Route::put('/update/{todo}', [TodoController::class, 'update'])->name('update');
Route::delete('/delete/{todo}', [TodoController::class, 'destroy'])->name('destroy');
