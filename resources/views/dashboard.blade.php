@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Welcome Header -->
    <div class="p-5 mb-4 bg-body-tertiary rounded-3">
        <div class="container-fluid py-5">
            <h1 class="display-5 fw-bold">Welcome, {{ session('user')['name'] }}!</h1>
            <p class="col-md-8 fs-4">Track your study sessions and stay on top of your learning goals.</p>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-bg-primary mb-3 h-100">
                <div class="card-body">
                    <h5 class="card-title">Total Study Goals</h5>
                    <p class="card-text display-6">{{ $totalGoals }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-bg-success mb-3 h-100">
                <div class="card-body">
                    <h5 class="card-title">Total Study Time</h5>
                    <p class="card-text display-6">{{ round($totalMinutes / 60, 1) }}h</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-bg-warning mb-3 h-100">
                <div class="card-body">
                    <h5 class="card-title">Active Tasks</h5>
                    <p class="card-text display-6">{{ $activeTodos }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Goals -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Recent Study Goals</h4>
                    <a href="{{ route('study-goals.create') }}" class="btn btn-primary btn-sm">Add New Goal</a>
                </div>
                <div class="card-body">
                    @if($recentGoals->isEmpty())
                        <p class="text-muted">No study goals yet. Create your first goal to get started!</p>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($recentGoals as $goal)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">{{ $goal->title }}</h6>
                                    <small class="text-muted">Target: {{ $goal->target_hours }} hours</small>
                                </div>
                                <span class="badge bg-primary rounded-pill">
                                    {{ $goal->completed_hours }}h
                                </span>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Sessions -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Recent Study Sessions</h4>
                    <a href="{{ route('study-sessions.create') }}" class="btn btn-primary btn-sm">New Session</a>
                </div>
                <div class="card-body">
                    @if($recentSessions->isEmpty())
                        <p class="text-muted">No study sessions recorded yet. Start your first session!</p>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($recentSessions as $session)
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ $session->studyGoal->title }}</h6>
                                    <small>{{ $session->duration_minutes }}min</small>
                                </div>
                                <p class="mb-1">{{ $session->notes }}</p>
                                <small class="text-muted">{{ $session->created_at->diffForHumans() }}</small>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection