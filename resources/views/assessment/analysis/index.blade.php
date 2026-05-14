<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>PsyCheck | PRO Analysis</title>

	<link rel="preconnect" href="https://fonts.bunny.net">
	<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800,900" rel="stylesheet" />
	<script src="https://cdn.tailwindcss.com"></script>
	<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
	<style>
		body { font-family: 'Instrument Sans', sans-serif; }
        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
	</style>
</head>
<body class="min-h-screen bg-[#f8ebf1] bg-[radial-gradient(circle_at_50%_-20%,#b23673_0,#e39fb8_34%,#f8ebf1_82%)] text-slate-800 antialiased overflow-x-hidden">
	@php
        $latestMind = \App\Models\AssessmentResult::where('user_id', auth()->id())
            ->where('module_name', 'mind')
            ->orderBy('created_at', 'desc')
            ->first();

        $latestBody = \App\Models\AssessmentResult::where('user_id', auth()->id())
            ->where('module_name', 'body')
            ->orderBy('created_at', 'desc')
            ->first();

        $isUnlocked = $latestMind && $latestBody;

        if ($isUnlocked) {
            $mindScore = $latestMind->score;
            $bodyScore = $latestBody->score;
            $combinedScore = round(($mindScore + $bodyScore) / 2);
            
            if ($combinedScore >= 80) {
                $recTitle = "Peak Alignment";
                $recIcon = "M13 10V3L4 14h7v7l9-11h-7z";
                $recColor = "text-emerald-500";
                $recBg = "bg-emerald-50";
                $recText = "Your mind and body are in excellent synchronization. Continue your current routine. You are functioning at a very high level with exceptional cognitive and somatic balance.";
            } elseif ($combinedScore >= 60) {
                $recTitle = "Solid Equilibrium";
                $recIcon = "M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z";
                $recColor = "text-sky-500";
                $recBg = "bg-sky-50";
                $recText = "You have a good balance, but there's room for minor optimizations. Review the breakdown below and consider targeting whichever track scored lower to bring your overall wellness up.";
            } elseif ($combinedScore >= 40) {
                $recTitle = "Warning: Early Misalignment";
                $recIcon = "M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z";
                $recColor = "text-amber-500";
                $recBg = "bg-amber-50";
                $recText = "You're showing signs of fatigue across the board. It's time to intentionally schedule recovery days and prioritize both mental downtime and physical rest before you burn out.";
            } else {
                $recTitle = "Critical Disconnection";
                $recIcon = "M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z";
                $recColor = "text-rose-500";
                $recBg = "bg-rose-50";
                $recText = "Your systems are overloaded. We strongly advise taking a complete break, seeking professional support, and treating your wellness as an immediate and urgent priority.";
            }
            
            // Override with specific cross-checks if variance is high
            if ($mindScore >= 70 && $bodyScore < 50) {
                $recTitle = "Physical Lag Detected";
                $recIcon = "M13 10V3L4 14h7v7l9-11h-7z";
                $recColor = "text-fuchsia-500";
                $recBg = "bg-fuchsia-50";
                $recText = "Your mental clarity is high, but your physical body is struggling to keep up. You are running on cognitive willpower. Focus heavily on physical rest, somatic relaxation, and sleep recovery.";
            } elseif ($bodyScore >= 70 && $mindScore < 50) {
                $recTitle = "Cognitive Exhaustion";
                $recIcon = "M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z";
                $recColor = "text-fuchsia-500";
                $recBg = "bg-fuchsia-50";
                $recText = "Your physical body is healthy, but your mind is completely overwhelmed. Step away from mentally taxing work. Engage in mindless physical activities, meditation, or simply disconnect from screens.";
            }

            $improvementSteps = [];
            
            if ($mindScore < 80) {
                if ($latestMind->stress === 'High' || $latestMind->stress === 'Severe') {
                    $improvementSteps[] = [
                        'title' => 'Cognitive Decompression',
                        'desc' => 'Your mental stress is critically high. Implement a strict "no-screen" policy 1 hour before bed and practice 4-7-8 breathing exercises daily.',
                        'icon' => 'M13 10V3L4 14h7v7l9-11h-7z',
                        'color' => 'text-purple-600',
                        'bg' => 'bg-purple-100'
                    ];
                }
                if ($latestMind->mood === 'Tired' || $latestMind->mood === 'Overwhelmed') {
                    $improvementSteps[] = [
                        'title' => 'Emotional Grounding',
                        'desc' => 'Emotional exhaustion detected. Schedule at least two 15-minute blocks in your day for completely unstructured downtime. Do not try to be productive during this time.',
                        'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z',
                        'color' => 'text-fuchsia-600',
                        'bg' => 'bg-fuchsia-100'
                    ];
                }
            }

            if ($bodyScore < 80) {
                if ($latestBody->stress === 'High' || $latestBody->stress === 'Severe') {
                    $improvementSteps[] = [
                        'title' => 'Somatic Release',
                        'desc' => 'Physical tension is building up. Incorporate progressive muscle relaxation or restorative yoga into your evening routine to release trapped kinetic energy.',
                        'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
                        'color' => 'text-rose-600',
                        'bg' => 'bg-rose-100'
                    ];
                }
                if ($latestBody->mood === 'Tired' || $latestBody->mood === 'Exhausted') {
                    $improvementSteps[] = [
                        'title' => 'Vitality Restoration',
                        'desc' => 'Your physical energy reserves are depleted. Focus heavily on sleep hygiene, aiming for 8+ hours, and ensure you are hydrating and consuming nutrient-dense foods.',
                        'icon' => 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                        'color' => 'text-amber-600',
                        'bg' => 'bg-amber-100'
                    ];
                }
            }
            
            if (empty($improvementSteps)) {
                $improvementSteps[] = [
                    'title' => 'Maintain Current Trajectory',
                    'desc' => 'You are currently in an optimal state of both physical and mental health. The best step to improve is simply to maintain your current healthy habits and routines.',
                    'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                    'color' => 'text-emerald-600',
                    'bg' => 'bg-emerald-100'
                ];
            }
        }
	@endphp

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-8 lg:px-10">
        @if(!$isUnlocked)
            <!-- Navigation Header (Locked State Only) -->
            <header class="mb-6 flex flex-col sm:flex-row items-center justify-between gap-4 rounded-[32px] glass-panel px-6 py-3 shadow-[0_20px_60px_rgba(89,29,63,.12)] relative z-20">
                <div class="flex items-center group w-full sm:w-auto">
                    <img src="{{ asset('images/Logo.png') }}" alt="PsyCheck logo" class="h-16 w-16 shrink-0 object-cover transition-transform duration-300 group-hover:scale-105" />
                    <div class="flex flex-col ml-1">
                        <p class="text-lg font-bold text-fuchsia-700">PsyCheck</p>
                        <p class="text-[10px] uppercase tracking-[0.22em] text-slate-400">Mental Wellness Platform</p>
                    </div>
                </div>
                <div class="w-full sm:w-auto flex justify-end">
                    <a href="{{ route('dashboard') }}#assessment-menus" class="inline-flex items-center gap-2 rounded-full bg-white px-5 py-3 text-sm font-semibold text-fuchsia-700 shadow-sm ring-1 ring-fuchsia-100 hover:bg-fuchsia-50 transition">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                        Back to dashboard
                    </a>
                </div>
            </header>

            <!-- LOCKED STATE -->
            <div class="flex flex-col items-center justify-center py-20 text-center relative z-10">
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-20">
                    <div class="h-96 w-96 rounded-full bg-fuchsia-400 blur-3xl"></div>
                </div>
                
                <div class="relative glass-panel rounded-[40px] p-12 max-w-2xl shadow-[0_40px_100px_rgba(89,29,63,.1)] ring-1 ring-fuchsia-100">
                    <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-full bg-fuchsia-50 ring-1 ring-fuchsia-100 mb-8 shadow-inner shadow-fuchsia-200">
                        <svg class="h-10 w-10 text-fuchsia-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    </div>
                    
                    <h1 class="text-4xl sm:text-5xl font-black text-slate-900 tracking-tight">Analysis Locked</h1>
                    <p class="mt-6 text-lg leading-relaxed text-slate-600 font-medium">
                        To unlock the PRO Analysis dashboard, you must complete at least one test in both the <strong class="text-fuchsia-700">Mind Assessment</strong> and <strong class="text-fuchsia-700">Body Assessment</strong> modules. We need this combined data to provide accurate correlations and recommendations.
                    </p>

                    <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('assessment.start', 'mind') }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-slate-900 px-8 py-4 text-sm font-bold text-white transition hover:bg-slate-800 hover:-translate-y-1 hover:shadow-lg">
                            Go to Mind Assessment
                        </a>
                        <a href="{{ route('assessment.start', 'body') }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-slate-900 px-8 py-4 text-sm font-bold text-white transition hover:bg-slate-800 hover:-translate-y-1 hover:shadow-lg">
                            Go to Body Assessment
                        </a>
                    </div>

                    <div class="mt-10 grid grid-cols-2 gap-4 text-left">
                        <div class="rounded-2xl bg-white p-5 ring-1 ring-slate-100 shadow-sm flex items-center gap-4">
                            <div class="h-10 w-10 rounded-full {{ $latestMind ? 'bg-emerald-100 text-emerald-600' : 'bg-slate-100 text-slate-400' }} flex items-center justify-center shrink-0">
                                @if($latestMind)
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                @else
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                @endif
                            </div>
                            <div>
                                <p class="text-xs font-bold uppercase tracking-[0.1em] text-slate-500">Requirement</p>
                                <p class="text-sm font-bold text-slate-900 mt-0.5">Mind Data</p>
                            </div>
                        </div>
                        <div class="rounded-2xl bg-white p-5 ring-1 ring-slate-100 shadow-sm flex items-center gap-4">
                            <div class="h-10 w-10 rounded-full {{ $latestBody ? 'bg-emerald-100 text-emerald-600' : 'bg-slate-100 text-slate-400' }} flex items-center justify-center shrink-0">
                                @if($latestBody)
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                @else
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                @endif
                            </div>
                            <div>
                                <p class="text-xs font-bold uppercase tracking-[0.1em] text-slate-500">Requirement</p>
                                <p class="text-sm font-bold text-slate-900 mt-0.5">Body Data</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @else
            <!-- PRO DASHBOARD STATE -->
            <div class="relative z-10">
                <!-- Unified Top Header Section -->
                <div class="mb-12 rounded-[40px] glass-panel relative overflow-hidden shadow-[0_20px_55px_rgba(89,29,63,.05)] border border-white/60 flex flex-col">
                    <div class="absolute inset-0 bg-white/40 pointer-events-none"></div>
                    
                    <!-- Integrated Navigation Bar -->
                    <div class="flex items-center justify-between w-full p-6 sm:px-10 sm:py-6 border-b border-white/60 relative z-10">
                        <div class="flex items-center group">
                            <img src="{{ asset('images/Logo.png') }}" alt="PsyCheck logo" class="h-14 w-14 shrink-0 object-cover transition-transform duration-300 group-hover:scale-105" />
                            <div class="flex flex-col ml-3">
                                <p class="text-xl font-black text-slate-900 tracking-tight">PsyCheck <span class="text-fuchsia-600 ml-1">AUDIT</span></p>
                                <p class="text-[10px] uppercase tracking-[0.2em] text-slate-500 font-bold mt-0.5">Mental Wellness Platform</p>
                            </div>
                        </div>
                        <a href="{{ route('dashboard') }}#assessment-menus" class="inline-flex items-center justify-center gap-2 rounded-full bg-slate-900 px-6 py-2.5 text-sm font-bold text-white shadow-sm ring-1 ring-slate-800 transition hover:bg-slate-800 hover:-translate-y-0.5 hover:shadow-md">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                            Dashboard
                        </a>
                    </div>
                    
                    <!-- Hero Content -->
                    <div class="p-10 sm:p-14 text-center relative z-10">
                        <h1 class="text-5xl font-black tracking-tight text-slate-900 sm:text-6xl lg:text-7xl">
                            System Diagnostics
                        </h1>
                        <p class="mt-6 text-xl leading-relaxed text-slate-600 max-w-2xl mx-auto font-medium">
                            Based on your latest assessments, here is a complete breakdown of your psycho-somatic health.
                        </p>
                    </div>
                </div>

                <div class="grid gap-6 lg:grid-cols-3">
                    
                    <!-- Center/Hero Metric (Combined Score) -->
                    <div class="lg:col-span-3 glass-panel rounded-[40px] p-10 flex flex-col md:flex-row items-center justify-between gap-10 shadow-[0_20px_55px_rgba(89,29,63,.08)]">
                        <div class="flex-1 max-w-xl">
                            <p class="text-sm font-bold uppercase tracking-[0.24em] text-fuchsia-600">Overall Assessment</p>
                            <h2 class="mt-3 text-4xl font-black text-slate-900">Total Wellness Index</h2>
                            <p class="mt-4 text-lg text-slate-600 leading-relaxed font-medium">This score represents the harmonic average of your cognitive stability and your physical resilience. Maintaining a score above 75% indicates optimal functioning.</p>
                            
                            <div class="mt-8 flex items-center gap-4 bg-white/60 p-4 rounded-2xl ring-1 ring-white/80 shadow-sm backdrop-blur">
                                <div class="h-12 w-12 rounded-full {{ $recBg }} {{ $recColor }} flex items-center justify-center shrink-0 shadow-inner">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $recIcon }}" /></svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.15em] text-slate-500">System Verdict</p>
                                    <p class="text-base font-black text-slate-900 mt-0.5">{{ $recTitle }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="relative shrink-0 flex items-center justify-center">
                            @php
                                $circumference = 666.02; // 2 * pi * 106
                                $dashoffset = $circumference - ($combinedScore / 100) * $circumference;
                            @endphp
                            <div class="relative flex h-72 w-72 items-center justify-center rounded-full bg-white shadow-[0_0_50px_rgba(190,24,93,.15)] ring-1 ring-fuchsia-100">
                                <svg class="absolute inset-0 h-full w-full -rotate-90 transform drop-shadow-md" viewBox="0 0 240 240">
                                    <!-- Background track -->
                                    <circle cx="120" cy="120" r="106" stroke="#fae8ff" stroke-width="14" fill="none" />
                                    <!-- Dynamic progress -->
                                    <circle cx="120" cy="120" r="106" stroke="url(#gradient)" stroke-width="14" fill="none" stroke-linecap="round" 
                                            stroke-dasharray="666.02" 
                                            stroke-dashoffset="{{ $dashoffset }}" 
                                            class="transition-all duration-1500 ease-out delay-300" />
                                    <defs>
                                        <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" stop-color="#db2777" />
                                            <stop offset="100%" stop-color="#e11d48" />
                                        </linearGradient>
                                    </defs>
                                </svg>
                                <div class="text-center relative z-10 flex flex-col items-center">
                                    <span class="text-6xl font-black text-slate-900 tracking-tighter">{{ $combinedScore }}<span class="text-4xl text-slate-400">%</span></span>
                                    <p class="mt-1 text-[10px] font-bold uppercase tracking-[0.25em] text-fuchsia-600">Index Score</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Left Column: Mind Breakdown -->
                    <div class="lg:col-span-1 glass-panel rounded-[32px] p-8 relative overflow-hidden group hover:-translate-y-1 hover:shadow-[0_20px_40px_rgba(89,29,63,.1)] transition-all duration-300">
                        <div class="absolute -right-6 -top-6 h-32 w-32 rounded-full bg-purple-100 opacity-50 blur-2xl group-hover:bg-purple-200 transition-colors"></div>
                        <div class="relative z-10">
                            <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-purple-400 to-fuchsia-500 shadow-inner text-white mb-6">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <h3 class="text-2xl font-black text-slate-900">Mind Matrix</h3>
                            <p class="mt-1 text-sm font-semibold text-slate-500">{{ $latestMind->title }}</p>
                            
                            <div class="mt-8 mb-6 text-center bg-white/60 rounded-2xl py-6 ring-1 ring-white shadow-sm backdrop-blur">
                                <span class="text-5xl font-black text-fuchsia-600">{{ $mindScore }}%</span>
                            </div>

                            <div class="space-y-3">
                                <div class="flex items-center justify-between rounded-xl bg-white p-3 shadow-sm ring-1 ring-slate-100">
                                    <span class="text-xs font-bold uppercase tracking-widest text-slate-400">Mood</span>
                                    <span class="text-sm font-black text-slate-800">{{ $latestMind->mood }}</span>
                                </div>
                                <div class="flex items-center justify-between rounded-xl bg-white p-3 shadow-sm ring-1 ring-slate-100">
                                    <span class="text-xs font-bold uppercase tracking-widest text-slate-400">Stress</span>
                                    <span class="text-sm font-black text-slate-800">{{ $latestMind->stress }}</span>
                                </div>
                            </div>
                            
                            <div class="mt-6">
                                <a href="{{ route('assessment.start', 'mind') }}" class="block w-full rounded-xl bg-fuchsia-50 py-3 text-center text-sm font-bold text-fuchsia-700 hover:bg-fuchsia-100 transition">Retake Mind Test</a>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Body Breakdown -->
                    <div class="lg:col-span-1 glass-panel rounded-[32px] p-8 relative overflow-hidden group hover:-translate-y-1 hover:shadow-[0_20px_40px_rgba(89,29,63,.1)] transition-all duration-300">
                        <div class="absolute -left-6 -top-6 h-32 w-32 rounded-full bg-rose-100 opacity-50 blur-2xl group-hover:bg-rose-200 transition-colors"></div>
                        <div class="relative z-10">
                            <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-rose-400 to-rose-600 shadow-inner text-white mb-6">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                            </div>
                            <h3 class="text-2xl font-black text-slate-900">Body Matrix</h3>
                            <p class="mt-1 text-sm font-semibold text-slate-500">{{ $latestBody->title }}</p>
                            
                            <div class="mt-8 mb-6 text-center bg-white/60 rounded-2xl py-6 ring-1 ring-white shadow-sm backdrop-blur">
                                <span class="text-5xl font-black text-rose-600">{{ $bodyScore }}%</span>
                            </div>

                            <div class="space-y-3">
                                <div class="flex items-center justify-between rounded-xl bg-white p-3 shadow-sm ring-1 ring-slate-100">
                                    <span class="text-xs font-bold uppercase tracking-widest text-slate-400">Vitality</span>
                                    <span class="text-sm font-black text-slate-800">{{ $latestBody->mood }}</span>
                                </div>
                                <div class="flex items-center justify-between rounded-xl bg-white p-3 shadow-sm ring-1 ring-slate-100">
                                    <span class="text-xs font-bold uppercase tracking-widest text-slate-400">Tension</span>
                                    <span class="text-sm font-black text-slate-800">{{ $latestBody->stress }}</span>
                                </div>
                            </div>

                            <div class="mt-6">
                                <a href="{{ route('assessment.start', 'body') }}" class="block w-full rounded-xl bg-rose-50 py-3 text-center text-sm font-bold text-rose-700 hover:bg-rose-100 transition">Retake Body Test</a>
                            </div>
                        </div>
                    </div>

                    <!-- Far Right: Recommendations -->
                    <div class="lg:col-span-1 glass-panel rounded-[32px] p-8 flex flex-col relative overflow-hidden bg-white/80">
                        <div class="absolute right-0 bottom-0 opacity-10 pointer-events-none">
                            <svg width="200" height="200" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L2 22h20L12 2z"/></svg>
                        </div>
                        <div class="relative z-10 flex-1 flex flex-col">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="h-8 w-8 rounded-full bg-slate-900 text-white flex items-center justify-center shadow-md">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                </div>
                                <h3 class="text-xl font-black text-slate-900">Next Actions</h3>
                            </div>
                            
                            <div class="flex-1 rounded-2xl bg-slate-50 p-6 ring-1 ring-slate-100 shadow-inner">
                                <p class="text-lg leading-relaxed text-slate-700 font-medium italic">
                                    "{{ $recText }}"
                                </p>
                            </div>
                            
                            <div class="mt-6 pt-6 border-t border-slate-200/60">
                                <p class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-4">Targeted Interventions</p>
                                <ul class="space-y-3">
                                    @if($mindScore < 60)
                                        <li class="flex items-start gap-3">
                                            <svg class="h-5 w-5 shrink-0 text-fuchsia-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            <span class="text-sm font-semibold text-slate-700">Implement daily 10-minute mindfulness sessions to lower cognitive stress.</span>
                                        </li>
                                    @endif
                                    @if($bodyScore < 60)
                                        <li class="flex items-start gap-3">
                                            <svg class="h-5 w-5 shrink-0 text-rose-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            <span class="text-sm font-semibold text-slate-700">Prioritize 8 hours of sleep tonight and engage in light somatic stretching.</span>
                                        </li>
                                    @endif
                                    @if($combinedScore >= 60)
                                        <li class="flex items-start gap-3">
                                            <svg class="h-5 w-5 shrink-0 text-emerald-500 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            <span class="text-sm font-semibold text-slate-700">Maintain current hydration and baseline routine, you are doing well!</span>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Full Width: Detailed Steps to Improve -->
                    <div class="lg:col-span-3 mt-4">
                        <div class="glass-panel rounded-[40px] p-8 sm:p-12 shadow-[0_20px_55px_rgba(89,29,63,.08)] relative overflow-hidden group">
                            <!-- Background Accent -->
                            <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-gradient-to-br from-fuchsia-100 to-rose-100 opacity-50 blur-3xl group-hover:scale-110 transition-transform duration-700 pointer-events-none"></div>
                            
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10 relative z-10 border-b border-slate-200/50 pb-8">
                                <div class="flex items-center gap-5">
                                    <div class="h-14 w-14 rounded-2xl bg-slate-900 text-white flex items-center justify-center shadow-lg transform -rotate-3 ring-4 ring-slate-100">
                                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                    </div>
                                    <div>
                                        <h3 class="text-3xl font-black text-slate-900 tracking-tight">Action Plan</h3>
                                        <div class="flex items-center gap-2 mt-1.5">
                                            <p class="text-xs font-black uppercase tracking-[0.2em] text-fuchsia-600">AI Pro</p>
                                        </div>
                                    </div>
                                </div>

                                @php
                                    $cacheKey = 'ai_credits_' . auth()->id() . '_' . date('Y-m-d');
                                    $creditsUsed = \Illuminate\Support\Facades\Cache::get($cacheKey, 0);
                                    $creditsRemaining = max(0, 2 - $creditsUsed);
                                @endphp

                                <div class="flex items-center gap-4 bg-white/80 backdrop-blur px-5 py-3 rounded-2xl ring-1 ring-slate-200 shadow-sm shrink-0">
                                    <div class="text-right">
                                        <p class="text-[10px] font-bold uppercase tracking-[0.1em] text-slate-400">Daily Credits</p>
                                        <p class="text-sm font-black text-slate-800"><span id="credit-count" class="{{ $creditsRemaining > 0 ? 'text-emerald-600' : 'text-rose-600' }}">{{ $creditsRemaining }}</span> / 2</p>
                                    </div>
                                    <div class="h-8 w-px bg-slate-200"></div>
                                    <button id="start-ai-btn" class="inline-flex items-center gap-2 rounded-xl bg-fuchsia-600 px-5 py-2.5 text-sm font-bold text-white transition-all hover:scale-105 hover:shadow-[0_10px_20px_rgba(225,29,72,.25)] disabled:opacity-50 disabled:pointer-events-none group/btn">
                                        <span>Generate Now</span>
                                        <svg class="h-4 w-4 group-hover/btn:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Initial Empty State -->
                            <div id="ai-empty-state" class="flex flex-col items-center justify-center py-10 text-center relative z-10">
                                <div class="h-20 w-20 rounded-full bg-slate-50 flex items-center justify-center mb-6 ring-1 ring-slate-100">
                                    <svg class="h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                                </div>
                                <h4 class="text-xl font-bold text-slate-800">Ready for Synthesis</h4>
                                <p class="mt-2 text-slate-500 max-w-md mx-auto text-sm leading-relaxed">Click generate to let the Gemini engine build a personalized, step-by-step action plan using your latest Mind and Body metrics.</p>
                            </div>

                            <div id="ai-loading" class="hidden py-16 flex-col items-center justify-center relative z-10">
                                <div class="relative flex items-center justify-center">
                                    <div class="absolute inset-0 h-16 w-16 rounded-full border-4 border-fuchsia-100 opacity-50"></div>
                                    <div class="h-16 w-16 animate-spin rounded-full border-4 border-transparent border-t-fuchsia-600 border-l-fuchsia-600"></div>
                                </div>
                                <p class="mt-6 text-sm font-black uppercase tracking-[0.2em] text-fuchsia-600 animate-pulse">Running Neural Synthesis...</p>
                                <p class="mt-2 text-xs text-slate-400">This may take up to 30 seconds.</p>
                            </div>

                            <!-- AI Response Container -->
                            <div id="ai-response-container" class="hidden mt-4 bg-white/90 backdrop-blur p-8 sm:p-12 rounded-[32px] ring-1 ring-slate-200 shadow-[0_10px_40px_rgba(0,0,0,.03)] relative z-10 transition-all">
                                <div class="prose prose-lg max-w-none 
                                    prose-headings:font-black prose-headings:tracking-tight prose-headings:text-slate-900 
                                    prose-h2:text-3xl prose-h2:border-b prose-h2:border-slate-100 prose-h2:pb-4 prose-h2:mb-6 prose-h2:mt-10
                                    prose-h3:text-2xl prose-h3:text-fuchsia-800 prose-h3:mt-8 prose-h3:mb-4
                                    prose-p:text-slate-600 prose-p:leading-loose prose-p:font-medium prose-p:mb-6
                                    prose-strong:text-slate-900 prose-strong:bg-fuchsia-50 prose-strong:px-1 prose-strong:rounded
                                    prose-ul:list-none prose-ul:pl-0 prose-ul:mt-6 prose-ul:mb-8
                                    prose-li:relative prose-li:pl-8 prose-li:mb-5 prose-li:text-slate-700 prose-li:leading-relaxed
                                    prose-li:before:content-[''] prose-li:before:absolute prose-li:before:left-0 prose-li:before:top-2.5 prose-li:before:h-2.5 prose-li:before:w-2.5 prose-li:before:rounded-full prose-li:before:bg-fuchsia-500 prose-li:before:ring-4 prose-li:before:ring-fuchsia-100">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        @endif
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof marked !== 'undefined') {
                marked.use({ breaks: true, gfm: true });
            }

            const btn = document.getElementById('start-ai-btn');
            const loading = document.getElementById('ai-loading');
            const responseContainer = document.getElementById('ai-response-container');
            const proseContainer = responseContainer.querySelector('.prose');
            const emptyState = document.getElementById('ai-empty-state');
            const creditCount = document.getElementById('credit-count');

            if (btn) {
                btn.addEventListener('click', async () => {
                    btn.disabled = true;
                    if(emptyState) emptyState.classList.add('hidden');
                    loading.classList.remove('hidden');
                    loading.classList.add('flex');
                    responseContainer.classList.add('hidden');
                    
                    try {
                        const response = await fetch('{{ route("assessment.ai-analysis") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        });
                        
                        const data = await response.json();
                        
                        loading.classList.add('hidden');
                        loading.classList.remove('flex');
                        
                        if (response.ok) {
                            proseContainer.innerHTML = marked.parse(data.content);
                            responseContainer.classList.remove('hidden');
                            creditCount.innerText = data.credits_remaining;
                            
                            if (data.credits_remaining <= 0) {
                                creditCount.classList.remove('text-emerald-600');
                                creditCount.classList.add('text-rose-600');
                                btn.disabled = true;
                                btn.innerHTML = '<span>Limit Reached</span>';
                                btn.disabled = true;
                                btn.innerHTML = '<span>Daily Limit Reached</span>';
                            } else {
                                btn.disabled = false;
                            }
                        } else {
                            responseContainer.innerHTML = `<p class="text-rose-600 font-bold">Error: ${data.error}</p>`;
                            responseContainer.classList.remove('hidden');
                            if (data.error.includes("Daily limit")) {
                                btn.innerHTML = '<span>Daily Limit Reached</span>';
                            } else {
                                btn.disabled = false;
                            }
                        }
                    } catch (error) {
                        loading.classList.add('hidden');
                        loading.classList.remove('flex');
                        responseContainer.innerHTML = `<p class="text-rose-600 font-bold">Network Error: Failed to contact the server.</p>`;
                        responseContainer.classList.remove('hidden');
                        btn.disabled = false;
                    }
                });
            }
        });
    </script>
</body>
</html>
