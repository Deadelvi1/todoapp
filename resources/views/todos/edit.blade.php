@extends('layouts.app')

@section('content')
<h1>Edit Task</h1>

<form method="POST" action="{{ route('todos.update', $todo->id) }}">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label class="form-label">Title</label>
        <input name="title" class="form-control" value="{{ old('title', $todo->title) }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control">{{ old('description', $todo->description) }}</textarea>
    </div>
    <button class="btn btn-primary">Save</button>
</form>
@endsection
