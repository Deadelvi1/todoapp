<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Study Sessions</title>
</head>
<body>
    <h1>Study Sessions</h1>

    <p><a href="{{ route('study-sessions.create') }}">Tambah Session</a> | <a href="{{ route('study-goals.index') }}">Goals</a></p>

    <h3>Total durasi: {{ intdiv($totalMinutes, 60) }} jam {{ $totalMinutes % 60 }} menit</h3>

    @if(session('success'))
        <div style="color:green">{{ session('success') }}</div>
    @endif

    <table border="1" cellpadding="6" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Goal</th>
                <th>Duration (minutes)</th>
                <th>Note</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($sessions as $s)
            <tr>
                <td>{{ $s->id }}</td>
                <td>{{ $s->studyGoal?->title ?? '-' }}</td>
                <td>{{ $s->duration_minutes }}</td>
                <td>{{ $s->note }}</td>
                <td>{{ $s->created_at }}</td>
                <td>
                    <a href="{{ route('study-sessions.show', $s) }}">View</a> |
                    <a href="{{ route('study-sessions.edit', $s) }}">Edit</a> |
                    <form action="{{ route('study-sessions.destroy', $s) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
