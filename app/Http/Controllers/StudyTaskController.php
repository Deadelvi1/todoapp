<?php

namespace App\Http\Controllers;

use App\Models\StudyTask;
use Illuminate\Http\Request;

class StudyTaskController extends Controller
{
    public function index()
    {
        if (!session()->has('user')) {
            return redirect()->route('create')->withErrors(['msg' => 'Harus login dulu']);
        }

        $userId = session('user')->id;

        $tasks = StudyTask::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('study_tasks.index', compact('tasks'));
    }

    public function create()
    {
        if (!session()->has('user')) {
            return redirect()->route('create')->withErrors(['msg' => 'Harus login dulu']);
        }

        return view('study_tasks.create');
    }

    public function store(Request $request)
    {
        if (!session()->has('user')) {
            return redirect()->route('create')->withErrors(['msg' => 'Harus login dulu']);
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'nullable|in:low,medium,high',
            'status' => 'nullable|in:pending,in_progress,completed',
            'deadline' => 'nullable|date',
        ]);

        $userId = session('user')->id;

        $payload = [
            'user_id' => $userId,
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'priority' => $data['priority'] ?? 'medium',
            'status' => $data['status'] ?? 'pending',
            'deadline' => $data['deadline'] ?? null,
        ];

        StudyTask::create($payload);

        return redirect()->route('study-tasks.index')->with('success', 'Task dibuat.');
    }

    public function show(StudyTask $studyTask)
    {
        if (!session()->has('user') || session('user')->id != $studyTask->user_id) {
            return redirect()->route('study-tasks.index')->withErrors(['msg' => 'Tidak diizinkan']);
        }

        return view('study_tasks.show', ['task' => $studyTask]);
    }

    public function edit(StudyTask $studyTask)
    {
        if (!session()->has('user') || session('user')->id != $studyTask->user_id) {
            return redirect()->route('study-tasks.index')->withErrors(['msg' => 'Tidak diizinkan']);
        }

        return view('study_tasks.edit', compact('studyTask'));
    }

    public function update(Request $request, StudyTask $studyTask)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'nullable|in:low,medium,high',
            'status' => 'nullable|in:pending,in_progress,completed',
            'deadline' => 'nullable|date',
        ]);

        if (!session()->has('user') || session('user')->id != $studyTask->user_id) {
            return redirect()->route('study-tasks.index')->withErrors(['msg' => 'Tidak diizinkan']);
        }

        $studyTask->update($data);

        return redirect()->route('study-tasks.index')->with('success', 'Task diperbarui.');
    }

    public function destroy(StudyTask $studyTask)
    {
        if (!session()->has('user') || session('user')->id != $studyTask->user_id) {
            return redirect()->route('study-tasks.index')->withErrors(['msg' => 'Tidak diizinkan']);
        }

        $studyTask->delete();
        return redirect()->route('study-tasks.index')->with('success', 'Task dihapus.');
    }
}

