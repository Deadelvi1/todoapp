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

    <div class="relative bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl shadow-lg p-6 sm:p-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <h1 class="font-semibold text-2xl text-black flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" class="text-indigo-800">
                    <g fill="none" stroke="currentColor" stroke-linecap="square" stroke-width="1.6">
                        <path d="M22 12c0 5.523-4.477 10-10 10S2 17.523 2 12S6.477 2 12 2a10 10 0 0 1 3.847.767"/>
                        <path d="m22 4.5l-10 10L7.5 10"/>
                    </g>
                </svg>
                Daftar Semua Tugas
            </h1>
            <a href="{{ route('todos.create') }}" class="mt-4 sm:mt-0 bg-gradient-to-tr from-indigo-100 to-sky-300 text-black px-5 py-2 rounded-lg hover:scale-95 transition-all duration-300 flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M18 12h-6m0 0H6m6 0V6m0 6v6"/>
                </svg>
                Tambah Tugas Baru
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
            <table class="w-full text-sm text-left bg-white">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">Tugas</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Tanggal Dibuat</th>
                        <th scope="col" class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($todos as $todo)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900 {{ $todo->is_done ? 'line-through text-gray-400' : '' }}">
                            {{ $todo->title }}
                        </td>
                        <td class="px-6 py-4">
                            @if($todo->is_done)
                                <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full">Selesai</span>
                            @else
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full">Aktif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $todo->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                @if(!$todo->is_done)
                                <form action="{{ route('todos.complete', $todo->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-xs text-green-700 bg-green-100 hover:bg-green-200 px-2 py-1 rounded-md transition-colors">Selesai</button>
                                </form>
                                <a href="{{ route('todos.edit', $todo->id) }}" class="text-xs text-blue-700 bg-blue-100 hover:bg-blue-200 px-2 py-1 rounded-md transition-colors">Edit</a>
                                @endif
                                <form action="{{ route('todos.destroy', $todo->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus tugas ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs text-red-700 bg-red-100 hover:bg-red-200 px-2 py-1 rounded-md transition-colors">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-10 text-gray-500">
                            Anda belum memiliki tugas. <a href="{{ route('todos.create') }}" class="text-indigo-600 hover:underline">Buat tugas pertama Anda!</a>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
