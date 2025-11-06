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

    .badge { display: inline-block; padding: 4px 12px; border-radius: 12px; font-size: 13px; font-weight: 600; }
    .badge-pending { background: #fff7e6; color: #ff9900; }
    .badge-completed { background: #eafbe7; color: #0a7a18; }
    .badge-in-progress { background: #eaf2ff; color: #1e90ff; }
</style>

<div class="container">
    <h1 class="title">📝 Study Tasks</h1>

    <div class="top-links">
        <div>
            <a href="{{ route('study-tasks.create') }}">➕ Tambah Task</a>
            &nbsp;|&nbsp;
            <a href="{{ route('study-sessions.index') }}">📋 Sessions</a>
            &nbsp;|&nbsp;
            <a href="{{ route('study-goals.index') }}">🎯 Goals</a>
        </div>
    </div>

    @if(isset($tasks) && $tasks->count() > 0)
        <div style="margin-bottom: 15px; color: #666; font-size: 14px;">
            Total: {{ $tasks->count() }} task
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Status</th>
                <th>Prioritas</th>
                <th>Deadline</th>
                <th>Dibuat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse($tasks ?? [] as $task)
            <tr>
                <td><strong>{{ $task->title }}</strong></td>
                <td>{{ Str::limit($task->description ?? '-', 50) }}</td>
                <td>
                    @if($task->status == 'completed')
                        <span class="badge badge-completed">Selesai</span>
                    @elseif($task->status == 'in_progress')
                        <span class="badge badge-in-progress">Sedang Dikerjakan</span>
                    @else
                        <span class="badge badge-pending">Pending</span>
                    @endif
                </td>
                <td>{{ ucfirst($task->priority ?? 'medium') }}</td>
                <td>{{ $task->deadline ? \Carbon\Carbon::parse($task->deadline)->format('d M Y') : '-' }}</td>
                <td>{{ $task->created_at->format('d M Y, H:i') }}</td>
                <td>
                    <a href="{{ route('study-tasks.show', $task->id) }}" class="btn btn-view">View</a>
                    <a href="{{ route('study-tasks.edit', $task->id) }}" class="btn btn-edit">Edit</a>
                    <form action="{{ route('study-tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-delete" onclick="return confirm('Yakin hapus task ini?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" style="text-align:center; padding: 20px; color:#777;">Belum ada task.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection

