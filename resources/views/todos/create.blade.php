@extends('layouts.app')

@section('content')
{{-- Menambahkan script dan style yang diperlukan --}}
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    body { font-family: 'Poppins', sans-serif; }
</style>

<div class="relative max-w-[1440px] mx-auto px-6 py-20">
    <!-- Glow Background -->
    <div class="absolute top-[100px] left-0 w-[280px] h-[280px] bg-gradient-to-tr from-indigo-800 to-sky-400 rounded-full blur-[100px] opacity-50"></div>

    <div class="relative bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl shadow-lg p-6 sm:p-8 max-w-lg mx-auto">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <h1 class="font-semibold text-2xl text-black flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" class="text-indigo-800">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M12 5v14m-7-7h14"/>
                </svg>
                Buat Tugas Baru
            </h1>
        </div>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('todos.store') }}" class="space-y-4">
            @csrf

            <div>
                <label for="title" class="text-sm font-medium text-gray-700">Judul Tugas</label>
                <input id="title" name="title" type="text" autocomplete="off" required
                       class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                       value="{{ old('title') }}"
                       placeholder="Contoh: Belajar Laravel">
            </div>

            <div>
                <label for="description" class="text-sm font-medium text-gray-700">Deskripsi (Opsional)</label>
                <textarea id="description" name="description" rows="4"
                          class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                          placeholder="Detail tugas atau catatan tambahan">{{ old('description') }}</textarea>
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <a href="{{ route('todos.index') }}" class="flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Batal
                </a>
                <button type="submit"
                        class="flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Simpan Tugas
                </button>
            </div>
        </form>
    </div>
@endsection
