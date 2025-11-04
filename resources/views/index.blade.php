<!DOCTYPE html>
<html>
<head>
    <title>Todo List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Todo List</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('create') }}" class="btn btn-primary mb-3">Add Todo</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Done</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($todos as $todo)
            <tr>
                <td>{{ $todo->title }}</td>
                <td>{{ $todo->description }}</td>
                <td>{{ $todo->is_done ? 'Yes' : 'No' }}</td>
                <td>
                    <a href="{{ route('edit', $todo->id) }}" class="btn btn-sm btn-warning">Edit</a>

                    <form action="{{ route('destroy', $todo->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center">No todos found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
</body>
</html>
