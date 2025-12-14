<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\TaskResource;
use App\Models\Task;

// 1. ПУБЛІЧНИЙ МАРШРУТ (Для тесту в браузері)
// Доступний за адресою: http://127.0.0.1:8000/api/tasks
Route::get('/tasks', function () {
    // Беремо 10 будь-яких задач
    $tasks = Task::with('category')->latest()->take(10)->get();
    return TaskResource::collection($tasks);
});

// Маршрут для отримання даних користувача (автоматично створений Laravel)
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// НАШ МАРШРУТ: Список задач
// middleware('auth:sanctum') означає "Сюди можна тільки з токеном"
Route::middleware(['auth:sanctum'])->get('/my-tasks', function (Request $request) {
    // Беремо задачі поточного користувача
    $tasks = $request->user()->tasks()->with('category')->latest()->get();

    // Повертаємо красивий JSON через Resource
    return TaskResource::collection($tasks);
});
