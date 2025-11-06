@extends('layouts.app')

@section('content')
<style>
    /* === Custom Styling for Add Study Goal Page === */
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
        display: block;
    }

    .form-control {
        width: 100%;
        border-radius: 8px;
        padding: 10px 12px;
        border: 1px solid #ced4da;
        transition: all 0.2s ease;
        font-size: 15px;
    }

    .form-control:focus {
        border-color: #1e90ff;
        box-shadow: 0 0 0 0.2rem rgba(30,144,255,0.2);
        outline: none;
    }

    .alert-danger {
        color: #721c24;
        background: #f8d7da;
        border: 1px solid #f5c6cb;
        border-radius: 8px;
        padding: 12px 15px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .alert-danger ul {
        margin: 8px 0 0 0;
        padding-left: 20px;
    }

    .btn-primary {
        background: #1e90ff;
        color: white;
        border: none;
        border-radius: 10px;
        padding: 10px 22px;
        font-weight: 600;
        transition: 0.2s;
        cursor: pointer;
        font-size: 15px;
    }

    .btn-primary:hover {
        background: #007bff;
        transform: scale(1.02);
    }

    .btn-secondary {
        background: #f1f1f1;
        color: #333;
        border: none;
        border-radius: 10px;
        padding: 10px 22px;
        font-weight: 500;
        transition: 0.2s;
        text-decoration: none;
        display: inline-block;
        font-size: 15px;
    }

    .btn-secondary:hover {
        background: #e2e2e2;
        text-decoration: none;
        color: #333;
    }

    .button-group {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 30px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .help-text {
        font-size: 13px;
        color: #6c757d;
        margin-top: 5px;
    }
</style>

<div class="container">
    <div class="form-card">
        <h2 class="title">🎯 Tambah Study Goal</h2>

        @if($errors->any())
            <div class="alert alert-danger">
                <strong>Terjadi kesalahan!</strong>
                <ul>
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('study-goals.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="title" class="form-label">Judul Goal</label>
                <input 
                    type="text" 
                    name="title" 
                    id="title" 
                    class="form-control" 
                    placeholder="Contoh: Belajar Laravel, Persiapan Ujian, dll" 
                    required
                    value="{{ old('title') }}">
                <div class="help-text">Masukkan judul goal belajar kamu</div>
            </div>

            <div class="form-group">
                <label for="target_hours" class="form-label">Target Jam (Opsional)</label>
                <input 
                    type="number" 
                    name="target_hours" 
                    id="target_hours" 
                    class="form-control" 
                    placeholder="Contoh: 10" 
                    min="0"
                    value="{{ old('target_hours') }}">
                <div class="help-text">Target total jam belajar untuk goal ini (bisa dikosongkan)</div>
            </div>

            <div class="button-group">
                <a href="{{ route('study-goals.index') }}" class="btn-secondary">
                    ⬅ Kembali
                </a>
                <button type="submit" class="btn-primary">
                    💾 Simpan Goal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
