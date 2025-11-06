@extends('layouts.app')

@section('content')
<h1>Create Task</h1>

<form method="POST" action="{{ route('todos.store') }}">
    @csrf
    <div class="mb-3">
        <label class="form-label">Title</label>
        <input name="title" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control"></textarea>
    </div>
    <button class="btn btn-primary">Save</button>
</form>
@endsection
