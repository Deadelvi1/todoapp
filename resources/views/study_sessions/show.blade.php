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
        margin-bottom: 30px;
    }

    .top-links {
        display: flex;
        justify-content: space-between;
        margin-bottom: 30px;
        align-items: center;
    }

    .top-links a {
        color: #1e90ff;
        text-decoration: none;
        font-weight: 600;
        transition: 0.2s;
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

    .note-box {
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

    .alert-success {
        color: #0a7a18;
        background: #eafbe7;
        border: 1px solid #b8e4b0;
        border-radius: 8px;
        padding: 10px 15px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 600;
    }

    .badge-goal {
        background: #eaf2ff;
        color: #1e90ff;
    }

    .badge-duration {
        background: #fff7e6;
        color: #ff9900;
    }
</style>

<div class="container">
    <h1 class="title">📋 Detail Study Session</h1>

    <div class="top-links">
        <a href="{{ route('study-sessions.index') }}" class="btn-back">← Kembali ke Daftar</a>
        <div>
            <a href="{{ route('study-sessions.create') }}">➕ Tambah Session</a>
            &nbsp;|&nbsp;
            <a href="{{ route('study-goals.index') }}">🎯 Goals</a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert-success">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="detail-card">
        <div class="detail-row">
            <div class="detail-label">ID Session</div>
            <div class="detail-value">{{ $session->id }}</div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Goal</div>
            <div class="detail-value">
                @if($session->studyGoal)
                    <span class="badge badge-goal">{{ $session->studyGoal->title }}</span>
                @else
                    <span style="color: #999;">-</span>
                @endif
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Durasi</div>
            <div class="detail-value">
                <span class="badge badge-duration">
                    <strong>{{ intdiv($session->duration_minutes, 60) }} jam {{ $session->duration_minutes % 60 }} menit</strong>
                </span>
                <span style="color: #999; margin-left: 10px;">({{ $session->duration_minutes }} menit)</span>
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Catatan</div>
            <div class="detail-value">
                @if($session->note)
                    <div class="note-box">{{ $session->note }}</div>
                @else
                    <span style="color: #999;">Tidak ada catatan</span>
                @endif
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Dibuat</div>
            <div class="detail-value">
                <strong>{{ $session->created_at->format('d M Y, H:i') }}</strong>
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-label">Diperbarui</div>
            <div class="detail-value">
                <strong>{{ $session->updated_at->format('d M Y, H:i') }}</strong>
            </div>
        </div>
    </div>

    <div class="action-buttons">
        <a href="{{ route('study-sessions.edit', $session->id) }}" class="btn btn-edit">✏️ Edit Session</a>
        <form action="{{ route('study-sessions.destroy', $session->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-delete" onclick="return confirm('Yakin hapus session ini?')">
                🗑️ Hapus Session
            </button>
        </form>
    </div>
</div>
@endsection
