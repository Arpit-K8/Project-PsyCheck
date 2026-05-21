<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PsyCheck | Dashboard</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />
    <!-- Font Awesome for icon fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Instrument Sans', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-[#f8ebf1] bg-[radial-gradient(circle_at_50%_-20%,#b23673_0,#e39fb8_34%,#f8ebf1_82%)] text-slate-800 antialiased selection:bg-fuchsia-200 selection:text-fuchsia-900">
    <div class="mx-auto min-h-screen max-w-7xl px-4 pb-10 pt-6 sm:px-8 lg:px-10">
        @php
            $latestMindResult = \App\Models\AssessmentResult::where('user_id', auth()->id())
                ->where('module_name', 'mind')
                ->orderBy('created_at', 'desc')
                ->first();
            $latestBodyResult = \App\Models\AssessmentResult::where('user_id', auth()->id())
                ->where('module_name', 'body')
                ->orderBy('created_at', 'desc')
                ->first();

            $dashScore1 = $latestMindResult ? $latestMindResult->score : 0;
            $bodyScore = $latestBodyResult ? $latestBodyResult->score : 0;
            $combinedScore = ($dashScore1 + $bodyScore) / 2;
            
            $dashCircumference = 666.02;
            $dashOffset1 = $dashCircumference - ($dashScore1 / 100) * $dashCircumference;
            $dashOffset2 = $dashCircumference - ($combinedScore / 100) * $dashCircumference;
            
            // Mood balance (1-10)
            $moodBalance = $latestMindResult ? number_format($dashScore1 / 10, 1) : 'N/A';
            $moodDiff = $latestMindResult ? '+0.0' : ''; // simplified for now
            
            // Stress load
            $stressLoad = $latestMindResult ? $latestMindResult->stress : 'No Data';
            $stressStr = strtolower($stressLoad);
            $stressDesc = match(true) {
                str_contains($stressStr, 'low') => 'manageable today',
                str_contains($stressStr, 'moderate') => 'approaching limit',
                str_contains($stressStr, 'high') || str_contains($stressStr, 'severe') => 'requires attention',
                default => 'take an assessment'
            };
            $stressColorClass = match(true) {
                str_contains($stressStr, 'low') => 'text-rose-500',
                str_contains($stressStr, 'moderate') => 'text-fuchsia-600',
                str_contains($stressStr, 'high') || str_contains($stressStr, 'severe') => 'text-slate-900',
                default => 'text-slate-500'
            };
            $stressBgClass = match(true) {
                str_contains($stressStr, 'low') => 'bg-rose-50 text-rose-600',
                str_contains($stressStr, 'moderate') => 'bg-fuchsia-50 text-fuchsia-600',
                str_contains($stressStr, 'high') || str_contains($stressStr, 'severe') => 'bg-slate-100 text-slate-700',
                default => 'bg-slate-50 text-slate-600'
            };

            // Sleep quality
            $sleepQuality = $latestBodyResult ? number_format($bodyScore / 10, 1) : 'N/A';
            
            // Next check-in
            $lastCheckin = $latestMindResult ? $latestMindResult->created_at : null;
            $daysSince = $lastCheckin ? $lastCheckin->diffInDays(now()) : 0;
            $daysUntil = round(max(0, 3 - $daysSince));
            $checkinText = $latestMindResult ? ($daysUntil > 0 ? $daysUntil . 'd' : 'Today') : 'Now';
            
            // Recommendations
            if ($combinedScore == 0) {
                $recTitle = "Action Required: Take Assessments";
                $recDesc = "Please give your test first of both modules. This allows PsyCheck and the AI Analysis module to dynamically generate your personalized wellness steps.";
                $recStep1 = "1. Take the Mind Assessment";
                $recStep2 = "2. Take the Body Assessment";
                $recStep3 = "3. Unlock PRO AI Analysis";
            } else {
                if ($dashScore1 < 50) {
                    $recTitle = "Cognitive Decompression";
                    $recDesc = "Your mind score (" . $dashScore1 . "%) and " . strtolower($latestMindResult->stress ?? 'high') . " stress levels indicate cognitive load. Prioritize mental rest.";
                    $recStep1 = "1. Try a 10 minute breathing session";
                    $recStep2 = "2. Digital detox 1 hour before bed";
                    $recStep3 = "3. Run PRO AI Analysis for deeper insights";
                } elseif ($bodyScore < 50) {
                    $recTitle = "Somatic Recovery";
                    $recDesc = "Your physical vitality (" . $bodyScore . "%) is lagging. Focus on sleep and physical rest to restore energy reserves.";
                    $recStep1 = "1. Prioritize 8 hours of sleep tonight";
                    $recStep2 = "2. Do 5 minutes of light stretching";
                    $recStep3 = "3. Run PRO AI Analysis for customized steps";
                } else {
                    $recTitle = "Maintain Optimal Flow";
                    $recDesc = "Both mind (" . $dashScore1 . "%) and body (" . $bodyScore . "%) are in sync. Stick to your routines and preserve this " . strtolower($latestMindResult->mood ?? 'good') . " mood.";
                    $recStep1 = "1. Continue your current sleep schedule";
                    $recStep2 = "2. Log your mood to track this peak state";
                    $recStep3 = "3. Run PRO AI Analysis to optimize further";
                }
            }

            // Personal status
            if ($combinedScore == 0) {
                $statusTitle = 'Pending baseline';
                $statusLabel = 'setup';
                $statusBg = 'bg-slate-50 text-slate-700';
                $statusColorClass = 'text-slate-600';
            } else {
                $statusTitle = $combinedScore >= 70 ? 'You are on track' : ($combinedScore >= 40 ? 'Needs Calibration' : 'Critical Action Needed');
                $statusLabel = $combinedScore >= 70 ? 'active' : 'attention';
                $statusBg = $combinedScore >= 70 ? 'bg-fuchsia-50 text-fuchsia-700' : 'bg-rose-50 text-rose-700';
                $statusColorClass = $combinedScore >= 70 ? 'text-fuchsia-600' : 'text-rose-600';
            }

            $snapshotHeader = $combinedScore >= 60 ? 'Stable and improving' : ($combinedScore > 0 ? 'Needs attention' : 'Ready for tracking');

            // Weekly Trend Logic
            $trendBars = [];
            $trendLabels = [];
            $startDate = now()->subDays(6)->startOfDay();
            
            $weeklyResults = \App\Models\AssessmentResult::where('user_id', auth()->id())
                ->where('created_at', '>=', $startDate)
                ->get()
                ->groupBy(function($date) {
                    return \Carbon\Carbon::parse($date->created_at)->format('D'); // e.g. 'Mon'
                });

            // Fill array to maintain 7 days order
            for ($i = 6; $i >= 0; $i--) {
                $day = now()->subDays($i);
                $dayName = $day->format('D');
                $trendLabels[] = $dayName;
                
                if ($weeklyResults->has($dayName)) {
                    $avgScore = $weeklyResults->get($dayName)->avg('score');
                    $trendBars[] = round($avgScore);
                } else {
                    $trendBars[] = 0;
                }
            }

            // Notifications Logic
            $notifications = [];

            // Critical Score Alert / Crisis Safeguard
            $isMindCritical = $latestMindResult && $latestMindResult->score < 50;
            $isBodyCritical = $latestBodyResult && $latestBodyResult->score < 50;
            
            if ($isMindCritical || $isBodyCritical) {
                $criticalDetails = [];
                if ($isMindCritical) {
                    $criticalDetails[] = 'Mind (' . $latestMindResult->score . '%)';
                }
                if ($isBodyCritical) {
                    $criticalDetails[] = 'Body (' . $latestBodyResult->score . '%)';
                }
                $detailsStr = implode(' & ', $criticalDetails);
                
                $emergencyPhone = auth()->user()->emergency_contact_phone;
                $emergencyPhoneHtml = !empty($emergencyPhone) 
                    ? ' or call your emergency contact at <a href="tel:' . e($emergencyPhone) . '" class="underline font-black text-rose-700 hover:text-rose-900">' . e($emergencyPhone) . '</a>'
                    : '';
                
                $notifications[] = [
                    'id' => 'critical_emergency_alert',
                    'bgClass' => 'bg-rose-50 animate-pulse',
                    'ringClass' => 'ring-rose-100',
                    'textClass' => 'text-rose-600 font-extrabold',
                    'title' => 'Safeguard: Stay Calm',
                    'message' => 'Your recent ' . $detailsStr . ' check-in shows a low health score. Please <strong>stay calm, take a deep breath</strong>, and do not panic. If you are in immediate distress, please call emergency services (<strong>108 / 112</strong>)' . $emergencyPhoneHtml . ' immediately.'
                ];
            }
            
            if ($daysSince >= 2) {
                $notifications[] = [
                    'id' => 'overdue_1',
                    'bgClass' => 'bg-rose-50',
                    'ringClass' => 'ring-rose-100',
                    'textClass' => 'text-rose-600',
                    'title' => 'Check-in overdue',
                    'message' => 'You haven\'t taken an assessment in ' . floor($daysSince) . ' days. Complete one today to keep your trend data accurate.'
                ];
            }
            
            if ($latestMindResult && $daysSince < 2) {
                $notifications[] = [
                    'id' => 'score_update_1',
                    'bgClass' => 'bg-fuchsia-50',
                    'ringClass' => 'ring-fuchsia-100',
                    'textClass' => 'text-fuchsia-600',
                    'title' => 'Score update',
                    'message' => 'Your latest mind score is <span class="font-black text-fuchsia-700">' . $latestMindResult->score . '%</span>. Keep up the momentum!'
                ];
            }

            // Support Circle & Goals variables
            $user = auth()->user();
            $targetScore = $user->target_score ?? 75;
            $streakDays = $user->streak_days ?? 0;
            $consistencyRate = $user->consistency_rate ?? 0;
            $emergencyName = $user->emergency_contact_name;
            $emergencyPhone = $user->emergency_contact_phone;
            $trustedEmail = $user->trusted_email;
            $alertOnCritical = $user->alert_on_critical ?? true;

            // Calculate progress to goal
            $goalProgress = $targetScore > 0 ? min(100, round(($combinedScore / $targetScore) * 100)) : 0;
        @endphp

        @include('layouts.dashboard-navigation')

        <main class="grid gap-6 xl:grid-cols-[minmax(0,1.45fr)_minmax(320px,0.95fr)]">
            <section class="space-y-6">
                <article class="overflow-hidden rounded-[36px] bg-white shadow-[0_24px_70px_rgba(89,29,63,.14)]">
                    <div class="grid gap-0 lg:grid-cols-[1.1fr_0.9fr]">
                        <div class="relative p-7 sm:p-10">
                            <div class="absolute right-6 top-6 h-24 w-24 rounded-full bg-[radial-gradient(circle,#e39fb8_2px,transparent_2px)] bg-[length:18px_18px] opacity-45"></div>
                            <p class="text-sm font-bold uppercase tracking-[0.28em] text-fuchsia-600">Wellness Snapshot</p>
                            <h1 class="mt-4 max-w-xl text-4xl font-black leading-tight text-slate-900 sm:text-5xl">
                                Your holistic health is <span class="text-fuchsia-700">{{ strtolower($snapshotHeader) }}</span>.
                            </h1>
                            <p class="mt-5 max-w-lg text-lg leading-8 text-slate-600">
                                PsyCheck gives you a personal view of your mental wellbeing, current mood, stress, and the next step that fits your results.
                            </p>

                            <div class="mt-8 flex flex-wrap gap-4">
                                <a href="#summary" class="inline-flex items-center gap-2 rounded-2xl bg-fuchsia-700 px-6 py-3 text-sm font-semibold text-white shadow-[0_12px_26px_rgba(114,29,100,.28)] transition hover:-translate-y-0.5 hover:bg-fuchsia-800">
                                    View my summary
                                </a>
                                <a href="#recommendation" class="inline-flex items-center gap-2 rounded-2xl bg-fuchsia-50 px-6 py-3 text-sm font-semibold text-fuchsia-700 transition hover:bg-fuchsia-100">
                                    See recommendations
                                </a>
                            </div>
                        </div>

                        <div class="border-t border-fuchsia-50 bg-[linear-gradient(180deg,#fff7fb_0%,#fff3f7_100%)] p-7 sm:p-10 lg:border-l lg:border-t-0">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-bold uppercase tracking-[0.24em] text-fuchsia-600">Current status</p>
                                    <p class="mt-2 text-xl font-extrabold text-slate-900">{{ $snapshotHeader }}</p>
                                </div>
                            </div>

                            <div class="mt-8 flex justify-center">
                                <div class="relative flex h-64 w-64 items-center justify-center rounded-full bg-[linear-gradient(180deg,#fff7fb_0%,#fff1f6_100%)] shadow-inner shadow-fuchsia-100">
                                    <svg class="absolute inset-0 h-full w-full -rotate-90 transform" viewBox="0 0 240 240">
                                        <circle cx="120" cy="120" r="106" stroke="#fae8ff" stroke-width="16" fill="none" />
                                        <circle cx="120" cy="120" r="106" stroke="#c026d3" stroke-width="16" fill="none" stroke-linecap="round" 
                                                stroke-dasharray="666.02" 
                                                stroke-dashoffset="{{ $dashOffset1 }}" 
                                                class="transition-all duration-1000 ease-out" />
                                    </svg>
                                    <div class="text-center relative z-10 px-4">
                                        <p class="text-5xl font-black tracking-tight text-slate-900">{{ $dashScore1 }}%</p>
                                        <p class="mt-2 text-xs font-semibold uppercase tracking-[0.2em] text-fuchsia-600">Mind balance</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8 flex flex-col gap-3">
                                <div class="rounded-2xl bg-white px-5 py-4 shadow-sm ring-1 ring-fuchsia-100/70 flex items-center justify-between">
                                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Mood</p>
                                    <p class="text-xl font-black text-fuchsia-700">{{ $latestMindResult ? ucfirst(strtolower($latestMindResult->mood)) : 'N/A' }}</p>
                                </div>
                                <div class="rounded-2xl bg-white px-5 py-4 shadow-sm ring-1 ring-fuchsia-100/70 flex items-center justify-between">
                                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Stress</p>
                                    <p class="text-xl font-black {{ $stressColorClass }}">{{ ucfirst(strtolower($stressLoad)) }}</p>
                                </div>
                                <div class="rounded-2xl bg-white px-5 py-4 shadow-sm ring-1 ring-fuchsia-100/70 flex items-center justify-between">
                                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Vitality</p>
                                    <p class="text-xl font-black text-fuchsia-700">{{ $latestBodyResult ? ucfirst(strtolower($latestBodyResult->mood)) : 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>

                <section id="assessment-menus" class="rounded-[32px] bg-white p-8 shadow-[0_20px_55px_rgba(89,29,63,.1)] ring-1 ring-fuchsia-100/70">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-bold uppercase tracking-[0.24em] text-fuchsia-600">Assessment Menus</p>
                            <h2 class="mt-2 text-2xl font-extrabold text-slate-900">Choose your assessment</h2>
                        </div>
                        <span class="rounded-full bg-fuchsia-50 px-3 py-2 text-xs font-semibold text-fuchsia-700">3 tracks</span>
                    </div>

                    <div class="mt-6 grid gap-4 md:grid-cols-3">
                        <a href="{{ route('assessment.start', ['track' => 'mind']) }}" class="group rounded-[24px] bg-[linear-gradient(180deg,#fff7fb_0%,#fff1f6_100%)] p-5 ring-1 ring-fuchsia-100 transition hover:-translate-y-1 hover:shadow-[0_12px_28px_rgba(190,24,93,.16)]">
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-fuchsia-600">Mind</p>
                            <h3 class="mt-2 text-xl font-black text-slate-900">Mind Assessment</h3>
                            <p class="mt-2 text-sm text-slate-600">Measure mood, stress patterns, and emotional balance today.</p>
                            <p class="mt-4 text-sm font-semibold text-fuchsia-700 group-hover:text-fuchsia-800">Start now -></p>
                        </a>
                        
                        <a href="{{ route('assessment.start', ['track' => 'body']) }}" class="group rounded-[24px] bg-[linear-gradient(180deg,#fff7fb_0%,#fff1f6_100%)] p-5 ring-1 ring-fuchsia-100 transition hover:-translate-y-1 hover:shadow-[0_12px_28px_rgba(190,24,93,.16)]">
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-fuchsia-600">Body</p>
                            <h3 class="mt-2 text-xl font-black text-slate-900">Body Assessment</h3>
                            <p class="mt-2 text-sm text-slate-600">Check physical wellbeing, sleep rhythm, and daily energy level.</p>
                            <p class="mt-4 text-sm font-semibold text-fuchsia-700 group-hover:text-fuchsia-800">Start now -></p>
                        </a>

                        <a href="{{ route('assessment.start', ['track' => 'analysis']) }}" class="group rounded-[24px] bg-[linear-gradient(180deg,#fff7fb_0%,#fff1f6_100%)] p-5 ring-1 ring-fuchsia-100 transition hover:-translate-y-1 hover:shadow-[0_12px_28px_rgba(190,24,93,.16)]">
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-fuchsia-600">Analysis</p>
                            <h3 class="mt-2 text-xl font-black text-slate-900">Analysis Assessment</h3>
                            <p class="mt-2 text-sm text-slate-600">Review combined score trends and next-action recommendations.</p>
                            <p class="mt-4 text-sm font-semibold text-fuchsia-700 group-hover:text-fuchsia-800">Start now -></p>
                        </a>
                    </div>
                </section>

                <section id="summary" class="grid gap-5 sm:grid-cols-2 xl:grid-cols-4">
                    <article class="rounded-[28px] bg-white p-6 shadow-[0_20px_55px_rgba(89,29,63,.1)] ring-1 ring-fuchsia-100/70 transition hover:-translate-y-1">
                        <p class="text-sm font-semibold text-slate-500">Mood balance</p>
                        <div class="mt-4 flex items-end justify-between gap-4">
                            <div>
                                <p class="text-4xl font-black text-fuchsia-700">{{ $moodBalance }}</p>
                                <p class="mt-1 text-sm text-slate-400">out of 10</p>
                            </div>
                            @if($moodBalance !== 'N/A')
                                <div class="rounded-2xl bg-fuchsia-50 px-3 py-2 text-sm font-semibold text-fuchsia-700 whitespace-nowrap">{{ $dashScore1 >= 50 ? 'Good' : 'Fair' }}</div>
                            @endif
                        </div>
                    </article>

                    <article class="rounded-[28px] bg-white p-6 shadow-[0_20px_55px_rgba(89,29,63,.1)] ring-1 ring-fuchsia-100/70 transition hover:-translate-y-1">
                        <p class="text-sm font-semibold text-slate-500">Stress load</p>
                        <div class="mt-4 flex items-end justify-between gap-4">
                            <div>
                                <p class="text-3xl tracking-tight sm:text-4xl font-black leading-none {{ $stressColorClass }}">{{ ucfirst(strtolower($stressLoad)) }}</p>
                                <p class="mt-2 text-sm text-slate-400">{{ $stressDesc }}</p>
                            </div>
                            <div class="rounded-2xl {{ $stressBgClass }} px-3 py-2 text-sm font-semibold whitespace-nowrap">{{ $dashScore1 > 0 ? 'logged' : 'N/A' }}</div>
                        </div>
                    </article>

                    <article class="rounded-[28px] bg-white p-6 shadow-[0_20px_55px_rgba(89,29,63,.1)] ring-1 ring-fuchsia-100/70 transition hover:-translate-y-1">
                        <p class="text-sm font-semibold text-slate-500">Vitality & Sleep</p>
                        <div class="mt-4 flex items-end justify-between gap-4">
                            <div>
                                <p class="text-4xl font-black text-fuchsia-700">{{ $sleepQuality }}</p>
                                <p class="mt-1 text-sm text-slate-400">out of 10</p>
                            </div>
                            <div class="rounded-2xl bg-fuchsia-50 px-3 py-2 text-sm font-semibold text-fuchsia-700 whitespace-nowrap">steady</div>
                        </div>
                    </article>

                    <article class="rounded-[28px] bg-white p-6 shadow-[0_20px_55px_rgba(89,29,63,.1)] ring-1 ring-fuchsia-100/70 transition hover:-translate-y-1">
                        <p class="text-sm font-semibold text-slate-500">Next check-in</p>
                        <div class="mt-4 flex items-end justify-between gap-4">
                            <div>
                                <p class="text-4xl font-black text-slate-900">{{ $checkinText }}</p>
                                <p class="mt-1 text-sm text-slate-400">{{ $checkinText === 'Today' ? 'due now' : 'keep tracking progress' }}</p>
                            </div>
                            <div class="rounded-2xl bg-fuchsia-50 px-3 py-2 text-sm font-semibold text-fuchsia-700">reminder on</div>
                        </div>
                </section>

                <!-- Goals & Support Circle Grid Section -->
                <section class="grid gap-6 md:grid-cols-2">
                    <!-- Wellness Goals & Milestones Card -->
                    <article class="rounded-[32px] md:col-span-2 bg-white p-8 shadow-[0_20px_55px_rgba(89,29,63,.1)] ring-1 ring-fuchsia-100/70 flex flex-col justify-between transition hover:shadow-lg">
                        <div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-fuchsia-600">Wellness Goals</p>
                                    <h3 class="mt-2 text-2xl font-extrabold text-slate-900">Goals & Activity</h3>
                                </div>
                                <div class="flex items-center gap-1.5 rounded-full bg-rose-50 px-3.5 py-1.5 text-xs font-bold text-rose-600 shadow-sm ring-1 ring-rose-100">
                                    <span>{{ $streakDays }} Day Streak</span>
                                </div>
                            </div>

                            <!-- Goal Progress bar -->
                            <div class="mt-8 rounded-[24px] bg-fuchsia-50/40 p-5 ring-1 ring-fuchsia-100/60">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-[10px] font-bold uppercase tracking-[0.16em] text-slate-400">Baseline Target</p>
                                        <p class="mt-1 text-base font-black text-slate-800">{{ $targetScore }}% <span class="text-[10px] font-medium text-slate-500">health</span></p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-[10px] font-bold uppercase tracking-[0.16em] text-slate-400">Goal Progress</p>
                                        <p class="mt-1 text-base font-black text-fuchsia-700">{{ $goalProgress }}% <span class="text-[10px] font-medium text-fuchsia-500">reached</span></p>
                                    </div>
                                </div>

                                <!-- Progress bar track -->
                                <div class="mt-4 h-3.5 w-full rounded-full bg-fuchsia-100/70 overflow-hidden ring-1 ring-fuchsia-200/50">
                                    <div class="h-full rounded-full bg-[linear-gradient(90deg,#be185d_0%,#c026d3_100%)] shadow-inner transition-all duration-1000 ease-out" style="width: {{ $goalProgress }}%"></div>
                                </div>
                                <p class="mt-4 text-xs leading-5 text-slate-500">
                                    @if($combinedScore == 0)
                                        Take assessments to calculate your current wellness balance and see progress to your target!
                                    @elseif($combinedScore >= $targetScore)
                                        🎉 <span class="font-bold text-fuchsia-700">Incredible!</span> You've met or exceeded your target score. Keep up the amazing momentum!
                                    @else
                                        You are currently at <strong class="font-extrabold text-slate-700">{{ $combinedScore }}%</strong>. Continue checking in regularly to raise your balance!
                                    @endif
                                </p>
                            </div>
                        </div>

                        <!-- Consistency details -->
                        <div class="mt-6 grid grid-cols-2 gap-4">
                            <div class="rounded-2xl bg-slate-50 p-4 border border-slate-100 flex items-center gap-3.5">
                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white text-fuchsia-600 font-extrabold text-sm shadow-sm ring-1 ring-fuchsia-100">
                                    {{ $streakDays }}d
                                </div>
                                <div class="min-w-0">
                                    <p class="text-[9px] font-bold uppercase tracking-wider text-slate-400 truncate">Check-in Streak</p>
                                    <p class="text-xs font-black text-slate-800 truncate">{{ $streakDays > 0 ? $streakDays . ' Days Active' : 'No Active Streak' }}</p>
                                </div>
                            </div>

                            <div class="rounded-2xl bg-slate-50 p-4 border border-slate-100 flex items-center gap-3.5">
                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white text-fuchsia-700 font-extrabold text-sm shadow-sm ring-1 ring-fuchsia-100">
                                    {{ $consistencyRate }}%
                                </div>
                                <div class="min-w-0">
                                    <p class="text-[9px] font-bold uppercase tracking-wider text-slate-400 truncate">Consistency (30d)</p>
                                    <p class="text-xs font-black text-slate-800 truncate">{{ $consistencyRate }}% Check-in Rate</p>
                                </div>
                            </div>
                        </div>
                    </article>
                </section>

                <section>
                    <article id="recommendation" class="rounded-[32px] bg-white p-7 shadow-[0_20px_55px_rgba(89,29,63,.1)] ring-1 ring-fuchsia-100/70">
                        <p class="text-2xl font-extrabold text-slate-900">Recommended next step</p>
                        <p class="mt-2 text-sm text-slate-500">Based on your latest assessment, this is the most relevant action for you.</p>

                        <div class="mt-6 rounded-[28px] bg-fuchsia-50 p-5 ring-1 ring-fuchsia-100">
                            <p class="text-sm font-bold uppercase tracking-[0.24em] text-fuchsia-600">Focus area</p>
                            <h2 class="mt-3 text-3xl font-black text-slate-900">{{ $recTitle }}</h2>
                            <p class="mt-3 text-base leading-7 text-slate-600">
                                {{ $recDesc }}
                            </p>
                            <div class="mt-5 space-y-3">
                                <div class="rounded-2xl bg-white px-4 py-3 text-sm font-semibold text-slate-700 shadow-sm ring-1 ring-fuchsia-100">{{ $recStep1 }}</div>
                                <div class="rounded-2xl bg-white px-4 py-3 text-sm font-semibold text-slate-700 shadow-sm ring-1 ring-fuchsia-100">{{ $recStep2 }}</div>
                                <div class="rounded-2xl bg-white px-4 py-3 text-sm font-semibold text-slate-700 shadow-sm ring-1 ring-fuchsia-100">{{ $recStep3 }}</div>
                            </div>
                        </div>
                    </article>
                </section>

                <section>
                    <article class="rounded-[32px] bg-white p-8 shadow-[0_20px_55px_rgba(89,29,63,.1)] ring-1 ring-fuchsia-100/70">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-2xl font-extrabold text-slate-900">Your weekly wellness score trend</p>
                                <p class="mt-1 text-sm text-slate-500">Daily mental wellbeing score tracking (0-100 scale)</p>
                            </div>
                            <span class="rounded-full bg-fuchsia-50 px-3 py-2 text-sm font-semibold text-fuchsia-700">last 7 days</span>
                        </div>

                        <!-- Graph Legend & Scale Reference -->
                        <div class="mt-6 grid grid-cols-3 gap-4 rounded-2xl bg-slate-50 p-4">
                            <div class="text-center">
                                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Scale</p>
                                <p class="mt-1 text-sm font-bold text-slate-600">0 - 100</p>
                            </div>
                            <div class="text-center">
                                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Bar Height</p>
                                <p class="mt-1 text-sm font-bold text-slate-600">Daily Score</p>
                            </div>
                            <div class="text-center">
                                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-slate-400">Bar Color</p>
                                <div class="mt-1 h-2 w-full rounded-full bg-fuchsia-600"></div>
                            </div>
                        </div>

                        <div class="mt-8 rounded-[28px] bg-[linear-gradient(180deg,#fff7fb_0%,#fff1f6_100%)] p-5">
                            <!-- Y-axis scale indicator -->
                            <div class="relative flex h-72 items-end gap-4">
                                <!-- Score markers on the left -->
                                <div class="absolute left-0 top-0 flex h-72 flex-col justify-between text-[10px] font-semibold text-slate-300">
                                    <span>100</span>
                                    <span>75</span>
                                    <span>50</span>
                                    <span>25</span>
                                    <span>0</span>
                                </div>
                                
                                <!-- Bar chart container with left padding for scale -->
                                <div class="ml-8 flex w-full items-end gap-4">
                                    @foreach ($trendBars as $index => $height)
                                        <div class="flex flex-1 flex-col items-center justify-end gap-3">
                                            <!-- Bar with score tooltip on hover -->
                                            <div 
                                                class="group relative w-full max-w-[34px] rounded-t-full bg-fuchsia-600 shadow-[0_12px_28px_rgba(114,29,100,.22)] transition hover:shadow-[0_16px_36px_rgba(114,29,100,.28)] hover:bg-fuchsia-700" 
                                                style="height: {{ $height * 2 }}px"
                                                title="Score: {{ $height }}/100"
                                            >
                                                <!-- Score value tooltip -->
                                                <span class="absolute -top-7 left-1/2 -translate-x-1/2 whitespace-nowrap rounded-lg bg-slate-900 px-2 py-1 text-xs font-bold text-white opacity-0 transition group-hover:opacity-100">{{ $height }}</span>
                                            </div>
                                            <!-- Day label -->
                                            <span class="text-xs font-semibold text-slate-600">{{ $trendLabels[$index] }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Chart interpretation guide -->
                        <div class="mt-5 flex gap-4 rounded-2xl bg-fuchsia-50 p-4 ring-1 ring-fuchsia-100">
                            <div class="flex-1">
                                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-fuchsia-600">How to read this graph</p>
                                <p class="mt-2 text-sm text-slate-700">Each bar represents your daily wellness score based on your assessments. Taller bars indicate better holistic wellbeing and alignment for that specific day.</p>
                            </div>
                        </div>
                    </article>
                </section>
            </section>
            
            <aside class="space-y-6">
                <article class="rounded-[32px] bg-white p-6 shadow-[0_20px_55px_rgba(89,29,63,.1)] ring-1 ring-fuchsia-100/70">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-bold uppercase tracking-[0.24em] text-fuchsia-600">Profile</p>
                            <h3 class="mt-2 text-2xl font-extrabold text-slate-900">Your account</h3>
                        </div>
                        <div class="rounded-full bg-fuchsia-50 px-3 py-2 text-sm font-semibold text-fuchsia-700">{{ __("You're logged in!") }}</div>
                    </div>
                    
                    <div class="mt-6 rounded-[28px] bg-[linear-gradient(180deg,#fff7fb_0%,#fff1f6_100%)] p-6 ring-1 ring-fuchsia-100">
                        <div class="flex items-center gap-4">
                            <div class="flex h-16 w-16 items-center justify-center rounded-3xl bg-fuchsia-600 text-2xl font-black text-white shadow-[0_12px_30px_rgba(194,37,112,.28)]">
                                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-lg font-bold text-slate-900">{{ auth()->user()->name ?? 'User' }}</p>
                                <p class="text-sm text-slate-500">{{ auth()->user()->email ?? 'user@example.com' }}</p>
                            </div>
                        </div>
                        
                        <div class="mt-6 grid gap-3 sm:grid-cols-2">
                            <div class="rounded-2xl bg-white px-4 py-3 shadow-sm ring-1 ring-fuchsia-100">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Account state</p>
                                <p class="mt-2 text-sm font-bold text-slate-900">Active and secure</p>
                            </div>
                            <div class="rounded-2xl bg-white px-4 py-3 shadow-sm ring-1 ring-fuchsia-100">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Last login</p>
                                <p class="mt-2 text-sm font-bold text-slate-900">Today</p>
                            </div>
                        </div>
                        
                        <div class="mt-5 space-y-3">
                            <a href="{{ route('profile.edit') }}" class="flex items-center justify-between rounded-2xl bg-fuchsia-700 px-4 py-3 text-sm font-semibold text-white shadow-[0_12px_26px_rgba(114,29,100,.22)] transition hover:bg-fuchsia-800">
                                <span>Edit profile details</span>
                                <span>›</span>
                            </a>
                            <a href="{{ route('profile.edit') }}" class="flex items-center justify-between rounded-2xl bg-white px-4 py-3 text-sm font-semibold text-slate-700 ring-1 ring-fuchsia-100 transition hover:bg-fuchsia-50 hover:text-fuchsia-700">
                                <span>Update password</span>
                                <span>›</span>
                            </a>
                        </div>
                    </div>
                </article>

                <article class="rounded-[32px] bg-white p-6 shadow-[0_20px_55px_rgba(89,29,63,.1)] ring-1 ring-fuchsia-100/70">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-bold uppercase tracking-[0.24em] text-fuchsia-600">Notifications</p>
                            <h3 class="mt-2 text-2xl font-extrabold text-slate-900">Recent alerts</h3>
                        </div>
                        <span class="js-notification-badge rounded-full {{ count($notifications) > 0 ? 'bg-rose-50 text-rose-700' : 'bg-green-50 text-green-700' }} px-3 py-2 text-xs font-semibold">
                            {{ count($notifications) > 0 ? count($notifications) . ' new' : 'all caught up' }}
                        </span>
                    </div>

                    <div class="js-notifications-container mt-6 space-y-3 max-h-96 overflow-y-auto pr-2 [scrollbar-width:thin] [scrollbar-color:rgba(226,232,240,0.5)_transparent] hover:[scrollbar-color:rgba(148,163,184,0.5)_transparent]">
                        @foreach($notifications as $notif)
                            <div class="js-notification-item group rounded-2xl {{ $notif['bgClass'] }} px-4 py-4 ring-1 {{ $notif['ringClass'] }} transition hover:shadow-md" data-notification-id="{{ $notif['id'] }}">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-semibold uppercase tracking-[0.18em] {{ $notif['textClass'] }}">{{ $notif['title'] }}</p>
                                        <p class="mt-2 text-sm font-semibold text-slate-700">{!! $notif['message'] !!}</p>
                                    </div>
                                    <div class="flex items-center gap-2 opacity-0 transition group-hover:opacity-100">
                                        <button type="button" class="js-mark-read flex h-7 w-7 items-center justify-center rounded-lg bg-green-100 text-green-600 hover:bg-green-200 transition" title="Mark as read">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </button>
                                        <button type="button" class="js-dismiss flex h-7 w-7 items-center justify-center rounded-lg bg-rose-100 text-rose-600 hover:bg-rose-200 transition" title="Dismiss">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!-- Empty state -->
                        <div class="js-empty-state {{ count($notifications) > 0 ? 'hidden' : '' }} flex items-center justify-center rounded-2xl bg-slate-50 px-4 py-8 text-center ring-1 ring-slate-200">
                            <div>
                                <p class="text-sm font-semibold text-slate-500">All caught up!</p>
                                <p class="mt-1 text-xs text-slate-400">No new notifications</p>
                            </div>
                        </div>
                    </div>
                </article>

                <article class="rounded-[32px] bg-white p-6 shadow-[0_20px_55px_rgba(89,29,63,.1)] ring-1 ring-fuchsia-100/70">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-bold uppercase tracking-[0.24em] {{ $statusColorClass }}">Personal status</p>
                            <h3 class="mt-2 text-2xl font-extrabold text-slate-900">{{ $statusTitle }}</h3>
                        </div>
                        <div class="rounded-2xl {{ $statusBg }} px-3 py-2 text-sm font-semibold">{{ $statusLabel }}</div>
                    </div>

                    <div class="mt-6 flex justify-center">
                        <div class="relative flex h-64 w-64 items-center justify-center rounded-full bg-[linear-gradient(180deg,#fff7fb_0%,#fff1f6_100%)] shadow-inner shadow-fuchsia-100">
                            <svg class="absolute inset-0 h-full w-full -rotate-90 transform" viewBox="0 0 240 240">
                                <circle cx="120" cy="120" r="106" stroke="#fae8ff" stroke-width="16" fill="none" />
                                <circle cx="120" cy="120" r="106" stroke="#c026d3" stroke-width="16" fill="none" stroke-linecap="round" 
                                        stroke-dasharray="666.02" 
                                        stroke-dashoffset="{{ $dashOffset2 }}" 
                                        class="transition-all duration-1000 ease-out" />
                            </svg>
                            <div class="text-center relative z-10 px-4">
                                <p class="text-5xl font-black text-slate-900">{{ $combinedScore }}%</p>
                                <p class="mt-2 text-xs font-semibold uppercase tracking-[0.2em] {{ $statusColorClass }}">Holistic Balance</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-2 gap-3 text-center">
                        <div class="rounded-3xl bg-fuchsia-50 p-4">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Energy</p>
                            <p class="mt-2 text-2xl font-black text-fuchsia-700">{{ $latestBodyResult ? ucfirst(strtolower($latestBodyResult->mood)) : 'N/A' }}</p>
                        </div>
                        <div class="rounded-3xl bg-fuchsia-50 p-4">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Focus</p>
                            <p class="mt-2 text-2xl font-black text-fuchsia-700">{{ $dashScore1 >= 70 ? 'Sharp' : ($dashScore1 >= 40 ? 'Stable' : 'Scattered') }}</p>
                        </div>
                        <div class="rounded-3xl bg-fuchsia-50 p-4">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Tension</p>
                            <p class="mt-2 text-2xl font-black {{ strtolower($latestBodyResult->stress ?? '') === 'high' ? 'text-rose-500' : 'text-fuchsia-700' }}">{{ $latestBodyResult ? ucfirst(strtolower($latestBodyResult->stress)) : 'N/A' }}</p>
                        </div>
                        <div class="rounded-3xl bg-fuchsia-50 p-4">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Support</p>
                            <p class="mt-2 text-2xl font-black text-fuchsia-700">{{ $combinedScore > 0 ? 'Ready' : 'Pending' }}</p>
                        </div>
                    </div>
                </article>
                
                    <!-- Support Circle / Emergency Card -->
                    <article class="rounded-[32px] bg-white p-8 shadow-[0_20px_55px_rgba(89,29,63,.1)] ring-1 ring-fuchsia-100/70 flex flex-col justify-between transition hover:shadow-lg">
                        <div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-fuchsia-600">Support Circle</p>
                                    <h3 class="mt-2 text-2xl font-extrabold text-slate-900">Safety & Safeguard</h3>
                                </div>
                                <div>
                                    @if(!empty($trustedEmail) && $alertOnCritical)
                                        <span class="rounded-full bg-fuchsia-50 px-3 py-1.5 text-[10px] font-bold text-fuchsia-600 ring-1 ring-fuchsia-100 flex items-center gap-1 shadow-sm">
                                            Alerts Active
                                        </span>
                                    @else
                                        <span class="rounded-full bg-slate-100 px-3 py-1.5 text-[10px] font-bold text-slate-500 ring-1 ring-slate-200">
                                            Alerts Inactive
                                        </span>
                                    @endif
                                </div>
                            </div>

                            @if(!empty($emergencyName) || !empty($emergencyPhone) || !empty($trustedEmail))
                                <div class="mt-8 space-y-3">
                                    <!-- Contact row -->
                                    @if(!empty($emergencyName))
                                        <div class="rounded-2xl bg-fuchsia-50/30 p-3.5 ring-1 ring-fuchsia-100/50 flex items-center justify-between gap-4">
                                            <div class="flex items-center gap-3">
                                                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-white text-fuchsia-600 shadow-sm ring-1 ring-fuchsia-100">
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                                </div>
                                                <div>
                                                    <p class="text-[9px] font-bold uppercase tracking-wider text-slate-400">Emergency Contact</p>
                                                    <p class="text-sm font-extrabold text-slate-800">{{ $emergencyName }}</p>
                                                </div>
                                            </div>
                                            @if(!empty($emergencyPhone))
                                                <a href="tel:{{ $emergencyPhone }}" class="flex h-10 w-10 items-center justify-center rounded-xl bg-fuchsia-700 text-white shadow-md hover:bg-fuchsia-800 transition" title="Call Emergency Contact">
                                                    <i class="fa-solid fa-phone" aria-hidden="true"></i>
                                                </a>
                                            @endif
                                        </div>
                                    @endif

                                    <!-- Phone row if emergencyName empty but phone present -->
                                    @if(empty($emergencyName) && !empty($emergencyPhone))
                                        <div class="rounded-2xl bg-fuchsia-50/30 p-3.5 ring-1 ring-fuchsia-100/50 flex items-center justify-between gap-4">
                                            <div>
                                                <p class="text-[9px] font-bold uppercase tracking-wider text-slate-400">Emergency Phone</p>
                                                <p class="text-sm font-extrabold text-slate-800">{{ $emergencyPhone }}</p>
                                            </div>
                                            <a href="tel:{{ $emergencyPhone }}" class="flex h-10 w-10 items-center justify-center rounded-xl bg-fuchsia-700 text-white shadow-md hover:bg-fuchsia-800 transition">
                                                <i class="fa-solid fa-phone" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    @endif

                                    <!-- Trusted Email row -->
                                    @if(!empty($trustedEmail))
                                        <div class="rounded-2xl bg-fuchsia-50/30 p-3.5 ring-1 ring-fuchsia-100/50 flex items-center gap-3">
                                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-white text-fuchsia-600 shadow-sm ring-1 ring-fuchsia-100">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p class="text-[9px] font-bold uppercase tracking-wider text-slate-400">Trusted Alert Email</p>
                                                <p class="text-sm font-extrabold text-slate-800 truncate" title="{{ $trustedEmail }}">{{ $trustedEmail }}</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <!-- Empty state for support contacts -->
                                <div class="mt-8 flex flex-col items-center justify-center rounded-[24px] bg-slate-50 p-6 text-center border border-dashed border-fuchsia-200">
                                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-fuchsia-50 text-fuchsia-500 shadow-sm">
                                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    </div>
                                    <p class="mt-4 text-sm font-extrabold text-slate-800">Support Circle Pending</p>
                                    <p class="mt-1 max-w-[220px] text-xs text-slate-400">Add an emergency contact and trusted email to activate your Support Circle safeguard.</p>
                                </div>
                            @endif
                        </div>

                        <!-- Edit link shortcut -->
                        <div class="mt-6">
                            <a href="{{ route('profile.edit') }}" class="flex w-full items-center justify-center gap-2 rounded-[18px] bg-fuchsia-50 py-3.5 text-sm font-bold text-fuchsia-700 transition hover:bg-fuchsia-100 ring-1 ring-fuchsia-200/50">
                                <span>Configure Goals & Contacts</span>
                                <span>›</span>
                            </a>
                        </div>
                    </article>
                <article class="rounded-[32px] bg-white p-6 shadow-[0_20px_55px_rgba(89,29,63,.1)] ring-1 ring-fuchsia-100/70">
                    <p class="text-sm font-bold uppercase tracking-[0.24em] text-fuchsia-600">Profile note</p>
                    <h3 class="mt-2 text-2xl font-extrabold text-slate-900">Keep your profile ready for better tracking</h3>
                    <p class="mt-3 text-sm leading-7 text-slate-600">
                        A complete profile helps PsyCheck keep your assessment history, reminders, and personalized guidance tied to your account.
                    </p>

                    <div class="mt-6 grid gap-4 sm:grid-cols-3">
                        <div class="rounded-3xl bg-fuchsia-50 p-4 ring-1 ring-fuchsia-100">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Security</p>
                            <p class="mt-2 text-lg font-black text-fuchsia-700">Protected</p>
                        </div>
                        <div class="rounded-3xl bg-fuchsia-50 p-4 ring-1 ring-fuchsia-100">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">History</p>
                            <p class="mt-2 text-lg font-black text-fuchsia-700">Saved</p>
                        </div>
                        <div class="rounded-3xl bg-fuchsia-50 p-4 ring-1 ring-fuchsia-100">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Support</p>
                            <p class="mt-2 text-lg font-black text-fuchsia-700">Connected</p>
                        </div>
                    </div>
                </article>
                <section class="rounded-[32px] bg-white p-6 shadow-[0_20px_55px_rgba(89,29,63,.1)] ring-1 ring-fuchsia-100/70">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-bold uppercase tracking-[0.24em] text-fuchsia-600">Wellness Highlights</p>
                        <span class="rounded-full bg-fuchsia-50 px-3 py-1 text-xs font-semibold text-fuchsia-700">5 slides</span>
                    </div>

                    <div id="wellness-slider" class="mt-5 flex snap-x snap-mandatory gap-4 overflow-x-auto pb-2 [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden">
                        <article class="js-wellness-slide min-w-full snap-start rounded-[28px] bg-[linear-gradient(180deg,#fff7fb_0%,#fff1f6_100%)] p-5 ring-1 ring-fuchsia-100">
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-fuchsia-600">Quote</p>
                            <h3 class="mt-2 text-xl font-extrabold text-slate-900">The greatest wealth is health.</h3>
                            <p class="mt-3 text-sm leading-7 text-slate-600">Small daily habits protect your energy, focus, and peace of mind more than one big effort.</p>
                        </article>

                        <article class="js-wellness-slide min-w-full snap-start rounded-[28px] bg-[linear-gradient(180deg,#fff7fb_0%,#fff1f6_100%)] p-5 ring-1 ring-fuchsia-100">
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-fuchsia-600">Reminder</p>
                            <h3 class="mt-2 text-xl font-extrabold text-slate-900">Pause before burnout builds up.</h3>
                            <p class="mt-3 text-sm leading-7 text-slate-600">Take one short break, drink water, and reset your breathing when the day starts to feel heavy.</p>
                        </article>

                        <article class="js-wellness-slide min-w-full snap-start rounded-[28px] bg-[linear-gradient(180deg,#fff7fb_0%,#fff1f6_100%)] p-5 ring-1 ring-fuchsia-100">
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-fuchsia-600">Achievement</p>
                            <h3 class="mt-2 text-xl font-extrabold text-slate-900">You are building consistency.</h3>
                            <p class="mt-3 text-sm leading-7 text-slate-600">Every completed assessment improves your wellness history and gives you more useful insights over time.</p>
                        </article>

                        <article class="js-wellness-slide min-w-full snap-start rounded-[28px] bg-[linear-gradient(180deg,#fff7fb_0%,#fff1f6_100%)] p-5 ring-1 ring-fuchsia-100">
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-fuchsia-600">Tip</p>
                            <h3 class="mt-2 text-xl font-extrabold text-slate-900">Protect your sleep window.</h3>
                            <p class="mt-3 text-sm leading-7 text-slate-600">A calmer evening routine, lower screen time, and a fixed sleep schedule can lift both mood and energy.</p>
                        </article>

                        <article class="js-wellness-slide min-w-full snap-start rounded-[28px] bg-[linear-gradient(180deg,#fff7fb_0%,#fdf2f8_100%)] p-5 ring-1 ring-fuchsia-100">
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-fuchsia-600">Check-in</p>
                            <h3 class="mt-2 text-xl font-extrabold text-slate-900">How are you feeling right now?</h3>
                            <p class="mt-3 text-sm leading-7 text-slate-600">Use this moment to notice your stress, energy, and mood before you choose your next step.</p>
                        </article>
                    </div>

                    <div class="mt-4 flex items-center justify-center gap-2">
                        <button type="button" class="js-wellness-dot h-2.5 w-2.5 rounded-full bg-fuchsia-500 transition" data-index="0" aria-label="Go to slide 1"></button>
                        <button type="button" class="js-wellness-dot h-2.5 w-2.5 rounded-full bg-fuchsia-200 transition" data-index="1" aria-label="Go to slide 2"></button>
                        <button type="button" class="js-wellness-dot h-2.5 w-2.5 rounded-full bg-fuchsia-200 transition" data-index="2" aria-label="Go to slide 3"></button>
                        <button type="button" class="js-wellness-dot h-2.5 w-2.5 rounded-full bg-fuchsia-200 transition" data-index="3" aria-label="Go to slide 4"></button>
                        <button type="button" class="js-wellness-dot h-2.5 w-2.5 rounded-full bg-fuchsia-200 transition" data-index="4" aria-label="Go to slide 5"></button>
                    </div>
                </section>
                <section class="rounded-[32px] bg-white p-6 shadow-[0_20px_55px_rgba(89,29,63,.1)] ring-1 ring-fuchsia-100/70">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-bold uppercase tracking-[0.24em] text-fuchsia-600">Emergency Info</p>
                            <h3 class="mt-2 text-2xl font-extrabold text-slate-900">Need immediate help?</h3>
                        </div>
                        <div class="rounded-full bg-rose-50 px-3 py-2 text-xs font-semibold text-rose-700 ring-1 ring-rose-100">24 / 7</div>
                    </div>

                    <div class="mt-5 rounded-[28px] bg-[linear-gradient(180deg,#fff7fb_0%,#fff1f6_100%)] p-5 ring-1 ring-fuchsia-100">
                        <div class="flex items-start gap-4">
                            <div class="min-w-0">
                                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-fuchsia-600">Emergency Call</p>
                                <a href="tel:108" class="mt-2 inline-flex items-center gap-3 text-4xl font-black tracking-tight text-slate-900 transition hover:text-fuchsia-700">
                                    108
                                    <span class="rounded-full bg-white px-3 py-1 text-sm font-semibold text-fuchsia-700 shadow-sm ring-1 ring-fuchsia-100">Tap to call</span>
                                </a>
                            </div>
                        </div>

                        <p class="mt-4 text-sm leading-7 text-slate-600">
                            If you or someone else is in immediate danger, call emergency services right away or go to the nearest emergency room.
                        </p>
                    </div>
                </section>
            </aside>
        </main>
    </div>

    <script>
        // Notification handler
        document.addEventListener('DOMContentLoaded', function () {
            const notificationsContainer = document.querySelector('.js-notifications-container');
            const notificationBadge = document.querySelector('.js-notification-badge');
            const navBellBadge = document.querySelector('.js-nav-notification-badge');
            const emptyState = document.querySelector('.js-empty-state');
            let unreadCount = {{ count($notifications) }};

            if (!notificationsContainer) return;

            // Handle mark as read buttons
            document.querySelectorAll('.js-mark-read').forEach(button => {
                button.addEventListener('click', function () {
                    const notification = this.closest('.js-notification-item');
                    notification.style.opacity = '0.6';
                    notification.style.pointerEvents = 'none';
                    this.closest('.js-notification-item').classList.add('opacity-60');
                    
                    unreadCount--;
                    updateBadge();
                });
            });

            // Handle dismiss buttons
            document.querySelectorAll('.js-dismiss').forEach(button => {
                button.addEventListener('click', function () {
                    const notification = this.closest('.js-notification-item');
                    notification.style.transition = 'all 0.3s ease';
                    notification.style.opacity = '0';
                    notification.style.transform = 'translateX(10px)';
                    
                    setTimeout(() => {
                        notification.remove();
                        unreadCount--;
                        updateBadge();
                    }, 300);
                });
            });

            function updateBadge() {
                if (unreadCount <= 0) {
                    notificationBadge.textContent = 'all caught up';
                    notificationBadge.classList.remove('bg-rose-50', 'text-rose-700');
                    notificationBadge.classList.add('bg-green-50', 'text-green-700');
                    
                    // Update navbar bell badge
                    if (navBellBadge) {
                        navBellBadge.textContent = '0';
                        navBellBadge.classList.add('hidden');
                    }
                    
                    // Show empty state
                    if (document.querySelectorAll('.js-notification-item:not(.hidden)').length === 0) {
                        emptyState.classList.remove('hidden');
                    }
                } else {
                    notificationBadge.textContent = unreadCount + ' new';
                    notificationBadge.classList.add('bg-rose-50', 'text-rose-700');
                    notificationBadge.classList.remove('bg-green-50', 'text-green-700');
                    
                    // Update navbar bell badge
                    if (navBellBadge) {
                        navBellBadge.textContent = unreadCount;
                        navBellBadge.classList.remove('hidden');
                    }
                }
            }
        });

        // Wellness slider
        document.addEventListener('DOMContentLoaded', function () {
            const slider = document.getElementById('wellness-slider');
            if (!slider) {
                return;
            }

            const slides = Array.from(slider.querySelectorAll('.js-wellness-slide'));
            const section = slider.closest('section');
            const dots = section ? Array.from(section.querySelectorAll('.js-wellness-dot')) : [];
            if (!slides.length || !dots.length) {
                return;
            }

            let activeIndex = 0;
            let autoSlideTimer = null;
            let scrollTicking = false;

            const normalizeIndex = function (index) {
                return (index + slides.length) % slides.length;
            };

            const setActiveDot = function (index) {
                dots.forEach(function (dot, dotIndex) {
                    const isActive = dotIndex === index;
                    dot.classList.toggle('bg-fuchsia-500', isActive);
                    dot.classList.toggle('bg-fuchsia-200', !isActive);
                    dot.setAttribute('aria-current', isActive ? 'true' : 'false');
                });
            };

            const getCenteredSlideIndex = function () {
                const sliderRect = slider.getBoundingClientRect();
                const sliderCenter = sliderRect.left + sliderRect.width / 2;
                let nearestIndex = 0;
                let nearestDistance = Number.POSITIVE_INFINITY;

                slides.forEach(function (slide, index) {
                    const slideRect = slide.getBoundingClientRect();
                    const slideCenter = slideRect.left + slideRect.width / 2;
                    const distance = Math.abs(sliderCenter - slideCenter);

                    if (distance < nearestDistance) {
                        nearestDistance = distance;
                        nearestIndex = index;
                    }
                });

                return nearestIndex;
            };

            const getSlideLeftInSlider = function (index) {
                const targetSlide = slides[index];
                return targetSlide.offsetLeft - slider.offsetLeft;
            };

            const syncActiveFromView = function () {
                const nearestIndex = getCenteredSlideIndex();
                if (nearestIndex !== activeIndex) {
                    activeIndex = nearestIndex;
                    setActiveDot(activeIndex);
                }
            };

            const goToSlide = function (index, smooth) {
                const targetIndex = normalizeIndex(index);
                activeIndex = targetIndex;
                slider.scrollTo({
                    left: getSlideLeftInSlider(targetIndex),
                    behavior: smooth === false ? 'auto' : 'smooth'
                });
                setActiveDot(activeIndex);
            };

            const startAutoSlide = function () {
                clearInterval(autoSlideTimer);
                autoSlideTimer = setInterval(function () {
                    goToSlide(activeIndex + 1);
                }, 5000);
            };

            dots.forEach(function (dot) {
                dot.addEventListener('click', function () {
                    const index = Number(dot.dataset.index || 0);
                    goToSlide(index);
                    startAutoSlide();
                });
            });

            slider.addEventListener('scroll', function () {
                if (scrollTicking) {
                    return;
                }

                scrollTicking = true;
                window.requestAnimationFrame(function () {
                    syncActiveFromView();
                    scrollTicking = false;
                });
            });

            window.addEventListener('resize', function () {
                goToSlide(activeIndex, false);
                syncActiveFromView();
            });

            goToSlide(0, false);
            syncActiveFromView();
            startAutoSlide();
        });
    </script>
</body>
</html>
