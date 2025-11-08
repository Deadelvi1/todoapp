<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\StudyTaskController;
use App\Http\Controllers\StudyGoalController;
use App\Http\Controllers\StudySessionController;

// --------------------
// Public routes
// --------------------
Route::get('/', [WelcomeController::class, 'landing'])->name('home');

// Authentication
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// --------------------
// Protected routes
// --------------------
Route::middleware([\App\Http\Middleware\AuthCheck::class])->group(function () {

    // Dashboard
    Route::get('/dashboard', [WelcomeController::class, 'index'])->name('dashboard');

    // --------------------
    // STUDY TASKS
    // --------------------
    Route::prefix('study-tasks')->name('study_tasks.')->group(function () {
        Route::get('/', [StudyTaskController::class, 'index'])->name('index');
        Route::get('/create', [StudyTaskController::class, 'create'])->name('create');
        Route::post('/', [StudyTaskController::class, 'store'])->name('store');
        Route::get('/{study_task}', [StudyTaskController::class, 'show'])->name('show');
        Route::get('/{study_task}/edit', [StudyTaskController::class, 'edit'])->name('edit');
        Route::put('/{study_task}', [StudyTaskController::class, 'update'])->name('update');
        Route::delete('/{study_task}', [StudyTaskController::class, 'destroy'])->name('destroy');
        Route::patch('/{study_task}/complete', [StudyTaskController::class, 'complete'])->name('complete');
    });

    // --------------------
    // STUDY GOALS & SESSIONS (nested)
    // --------------------
    Route::resource('study-goals', StudyGoalController::class);

    Route::prefix('study-goals/{goalId}')->name('study_sessions.')->group(function () {
        Route::get('/sessions', [StudySessionController::class, 'index'])->name('index');
        Route::post('/sessions', [StudySessionController::class, 'store'])->name('store');
    });


    Route::put('/study-sessions/{id}', [StudySessionController::class, 'update'])->name('studySessions.update');
    Route::delete('/study-sessions/{id}', [StudySessionController::class, 'destroy'])->name('studySessions.destroy');
});
