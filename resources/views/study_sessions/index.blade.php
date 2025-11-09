@extends('layouts.app')

@section('content')
<div class="relative max-w-[1440px] mx-auto px-6 py-16 font-inter">
  <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-xl shadow-lg p-8">
    <h2 class="font-semibold text-2xl mb-6 text-black flex items-center gap-2 justify-center">
      <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" class="text-indigo-800">
        <g fill="none" stroke="currentColor" stroke-linecap="square" stroke-width="2">
          <path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2S4 3 4 3v12z"/>
          <path d="M4 22v-7"/>
        </g>
      </svg>
      Study Time Tracker
    </h2>

    <div class="flex justify-between pb-4 px-4">
      @if(isset($goals) && $goals->count() > 0)
      <div class="text-black/70 text-sm mb-4 text-center">
        Total: {{ $goals->count() }} goal
      </div>
      @endif

      <a href="{{ route('study-goals.create') }}"
         class="bg-gradient-to-tr from-indigo-100 to-sky-300 text-black px-4 py-2 rounded-lg hover:scale-95 transition-all duration-300 flex items-center gap-1 border border-white/30 shadow-lg">
        <i data-lucide="plus" class="w-4 h-4"></i> Goal
      </a>
    </div>

    <div class="overflow-x-auto rounded-lg border border-white/20 shadow-lg">
      <table class="w-full text-sm text-left">
        <thead class="text-sm text-white uppercase bg-gradient-to-tr from-indigo-800 to-sky-400">
          <tr>
            <th class="px-4 py-3">Goal</th>
            <th class="px-4 py-3 text-center">Target (Jam)</th>
            <th class="px-4 py-3 text-center">Progress</th>
            <th class="px-4 py-3 text-center">Timer</th>
            <th class="px-4 py-3 text-center">Aksi</th>
          </tr>
        </thead>
        <tbody class="text-sm">
          @forelse($goals ?? [] as $g)
          @php
              $minutes = $g->study_sessions_sum_duration_minutes ?? 0;
              $hours = round($minutes / 60, 2);
              $progress = $g->target_hours > 0 ? min(($hours / $g->target_hours) * 100, 100) : 0;
          @endphp
          <tr class="border-b border-gray-200 hover:bg-white/10 transition-all duration-300">
            <td class="px-4 py-3 text-black/90 font-medium">{{ $g->title }}</td>
            <td class="px-4 py-3 text-center text-black/80">{{ $g->target_hours }}</td>
            <td class="px-4 py-3 text-center">
              <div class="w-full bg-gray-200 rounded-full h-2.5 border border-gray-300">
                <div class="bg-indigo-500 h-2.5 rounded-full transition-all duration-300" style="width: {{ $progress }}%"></div>
              </div>
              <p class="text-xs text-black/60 mt-1">{{ $hours }} jam ({{ number_format($progress, 0) }}%)</p>
            </td>
            <td class="px-4 py-3 text-center">
              <span id="timer-{{ $g->id }}" class="font-mono text-lg text-black/90">00:00:00</span>
            </td>
            <td class="px-4 py-3 text-center">
              <div class="flex justify-center items-center gap-2">
                <button onclick="startTimer('{{ $g->id }}')" class="bg-green-100 text-green-700 px-3 py-1 rounded-lg hover:bg-green-200 border border-green-300 shadow-md text-xs">Start</button>
                <button onclick="pauseTimer('{{ $g->id }}')" class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-lg hover:bg-yellow-200 border border-yellow-300 shadow-md text-xs">Pause</button>
                <button onclick="openFinishModal('{{ $g->id }}')" class="bg-blue-100 text-blue-700 px-3 py-1 rounded-lg hover:bg-blue-200 border border-blue-300 shadow-md text-xs">Finish</button>
                <a href="{{ route('study-goals.edit', $g->id) }}" class="bg-purple-100 text-purple-700 px-3 py-1 rounded-lg hover:bg-purple-200 border border-purple-300 shadow-md text-xs">Edit</a>
                <form action="{{ route('study-goals.destroy', $g->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus goal ini?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="bg-red-100 text-red-700 px-3 py-1 rounded-lg hover:bg-red-200 border border-red-300 shadow-md text-xs">Delete</button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="text-center py-8 text-black/70">
              Belum ada goal yang dibuat.
              <a href="{{ route('study-goals.create') }}" class="text-indigo-700 hover:underline font-medium">Buat goal pertama Anda!</a>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- MODAL KONFIRMASI FINISH -->
<div id="finishModal" class="fixed inset-0 hidden items-center justify-center bg-black/40 z-50">
  <div class="bg-white rounded-xl shadow-lg p-8 text-center w-[90%] max-w-sm border border-gray-200">
    <h2 class="text-lg font-semibold text-black mb-4">Apakah kamu yakin ingin menyelesaikan sesi ini?</h2>
    <div class="flex justify-center gap-4">
      <button id="confirmFinish" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition shadow-md">Ya</button>
      <button id="cancelFinish" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 transition shadow-md">Tidak</button>
    </div>
  </div>
