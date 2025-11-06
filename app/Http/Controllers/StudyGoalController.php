<?php

namespace App\Http\Controllers;

use App\Models\StudyGoal;
use Illuminate\Http\Request;

class StudyGoalController extends Controller
{
    public function index()
    {
        if (!session()->has('user')) {
            return redirect()->route('create')->withErrors(['msg' => 'Harus login dulu']);
        }

        $userId = session('user')->id;

        // use withSum to get total minutes per goal
        $goals = StudyGoal::where('user_id', $userId)
            ->withSum('studySessions', 'duration_minutes')
            ->get();

        return view('study_goals.index', compact('goals'));
    }

    public function create()
    {
        if (!session()->has('user')) {
            return redirect()->route('create')->withErrors(['msg' => 'Harus login dulu']);
        }

        return view('study_goals.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'nullable|uuid',
            'title' => 'required|string|max:255',
            'target_hours' => 'nullable|integer|min:0',
        ]);

        if (!session()->has('user')) {
            return redirect()->route('create')->withErrors(['msg' => 'Harus login dulu']);
        }

        $userId = session('user')->id;

        $payload = array_merge($data, ['achieved_hours' => 0, 'status' => 'ongoing', 'user_id' => $userId]);

        StudyGoal::create($payload);

        return redirect()->route('study-goals.index')->with('success', 'Goal dibuat.');
    }

    public function edit(StudyGoal $studyGoal)
    {
        if (!session()->has('user') || session('user')->id != $studyGoal->user_id) {
            return redirect()->route('study-goals.index')->withErrors(['msg' => 'Tidak diizinkan']);
        }

        return view('study_goals.edit', compact('studyGoal'));
    }

    public function update(Request $request, StudyGoal $studyGoal)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'target_hours' => 'nullable|integer|min:0',
            'status' => 'nullable|in:ongoing,completed',
        ]);

        if (!session()->has('user') || session('user')->id != $studyGoal->user_id) {
            return redirect()->route('study-goals.index')->withErrors(['msg' => 'Tidak diizinkan']);
        }

        $studyGoal->update($data);

        return redirect()->route('study-goals.index')->with('success', 'Goal diperbarui.');
    }

    public function destroy(StudyGoal $studyGoal)
    {
        if (!session()->has('user') || session('user')->id != $studyGoal->user_id) {
            return redirect()->route('study-goals.index')->withErrors(['msg' => 'Tidak diizinkan']);
        }

        $studyGoal->delete();
        return redirect()->route('study-goals.index')->with('success', 'Goal dihapus.');
    }
}
