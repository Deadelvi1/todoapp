@extends('layouts.app')

@section('content')
<div class="relative grid grid-cols-4 gap-8 justify-center items-start mt-8">
    <!-- ===== Tasks Section ===== -->
    <div class="col-span-4 lg:col-span-3 bg-gradient-to-tr from-white/10 to-sky-400/30 backdrop-blur-xl border border-white/20 rounded-2xl shadow-lg p-6">
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
          class="flex-1 bg-white/90 text-black border border-gray-200 hover:border-gray-700 focus:ring-1 focus:ring-sky-400 outline-none rounded-lg px-3 py-2 placeholder-gray-700"
        >
        <a href="{{ route('todos.create') }}" class="bg-white/90 backdrop-blur-xl text-black px-5 py-2 rounded-lg hover:scale-95 transition-all duration-300 flex items-center gap-1">
          <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24">
            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M18 12h-6m0 0H6m6 0V6m0 6v6"/>
          </svg>
          Task
        </a>
      </div>

      <!-- Empty State -->
      <p class="text-red-400 text-sm mb-2">Not Found</p>
      <div class="bg-white/5 border border-white/10 rounded-xl p-4 text-black/70 text-sm text-center">
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        No tasks yet. Add your first task above.
      </div>
    </div>

    <!-- ===== Tasks Section ===== -->
    <div class="col-span-4 lg:col-span-1 bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl shadow-lg p-6">
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
    </div>
@endsection
