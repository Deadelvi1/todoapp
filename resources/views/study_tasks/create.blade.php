@extends('layouts.app')

@section('content')
<div class=" flex items-center justify-center py-12 px-4">
      <!-- Glow Background -->
  <div class="absolute top-[240px] lg:top-[240px] left-0 lg:left-[80px] w-[320px] h-[320px] bg-gradient-to-tr from-indigo-800 to-sky-400 rounded-full blur-[120px] opacity-60"></div>
    <div class="w-full max-w-2xl bg-white rounded-2xl shadow-lg p-10 animate-fadeIn">
        <div class="flex items-center justify-center gap-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" class="text-indigo-800" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="square" stroke-width="1.6" d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2a10 10 0 0 1 3.847.767M22 4.5l-10 10L7.5 10M19 16v3m0 0v3m0-3h-3m3 0h3"/></svg>
            <h2 class="text-3xl font-bold text-center text-[#1d3557] ">
                Tambah Study Task</h2>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-lg border border-red-300 bg-red-100 text-red-800 p-4 text-sm">
                <strong class="block font-semibold mb-1">Terjadi kesalahan!</strong>
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('study_tasks.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Judul Task --}}
            <div>
                <label for="title" class="block text-sm font-semibold text-gray-800 mb-1">Judul Task</label>
                <input
                    type="text"
                    name="title"
                    id="title"
                    placeholder="Contoh: Belajar Laravel, Mengerjakan Tugas, dll"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                    required
                    value="{{ old('title') }}">
                <p class="text-xs text-gray-500 mt-1">Masukkan judul task yang akan dikerjakan</p>
            </div>

            {{-- Deskripsi --}}
            <div>
                <label for="description" class="block text-sm font-semibold text-gray-800 mb-1">Deskripsi (Opsional)</label>
                <textarea
                    name="description"
                    id="description"
                    rows="4"
                    placeholder="Tulis deskripsi detail tentang task ini..."
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">{{ old('description') }}</textarea>
            </div>

            {{-- Prioritas --}}
            <div>
                <label for="priority" class="block text-sm font-semibold text-gray-800 mb-1">Prioritas</label>
                <select name="priority" id="priority" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Rendah</option>
                    <option value="medium" {{ old('priority') == 'medium' || !old('priority') ? 'selected' : '' }}>Sedang</option>
                    <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>Tinggi</option>
                </select>
            </div>

            {{-- Status --}}
            <div>
                <label for="status" class="block text-sm font-semibold text-gray-800 mb-1">Status</label>
                <select name="status" id="status" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    <option value="pending" {{ old('status') == 'pending' || !old('status') ? 'selected' : '' }}>Pending</option>
                    <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>Sedang Dikerjakan</option>
                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            {{-- Deadline --}}
            <div>
                <label for="deadline" class="block text-sm font-semibold text-gray-800 mb-1">Deadline (Opsional)</label>
                <input
                    type="date"
                    name="deadline"
                    id="deadline"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                    value="{{ old('deadline') }}">
                <p class="text-xs text-gray-500 mt-1">Pilih tanggal deadline untuk task ini</p>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-end items-center pt-4 gap-4">
                <a href="{{ route('study_tasks.index') }}" class="bg-gray-100 text-gray-700 font-medium px-5 py-2.5 rounded-lg hover:bg-gray-200 transition flex gap-1 items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 512 512"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="40" d="M244 400L100 256l144-144M120 256h292"/></svg>
                Kembali
                </a>
                <button type="submit" class="bg-blue-500 text-white font-semibold px-5 py-2.5 rounded-lg hover:bg-blue-600 transition transform hover:scale-105 flex gap-1 items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-width="1.6"><path d="M16 21v-2c0-1.886 0-2.828-.586-3.414S13.886 15 12 15h-1c-1.886 0-2.828 0-3.414.586S7 17.114 7 19v2"/><path stroke-linecap="round" d="M7 8h5"/><path d="M3 9c0-2.828 0-4.243.879-5.121C4.757 3 6.172 3 9 3h7.172c.408 0 .613 0 .796.076s.329.22.618.51l2.828 2.828c.29.29.434.434.51.618c.076.183.076.388.076.796V15c0 2.828 0 4.243-.879 5.121C19.243 21 17.828 21 15 21H9c-2.828 0-4.243 0-5.121-.879C3 19.243 3 17.828 3 15z"/></g></svg> Simpan Task
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Animasi sederhana --}}
<style>
@keyframes fadeIn {
    from {opacity: 0; transform: translateY(10px);}
    to {opacity: 1; transform: translateY(0);}
}
.animate-fadeIn {
    animation: fadeIn 0.4s ease-in-out;
}
</style>
@endsection
