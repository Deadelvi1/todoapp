<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Edit Study Session</title>
</head>
<body>
    <h1>Edit Study Session</h1>
    <p><a href="{{ route('study-sessions.index') }}">Kembali</a></p>

    @if($errors->any())
        <div style="color:red">
            <ul>
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('study-sessions.update', $studySession) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label>Goal (optional)</label>
            <select name="study_goal_id">
                <option value="">-- pilih --</option>
                @foreach($goals as $g)
                    <option value="{{ $g->id }}" {{ $studySession->study_goal_id == $g->id ? 'selected' : '' }}>{{ $g->title }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Duration (minutes)</label>
            <input type="number" name="duration_minutes" required min="1" value="{{ $studySession->duration_minutes }}">
        </div>
        <div>
            <label>Note</label>
            <textarea name="note">{{ $studySession->note }}</textarea>
        </div>
        <div>
            <button type="submit">Simpan</button>
        </div>
    </form>
</body>
</html>
