<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        $userId = session()->has('user') ? session('user')->id : null;
        if ($userId) {
            $todos = Todo::where('user_id', $userId)->orderBy('created_at', 'desc')->get();
        } else {
            $todos = collect();
        }
        return view('todos.index', compact('todos'));
    }

    public function create()
    {
        return view('todos.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Tambahkan user_id dari session ke data yang akan disimpan
        $validatedData['user_id'] = session('user')->id;
        Todo::create($validatedData);

        return redirect()->route('todos.index')->with('success', 'Task created successfully.');
    }

    public function edit(Todo $todo)
    {
        return view('todos.edit', compact('todo'));
    }

    public function update(Request $request, Todo $todo)
    {
        $request->validate([
            'title' => 'required'
        ]);

        $todo->update([
            'title' => $request->title,
            'description' => $request->description ?? ''
        ]);

        return redirect()->route('todos.index')->with('success', 'Task updated successfully.');
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();
        return redirect()->route('todos.index')->with('success', 'Task deleted successfully.');
    }

    public function complete(Todo $todo)
    {
        $todo->is_done = true;
        $todo->save();

        return back()->with('success', 'Task marked as completed!');
    }
}
