@extends('layouts.app')

@section('content')
@php
    use App\Models\StudyGoal;
    $firstGoal = StudyGoal::where('user_id', session('user.id') ?? null)->first();
@endphp

<style>
    body {
        background: linear-gradient(135deg, #edf2fb, #e2eafc, #d7e3fc);
        font-family: 'Inter', sans-serif;
    }

    .container {
        max-width: 1050px;
        margin: 60px auto;
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.06);
        padding: 40px 50px;
        animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }

    h1.title {
        font-weight: 700;
        font-size: 1.9rem;
        color: #1d3557;
        text-align: center;
        margin-bottom: 30px;
    }

    .top-links {
        display: flex;
        justify-content: center;
        gap: 25px;
        margin-bottom: 25px;
    }
    .top-links a {
        color: #1e90ff;
        text-decoration: none;
        font-weight: 600;
        transition: 0.2s;
    }
    .top-links a:hover {
        color: #0b60d0;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 15px;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 0 0 1px rgba(0,0,0,0.05);
    }

    thead {
        background: linear-gradient(90deg, #1e90ff, #1c7ed6);
        color: white;
    }

    th {
        text-align: left;
        padding: 14px 16px;
        font-weight: 600;
        border: none;
        letter-spacing: 0.3px;
    }

    tbody tr {
        transition: all 0.25s ease;
        border-bottom: 1px solid #f0f0f0;
    }

    tbody tr:hover {
        background-color: #f8faff;
        transform: scale(1.005);
    }

    td {
        padding: 12px 16px;
        vertical-align: middle;
        color: #333;
    }

    .badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 600;
    }

    .badge-pending { background: #fff4e6; color: #e68a00; }
    .badge-completed { background: #e6f9ec; color: #098f1c; }
    .badge-in-progress { background: #eaf3ff; color: #1e90ff; }

    .actions {
        display: flex;
        gap: 10px;
        justify-content: flex-start;
        align-items: center;
    }

    .btn-icon {
        background: none;
        border: none;
        cursor: pointer;
        padding: 6px;
        border-radius: 8px;
        transition: 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-icon svg {
        width: 18px;
        height: 18px;
    }

    .btn-view svg { color: #1e90ff; }
    .btn-edit svg { color: #ff9900; }
    .btn-complete svg { color: #0a7a18; }
    .btn-delete svg { color: #e63946; }

    .btn-icon:hover {
        background: rgba(0,0,0,0.05);
        transform: scale(1.1);
    }

</style>

<div class="container">
    <h1 class="title">📝 Study Tasks</h1>

    <div class="top-links">
        <a href="{{ route('study_tasks.create') }}">➕ Tambah Task</a>

        @if($firstGoal)
            <a href="{{ route('study_sessions.index', ['goalId' => $firstGoal->id]) }}">📋 Sessions</a>
        @else
            <a href="{{ route('study-goals.create') }}">🎯 Buat Goal Dulu</a>
        @endif

        <a href="{{ route('study-goals.index') }}">🎯 Goals</a>
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
                        <span class="badge badge-in-progress">Proses</span>
                    @else
                        <span class="badge badge-pending">Pending</span>
                    @endif
                </td>
                <td>{{ ucfirst($task->priority ?? 'medium') }}</td>
                <td>{{ $task->deadline ? \Carbon\Carbon::parse($task->deadline)->format('d M Y') : '-' }}</td>
                <td>{{ $task->created_at->format('d M Y, H:i') }}</td>
                <td>
                    <div class="actions">
                        <a href="{{ route('study_tasks.show', $task->id) }}" class="btn-icon btn-view" title="Lihat">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7s-8.268-2.943-9.542-7z" />
                            </svg>
                        </a>

                        <a href="{{ route('study_tasks.edit', $task->id) }}" class="btn-icon btn-edit" title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5h2m-1 0v14m0-14L5 19m6-14l6 14" />
                            </svg>
                        </a>

                        @if($task->status !== 'completed')
                            <form action="{{ route('study_tasks.complete', $task->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn-icon btn-complete" title="Selesai">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('study_tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-icon btn-delete" title="Hapus" onclick="return confirm('Yakin hapus task ini?')">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" style="text-align:center; padding: 25px; color:#777;">Belum ada task.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
