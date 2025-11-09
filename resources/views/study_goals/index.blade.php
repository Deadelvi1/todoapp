@extends('layouts.app')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    body { font-family: 'Poppins', sans-serif; }
    .modal-bg { background-color: rgba(0,0,0,0.4); }
</style>

<div class="relative max-w-[1440px] mx-auto px-6 py-20">
    <div class="absolute top-[120px] left-0 w-[300px] h-[300px] bg-gradient-to-tr from-indigo-800 to-sky-400 rounded-full blur-[100px] opacity-40"></div>

    <div class="relative bg-white/30 backdrop-blur-xl border border-white/40 rounded-lg shadow-2xl p-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
            <h1 class="font-semibold text-3xl text-gray-800 flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" class="text-indigo-700">
                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6">
                        <path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2S4 3 4 3v12z"/>
                        <path d="M4 22v-7"/>
                    </g>
                </svg>
                Study Time Tracker
            </h1>

            <a href="{{ route('study-goals.create') }}"
               class="mt-4 sm:mt-0 bg-gradient-to-tr from-indigo-200 to-sky-300 text-gray-800 px-6 py-2.5 rounded-xl hover:scale-95 transition-all duration-300 flex items-center gap-2 font-medium shadow-sm hover:shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M12 6v12m6-6H6"/>
                </svg>
                Tambah Goal Baru
            </a>
        </div>

        <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-lg bg-white">
            <table class="w-full text-sm text-left">
                <thead class="text-sm text-white uppercase bg-gradient-to-tr from-indigo-800 to-sky-400">
                    <tr>
                        <th class="px-6 py-4">Goal</th>
                        <th class="px-6 py-4 text-center">Target (Jam)</th>
                        <th class="px-6 py-4 text-center">Progress</th>
                        <th class="px-6 py-4 text-center">Timer</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($goals as $g)
                        @php
                            $minutes = $g->study_sessions_sum_duration_minutes ?? 0;
                            $hours = round($minutes / 60, 2);
                            $progress = $g->target_hours > 0 ? min(($hours / $g->target_hours) * 100, 100) : 0;
                        @endphp
                        <tr class="border-b border-gray-200 hover:bg-indigo-50 transition-all duration-300" id="goal-{{ $g->id }}">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $g->title }}</td>
                            <td class="px-6 py-4 text-center text-gray-700">{{ $g->target_hours }}</td>
                            <td class="px-6 py-4">
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-indigo-500 h-2.5 rounded-full transition-all duration-300" style="width: {{ $progress }}%"></div>
                                </div>
                                <p class="text-xs text-gray-600 mt-1 text-center">{{ $hours }} jam ({{ number_format($progress, 0) }}%)</p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span id="timer-{{ $g->id }}" class="font-mono text-lg text-gray-800">00:00:00</span>
                            </td>
                            <td class="px-6 py-4 text-right flex justify-end items-center gap-2 pr-20">
                                <button onclick="startTimer('{{ $g->id }}')" class="text-xs text-green-700 px-3 py-1.5 rounded-md hover:bg-green-200 "><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M5 5a2 2 0 0 1 3.008-1.728l11.997 6.998a2 2 0 0 1 .003 3.458l-12 7A2 2 0 0 1 5 19z"/></svg></button>
                                <button onclick="pauseTimer('{{ $g->id }}')" class="text-xs text-yellow-700 px-3 py-1.5 rounded-md hover:bg-yellow-200 "><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="1.6" d="M20.2 3h-4.4a.8.8 0 0 0-.8.8v16.4a.8.8 0 0 0 .8.8h4.4a.8.8 0 0 0 .8-.8V3.8a.8.8 0 0 0-.8-.8Zm-12 0H3.8a.8.8 0 0 0-.8.8v16.4a.8.8 0 0 0 .8.8h4.4a.8.8 0 0 0 .8-.8V3.8a.8.8 0 0 0-.8-.8Z"/></svg></button>
                                <button onclick="openFinishModal('{{ $g->id }}')" class="text-xs text-rose-700 px-3 py-1.5 rounded-md hover:bg-blue-200 "><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-width="1.6" d="M2 12c0-4.714 0-7.071 1.464-8.536C4.93 2 7.286 2 12 2s7.071 0 8.535 1.464C22 4.93 22 7.286 22 12s0 7.071-1.465 8.535C19.072 22 16.714 22 12 22s-7.071 0-8.536-1.465C2 19.072 2 16.714 2 12Z"/></svg></button>
                                <a href="{{ route('study-goals.edit', $g->id) }}" class="text-xs text-blue-600 px-3 py-1.5 rounded-md hover:bg-purple-200 "><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/></g></svg></a>
                                <form action="{{ route('study-goals.destroy', $g->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus goal ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs text-red-700 px-3 py-1.5 rounded-md hover:bg-red-200 shadow-sm"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="1.6" d="m19.5 5.5l-.62 10.025c-.158 2.561-.237 3.842-.88 4.763a4 4 0 0 1-1.2 1.128c-.957.584-2.24.584-4.806.584c-2.57 0-3.855 0-4.814-.585a4 4 0 0 1-1.2-1.13c-.642-.922-.72-2.205-.874-4.77L4.5 5.5M3 5.5h18m-4.944 0l-.683-1.408c-.453-.936-.68-1.403-1.071-1.695a2 2 0 0 0-.275-.172C13.594 2 13.074 2 12.035 2c-1.066 0-1.599 0-2.04.234a2 2 0 0 0-.278.18c-.395.303-.616.788-1.058 1.757L8.053 5.5"/></svg></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-12 text-gray-500">
                                Belum ada goal yang dibuat.
                                <a href="{{ route('study-goals.create') }}" class="text-indigo-600 hover:underline font-medium">
                                    Buat goal pertama Anda!
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL KONFIRMASI FINISH -->
<div id="finishModal" class="fixed inset-0 hidden items-center justify-center modal-bg z-50">
    <div class="bg-white rounded-2xl shadow-2xl p-8 text-center w-[90%] max-w-sm">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Apakah kamu yakin ingin menyelesaikan sesi ini?</h2>
        <div class="flex justify-center gap-4">
            <button id="confirmFinish" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Ya</button>
            <button id="cancelFinish" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 transition">Tidak</button>
        </div>
    </div>
</div>

<script>
let activeGoal = null;
let timerInterval = null;
let startTime = null;
let elapsedSeconds = 0;
let pendingFinishGoal = null;

// === Restore timer ===
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

// === Sync antar tab ===
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
