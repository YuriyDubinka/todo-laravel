<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $categories = $request->user()->categories;

        $query = $request->user()->tasks()->with('category')->latest();

        if ($request->filled('filter_category_id')) {
            $query->where('category_id', $request->filter_category_id);
        }

        if ($request->filled('search')) {
            // SQL: WHERE title LIKE '%значення%'
            // % означає "будь-що до" і "будь-що після"
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $tasks = $query->paginate(3);

        return view('index', ['tasks' => $tasks, 'categories' => $categories]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $request->user()->tasks()->create($validated);

        return redirect('/dashboard');
    }

    public function toggle(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }

        $task->update(['is_completed' => !$task->is_completed]);
        return back();
    }

    public function destroy(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }

        $task->delete();
        return back();
    }

    // 1. Показати форму з даними
    public function edit(Task $task)
    {
        // AUTHORIZATION: Не даємо редагувати чуже
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }

        // Нам потрібні категорії, щоб вивести їх у випадаючому списку
        $categories = Auth::user()->categories;

        return view('edit', [
            'task' => $task,
            'categories' => $categories
        ]);
    }

    // 2. Зберегти зміни
    public function update(Request $request, Task $task)
    {
        // AUTHORIZATION
        if ($task->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        // Оновлюємо запис
        $task->update($validated);

        return redirect()->route('dashboard');
    }
}
