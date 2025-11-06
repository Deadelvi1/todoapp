<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Edit Goal</title>
</head>
<body>
    <h1>Edit Goal</h1>
    <p><a href="{{ route('study-goals.index') }}">Kembali</a></p>

    @if($errors->any())
        <div style="color:red">
            <ul>
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('study-goals.update', $studyGoal) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label>Title</label>
            <input type="text" name="title" required value="{{ $studyGoal->title }}">
        </div>
        <div>
            <label>Target Hours</label>
            <input type="number" name="target_hours" min="0" value="{{ $studyGoal->target_hours }}">
        </div>
        <div>
            <label>Status</label>
            <select name="status">
                <option value="ongoing" {{ $studyGoal->status == 'ongoing' ? 'selected' : '' }}>ongoing</option>
                <option value="completed" {{ $studyGoal->status == 'completed' ? 'selected' : '' }}>completed</option>
            </select>
        </div>
        <div>
            <button type="submit">Simpan</button>
        </div>
    </form>
</body>
</html>
