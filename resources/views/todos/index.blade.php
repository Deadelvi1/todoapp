@extends('layouts.app')

@section('content')
<div class="relative max-w-6xl mx-auto px-6 py-16">
    <!-- Glow Effect -->
    <div class="absolute top-20 left-10 w-[300px] h-[300px] bg-gradient-to-tr from-indigo-700 to-sky-400 rounded-full blur-[120px] opacity-40"></div>

    <div class="relative bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl shadow-lg p-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
            <h1 class="font-semibold text-2xl text-gray-900 flex items-center gap-3">
                <i data-lucide="check-square" class="w-6 h-6 text-indigo-700"></i>
                Daftar Semua Tugas
            </h1>
            <a href="{{ route('todos.create') }}" 
                class="mt-4 sm:mt-0 flex items-center gap-2 px-5 py-2 rounded-xl 
                       bg-gradient-to-tr from-indigo-100 to-sky-300 text-gray-800 font-medium 
                       hover:scale-95 active:scale-90 transition-all duration-200 shadow-sm">
                <i data-lucide="plus-circle" class="w-5 h-5"></i>
                Tambah Tugas Baru
            </a>
        </div>

        @if(session('success'))
            <div class="mb-5 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if($todos->isEmpty())
            <div class="text-center py-16 bg-white/20 backdrop-blur-md border border-white/30 rounded-xl">
                <i data-lucide="clipboard-x" class="w-10 h-10 text-gray-400 mx-auto mb-3"></i>
                <p class="text-gray-600">Anda belum memiliki tugas.</p>
                <a href="{{ route('todos.create') }}" 
                   class="inline-block mt-3 text-indigo-600 hover:underline font-medium">
                   Buat tugas pertama Anda!
                </a>
            </div>
        @else
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($todos as $todo)
                    <div class="bg-white/20 backdrop-blur-lg border border-white/30 
                                rounded-xl p-5 shadow-sm hover:shadow-md 
                                transition-all duration-300 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-3">
                                <h2 class="font-semibold text-lg text-gray-800 {{ $todo->is_done ? 'line-through text-gray-400' : '' }}">
                                    {{ $todo->title }}
                                </h2>
                                <span class="text-xs px-2 py-1 rounded-full
                                    {{ $todo->is_done 
                                        ? 'bg-green-100 text-green-700' 
                                        : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ $todo->is_done ? 'Selesai' : 'Aktif' }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-500 mb-4">Dibuat pada: {{ $todo->created_at->format('d M Y') }}</p>
                        </div>

                        <div class="flex items-center justify-between gap-2">
                            <div class="flex gap-2">
                                @if(!$todo->is_done)
                                <form action="{{ route('todos.complete', $todo->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                        class="flex items-center gap-1 text-xs text-green-700 bg-green-100 hover:bg-green-200 px-3 py-1.5 rounded-lg transition">
                                        <i data-lucide="check" class="w-4 h-4"></i> Selesai
                                    </button>
                                </form>
                                <a href="{{ route('todos.edit', $todo->id) }}" 
                                    class="flex items-center gap-1 text-xs text-blue-700 bg-blue-100 hover:bg-blue-200 px-3 py-1.5 rounded-lg transition">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i> Edit
                                </a>
                                @endif
                            </div>
                            <form action="{{ route('todos.destroy', $todo->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus tugas ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                    class="flex items-center gap-1 text-xs text-red-700 bg-red-100 hover:bg-red-200 px-3 py-1.5 rounded-lg transition">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<!-- Initialize Lucide -->
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();
    });
</script>
@endsection
