@extends('layouts.app')

@section('content')
<style>
    body { background-color: #f6f8fb; }

    .container { max-width: 1000px; margin: 60px auto; background: #ffffff; border-radius: 16px; box-shadow: 0 4px 16px rgba(0,0,0,0.08); padding: 35px 45px; animation: fadeIn 0.4s ease; }
    @keyframes fadeIn { from {opacity: 0; transform: translateY(10px);} to {opacity: 1; transform: translateY(0);} }

    h1.title { font-weight: 700; font-size: 2rem; color: #1d3557; text-align: center; margin-bottom: 25px; }

    .top-links { display: flex; justify-content: space-between; margin-bottom: 20px; }
    .top-links a { color: #1e90ff; text-decoration: none; font-weight: 600; }
    .top-links a:hover { text-decoration: underline; }

    .total { font-size: 1.1rem; font-weight: 600; color: #1d3557; margin-bottom: 15px; }

    .alert-success { color: #0a7a18; background: #eafbe7; border: 1px solid #b8e4b0; border-radius: 8px; padding: 10px 15px; margin-bottom: 15px; font-size: 14px; }

    table { width: 100%; border-collapse: collapse; margin-top: 15px; font-size: 15px; border-radius: 10px; overflow: hidden; }
    th { background: #1e90ff; color: white; padding: 10px; text-align: left; }
    td { background: #f9fafc; padding: 10px; border-bottom: 1px solid #e5e7eb; }
    tr:hover td { background: #eef6ff; }

    .btn { display: inline-block; padding: 6px 12px; border-radius: 8px; font-size: 14px; text-decoration: none; font-weight: 600; margin: 0 2px; transition: 0.2s; }
    .btn-view { background: #eaf2ff; color: #1e90ff; }
    .btn-view:hover { background: #d3e4ff; }
    .btn-edit { background: #fff7e6; color: #ff9900; }
    .btn-edit:hover { background: #ffe2b3; }
    .btn-delete { background: #ffeaea; color: #e63946; border: none; cursor: pointer; }
    .btn-delete:hover { background: #ffcccc; }

    footer { background-color: #1e90ff; color: white; padding: 12px; text-align: center; font-weight: 500; border-radius: 0 0 10px 10px; margin-top: 40px; }
</style>

<div class="container">
    <h1 class="title">📋 Study Sessions</h1>

    <div class="top-links">
        <div>
            <a href="{{ route('study-sessions.create') }}">➕ Tambah Session</a>
            &nbsp;|&nbsp;
            <a href="{{ route('study-goals.index') }}">🎯 Goals</a>
        </div>
    </div>

    <div class="total">
        Total durasi:
        <strong>{{ intdiv($totalMinutes, 60) }} jam {{ $totalMinutes % 60 }} menit</strong>
    </div>

    @if(session('success'))
        <div class="alert-success">✅ {{ session('success') }}</div>
    @endif

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Goal</th>
                <th>Durasi (menit)</th>
                <th>Catatan</th>
                <th>Dibuat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse($sessions as $s)
            <tr>
                <td>{{ $s->id }}</td>
                <td>{{ $s->studyGoal?->title ?? '-' }}</td>
                <td>{{ $s->duration_minutes }}</td>
                <td>{{ $s->note ?? '-' }}</td>
                <td>{{ $s->created_at->format('d M Y, H:i') }}</td>
                <td>
                    <a href="{{ route('study-sessions.show', $s->id) }}" class="btn btn-view">View</a>
                    <a href="{{ route('study-sessions.edit', $s->id) }}" class="btn btn-edit">Edit</a>
                    <form action="{{ route('study-sessions.destroy', $s->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete" onclick="return confirm('Yakin hapus session ini?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" style="text-align:center; padding: 20px; color:#777;">Belum ada session.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <footer>© 2025 Study Timer — Belajar Konsisten, Hasil Maksimal 📚</footer>
</div>
@endsection
