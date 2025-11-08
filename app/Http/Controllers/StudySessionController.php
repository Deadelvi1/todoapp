<?php

namespace App\Http\Controllers;

use App\Models\StudyGoal;
use App\Models\StudySession;
use Illuminate\Http\Request;

class StudySessionController extends Controller
{
    public function index($goalId)
    {
        $goal = StudyGoal::with('studySessions')->findOrFail($goalId);
        return view('study_sessions.index', compact('goal'));
    }

    public function store(Request $request, $goalId)
    {
        $validated = $request->validate([
            'duration_minutes' => 'required|numeric|min:1',
            'note' => 'nullable|string|max:255',
        ]);

        $validated['study_goal_id'] = $goalId;

        StudySession::create($validated);

        return redirect()->back()->with('success', 'Study session berhasil disimpan.');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'duration_minutes' => 'required|numeric|min:1',
            'note' => 'nullable|string|max:255',
        ]);

        $session = StudySession::findOrFail($id);
        $session->update($validated);

        return redirect()->back()->with('success', 'Study session berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $session = StudySession::findOrFail($id);
        $session->delete();

        return redirect()->back()->with('success', 'Study session berhasil dihapus.');
    }
}
