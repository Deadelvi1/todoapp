@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #f6f8fb;
    }

    .container {
        max-width: 800px;
        margin: 60px auto;
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.08);
        padding: 35px 45px;
        animation: fadeIn 0.4s ease;
    }

    @keyframes fadeIn {
        from {opacity: 0; transform: translateY(10px);}
        to {opacity: 1; transform: translateY(0);}
    }

    h1.title {
        font-weight: 700;
        font-size: 2rem;
        color: #1d3557;
        text-align: center;
        margin-bottom: 25px;
    }

    .top-links {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .top-links a {
        color: #1e90ff;
        text-decoration: none;
        font-weight: 600;
    }

    .top-links a:hover {
        text-decoration: underline;
    }

    .detail-card {
        background: #f9fafc;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 20px;
    }

    .detail-row {
        display: flex;
        padding: 15px 0;
        border-bottom: 1px solid #e5e7eb;
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-label {
        font-weight: 600;
        color: #1d3557;
        min-width: 150px;
        font-size: 15px;
    }

    .detail-value {
        color: #4a5568;
        font-size: 15px;
        flex: 1;
    }

    .detail-value strong {
        color: #1d3557;
    }

    .description-box {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 15px;
        margin-top: 10px;
        min-height: 60px;
        color: #4a5568;
        white-space: pre-wrap;
    }

    .action-buttons {
        display: flex;
        gap: 10px;
        margin-top: 30px;
        justify-content: center;
    }

    .btn {
        display: inline-block;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 14px;
        text-decoration: none;
        font-weight: 600;
        transition: 0.2s;
        border: none;
        cursor: pointer;
    }

    .btn-edit {
        background: #fff7e6;
        color: #ff9900;
    }

    .btn-edit:hover {
        background: #ffe2b3;
    }

    .btn-delete {
        background: #ffeaea;
        color: #e63946;
    }

    .btn-delete:hover {
        background: #ffcccc;
    }

    .btn-back {
        background: #eaf2ff;
        color: #1e90ff;
    }

    .btn-back:hover {
        background: #d3e4ff;
    }

    .badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 600;
    }

    .badge-pending {
        background: #fff7e6;
        color: #ff9900;
    }

    .badge-completed {
        background: #eafbe7;
        color: #0a7a18;
    }

    .badge-in-progress {
        background: #eaf2ff;
        color: #1e90ff;
    }

    .badge-low {
        background: #f1f1f1;
        color: #6c757d;
    }

    .badge-medium {
        background: #fff7e6;
        color: #ff9900;
    }

    .badge-high {
        background: #ffeaea;
        color: #e63946;
    }
</style>

<div class="container">
    <h1 class="title">📝 Detail Study Task</h1>

    <div class="top-links">
        <div>
            <a href="{{ route('study_tasks.create') }}">➕ Tambah Task</a>
            &nbsp;|&nbsp;
            <a href="{{ route('study-sessions.index') }}">📋 Sessions</a>
            &nbsp;|&nbsp;
            <a href="{{ route('study-goals.index') }}">🎯 Goals</a>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-row">
            <div class="detail-label">Judul Task</div>
            <div class="detail-value"><strong>{{ $task->title }}</strong></div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Deskripsi</div>
            <div class="detail-value">
                @if($task->description)
                    <div class="description-box">{{ $task->description }}</div>
                @else
                    <span style="color: #999;">Tidak ada deskripsi</span>
                @endif
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Status</div>
            <div class="detail-value">
                @if($task->status == 'completed')
                    <span class="badge badge-completed">Selesai</span>
                @elseif($task->status == 'in_progress')
                    <span class="badge badge-in-progress">Sedang Dikerjakan</span>
                @else
                    <span class="badge badge-pending">Pending</span>
                @endif
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Prioritas</div>
            <div class="detail-value">
                @if($task->priority == 'high')
                    <span class="badge badge-high">Tinggi</span>
                @elseif($task->priority == 'medium')
                    <span class="badge badge-medium">Sedang</span>
                @else
                    <span class="badge badge-low">Rendah</span>
                @endif
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Deadline</div>
            <div class="detail-value">
                @if($task->deadline)
                    <strong>{{ \Carbon\Carbon::parse($task->deadline)->format('d M Y') }}</strong>
                @else
                    <span style="color: #999;">Tidak ada deadline</span>
                @endif
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Dibuat</div>
            <div class="detail-value">
                <strong>{{ $task->created_at->format('d M Y, H:i') }}</strong>
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Diperbarui</div>
            <div class="detail-value">
                <strong>{{ $task->updated_at->format('d M Y, H:i') }}</strong>
            </div>
        </div>
    </div>

    <div class="action-buttons">
        <a href="{{ route('study_tasks.index') }}" class="btn btn-back">← Kembali</a>
        <a href="{{ route('study_tasks.edit', $task->id) }}" class="btn btn-edit">✏️ Edit Task</a>
        <form action="{{ route('study_tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-delete" onclick="return confirm('Yakin hapus task ini?')">
                🗑️ Hapus Task
            </button>
        </form>
    </div>
</div>
@endsection

