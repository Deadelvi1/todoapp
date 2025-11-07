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
                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6">
                        <path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2S4 3 4 3v12z"/>
                        <path d="M4 22v-7"/>
                    </g>
                </svg>
                Daftar Study Goals
            </h1>
            <a href="{{ route('study-goals.create') }}" class="mt-4 sm:mt-0 bg-gradient-to-tr from-indigo-100 to-sky-300 text-black px-5 py-2 rounded-lg hover:scale-95 transition-all duration-300 flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M18 12h-6m0 0H6m6 0V6m0 6v6"/>
                </svg>
                Tambah Goal Baru
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
                        <th scope="col" class="px-6 py-3">Goal</th>
                        <th scope="col" class="px-6 py-3">Target</th>
                        <th scope="col" class="px-6 py-3">Tercapai</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($goals as $g)
                    @php
                        $minutes = $g->study_sessions_sum_duration_minutes ?? 0;
                        $hours = intdiv($minutes, 60);
                        $remainingMinutes = $minutes % 60;
                    @endphp
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $g->title }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $g->target_hours ? $g->target_hours . ' jam' : 'N/A' }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $hours }} jam {{ $remainingMinutes }} menit</td>
                        <td class="px-6 py-4">
                            @if($g->status == 'completed')
                                <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full">Selesai</span>
                            @else
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full">Berjalan</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('study-goals.edit', $g) }}" class="text-xs text-blue-700 bg-blue-100 hover:bg-blue-200 px-2 py-1 rounded-md transition-colors">Edit</a>
                            <form action="{{ route('study-goals.destroy', $g) }}" method="POST" class="inline-block" onsubmit="return confirm('Anda yakin ingin menghapus goal ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-red-700 bg-red-100 hover:bg-red-200 px-2 py-1 rounded-md transition-colors">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-10 text-gray-500">
                            Anda belum memiliki goal. <a href="{{ route('study-goals.create') }}" class="text-indigo-600 hover:underline">Buat goal pertama Anda!</a>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
