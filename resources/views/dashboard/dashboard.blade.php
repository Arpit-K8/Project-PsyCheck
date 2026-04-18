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
    <style>
        body { font-family: 'Instrument Sans', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-[#f8ebf1] bg-[radial-gradient(circle_at_50%_-20%,#b23673_0,#e39fb8_34%,#f8ebf1_82%)] text-slate-800 antialiased selection:bg-fuchsia-200 selection:text-fuchsia-900">
    <div class="mx-auto min-h-screen max-w-7xl px-4 pb-10 pt-6 sm:px-8 lg:px-10">
        <header class="mb-6 flex flex-col gap-4 rounded-[32px] bg-white/80 px-6 py-3 shadow-[0_20px_60px_rgba(89,29,63,.12)] backdrop-blur sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center group">
                <!-- Logo -->
                <img src="{{ asset('images/Logo.png') }}" 
                    alt="PsyCheck logo" 
                    class="h-20 w-20 shrink-0 object-cover transition-transform duration-300 group-hover:scale-105 group-hover:drop-shadow-lg lg:h-24 lg:w-24" />

                <!-- Text block -->
                <div class="flex flex-col">
                    <p class="text-xl font-bold text-fuchsia-700">PsyCheck</p>
                    <p class="text-xs uppercase tracking-[0.22em] text-slate-400">Mental Wellness Platform</p>
                </div>
            </div>
            <div class="flex flex-wrap items-center gap-3 text-sm font-semibold">
                <div class="rounded-full bg-fuchsia-50 px-4 py-2 text-fuchsia-700 ring-1 ring-fuchsia-100">Today: {{ now()->format('M d, Y') }}</div>
                <div class="rounded-full bg-rose-50 px-4 py-2 text-rose-700 ring-1 ring-rose-100">1 new recommendation</div>
                <div class="rounded-full bg-slate-50 px-4 py-2 text-slate-600 ring-1 ring-slate-200">Next check-in in 3 days</div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="inline-flex items-center justify-center rounded-full bg-slate-900 px-4 py-2 text-white shadow-[0_10px_24px_rgba(15,23,42,.18)] transition hover:bg-slate-800" aria-label="Logout">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                            <path fill-rule="evenodd" d="M10 3.75A2.75 2.75 0 0 0 7.25 6.5v2a.75.75 0 0 1-1.5 0v-2A4.25 4.25 0 0 1 10 2.25h5A4.25 4.25 0 0 1 19.25 6.5v11A4.25 4.25 0 0 1 15 21.75h-5A4.25 4.25 0 0 1 5.75 17.5v-2a.75.75 0 0 1 1.5 0v2A2.75 2.75 0 0 0 10 20.25h5a2.75 2.75 0 0 0 2.75-2.75v-11A2.75 2.75 0 0 0 15 3.75h-5Zm1.78 5.72a.75.75 0 0 0-1.06 1.06l1.72 1.72H3a.75.75 0 0 0 0 1.5h9.44l-1.72 1.72a.75.75 0 1 0 1.06 1.06l3-3a.75.75 0 0 0 0-1.06l-3-3Z" clip-rule="evenodd" />
                        </svg>
                        <p class="ml-2">Exit</p>
                    </button>
                </form>
            </div>
        </header>

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
                    <article id="recommendation" class="rounded-[32px] bg-white p-6 shadow-[0_20px_55px_rgba(89,29,63,.1)] ring-1 ring-fuchsia-100/70">
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
                    <article class="rounded-[32px] bg-white p-6 shadow-[0_20px_55px_rgba(89,29,63,.1)] ring-1 ring-fuchsia-100/70">
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
            </aside>
        </main>
    </div>
</body>
</html>
