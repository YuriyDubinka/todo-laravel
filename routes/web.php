<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController; // <--- Не забудь цей рядок!
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Твоя група маршрутів
Route::middleware(['auth', 'verified'])->group(function () {

    // ГЛАВНЕ: Маршрут /dashboard має вести на ТВІЙ контролер
    Route::get('/dashboard', [TaskController::class, 'index'])->name('dashboard');

    // Сторінка редагування
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    
    // Обробка змін (PUT - стандарт для повного оновлення ресурсу)
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');

    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::patch('/tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

    // Маршрути профілю (їх додав Breeze, можна залишити)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
