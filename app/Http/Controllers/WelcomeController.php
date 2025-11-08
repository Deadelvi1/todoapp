<?php

namespace App\Http\Controllers;

use App\Models\StudyGoal;
use App\Models\StudySession;
use App\Models\Todo;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function landing()
    {
        if (session()->has('user')) {
            return redirect()->route('dashboard');
        }
            return view('landing');
    }

    public function index()
    {
        if (!session()->has('user')) {
            return redirect()->route('login');
        }

        $userId = session('user')->id;
        $data = [
            'totalGoals' => StudyGoal::where('user_id', $userId)->count(),
            'totalMinutes' => StudySession::whereHas('studyGoal', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })->sum('duration_minutes'),
            'activeTodos' => Todo::where([
                'user_id' => $userId,
                'is_done' => false
            ])->count(),
            'recentGoals' => StudyGoal::where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get(),
            'recentSessions' => StudySession::with('studyGoal')
                ->whereHas('studyGoal', function($q) use ($userId) {
                    $q->where('user_id', $userId);
                })
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get()
        ];

            return view('dashboard', $data);
    }
}