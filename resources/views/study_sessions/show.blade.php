<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Detail Session</title>
</head>
<body>
    <h1>Detail Study Session</h1>
    <p><a href="{{ route('study-sessions.index') }}">Kembali</a></p>

    <ul>
        <li>ID: {{ $session->id }}</li>
        <li>Goal: {{ $session->studyGoal?->title ?? '-' }}</li>
        <li>Duration: {{ $session->duration_minutes }} menit</li>
        <li>Note: {{ $session->note }}</li>
        <li>Created: {{ $session->created_at }}</li>
    </ul>
</body>
</html>
