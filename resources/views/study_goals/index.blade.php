@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Study Goals</h1>
    <div>
        <a href="{{ route('study-goals.create') }}" class="btn btn-sm btn-primary">Tambah Goal</a>
        <a href="{{ route('study-sessions.index') }}" class="btn btn-sm btn-secondary">Sessions</a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-striped">
    <thead>
        <tr>
            <th>Title</th>
            <th>Target (hours)</th>
            <th>Achieved</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    @foreach($goals as $g)
        @php
            // The withSum('studySessions', 'duration_minutes') adds the attribute
            // "study_sessions_sum_duration_minutes" to the model. Fall back to
            // summing the relation if present.
            $minutes = $g->study_sessions_sum_duration_minutes ?? ($g->studySessions ? $g->studySessions->sum('duration_minutes') : 0);
            $hours = intdiv($minutes, 60);
        @endphp
        <tr>
            <td>{{ $g->title }}</td>
            <td>{{ $g->target_hours }}</td>
            <td>{{ $hours }} jam ({{ $minutes }} menit)</td>
            <td>{{ $g->status }}</td>
            <td>
                <a href="{{ route('study-goals.edit', $g) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                <form action="{{ route('study-goals.destroy', $g) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