</div>

<script>
  lucide.createIcons();

  let activeGoal = null;
  let timerInterval = null;
  let startTime = null;
  let elapsedSeconds = 0;
  let pendingFinishGoal = null;

  window.addEventListener("load", () => {
    const saved = JSON.parse(localStorage.getItem("studyTimer"));
    if (saved && saved.isRunning) {
      activeGoal = saved.goalId;
      startTime = new Date(saved.startTime);
      elapsedSeconds = Math.floor((Date.now() - startTime.getTime()) / 1000) + saved.elapsedSeconds;
      resumeTimer(activeGoal);
    }
  });

  function updateDisplay(goalId) {
    const hrs = Math.floor(elapsedSeconds / 3600);
    const mins = Math.floor((elapsedSeconds % 3600) / 60);
    const secs = elapsedSeconds % 60;
    document.getElementById(`timer-${goalId}`).textContent =
      `${hrs.toString().padStart(2,'0')}:${mins.toString().padStart(2,'0')}:${secs.toString().padStart(2,'0')}`;
  }

  function startTimer(goalId) {
    if (activeGoal && activeGoal !== goalId) {
      alert("Timer lain masih berjalan. Selesaikan dulu sebelum mulai yang baru.");
      return;
    }

    if (!activeGoal) {
      activeGoal = goalId;
      startTime = new Date();
      elapsedSeconds = 0;
      saveState(true);
    }

    if (timerInterval) clearInterval(timerInterval);
    timerInterval = setInterval(() => {
      elapsedSeconds++;
      updateDisplay(goalId);
      saveState(true);
    }, 1000);
  }

  function pauseTimer(goalId) {
    if (goalId !== activeGoal) return;
    clearInterval(timerInterval);
    timerInterval = null;
    saveState(false);
  }

  function resumeTimer(goalId) {
    if (timerInterval) clearInterval(timerInterval);
    timerInterval = setInterval(() => {
      elapsedSeconds++;
      updateDisplay(goalId);
      saveState(true);
    }, 1000);
    updateDisplay(goalId);
  }

  function openFinishModal(goalId) {
    if (goalId !== activeGoal) {
      alert("Mulai dulu timernya sebelum menyelesaikan.");
      return;
    }
    pauseTimer(goalId);
    pendingFinishGoal = goalId;
    document.getElementById("finishModal").classList.remove("hidden");
    document.getElementById("finishModal").classList.add("flex");
  }

  document.getElementById("cancelFinish").addEventListener("click", () => {
    document.getElementById("finishModal").classList.add("hidden");
    document.getElementById("finishModal").classList.remove("flex");
    resumeTimer(pendingFinishGoal);
  });

  document.getElementById("confirmFinish").addEventListener("click", () => {
    document.getElementById("finishModal").classList.add("hidden");
    document.getElementById("finishModal").classList.remove("flex");
    finishSession(pendingFinishGoal);
  });

  function finishSession(goalId) {
    const minutes = Math.floor(elapsedSeconds / 60);
    if (minutes < 1) {
      alert("Minimal 1 menit untuk menyimpan sesi.");
      resumeTimer(goalId);
      return;
    }

    fetch(`/study-sessions`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": "{{ csrf_token() }}"
      },
      body: JSON.stringify({
        study_goal_id: goalId,
        duration_minutes: minutes,
        note: "Session finished via tracker"
      })
    })
    .then(res => res.json())
    .then(() => {
      alert(`Sesi belajar tersimpan: ${minutes} menit`);
      resetTimer();
      location.reload();
    })
    .catch(err => console.error(err));
  }

  function saveState(isRunning) {
    localStorage.setItem("studyTimer", JSON.stringify({
      goalId: activeGoal,
      startTime: startTime.toISOString(),
      elapsedSeconds,
      isRunning
    }));
  }

  function resetTimer() {
    clearInterval(timerInterval);
    timerInterval = null;
    activeGoal = null;
    elapsedSeconds = 0;
    pendingFinishGoal = null;
    localStorage.removeItem("studyTimer");
  }

  window.addEventListener("storage", e => {
    if (e.key === "studyTimer") {
      const saved = JSON.parse(e.newValue);
      if (!saved) {
        resetTimer();
        return;
      }
      if (saved.isRunning) {
        activeGoal = saved.goalId;
        elapsedSeconds = saved.elapsedSeconds;
        startTime = new Date(saved.startTime);
        resumeTimer(activeGoal);
      } else {
        pauseTimer(saved.goalId);
      }
    }
  });
</script>
@endsection
