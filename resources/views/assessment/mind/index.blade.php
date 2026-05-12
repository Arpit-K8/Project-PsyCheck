<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>PsyCheck | Mind Assessment</title>

	<link rel="preconnect" href="https://fonts.bunny.net">
	<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />
	<script src="https://cdn.tailwindcss.com"></script>
	<style>
		body { font-family: 'Instrument Sans', sans-serif; }
	</style>
</head>
<body class="min-h-screen bg-[#f8ebf1] bg-[radial-gradient(circle_at_50%_-20%,#b23673_0,#e39fb8_34%,#f8ebf1_82%)] text-slate-800 antialiased">
	@php
        // Fetch real history logs from DB
        $historyLogs = \App\Models\AssessmentResult::where('user_id', auth()->id())
            ->where('module_name', 'mind')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($log) {
                return [
                    'id' => $log->id,
                    'date' => $log->created_at->format('M d, g:i A'),
                    'title' => $log->title ?? 'Assessment',
                    'score' => $log->score,
                    'mood' => $log->mood,
                    'stress' => $log->stress,
                    'remarks' => $log->remarks,
                ];
            })->toArray();

        // Ensure we have at least one empty state if no logs
        if (empty($historyLogs)) {
            $historyLogs = [
                [
                    'id' => 0,
                    'date' => '-',
                    'title' => 'No tests taken yet',
                    'score' => 0,
                    'mood' => '-',
                    'stress' => '-',
                    'remarks' => 'Click on an available test to start your first assessment.',
                ]
            ];
        }
	@endphp

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-8 lg:px-10">
        <a href="{{ route('dashboard') }}#assessment-menus" class="inline-flex items-center gap-2 rounded-full bg-white/80 px-4 py-2 text-sm font-semibold text-fuchsia-700 ring-1 ring-fuchsia-100 transition hover:bg-white hover:text-fuchsia-800 hover:shadow-sm">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Back to dashboard
        </a>

        <!-- Instruction Section -->
        <section class="mt-8 mb-10">
            <div class="relative overflow-hidden rounded-[32px] bg-[linear-gradient(180deg,#fff7fb_0%,#fff1f6_100%)] p-8 sm:p-10 shadow-[0_20px_55px_rgba(89,29,63,.05)] ring-1 ring-fuchsia-100/70">
                <!-- Decorative background elements -->
                <div class="absolute -right-10 -top-10 h-64 w-64 rounded-full bg-[radial-gradient(circle,#fbcfe8_0,transparent_70%)] opacity-40 blur-xl"></div>
                <div class="absolute -left-10 -bottom-10 h-48 w-48 rounded-full bg-[radial-gradient(circle,#fbcfe8_0,transparent_70%)] opacity-30 blur-xl"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-8">
                    <div class="max-w-2xl">
                        <div class="inline-flex items-center gap-2 rounded-full bg-white px-3 py-1.5 text-xs font-bold uppercase tracking-[0.2em] text-fuchsia-600 shadow-sm ring-1 ring-fuchsia-100">
                            Module: Mind
                        </div>
                        <h1 class="mt-5 text-4xl font-black tracking-tight text-slate-900 sm:text-5xl">Mind Assessment</h1>
                        <p class="mt-4 text-lg leading-relaxed text-slate-600">
                            Answer 90 questions across stress, cognitive focus, and emotional balance. The ideal response is "Not at all" and the non-ideal response is "Nearly every day". Select a module below to start, or click on a history log to review past outcomes.
                        </p>
                    </div>
                    
                    <div class="hidden md:flex h-28 w-28 shrink-0 items-center justify-center rounded-[32px] bg-white shadow-[0_12px_30px_rgba(190,24,93,.12)] ring-1 ring-fuchsia-100 rotate-3 transition-transform hover:rotate-0">
                        <svg class="h-12 w-12 text-fuchsia-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                    </div>
                </div>
            </div>
        </section>

        <div class="grid gap-6 lg:grid-cols-[minmax(0,1.3fr)_minmax(320px,0.8fr)] xl:grid-cols-[minmax(0,1.5fr)_minmax(380px,0.9fr)]">
            <!-- Left Screen Section -->
            <div class="space-y-6">
                <!-- Paper-like Tests Container -->
                <div class="rounded-[32px] bg-[linear-gradient(180deg,#fff7fb_0%,#fff1f6_100%)] p-7 sm:p-10 shadow-[0_20px_55px_rgba(89,29,63,.05)] ring-1 ring-fuchsia-100/70 relative overflow-hidden">
                    <!-- Paper texture overlay / lines -->
                    <div class="absolute inset-0 opacity-[0.2] pointer-events-none" style="background-image: repeating-linear-gradient(transparent, transparent 27px, #fbcfe8 28px);"></div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center justify-between">
                            <h2 class="text-2xl font-extrabold text-slate-900">Available Tests</h2>
                            <span class="rounded-full bg-fuchsia-50 px-3 py-1 text-xs font-semibold text-fuchsia-700 ring-1 ring-fuchsia-100">90 questions</span>
                        </div>
                        
                        <div class="mt-6 grid gap-4 sm:grid-cols-2 md:grid-cols-3">
                            <!-- Test 1 -->
                            <a href="{{ route('assessment.exam', ['track' => 'mind', 'module' => 'Stress Pattern']) }}" class="group relative block rounded-[24px] bg-white p-5 shadow-sm ring-1 ring-fuchsia-100 transition hover:-translate-y-1 hover:shadow-[0_12px_28px_rgba(190,24,93,.12)]">
                                <div class="absolute right-4 top-4 h-8 w-8 rounded-full bg-fuchsia-50 flex items-center justify-center text-fuchsia-600 group-hover:bg-fuchsia-100 transition">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                                </div>
                                <div class="h-10 w-10 rounded-2xl bg-gradient-to-br from-fuchsia-500 to-fuchsia-600 shadow-inner flex items-center justify-center text-white">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                                </div>
                                <h3 class="mt-4 text-lg font-black text-slate-900 leading-tight">Stress Pattern</h3>
                                <p class="mt-1 text-sm font-semibold text-fuchsia-600">30 questions</p>
                            </a>

                            <!-- Test 2 -->
                            <a href="{{ route('assessment.exam', ['track' => 'mind', 'module' => 'Cognitive Function & Focus']) }}" class="group relative block rounded-[24px] bg-white p-5 shadow-sm ring-1 ring-fuchsia-100 transition hover:-translate-y-1 hover:shadow-[0_12px_28px_rgba(190,24,93,.12)]">
                                <div class="absolute right-4 top-4 h-8 w-8 rounded-full bg-fuchsia-50 flex items-center justify-center text-fuchsia-600 group-hover:bg-fuchsia-100 transition">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                                </div>
                                <div class="h-10 w-10 rounded-2xl bg-gradient-to-br from-rose-400 to-rose-500 shadow-inner flex items-center justify-center text-white">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                </div>
                                <h3 class="mt-4 text-lg font-black text-slate-900 leading-tight">Cognitive Function & Focus</h3>
                                <p class="mt-1 text-sm font-semibold text-fuchsia-600">30 questions</p>
                            </a>

                            <!-- Test 3 -->
                            <a href="{{ route('assessment.exam', ['track' => 'mind', 'module' => 'Emotional Balance']) }}" class="group relative block rounded-[24px] bg-white p-5 shadow-sm ring-1 ring-fuchsia-100 transition hover:-translate-y-1 hover:shadow-[0_12px_28px_rgba(190,24,93,.12)]">
                                <div class="absolute right-4 top-4 h-8 w-8 rounded-full bg-fuchsia-50 flex items-center justify-center text-fuchsia-600 group-hover:bg-fuchsia-100 transition">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                                </div>
                                <div class="h-10 w-10 rounded-2xl bg-gradient-to-br from-purple-400 to-fuchsia-500 shadow-inner flex items-center justify-center text-white">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                </div>
                                <h3 class="mt-4 text-lg font-black text-slate-900 leading-tight">Emotional Balance</h3>
                                <p class="mt-1 text-sm font-semibold text-fuchsia-600">30 questions</p>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Latest Test Results -->
                <div class="rounded-[32px] bg-white p-7 sm:p-10 shadow-[0_20px_55px_rgba(89,29,63,.1)] ring-1 ring-fuchsia-100/70 transition-all duration-300" id="latest-result-container">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-5">
                        <div>
                            <p class="text-sm font-bold uppercase tracking-[0.24em] text-fuchsia-600">Selected Outcome</p>
                            <h2 class="mt-2 text-2xl font-extrabold text-slate-900" id="result-title">{{ $historyLogs[0]['title'] }}</h2>
                            <p class="mt-1 text-sm text-slate-500 font-semibold" id="result-date">{{ $historyLogs[0]['date'] }}</p>
                        </div>
                        <div class="flex h-16 w-16 flex-col items-center justify-center rounded-2xl bg-fuchsia-50 ring-1 ring-fuchsia-100">
                            <span class="text-xl font-black text-fuchsia-700" id="result-score">{{ $historyLogs[0]['score'] }}%</span>
                        </div>
                    </div>

                    <div class="mt-6 grid gap-4 sm:grid-cols-2">
                        <div class="rounded-2xl bg-slate-50 p-4 ring-1 ring-slate-100 flex items-center justify-between">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Mood Summary</p>
                            <p class="text-lg font-bold text-slate-900" id="result-mood">{{ $historyLogs[0]['mood'] }}</p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 p-4 ring-1 ring-slate-100 flex items-center justify-between">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Stress Level</p>
                            <p class="text-lg font-bold text-slate-900" id="result-stress">{{ $historyLogs[0]['stress'] }}</p>
                        </div>
                    </div>

                    <div class="mt-6 rounded-[28px] bg-[linear-gradient(180deg,#fff7fb_0%,#fff1f6_100%)] p-6 ring-1 ring-fuchsia-100">
                        <p class="text-xs font-semibold uppercase tracking-[0.18em] text-fuchsia-600">Remarks & Insights</p>
                        <p class="mt-3 text-base leading-7 font-medium text-slate-900" id="result-remarks">
                            {{ $historyLogs[0]['remarks'] }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right Screen Section -->
            <aside class="space-y-6">
                <!-- Percentage Bar -->
                <div class="rounded-[32px] bg-white p-8 shadow-[0_20px_55px_rgba(89,29,63,.1)] ring-1 ring-fuchsia-100/70 flex flex-col items-center justify-center">
                    <div class="w-full flex items-center justify-between mb-6">
                        <p class="text-sm font-bold uppercase tracking-[0.24em] text-fuchsia-600">Current Progress</p>
                    </div>
                    
                    @php
                        $score = $historyLogs[0]['score'] ?? 0;
                        $circumference = 666.02; // 2 * pi * 106
                        $dashoffset = $circumference - ($score / 100) * $circumference;
                    @endphp
                    <div class="mt-4 relative flex h-64 w-64 items-center justify-center rounded-full bg-[linear-gradient(180deg,#fff7fb_0%,#fff1f6_100%)] shadow-inner shadow-fuchsia-100 mx-auto">
                        <svg class="absolute inset-0 h-full w-full -rotate-90 transform" viewBox="0 0 240 240">
                            <!-- Background track -->
                            <circle cx="120" cy="120" r="106" stroke="#fae8ff" stroke-width="16" fill="none" />
                            <!-- Dynamic progress -->
                            <circle cx="120" cy="120" r="106" stroke="#c026d3" stroke-width="16" fill="none" stroke-linecap="round" 
                                    stroke-dasharray="666.02" 
                                    stroke-dashoffset="{{ $dashoffset }}" 
                                    class="transition-all duration-1000 ease-out"
                                    id="progress-circle" />
                        </svg>
                        <div class="text-center relative z-10 px-4">
                            <p class="text-5xl font-black text-slate-900" id="progress-text">{{ $score }}%</p>
                            <p class="mt-2 text-xs font-semibold uppercase tracking-[0.2em] text-fuchsia-600">Balance</p>
                        </div>
                    </div>
                </div>

                <!-- History Log -->
                <div class="rounded-[32px] bg-white p-6 shadow-[0_20px_55px_rgba(89,29,63,.1)] ring-1 ring-fuchsia-100/70 flex flex-col h-[400px]">
                    <div class="flex items-center justify-between mb-4">
                        <p class="text-sm font-bold uppercase tracking-[0.24em] text-fuchsia-600">History Log</p>
                        <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">{{ count($historyLogs) }} logs</span>
                    </div>

                    <div class="flex-1 overflow-y-auto pr-2 space-y-3 [scrollbar-width:thin] [scrollbar-color:rgba(226,232,240,1)_transparent]">
                        @foreach($historyLogs as $index => $log)
                            <button 
                                type="button"
                                class="js-history-log w-full text-left group flex items-center justify-between rounded-2xl p-4 transition-all {{ $index === 0 ? 'bg-fuchsia-50 ring-1 ring-fuchsia-200 shadow-sm' : 'bg-white hover:bg-slate-50 ring-1 ring-slate-100 hover:ring-slate-200' }}"
                                data-log="{{ json_encode($log) }}"
                            >
                                <div>
                                    <p class="text-sm font-bold text-slate-900 group-hover:text-fuchsia-700 transition-colors">{{ $log['title'] }}</p>
                                    <p class="mt-1 text-xs font-medium text-slate-500">{{ $log['date'] }}</p>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="text-sm font-black {{ $index === 0 ? 'text-fuchsia-700' : 'text-slate-700' }} group-hover:text-fuchsia-700 transition-colors">{{ $log['score'] }}%</span>
                                    <svg class="h-4 w-4 text-slate-400 group-hover:text-fuchsia-500 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                                </div>
                            </button>
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const logs = document.querySelectorAll('.js-history-log');
            const titleEl = document.getElementById('result-title');
            const dateEl = document.getElementById('result-date');
            const scoreEl = document.getElementById('result-score');
            const moodEl = document.getElementById('result-mood');
            const stressEl = document.getElementById('result-stress');
            const remarksEl = document.getElementById('result-remarks');
            const container = document.getElementById('latest-result-container');
            const progressText = document.getElementById('progress-text');
            const progressCircle = document.getElementById('progress-circle');

            logs.forEach(logBtn => {
                logBtn.addEventListener('click', function() {
                    // Reset styles for all buttons
                    logs.forEach(btn => {
                        btn.classList.remove('bg-fuchsia-50', 'ring-fuchsia-200', 'shadow-sm');
                        btn.classList.add('bg-white', 'hover:bg-slate-50', 'ring-slate-100', 'hover:ring-slate-200');
                        const scoreSpan = btn.querySelector('.font-black');
                        if(scoreSpan) {
                            scoreSpan.classList.remove('text-fuchsia-700');
                            scoreSpan.classList.add('text-slate-700');
                        }
                    });

                    // Set active styles for clicked button
                    this.classList.remove('bg-white', 'hover:bg-slate-50', 'ring-slate-100', 'hover:ring-slate-200');
                    this.classList.add('bg-fuchsia-50', 'ring-1', 'ring-fuchsia-200', 'shadow-sm');
                    const activeScoreSpan = this.querySelector('.font-black');
                    if(activeScoreSpan) {
                        activeScoreSpan.classList.remove('text-slate-700');
                        activeScoreSpan.classList.add('text-fuchsia-700');
                    }

                    // Parse data and update UI
                    const data = JSON.parse(this.dataset.log);
                    
                    // Add fade animation
                    container.style.opacity = '0.5';
                    container.style.transform = 'translateY(4px)';
                    
                    setTimeout(() => {
                        titleEl.textContent = data.title;
                        dateEl.textContent = data.date;
                        scoreEl.textContent = data.score + '%';
                        moodEl.textContent = data.mood;
                        stressEl.textContent = data.stress;
                        remarksEl.textContent = data.remarks;
                        
                        // Update progress ring
                        progressText.textContent = data.score + '%';
                        
                        // SVG offset calculation based on circumference 666.02
                        if(progressCircle) {
                            const circumference = 666.02;
                            const dashoffset = circumference - (data.score / 100) * circumference;
                            progressCircle.style.strokeDashoffset = dashoffset;
                        }
                        
                        container.style.opacity = '1';
                        container.style.transform = 'translateY(0)';
                    }, 200);
                });
            });
        });
    </script>
</body>
</html>
