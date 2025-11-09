@extends('layouts.app')

@section('content')
@php
    use App\Models\StudyGoal;
    $firstGoal = StudyGoal::where('user_id', session('user.id') ?? null)->first();
@endphp

<div class="relative max-w-[1440px] mx-auto px-6 py-16 font-inter">
        <div class="absolute top-[120px] left-0 w-[300px] h-[300px] bg-gradient-to-tr from-indigo-800 to-sky-400 rounded-full blur-[100px] opacity-40"></div>
  <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-lg shadow-lg p-8">
    <h2 class="font-semibold text-2xl mb-6 text-black flex items-center gap-2 justify-center">
      <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" class="text-indigo-800">
        <g fill="none" stroke="currentColor" stroke-linecap="square" stroke-width="2">
          <path d="M22 12c0 5.523-4.477 10-10 10S2 17.523 2 12S6.477 2 12 2a10 10 0 0 1 3.847.767"/>
          <path d="m22 4.5l-10 10L7.5 10"/>
        </g>
      </svg>
      Study Tasks
    </h2>
<div class="flex justify-between pb-4 px-4">

    @if(isset($tasks) && $tasks->count() > 0)
    <div class="text-black/70 text-sm mb-4 text-center">
        Total: {{ $tasks->count() }} task
    </div>
    @endif
    <a href="{{ route('study_tasks.create') }}"
    class="bg-gradient-to-tr from-indigo-100 to-sky-300 text-black px-4 py-2 rounded-lg hover:scale-95 transition-all duration-300 flex items-center gap-1">
    <i data-lucide="plus" class="w-4 h-4"></i> Task
</a>
</div>

    <div class="overflow-x-auto rounded-lg border border-white/20">
      <table class="w-full text-sm text-left">
        <thead class="text-sm text-white uppercase  bg-gradient-to-tr from-indigo-800 to-sky-400">
          <tr>
            <th class="px-4 py-3">Title</th>
            <th class="px-4 py-3">Description</th>
            <th class="px-4 py-3">Status</th>
            <th class="px-4 py-3">Priority</th>
            <th class="px-4 py-3">Deadline</th>
            <th class="px-4 py-3">Created</th>
            <th class="px-4 py-3 text-center">Action</th>
          </tr>
        </thead>
        <tbody class="text-sm">
          @forelse($tasks ?? [] as $task)
            <tr class="border-b border-gray-200 hover:bg-white/10 transition-all duration-300">
              <td class="px-4 py-3 text-black/90 font-medium">{{ $task->title }}</td>
              <td class="px-4 py-3 text-black/70">{{ Str::limit($task->description ?? '-', 50) }}</td>
              <td class="px-4 py-3">
                @if($task->status == 'completed')
                  <span class="px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-700">Completed</span>
                @elseif($task->status == 'in_progress')
                  <span class="px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-600">In Progress</span>
                @else
                  <span class="px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-700">Pending</span>
                @endif
              </td>
              <td class="px-4 py-3 capitalize text-black/80">
                <span class="@if($task->priority === 'high') text-red-600 @elseif($task->priority === 'medium') text-yellow-600 @else text-green-600 @endif font-semibold">
                  {{ $task->priority }}
                </span>
              </td>
              <td class="px-4 py-3 text-black/70">{{ $task->created_at->format('d M Y, H:i') }}</td>
              <td class="px-4 py-3 text-black/70">{{ $task->deadline ? \Carbon\Carbon::parse($task->deadline)->format('d M Y') : '-' }}</td>
              <td class="px-4 py-3 text-center">
                <div class="flex justify-end pr-16 items-center gap-3">
                    {{-- Complete --}}
                    @if($task->status !== 'completed')
                        <form action="{{ route('study_tasks.complete', $task->id) }}" method="POST" title="Mark as complete">
                          @csrf
                          @method('PATCH')
                          <button type="submit" class="text-green-600 hover:text-green-700 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" class="text-green-600"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.6" d="m5 14l3.233 2.425a1 1 0 0 0 1.374-.167L18 6"/></svg>
                          </button>
                        </form>
                    @endif

                  {{-- Edit --}}
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
          @empty
            <tr>
              <td colspan="7" class="text-center py-8 text-black/70">Belum ada task.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
  lucide.createIcons();
</script>
@endsection
