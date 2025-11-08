<?php

namespace App\Http\Controllers;

use App\Models\StudyTask;
use Illuminate\Http\Request;

class StudyTaskController extends Controller
{
    // show list
    public function index()
    {
        $userId = session('user')->id ?? auth()->id();
        $tasks = StudyTask::where('user_id', $userId)->orderBy('created_at', 'desc')->get();

        return view('study_tasks.index', compact('tasks'));
    }

    // show create form
    public function create()
    {
        return view('study_tasks.create');
    }

    // store new task
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'nullable|in:low,medium,high',
            'status' => 'nullable|in:pending,in_progress,completed',
            'deadline' => 'nullable|date',
        ]);

        $data['user_id'] = session('user')->id ?? auth()->id();
        StudyTask::create($data);

        return redirect()->route('study_tasks.index')->with('success', 'Task created.');
    }

    // EDIT - render edit form (this is the one you were missing)
    public function edit(StudyTask $study_task)
    {
        // pass the model as $task because your blade expects $task
        return view('study_tasks.edit', ['task' => $study_task]);
    }

    // UPDATE - handle edit submission
    public function update(Request $request, StudyTask $study_task)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'nullable|in:low,medium,high',
            'status' => 'nullable|in:pending,in_progress,completed',
            'deadline' => 'nullable|date',
        ]);

        $study_task->update($data);

        return redirect()->route('study_tasks.index')->with('success', 'Task updated.');
    }

    // SHOW (optional, used by your index blade)
    public function show(StudyTask $study_task)
    {
        return view('study_tasks.show', ['task' => $study_task]);
    }

    // DELETE
    public function destroy(StudyTask $study_task)
    {
        $study_task->delete();
        return redirect()->route('study_tasks.index')->with('success', 'Task deleted.');
    }

    // mark complete (optional)
    public function complete(StudyTask $study_task)
    {
        $study_task->update(['status' => 'completed']);
        return redirect()->back()->with('success', 'Task marked complete.');
    }
}
