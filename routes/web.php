<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\StudyGoalController;
use App\Http\Controllers\StudySessionController;
use App\Http\Controllers\StudyTaskController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AuthController;

// Public routes
Route::get('/', [WelcomeController::class, 'landing'])->name('home'); // Landing page
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes (require login)
Route::middleware([\App\Http\Middleware\AuthCheck::class])->group(function() {
    // Dashboard
    Route::get('/dashboard', [WelcomeController::class, 'index'])->name('dashboard');
    
    // Todos
    Route::get('/todos', [TodoController::class, 'index'])->name('todos.index');
    Route::get('/todos/create', [TodoController::class, 'create'])->name('todos.create');
    Route::post('/todos', [TodoController::class, 'store'])->name('todos.store');
    Route::get('/todos/{todo}/edit', [TodoController::class, 'edit'])->name('todos.edit');
    Route::put('/todos/{todo}', [TodoController::class, 'update'])->name('todos.update');
    Route::delete('/todos/{todo}', [TodoController::class, 'destroy'])->name('todos.destroy');

    // Study goals & sessions
    Route::resource('study-goals', StudyGoalController::class);
    Route::resource('study-sessions', StudySessionController::class);
    Route::resource('study-tasks', StudyTaskController::class);
});
