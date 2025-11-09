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
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="text-indigo-800"><g fill="none" stroke="currentColor" stroke-linecap="square" stroke-width="1.6"><path d="M22 12c0 5.523-4.477 10-10 10S2 17.523 2 12S6.477 2 12 2a10 10 0 0 1 3.847.767"/><path d="m22 4.5l-10 10L7.5 10"/></g></svg> Study Tasks
      </h2>

    <div class="flex justify-between items-center mb-4">
        <p class="text-black/70 text-sm">Your active study task</p>
        <a href="{{ route('study_tasks.create') }}"
           class="bg-gradient-to-tr from-indigo-100 to-sky-300 text-black px-4 py-2 rounded-lg hover:scale-95 transition-all duration-300 flex items-center gap-1">
          <i data-lucide="plus" class="w-4 h-4"></i> Task
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
                <th class="px-4 py-3 text-center">Action</th>
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
                  <td class=" py-3 items-center text-center flex mx-auto">
                    <div class="flex items-center justify-center mx-auto gap-3">
                      @if($task->status !== 'completed')
                        <form action="{{ route('study_tasks.complete', $task->id) }}" method="POST" title="Mark as complete">
                          @csrf
                          @method('PATCH')
                          <button type="submit" class="text-green-600 hover:text-green-700 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" class="text-green-600"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.6" d="m5 14l3.233 2.425a1 1 0 0 0 1.374-.167L18 6"/></svg>
                          </button>
                        </form>
                      @endif

                      <a href="{{ route('study_tasks.edit', $task->id) }}" title="Edit task" class="text-blue-600 hover:text-blue-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/></g></svg>
                      </a>

                      <form action="{{ route('study_tasks.destroy', $task->id) }}" method="POST" title="Delete task" onsubmit="return confirm('Delete cthis task?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-700 flex items-center">
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.6" d="m19.5 5.5l-.62 10.025c-.158 2.561-.237 3.842-.88 4.763a4 4 0 0 1-1.2 1.128c-.957.584-2.24.584-4.806.584c-2.57 0-3.855 0-4.814-.585a4 4 0 0 1-1.2-1.13c-.642-.922-.72-2.205-.874-4.77L4.5 5.5M3 5.5h18m-4.944 0l-.683-1.408c-.453-.936-.68-1.403-1.071-1.695a2 2 0 0 0-.275-.172C13.594 2 13.074 2 12.035 2c-1.066 0-1.599 0-2.04.234a2 2 0 0 0-.278.18c-.395.303-.616.788-1.058 1.757L8.053 5.5"/></svg>
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
                           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="text-indigo-800">
                        <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6">
                            <path d="M10.66 10.66A1.9 1.9 0 0 0 10.1 12a1.9 1.9 0 0 0 1.9 1.9a1.9 1.9 0 0 0 1.34-.56"/>
                            <path d="M12 6.3a5.7 5.7 0 1 0 5.7 5.7"/>
                            <path d="M12 2.5a9.5 9.5 0 1 0 9.5 9.5m-5.975-3.524L12.95 11.05"/>
                            <path d="M20.94 5.844L17.7 6.3l.456-3.24a.19.19 0 0 0-.313-.161l-2.148 2.137a1.9 1.9 0 0 0-.513 1.72l.342 1.72l1.72.341a1.9 1.9 0 0 0 1.72-.513L21.1 6.157a.19.19 0 0 0-.162-.313"/>
                        </g>
                    </svg></i> Study Goals
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
