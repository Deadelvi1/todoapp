@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #f8fafc;
    }

    .card-container {
        max-width: 1000px;
        margin: 40px auto;
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        padding: 40px 50px;
        animation: fadeIn 0.4s ease;
    }

    @keyframes fadeIn {
        from {opacity: 0; transform: translateY(10px);}
        to {opacity: 1; transform: translateY(0);}
    }

    .page-title {
        font-weight: 700;
        font-size: 2rem;
        color: #1d3557;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 25px;
    }

    .top-links {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .top-links a {
        color: #2563eb;
        text-decoration: none;
        font-weight: 600;
        transition: 0.2s;
    }

    .top-links a:hover {
        color: #1d4ed8;
        text-decoration: underline;
    }

    .total {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1d3557;
        margin-bottom: 15px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
        font-size: 15px;
        border-radius: 10px;
        overflow: hidden;
    }

    thead {
        background: #2563eb;
        color: white;
    }

    th, td {
        padding: 12px;
        text-align: left;
    }

    tbody tr:nth-child(even) {
        background-color: #f9fafb;
    }

    tbody tr:hover td {
        background-color: #eef6ff;
    }

    .btn {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 14px;
        text-decoration: none;
        font-weight: 600;
        margin: 0 2px;
        transition: 0.2s;
    }

    .btn-view {
        background: #eaf2ff;
        color: #2563eb;
    }

    .btn-view:hover {
        background: #d3e4ff;
    }

    .btn-edit {
        background: #fff7e6;
        color: #f59e0b;
    }

    .btn-edit:hover {
        background: #ffe2b3;
    }

    .btn-delete {
        background: #ffeaea;
        color: #e63946;
        border: none;
        cursor: pointer;
    }

    .btn-delete:hover {
        background: #ffcccc;
    }
</style>

<div class="card-container">
    <h1 class="page-title">
        <i class="bi bi-journal-text text-primary"></i>
        Study Sessions
    </h1>

    <div class="top-links">
        <div>
            <a href="{{ route('study-sessions.create') }}">
                <i class="bi bi-plus-circle"></i> Tambah Session
            </a>
            &nbsp;|&nbsp;
            <a href="{{ route('study-goals.index') }}">
                <i class="bi bi-bullseye"></i> Goals
            </a>
        </div>
    </div>

    <div class="total">
        Total durasi:
        <strong>{{ intdiv($totalMinutes, 60) }} jam {{ $totalMinutes % 60 }} menit</strong>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
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
                    <td colspan="6" style="text-align:center; padding: 20px; color:#777;">
                        Belum ada session.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
