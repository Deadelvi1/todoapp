@extends('layouts.app')

@section('content')
<style>
    /* === Custom Styling for Add Study Session Page === */
    body {
        background-color: #f6f8fb;
    }

    .form-card {
        max-width: 650px;
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

    h2.title {
        font-weight: 700;
        font-size: 1.9rem;
        color: #1d3557;
        text-align: center;
        margin-bottom: 30px;
    }

    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 6px;
    }

    .form-control, .form-select {
        border-radius: 8px;
        padding: 10px 12px;
        border: 1px solid #ced4da;
        transition: all 0.2s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #1e90ff;
        box-shadow: 0 0 0 0.2rem rgba(30,144,255,0.2);
    }

    .btn-primary {
        background: #1e90ff;
        border: none;
        border-radius: 10px;
        padding: 10px 22px;
        font-weight: 600;
        transition: 0.2s;
    }

    .btn-primary:hover {
        background: #007bff;
        transform: scale(1.02);
    }

    .btn-secondary {
        background: #f1f1f1;
        color: #333;
        border-radius: 10px;
        font-weight: 500;
        transition: 0.2s;
    }

    .btn-secondary:hover {
        background: #e2e2e2;
    }
</style>

<div class="container">
    <div class="form-card">
        <h2 class="title">📘 Tambah Study Session</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Terjadi kesalahan!</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('study-sessions.store') }}" method="POST">
            @csrf

            {{-- Pilih Goal --}}
            <div class="mb-3">
                <label for="study_goal_id" class="form-label">Goal (Opsional)</label>
                <select name="study_goal_id" id="study_goal_id" class="form-select">
                    <option value="">-- Pilih Goal --</option>
                    @foreach($goals as $goal)
                        <option value="{{ $goal->id }}">{{ $goal->title }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Durasi --}}
            <div class="mb-3">
                <label for="duration_minutes" class="form-label">Durasi (menit)</label>
                <input 
                    type="number" 
                    name="duration_minutes" 
                    id="duration_minutes" 
                    class="form-control" 
                    placeholder="Contoh: 90" 
                    min="1" 
                    required>
            </div>

            {{-- Catatan --}}
            <div class="mb-3">
                <label for="note" class="form-label">Catatan</label>
                <textarea 
                    name="note" 
                    id="note" 
                    rows="3" 
                    class="form-control" 
                    placeholder="Tulis catatan belajar kamu di sini..."></textarea>
            </div>

            {{-- Tombol --}}
            <div class="d-flex justify-content-between align-items-center mt-4">
                <a href="{{ route('study-sessions.index') }}" class="btn btn-secondary px-4">
                    ⬅ Kembali
                </a>
                <button type="submit" class="btn btn-primary px-4">
                    💾 Simpan Session
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
