@extends('layouts.app')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    body { font-family: 'Poppins', sans-serif; }
</style>

<div class="relative max-w-[1440px] mx-auto px-6 py-20">
    <!-- background gradient -->
    <div class="absolute top-[120px] left-0 w-[350px] h-[350px] bg-gradient-to-tr from-indigo-700 to-sky-400 rounded-full blur-[120px] opacity-30"></div>
    <div class="absolute bottom-[80px] right-0 w-[300px] h-[300px] bg-gradient-to-bl from-pink-300 to-purple-400 rounded-full blur-[100px] opacity-30"></div>

    <div class="relative bg-white/30 backdrop-blur-2xl border border-white/40 rounded-2xl shadow-2xl p-10">
        <div class="text-center mb-10">
            <h1 class="text-3xl font-semibold text-gray-800 mb-2 flex items-center justify-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" class="text-indigo-700">
                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6">
                        <path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2S4 3 4 3v12z"/>
                        <path d="M4 22v-7"/>
                    </g>
                </svg>
                Study Session History
            </h1>
            <p class="text-gray-600">📘 {{ $goal->title }}</p>
            <p class="text-sm text-gray-700 mt-2">
                <strong>Target:</strong> {{ $goal->target_hours }} jam |
                <strong>Total Selesai:</strong> {{ $goal->achieved_hours }} jam
            </p>
        </div>

        <div class="overflow-x-auto rounded-2xl border border-gray-200 shadow-lg bg-white/80 backdrop-blur-xl">
            <table class="w-full text-sm text-left text-gray-700">
                <thead class="bg-gradient-to-tr from-indigo-100 to-sky-100 text-indigo-700 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4 text-center">No</th>
                        <th class="px-6 py-4 text-center">Durasi (menit)</th>
                        <th class="px-6 py-4 text-center">Catatan</th>
                        <th class="px-6 py-4 text-center">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($goal->studySessions as $index => $session)
                    <tr class="border-b border-gray-200 hover:bg-indigo-50/50 transition-all">
                        <td class="px-6 py-3 text-center font-medium text-gray-800">{{ $index + 1 }}</td>
                        <td class="px-6 py-3 text-center">{{ $session->duration_minutes }}</td>
                        <td class="px-6 py-3 text-center">{{ $session->note ?? '-' }}</td>
                        <td class="px-6 py-3 text-center text-gray-600">{{ $session->created_at->format('d M Y, H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-12 text-gray-500">
                            Belum ada sesi belajar tercatat 📖
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('study-goals.index') }}" 
               class="inline-block bg-gradient-to-tr from-indigo-300 to-sky-300 text-gray-800 px-6 py-2.5 rounded-xl hover:scale-95 transition-all duration-300 font-medium shadow-sm">
               ⬅ Kembali ke Daftar Goal
            </a>
        </div>
    </div>
</div>
@endsection
