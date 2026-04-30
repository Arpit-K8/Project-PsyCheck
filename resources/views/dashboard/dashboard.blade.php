<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PsyCheck | Dashboard</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Instrument Sans', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-[#f8ebf1] bg-[radial-gradient(circle_at_50%_-20%,#b23673_0,#e39fb8_34%,#f8ebf1_82%)] text-slate-800 antialiased selection:bg-fuchsia-200 selection:text-fuchsia-900">
    <div class="mx-auto min-h-screen max-w-7xl px-4 pb-10 pt-6 sm:px-8 lg:px-10">
        @include('layouts.dashboard-navigation')
        <main class="grid gap-6 xl:grid-cols-[minmax(0,1.45fr)_minmax(320px,0.95fr)]">
            <section class="space-y-6">
                <article class="overflow-hidden rounded-[36px] bg-white shadow-[0_24px_70px_rgba(89,29,63,.14)]">
                    <div class="grid gap-0 lg:grid-cols-[1.1fr_0.9fr]">
                        <div class="relative p-7 sm:p-10">
                            <div class="absolute right-6 top-6 h-24 w-24 rounded-full bg-[radial-gradient(circle,#e39fb8_2px,transparent_2px)] bg-[length:18px_18px] opacity-45"></div>
                            <p class="text-sm font-bold uppercase tracking-[0.28em] text-fuchsia-600">Wellness Snapshot</p>
                            <h1 class="mt-4 max-w-xl text-4xl font-black leading-tight text-slate-900 sm:text-5xl">
                                Your mind health is doing <span class="text-fuchsia-700">better than last week</span>.
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
                                    <p class="mt-2 text-xl font-extrabold text-slate-900">Stable and improving</p>
                                </div>
                            </div>

                            <div class="mt-8 flex justify-center">
                                <div class="relative flex h-64 w-64 items-center justify-center rounded-full bg-white shadow-inner shadow-fuchsia-100">
                                    <div class="absolute inset-4 rounded-full border-[16px] border-fuchsia-100 border-t-fuchsia-600 border-r-rose-500 border-b-fuchsia-100 border-l-fuchsia-100"></div>
                                    <div class="text-center">
                                        <p class="text-5xl font-black tracking-tight text-slate-900">75%</p>
                                        <p class="mt-3 text-sm font-semibold uppercase tracking-[0.24em] text-fuchsia-600">Mind balance</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8 flex flex-col gap-3">
                                <div class="rounded-2xl bg-white px-5 py-4 shadow-sm ring-1 ring-fuchsia-100/70 flex items-center justify-between">
                                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Mood</p>
                                    <p class="text-xl font-black text-fuchsia-700">Good</p>
                                </div>
                                <div class="rounded-2xl bg-white px-5 py-4 shadow-sm ring-1 ring-fuchsia-100/70 flex items-center justify-between">
                                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Stress</p>
                                    <p class="text-xl font-black text-rose-500">Low</p>
                                </div>
                                <div class="rounded-2xl bg-white px-5 py-4 shadow-sm ring-1 ring-fuchsia-100/70 flex items-center justify-between">
                                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Sleep</p>
                                    <p class="text-xl font-black text-fuchsia-700">Fair</p>
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
                        <a href="{{ route('assessment.start', ['track' => 'body']) }}" class="group rounded-[24px] bg-[linear-gradient(180deg,#fff7fb_0%,#fff1f6_100%)] p-5 ring-1 ring-fuchsia-100 transition hover:-translate-y-1 hover:shadow-[0_12px_28px_rgba(190,24,93,.16)]">
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-fuchsia-600">Body</p>
                            <h3 class="mt-2 text-xl font-black text-slate-900">Body Assessment</h3>
                            <p class="mt-2 text-sm text-slate-600">Check physical wellbeing, sleep rhythm, and daily energy level.</p>
                            <p class="mt-4 text-sm font-semibold text-fuchsia-700 group-hover:text-fuchsia-800">Start now -></p>
                        </a>

                        <a href="{{ route('assessment.start', ['track' => 'mind']) }}" class="group rounded-[24px] bg-[linear-gradient(180deg,#fff7fb_0%,#fff1f6_100%)] p-5 ring-1 ring-fuchsia-100 transition hover:-translate-y-1 hover:shadow-[0_12px_28px_rgba(190,24,93,.16)]">
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-fuchsia-600">Mind</p>
                            <h3 class="mt-2 text-xl font-black text-slate-900">Mind Assessment</h3>
                            <p class="mt-2 text-sm text-slate-600">Measure mood, stress patterns, and emotional balance today.</p>
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
                                <p class="text-4xl font-black text-fuchsia-700">8.2</p>
                                <p class="mt-1 text-sm text-slate-400">out of 10</p>
                            </div>
                            <div class="rounded-2xl bg-fuchsia-50 px-3 py-2 text-sm font-semibold text-fuchsia-700">+0.6</div>
                        </div>
                    </article>

                    <article class="rounded-[28px] bg-white p-6 shadow-[0_20px_55px_rgba(89,29,63,.1)] ring-1 ring-fuchsia-100/70 transition hover:-translate-y-1">
                        <p class="text-sm font-semibold text-slate-500">Stress load</p>
                        <div class="mt-4 flex items-end justify-between gap-4">
                            <div>
                                <p class="text-4xl font-black text-rose-500">Low</p>
                                <p class="mt-1 text-sm text-slate-400">manageable today</p>
                            </div>
                            <div class="rounded-2xl bg-rose-50 px-3 py-2 text-sm font-semibold text-rose-600">-12%</div>
                        </div>
                    </article>

                    <article class="rounded-[28px] bg-white p-6 shadow-[0_20px_55px_rgba(89,29,63,.1)] ring-1 ring-fuchsia-100/70 transition hover:-translate-y-1">
                        <p class="text-sm font-semibold text-slate-500">Sleep quality</p>
                        <div class="mt-4 flex items-end justify-between gap-4">
                            <div>
                                <p class="text-4xl font-black text-fuchsia-700">7.1</p>
                                <p class="mt-1 text-sm text-slate-400">last 7 nights</p>
                            </div>
                            <div class="rounded-2xl bg-fuchsia-50 px-3 py-2 text-sm font-semibold text-fuchsia-700">steady</div>
                        </div>
                    </article>

                    <article class="rounded-[28px] bg-white p-6 shadow-[0_20px_55px_rgba(89,29,63,.1)] ring-1 ring-fuchsia-100/70 transition hover:-translate-y-1">
                        <p class="text-sm font-semibold text-slate-500">Next check-in</p>
                        <div class="mt-4 flex items-end justify-between gap-4">
                            <div>
                                <p class="text-4xl font-black text-slate-900">3d</p>
                                <p class="mt-1 text-sm text-slate-400">keep tracking progress</p>
                            </div>
                            <div class="rounded-2xl bg-fuchsia-50 px-3 py-2 text-sm font-semibold text-fuchsia-700">reminder on</div>
                        </div>
                    </article>
                </section>
                <section>
                    <article id="recommendation" class="rounded-[32px] bg-white p-7 shadow-[0_20px_55px_rgba(89,29,63,.1)] ring-1 ring-fuchsia-100/70">
                        <p class="text-2xl font-extrabold text-slate-900">Recommended next step</p>
                        <p class="mt-2 text-sm text-slate-500">Based on your latest assessment, this is the most relevant action for you.</p>

                        <div class="mt-6 rounded-[28px] bg-fuchsia-50 p-5 ring-1 ring-fuchsia-100">
                            <p class="text-sm font-bold uppercase tracking-[0.24em] text-fuchsia-600">Focus area</p>
                            <h2 class="mt-3 text-3xl font-black text-slate-900">Mood support and rest</h2>
                            <p class="mt-3 text-base leading-7 text-slate-600">
                                Your score suggests a stable but slightly tired state. A short rest routine, a lighter evening screen schedule, and one calming activity can help.
                            </p>
                            <div class="mt-5 space-y-3">
                                <div class="rounded-2xl bg-white px-4 py-3 text-sm font-semibold text-slate-700 shadow-sm ring-1 ring-fuchsia-100">1. Try a 10 minute breathing session</div>
                                <div class="rounded-2xl bg-white px-4 py-3 text-sm font-semibold text-slate-700 shadow-sm ring-1 ring-fuchsia-100">2. Keep your sleep time consistent tonight</div>
                                <div class="rounded-2xl bg-white px-4 py-3 text-sm font-semibold text-slate-700 shadow-sm ring-1 ring-fuchsia-100">3. Recheck your mood after 3 days</div>
                            </div>
                        </div>
                    </article>
                </section>

                <section>
                    <article class="rounded-[32px] bg-white p-8 shadow-[0_20px_55px_rgba(89,29,63,.1)] ring-1 ring-fuchsia-100/70">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-2xl font-extrabold text-slate-900">Your weekly trend</p>
                                <p class="mt-1 text-sm text-slate-500">A simple view of how you have been feeling</p>
                            </div>
                            <span class="rounded-full bg-fuchsia-50 px-3 py-2 text-sm font-semibold text-fuchsia-700">last 7 days</span>
                        </div>

                        @php
                            $trendBars = [42, 55, 48, 66, 58, 71, 76];
                            $trendLabels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                        @endphp
                        <div class="mt-8 rounded-[28px] bg-[linear-gradient(180deg,#fff7fb_0%,#fff1f6_100%)] p-5">
                            <div class="flex h-72 items-end gap-4">
                                @foreach ($trendBars as $index => $height)
                                    <div class="flex flex-1 flex-col items-center justify-end gap-3">
                                        <div class="w-full max-w-[34px] rounded-t-full bg-gradient-to-t from-fuchsia-600 via-rose-500 to-fuchsia-400 shadow-[0_12px_28px_rgba(190,24,93,.22)]" style="height: {{ $height * 2 }}px"></div>
                                        <span class="text-xs font-semibold text-slate-400">{{ $trendLabels[$index] }}</span>
                                    </div>
                                @endforeach
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
                            <div class="flex h-16 w-16 items-center justify-center rounded-3xl bg-gradient-to-br from-fuchsia-600 to-rose-500 text-2xl font-black text-white shadow-[0_12px_30px_rgba(194,37,112,.28)]">
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
                        <span class="rounded-full bg-rose-50 px-3 py-2 text-xs font-semibold text-rose-700">2 new</span>
                    </div>

                    <div class="mt-6 space-y-3">
                        <div class="rounded-2xl bg-fuchsia-50 px-4 py-4 ring-1 ring-fuchsia-100">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-fuchsia-600">Score update</p>
                            <p class="mt-2 text-sm font-semibold text-slate-700">Your latest mind score is <span class="font-black text-fuchsia-700">75%</span>, up from last check-in.</p>
                        </div>

                        <div class="rounded-2xl bg-rose-50 px-4 py-4 ring-1 ring-rose-100">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-rose-600">Check-in late</p>
                            <p class="mt-2 text-sm font-semibold text-slate-700">Your check-in is overdue by 1 day. Complete today to keep trend data accurate.</p>
                        </div>
                    </div>
                </article>

                <article class="rounded-[32px] bg-white p-6 shadow-[0_20px_55px_rgba(89,29,63,.1)] ring-1 ring-fuchsia-100/70">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-bold uppercase tracking-[0.24em] text-fuchsia-600">Personal status</p>
                            <h3 class="mt-2 text-2xl font-extrabold text-slate-900">You are on track</h3>
                        </div>
                        <div class="rounded-2xl bg-fuchsia-50 px-3 py-2 text-sm font-semibold text-fuchsia-700">active</div>
                    </div>

                    <div class="mt-6 flex justify-center">
                        <div class="relative flex h-56 w-56 items-center justify-center rounded-full bg-[linear-gradient(180deg,#fff7fb_0%,#fff1f6_100%)] shadow-inner shadow-fuchsia-100">
                            <div class="absolute inset-4 rounded-full border-[14px] border-fuchsia-100 border-t-fuchsia-600 border-r-rose-500 border-b-fuchsia-100 border-l-fuchsia-100"></div>
                            <div class="text-center">
                                <p class="text-5xl font-black text-slate-900">75%</p>
                                <p class="mt-2 text-sm font-semibold uppercase tracking-[0.24em] text-fuchsia-600">mind balance</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-2 gap-3 text-center">
                        <div class="rounded-3xl bg-fuchsia-50 p-4">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Energy</p>
                            <p class="mt-2 text-2xl font-black text-fuchsia-700">Good</p>
                        </div>
                        <div class="rounded-3xl bg-fuchsia-50 p-4">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Focus</p>
                            <p class="mt-2 text-2xl font-black text-fuchsia-700">Stable</p>
                        </div>
                        <div class="rounded-3xl bg-fuchsia-50 p-4">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Calmness</p>
                            <p class="mt-2 text-2xl font-black text-rose-500">High</p>
                        </div>
                        <div class="rounded-3xl bg-fuchsia-50 p-4">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Support</p>
                            <p class="mt-2 text-2xl font-black text-fuchsia-700">Ready</p>
                        </div>
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
                        <span class="rounded-full bg-fuchsia-50 px-3 py-1 text-xs font-semibold text-fuchsia-700">3 slides</span>
                    </div>

                    <div id="wellness-slider" class="mt-5 flex snap-x snap-mandatory gap-4 overflow-x-auto pb-2 [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden">
                        <article class="js-wellness-slide min-w-full snap-start rounded-[28px] bg-[linear-gradient(180deg,#fff7fb_0%,#fff1f6_100%)] p-5 ring-1 ring-fuchsia-100">
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-fuchsia-600">Slide 1</p>
                            <h3 class="mt-2 text-xl font-extrabold text-slate-900">Quote of the Day</h3>
                            <p class="mt-3 text-sm leading-7 text-slate-600">"The greatest wealth is health."</p>
                        </article>

                        <article class="js-wellness-slide min-w-full snap-start rounded-[28px] bg-[linear-gradient(180deg,#fff7fb_0%,#fff1f6_100%)] p-5 ring-1 ring-fuchsia-100">
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-fuchsia-600">Slide 2</p>
                            <h3 class="mt-2 text-xl font-extrabold text-slate-900">Achievement</h3>
                            <p class="mt-3 text-sm leading-7 text-slate-600">We are hitting <span class="font-extrabold text-fuchsia-700">400 followers</span>. Thank you for growing with PsyCheck.</p>
                        </article>

                        <article class="js-wellness-slide min-w-full snap-start rounded-[28px] bg-[linear-gradient(180deg,#fff7fb_0%,#fff1f6_100%)] p-5 ring-1 ring-fuchsia-100">
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-fuchsia-600">Slide 3</p>
                            <h3 class="mt-2 text-xl font-extrabold text-slate-900">Health Reminder</h3>
                            <p class="mt-3 text-sm leading-7 text-slate-600">If you are having a problem, go for a checkup with a nearby doctor.</p>
                        </article>
                    </div>

                    <div class="mt-4 flex items-center justify-center gap-2">
                        <button type="button" class="js-wellness-dot h-2.5 w-2.5 rounded-full bg-fuchsia-500 transition" data-index="0" aria-label="Go to slide 1"></button>
                        <button type="button" class="js-wellness-dot h-2.5 w-2.5 rounded-full bg-fuchsia-200 transition" data-index="1" aria-label="Go to slide 2"></button>
                        <button type="button" class="js-wellness-dot h-2.5 w-2.5 rounded-full bg-fuchsia-200 transition" data-index="2" aria-label="Go to slide 3"></button>
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
