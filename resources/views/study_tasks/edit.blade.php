@extends('layouts.app')

@section('content')
<style>
    body { background-color: #f6f8fb; }
    .form-card { max-width: 650px; margin: 60px auto; background: #ffffff; border-radius: 16px; box-shadow: 0 4px 16px rgba(0,0,0,0.08); padding: 35px 45px; animation: fadeIn 0.4s ease; }
    @keyframes fadeIn { from {opacity: 0; transform: translateY(10px);} to {opacity: 1; transform: translateY(0);} }
    h2.title { font-weight: 700; font-size: 1.9rem; color: #1d3557; text-align: center; margin-bottom: 30px; }
    .form-label { font-weight: 600; color: #333; margin-bottom: 6px; }
    .form-control, .form-select { border-radius: 8px; padding: 10px 12px; border: 1px solid #ced4da; transition: all 0.2s ease; width: 100%; }
    .form-control:focus, .form-select:focus { border-color: #1e90ff; box-shadow: 0 0 0 0.2rem rgba(30,144,255,0.2); outline: none; }
    .btn-primary { background: #1e90ff; color: white; border: none; border-radius: 10px; padding: 10px 22px; font-weight: 600; transition: 0.2s; cursor: pointer; }
    .btn-primary:hover { background: #007bff; transform: scale(1.02); }
    .btn-secondary { background: #f1f1f1; color: #333; border: none; border-radius: 10px; padding: 10px 22px; font-weight: 500; transition: 0.2s; text-decoration: none; display: inline-block; }
    .btn-secondary:hover { background: #e2e2e2; text-decoration: none; color: #333; }
    .alert-danger { color: #721c24; background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 8px; padding: 12px 15px; margin-bottom: 20px; font-size: 14px; }
    .alert-danger ul { margin: 8px 0 0 0; padding-left: 20px; }
    .form-group { margin-bottom: 20px; }
</style>

<div class="container">
    <div class="form-card">
        <h2 class="title">✏️ Edit Study Task</h2>

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

        <form action="{{ route('study-tasks.update', $task->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title" class="form-label">Judul Task</label>
                <input type="text" name="title" id="title" class="form-control" required value="{{ old('title', $task->title) }}">
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea name="description" id="description" rows="4" class="form-control">{{ old('description', $task->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="priority" class="form-label">Prioritas</label>
                <select name="priority" id="priority" class="form-select">
                    <option value="low" {{ old('priority', $task->priority) == 'low' ? 'selected' : '' }}>Rendah</option>
                    <option value="medium" {{ old('priority', $task->priority) == 'medium' ? 'selected' : '' }}>Sedang</option>
                    <option value="high" {{ old('priority', $task->priority) == 'high' ? 'selected' : '' }}>Tinggi</option>
                </select>
            </div>

            <div class="form-group">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="pending" {{ old('status', $task->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in_progress" {{ old('status', $task->status) == 'in_progress' ? 'selected' : '' }}>Sedang Dikerjakan</option>
                    <option value="completed" {{ old('status', $task->status) == 'completed' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <div class="form-group">
                <label for="deadline" class="form-label">Deadline</label>
                <input type="date" name="deadline" id="deadline" class="form-control" value="{{ old('deadline', $task->deadline ? \Carbon\Carbon::parse($task->deadline)->format('Y-m-d') : '') }}">
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 30px;">
                <a href="{{ route('study-tasks.index') }}" class="btn-secondary">⬅ Kembali</a>
                <button type="submit" class="btn-primary">💾 Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection

