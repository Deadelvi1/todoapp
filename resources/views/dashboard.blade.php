@extends('layouts.app')

@section('content')
<div class="relative max-w-[1440px] mx-auto px-6 py-20">
  <!-- Glow Background -->
  <div class="absolute top-[240px] lg:top-[160px] left-0 w-[320px] h-[320px] bg-gradient-to-tr from-indigo-800 to-sky-400 rounded-full blur-[120px] opacity-60"></div>

  <div class="relative max-w-[1440px] mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 text-center">

    <!-- Total Study Goals -->
    <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl shadow-lg p-6 hover:scale-[0.98] transition-all duration-300">
      <div class="flex flex-col items-center">
        <div class="w-12 h-12 bg-gradient-to-tr from-indigo-800 to-sky-400 rounded-xl flex items-center justify-center mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="none" stroke="white" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-flag">
            <path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2S4 3 4 3v12Z" />
            <path d="M4 22v-7" />
          </svg>
        </div>
        <h5 class="text-lg font-semibold text-black mb-1">Total Study Goals</h5>
        <p class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-tr from-indigo-800 to-sky-400">
          {{ $totalGoals }}
        </p>
      </div>
    </div>

    <!-- Total Study Time -->
    <div class="bg-gradient-to-tr from-indigo-800 to-sky-400 backdrop-blur-xl border border-white/20 rounded-2xl shadow-lg p-6 hover:scale-[0.98] transition-all duration-300">
      <div class="flex flex-col items-center text-white">
        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="none" stroke="white" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock">
            <circle cx="12" cy="12" r="10"/>
            <polyline points="12 6 12 12 16 14"/>
          </svg>
        </div>
        <h5 class="text-lg font-semibold mb-1">Total Study Time</h5>
        <p class="text-3xl font-bold">{{ round($totalMinutes / 60, 1) }}h</p>
      </div>
    </div>

    <!-- Active Tasks -->
    <div class="bg-gradient-to-tr from-indigo-100 to-sky-200 border border-white/20 rounded-2xl shadow-lg p-6 hover:scale-[0.98] transition-all duration-300">
      <div class="flex flex-col items-center">
        <div class="w-12 h-12 bg-indigo-400/20 rounded-xl flex items-center justify-center mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="none" stroke="black" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-list-checks">
            <path d="m3 17 2 2 4-4M3 7l2 2 4-4m5 2h8M14 12h8m-8 5h8"/>
          </svg>
        </div>
        <h5 class="text-lg font-semibold text-black mb-1">Active Tasks</h5>
        <p class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-tr from-indigo-800 to-sky-400">
          {{ $activeTodos }}
        </p>
      </div>
    </div>

  </div>

  <!-- Grid Container -->
  <div class="relative grid grid-cols-2 gap-8 justify-center items-start mt-8">
    <!-- ===== Tasks Section ===== -->
    <div class="col-span-2 lg:col-span-1 bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl shadow-lg p-6">
      <h2 class="font-semibold text-xl mb-5 text-black flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
             viewBox="0 0 24 24" class="text-indigo-800">
          <g fill="none" stroke="currentColor" stroke-linecap="square" stroke-width="1.6">
            <path d="M22 12c0 5.523-4.477 10-10 10S2 17.523 2 12S6.477 2 12 2a10 10 0 0 1 3.847.767"/>
            <path d="m22 4.5l-10 10L7.5 10"/>
          </g>
        </svg>
        Tasks
      </h2>

      <!-- Input Task -->
      <div class="flex gap-2 mb-4">
        <input
          type="text"
          placeholder="Add a new task..."
          class="flex-1 bg-white/10 text-black border border-gray-200 hover:border-gray-700 focus:ring-1 focus:ring-sky-400 outline-none rounded-lg px-3 py-2 placeholder-gray-700"
        >
        <a href="{{ route('todos.create') }}" class="bg-gradient-to-tr from-indigo-100 to-sky-300 text-black px-5 py-2 rounded-lg hover:scale-95 transition-all duration-300 flex items-center gap-1">
          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24">
            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M18 12h-6m0 0H6m6 0V6m0 6v6"/>
          </svg>
          Task
        </a>
      </div>

      <!-- Empty State -->
      <p class="text-red-400 text-sm mb-2">Not Found</p>
      <div class="bg-white/5 border border-white/10 rounded-xl p-4 text-black/70 text-sm text-center">
        No tasks yet. Add your first task above.
      </div>
    </div>

    <!-- ===== Goals & Timer Section ===== -->
    <div class="col-span-2 lg:col-span-1 bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl shadow-lg p-6">
      <h2 class="font-semibold text-xl mb-5 text-black flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" class="text-indigo-800">
          <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6">
            <path d="M10.66 10.66A1.9 1.9 0 0 0 10.1 12a1.9 1.9 0 0 0 1.9 1.9a1.9 1.9 0 0 0 1.34-.56"/>
            <path d="M12 6.3a5.7 5.7 0 1 0 5.7 5.7"/>
            <path d="M12 2.5a9.5 9.5 0 1 0 9.5 9.5m-5.975-3.524L12.95 11.05"/>
            <path d="M20.94 5.844L17.7 6.3l.456-3.24a.19.19 0 0 0-.313-.161l-2.148 2.137a1.9 1.9 0 0 0-.513 1.72l.342 1.72l1.72.341a1.9 1.9 0 0 0 1.72-.513L21.1 6.157a.19.19 0 0 0-.162-.313"/>
          </g>
        </svg>
        Goals & Timer
      </h2>

      <!-- Input Goal -->
      <div class="flex flex-col sm:flex-row gap-2 mb-4">
        <input
          type="text"
          placeholder="Add a goal..."
          class="flex-1 bg-white/10 text-black border border-gray-200 hover:border-gray-700 focus:ring-1 focus:ring-sky-400 outline-none rounded-lg px-3 py-2 placeholder-gray-700"
        >
        <input
          type="number"
          value="25"
          class="w-full sm:w-24 bg-white/10 text-black border border-gray-200 hover:border-gray-700 focus:ring-1 focus:ring-sky-400 outline-none rounded-lg px-3 py-2 block"
        >
        <button class="hover:scale-95 transition-all duration-300 bg-gradient-to-tr from-indigo-100 to-sky-300 text-black px-4 py-2 rounded-lg items-center justify-center gap-1 flex">
          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24">
            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M18 12h-6m0 0H6m6 0V6m0 6v6"/>
          </svg>
          Goal
        </button>
      </div>

      <!-- Empty State -->
      <p class="text-red-400 text-sm mb-2">Not Found</p>
      <div class="bg-white/5 border border-white/10 rounded-xl p-4 text-black/70 text-sm text-center mb-8">
        No goals yet. Create one above.
      </div>

      <!-- Timer -->
      <div class="text-center">
        <h3 class="text-5xl font-bold mb-1 text-black tracking-wider">00:00</h3>
        <p class="text-black/60 mb-6 text-sm">Ready</p>

        <div class="flex flex-wrap justify-center gap-3">
          <button class="bg-black text-white px-5 py-2 rounded-lg hover:bg-gray-900 hover:scale-95 transition-all duration-300">Start Timer</button>
          <button class="bg-white/10 text-black px-5 py-2 rounded-xl hover:bg-white/20 transition-all">Stop</button>
          <button class="flex items-center gap-2 bg-white/10 text-black px-5 py-2 rounded-xl hover:bg-white/20 transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14m0 0V10m0 4L9 10m0 4V10m0 4L3 10m0 4V10" />
            </svg>
            Test Sound
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
