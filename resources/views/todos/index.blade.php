@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Tasks</h1>
    <a href="{{ route('todos.create') }}" class="btn btn-primary">Add Task</a>
</div>

@if($todos->isEmpty())
    <div class="alert alert-info">No tasks yet.</div>
@else
    <table class="table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Done</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($todos as $todo)
            <tr>
                <td>{{ $todo->title }}</td>
                <td>{{ $todo->description }}</td>
                <td>{{ $todo->is_done ? 'Yes' : 'No' }}</td>
                <td>
                    <a href="{{ route('todos.edit', $todo->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('todos.destroy', $todo->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endif
@endsection
