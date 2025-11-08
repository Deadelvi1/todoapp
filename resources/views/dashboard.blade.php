@extends('layouts.app')

@section('content')
<div class="relative max-w-[1440px] mx-auto px-6 py-20">
  <!-- Glow Background -->
  <div class="absolute top-[240px] lg:top-[160px] left-0 w-[320px] h-[320px] bg-gradient-to-tr from-indigo-800 to-sky-400 rounded-full blur-[120px] opacity-60"></div>

  <!-- ===== Summary Section ===== -->
  <div class="relative grid grid-cols-1 md:grid-cols-3 gap-8 text-center">

    <!-- Study Goals -->
    <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl shadow-lg p-6 hover:scale-[0.98] transition-all duration-300">
      <div class="flex flex-col items-center">
        <div class="w-12 h-12 bg-gradient-to-tr from-indigo-800 to-sky-400 rounded-xl flex items-center justify-center mb-4">
          <i data-lucide="flag" class="text-white w-6 h-6"></i>
        </div>
        <h5 class="text-lg font-semibold text-black mb-1">Your Study Goals</h5>
        <p class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-tr from-indigo-800 to-sky-400">
          {{ $totalGoals }}
        </p>
      </div>
    </div>

    <!-- Total Study Time -->
    <div class="bg-gradient-to-tr from-indigo-800 to-sky-400 backdrop-blur-xl border border-white/20 rounded-2xl shadow-lg p-6 hover:scale-[0.98] transition-all duration-300">
      <div class="flex flex-col items-center text-white">
        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mb-4">
          <i data-lucide="clock" class="w-6 h-6"></i>
        </div>
        <h5 class="text-lg font-semibold mb-1">Total Study Hours</h5>
        <p class="text-3xl font-bold">{{ round($totalMinutes / 60, 1) }}h</p>
      </div>
    </div>

    <!-- Pending Tasks -->
    <div class="bg-gradient-to-tr from-indigo-100 to-sky-200 border border-white/20 rounded-2xl shadow-lg p-6 hover:scale-[0.98] transition-all duration-300">
      <div class="flex flex-col items-center">
        <div class="w-12 h-12 bg-indigo-400/20 rounded-xl flex items-center justify-center mb-4">
          <i data-lucide="list-checks" class="text-black w-6 h-6"></i>
        </div>
        <h5 class="text-lg font-semibold text-black mb-1">Pending Tasks</h5>
        <p class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-tr from-indigo-800 to-sky-400">
          {{ $pendingTasks }}
        </p>
      </div>
    </div>
  </div>

  <!-- ===== Grid Container ===== -->
  <div class="relative grid grid-cols-2 gap-8 justify-center items-start mt-8">
    
    <!-- ===== Tasks Section ===== -->
    <div class="col-span-2 lg:col-span-1 bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl shadow-lg p-6">
      <h2 class="font-semibold text-xl mb-5 text-black flex items-center gap-2">
        <i data-lucide="check-square" class="text-indigo-800 w-6 h-6"></i> Study Tasks
      </h2>

      <!-- Input Task -->
      <div class="flex gap-2 mb-4">
        <input type="text" placeholder="Add a new task..."
          class="flex-1 bg-white/10 text-black border border-gray-200 hover:border-gray-700 focus:ring-1 focus:ring-sky-400 outline-none rounded-lg px-3 py-2 placeholder-gray-700">
        <a href="{{ route('study_tasks.create') }}" 
           class="bg-gradient-to-tr from-indigo-100 to-sky-300 text-black px-5 py-2 rounded-lg hover:scale-95 transition-all duration-300 flex items-center gap-1">
          <i data-lucide="plus" class="w-5 h-5"></i>
          Task
        </a>
      </div>

      <!-- Task Table -->
      <div class="mt-4 overflow-x-auto">
        @if(isset($recentTasks) && $recentTasks->count() > 0)
          <table class="w-full text-sm text-left">
            <thead class="text-xs text-black/60 uppercase bg-white/10">
              <tr>
                <th class="px-4 py-3">Title</th>
                <th class="px-4 py-3">Priority</th>
                <th class="px-4 py-3">Deadline</th>
                <th class="px-4 py-3 text-right">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($recentTasks as $task)
                <tr class="border-b border-white/10 hover:bg-white/10">
                  <td class="px-4 py-3">
                    <p class="text-black/90 font-medium">{{ $task->title }}</p>
                    <p class="text-xs text-black/50">{{ $task->created_at->format('d M Y') }}</p>
                  </td>
                  <td class="px-4 py-3 capitalize text-black/80">
                    <span class="@if($task->priority === 'high') text-red-600 @elseif($task->priority === 'medium') text-yellow-600 @else text-green-600 @endif font-semibold">
                      {{ $task->priority }}
                    </span>
                  </td>
                  <td class="px-4 py-3 text-black/70">
                    {{ $task->deadline ? \Carbon\Carbon::parse($task->deadline)->format('d M Y') : '-' }}
                  </td>
                  <td class="px-4 py-3 text-right">
                    <div class="flex items-center justify-end gap-3">
                      @if($task->status !== 'completed')
                        <form action="{{ route('study_tasks.complete', $task->id) }}" method="POST" title="Mark as complete">
                          @csrf
                          @method('PATCH')
                          <button type="submit" class="text-green-600 hover:text-green-700">
                            <i data-lucide="check-circle" class="w-5 h-5"></i>
                          </button>
                        </form>
                      @endif

                      <a href="{{ route('study_tasks.edit', $task->id) }}" title="Edit task" class="text-blue-600 hover:text-blue-700">
                        <i data-lucide="pencil-line" class="w-5 h-5"></i>
                      </a>

                      <form action="{{ route('study_tasks.destroy', $task->id) }}" method="POST" title="Delete task" onsubmit="return confirm('Delete this task?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-700">
                          <i data-lucide="trash-2" class="w-5 h-5"></i>
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @else
          <div class="bg-white/5 border border-white/10 rounded-xl p-4 text-black/70 text-sm text-center">
            No pending study tasks yet. Add one above.
          </div>
        @endif
      </div>
    </div>

    <!-- ===== Study Goals Section ===== -->
    <div class="col-span-2 lg:col-span-1 bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl shadow-lg p-6">
      <h2 class="font-semibold text-xl mb-5 text-black flex items-center gap-2">
        <i data-lucide="target" class="text-indigo-800 w-6 h-6"></i> Study Goals
      </h2>

      <div class="flex justify-between items-center mb-4">
        <p class="text-black/70 text-sm">Your active learning targets</p>
        <a href="{{ route('study-goals.create') }}" 
           class="bg-gradient-to-tr from-indigo-100 to-sky-300 text-black px-4 py-2 rounded-lg hover:scale-95 transition-all duration-300 flex items-center gap-1">
          <i data-lucide="plus" class="w-4 h-4"></i> Add Goal
        </a>
      </div>

      <div class="overflow-x-auto">
        @if(isset($goals) && $goals->count() > 0)
          <table class="w-full text-sm text-left">
            <thead class="text-xs text-black/60 uppercase bg-white/10">
              <tr>
                <th class="px-4 py-3">Title</th>
                <th class="px-4 py-3">Target (h)</th>
                <th class="px-4 py-3">Achieved (h)</th>
                <th class="px-4 py-3">Progress</th>
              </tr>
            </thead>
            <tbody>
              @foreach($goals as $goal)
                @php
                  $progress = $goal->target_hours > 0 ? round(($goal->achieved_hours / $goal->target_hours) * 100, 1) : 0;
                @endphp
                <tr class="border-b border-white/10 hover:bg-white/10">
                  <td class="px-4 py-3 text-black/90 font-medium">{{ $goal->title }}</td>
                  <td class="px-4 py-3 text-black/80">{{ $goal->target_hours }}</td>
                  <td class="px-4 py-3 text-black/80">{{ $goal->achieved_hours }}</td>
                  <td class="px-4 py-3">
                    <div class="w-full bg-white/20 rounded-full h-2.5">
                      <div class="bg-gradient-to-r from-indigo-700 to-sky-400 h-2.5 rounded-full" style="width: {{ $progress }}%"></div>
                    </div>
                    <p class="text-xs text-black/60 mt-1">{{ $progress }}%</p>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @else
          <div class="bg-white/5 border border-white/10 rounded-xl p-4 text-black/70 text-sm text-center">
            No study goals yet. Add one to start tracking.
          </div>
        @endif
      </div>
    </div>
  </div>
</div>

<script>
  lucide.createIcons();
</script>
@endsection
