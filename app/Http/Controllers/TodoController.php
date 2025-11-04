<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::all();
        return view('index', compact('todos'));
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required'
        ]);

        Todo::create([
            'title' => $request->title,
            'description' => $request->description ?? ''
        ]);

        return redirect()->route('todos.index')->with('success', 'Task created successfully.');
    }

    public function edit(Todo $todo)
    {
        return view('edit', compact('todo'));
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
}
