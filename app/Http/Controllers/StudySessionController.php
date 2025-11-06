<?php

namespace App\Http\Controllers;

use App\Models\StudySession;
use App\Models\StudyGoal;
use Illuminate\Http\Request;

class StudySessionController extends Controller
{
    public function index()
    {
        // require logged in user
        if (!session()->has('user')) {
            return redirect()->route('create')->withErrors(['msg' => 'Harus login dulu']);
        }

        $userId = session('user')->id;

        // Only sessions that belong to this user's goals
        $sessions = StudySession::with('studyGoal')
            ->whereHas('studyGoal', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $totalMinutes = StudySession::whereHas('studyGoal', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->sum('duration_minutes');

        return view('study_sessions.index', compact('sessions', 'totalMinutes'));
    }

    public function create()
    {
        if (!session()->has('user')) {
            return redirect()->route('create')->withErrors(['msg' => 'Harus login dulu']);
        }

        $userId = session('user')->id;
        $goals = StudyGoal::where('user_id', $userId)->get();
        return view('study_sessions.create', compact('goals'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'study_goal_id' => 'nullable|exists:study_goals,id',
            'duration_minutes' => 'required|integer|min:1',
            'note' => 'nullable|string',
        ]);

        if (!session()->has('user')) {
            return redirect()->route('create')->withErrors(['msg' => 'Harus login dulu']);
        }

        $userId = session('user')->id;

        // ensure the study goal belongs to the user if provided
        if (!empty($data['study_goal_id'])) {
            $goal = StudyGoal::findOrFail($data['study_goal_id']);
            if ($goal->user_id != $userId) {
                return back()->withErrors(['study_goal_id' => 'Goal tidak ditemukan untuk user ini']);
            }
        }

        $session = StudySession::create($data);

        // recalc progress for the goal
        if (!empty($data['study_goal_id'])) {
            $this->recalculateGoalProgress($data['study_goal_id']);
        }

        return redirect()->route('study-sessions.index')->with('success', 'Session tersimpan.');
    }

    public function show(StudySession $studySession)
    {
        $studySession->load('studyGoal');
        return view('study_sessions.show', ['session' => $studySession]);
    }

    public function edit(StudySession $studySession)
    {
        if (!session()->has('user')) {
            return redirect()->route('create')->withErrors(['msg' => 'Harus login dulu']);
        }

        $userId = session('user')->id;

        // ensure the session belongs to a goal of this user
        if ($studySession->studyGoal && $studySession->studyGoal->user_id != $userId) {
            return redirect()->route('study-sessions.index')->withErrors(['msg' => 'Tidak diizinkan']);
        }

        $goals = StudyGoal::where('user_id', $userId)->get();
        return view('study_sessions.edit', compact('studySession', 'goals'));
    }

    public function update(Request $request, StudySession $studySession)
    {
        $data = $request->validate([
            'study_goal_id' => 'nullable|exists:study_goals,id',
            'duration_minutes' => 'required|integer|min:1',
            'note' => 'nullable|string',
        ]);

        if (!session()->has('user')) {
            return redirect()->route('create')->withErrors(['msg' => 'Harus login dulu']);
        }

        $userId = session('user')->id;

        // ensure goal belongs to user if provided
        if (!empty($data['study_goal_id'])) {
            $goal = StudyGoal::findOrFail($data['study_goal_id']);
            if ($goal->user_id != $userId) {
                return back()->withErrors(['study_goal_id' => 'Goal tidak ditemukan untuk user ini']);
            }
        }

        $oldGoalId = $studySession->study_goal_id;

        $studySession->update($data);

        // recalc for old and new goal if changed
        if (!empty($oldGoalId)) {
            $this->recalculateGoalProgress($oldGoalId);
        }
        if (!empty($data['study_goal_id']) && $data['study_goal_id'] !== $oldGoalId) {
            $this->recalculateGoalProgress($data['study_goal_id']);
        }

        return redirect()->route('study-sessions.index')->with('success', 'Session diperbarui.');
    }

    public function destroy(StudySession $studySession)
    {
        if (!session()->has('user')) {
            return redirect()->route('create')->withErrors(['msg' => 'Harus login dulu']);
        }

        $userId = session('user')->id;

        // ensure the session belongs to a goal of this user
        if ($studySession->studyGoal && $studySession->studyGoal->user_id != $userId) {
            return back()->withErrors(['msg' => 'Tidak diizinkan']);
        }

        $goalId = $studySession->study_goal_id;
        $studySession->delete();

        if (!empty($goalId)) {
            $this->recalculateGoalProgress($goalId);
        }

        return redirect()->route('study-sessions.index')->with('success', 'Session dihapus.');
    }

    private function recalculateGoalProgress($goalId)
    {
        $goal = StudyGoal::find($goalId);
        if (!$goal) return;

        $totalMinutes = StudySession::where('study_goal_id', $goalId)->sum('duration_minutes');
        // achieved_hours stored as full hours
        $achievedHours = intdiv($totalMinutes, 60);

        $goal->achieved_hours = $achievedHours;
        // if target_hours set and achieved >= target, mark completed
        if (!empty($goal->target_hours) && $goal->target_hours > 0 && $achievedHours >= $goal->target_hours) {
            $goal->status = 'completed';
        } else {
            $goal->status = 'ongoing';
        }

        $goal->save();
    }
}
