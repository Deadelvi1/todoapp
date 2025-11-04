<!DOCTYPE html>
<html>
<head>
    <title>Edit Todo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Edit Todo</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('update', $todo->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" name="title" id="title" value="{{ old('title', $todo->title) }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" name="description" id="description">{{ old('description', $todo->description) }}</textarea>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" name="is_done" id="is_done" value="1" {{ $todo->is_done ? 'checked' : '' }}>
            <label class="form-check-label" for="is_done">Done</label>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
</body>
</html>
