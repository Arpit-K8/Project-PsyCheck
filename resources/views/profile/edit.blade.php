<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PsyCheck | Profile</title>

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
        <header class="mb-6 flex flex-col gap-4 rounded-[32px] bg-white/80 px-6 py-3 shadow-[0_20px_60px_rgba(89,29,63,.12)] backdrop-blur sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center group">
                <img src="{{ asset('images/Logo.png') }}"
                    alt="PsyCheck logo"
                    class="h-20 w-20 shrink-0 object-cover transition-transform duration-300 group-hover:scale-105 group-hover:drop-shadow-lg lg:h-24 lg:w-24" />

                <div class="flex flex-col">
                    <p class="text-xl font-bold text-fuchsia-700">PsyCheck</p>
                    <p class="text-xs uppercase tracking-[0.22em] text-slate-400">Profile Settings</p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3 text-sm font-semibold">
                <a href="{{ route('dashboard') }}" class="rounded-full bg-fuchsia-50 px-4 py-2 text-fuchsia-700 ring-1 ring-fuchsia-100 transition hover:bg-fuchsia-100">
                    Back to Dashboard
                </a>
                <div class="rounded-full bg-slate-50 px-4 py-2 text-slate-600 ring-1 ring-slate-200">{{ now()->format('M d, Y') }}</div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="inline-flex items-center justify-center rounded-full bg-slate-900 px-4 py-2 text-white shadow-[0_10px_24px_rgba(15,23,42,.18)] transition hover:bg-slate-800" aria-label="Logout">
                        Exit
                    </button>
                </form>
            </div>
        </header>

        <main class="grid gap-6 xl:grid-cols-[minmax(0,1.4fr)_minmax(320px,0.95fr)]">
            <section class="space-y-6">
                <article class="rounded-[32px] bg-white p-6 shadow-[0_20px_55px_rgba(89,29,63,.1)] ring-1 ring-fuchsia-100/70 sm:p-8">
                    @include('profile.partials.update-profile-information-form')
                </article>

                <article class="rounded-[32px] bg-white p-6 shadow-[0_20px_55px_rgba(89,29,63,.1)] ring-1 ring-fuchsia-100/70 sm:p-8">
                    @include('profile.partials.update-password-form')
                </article>
            </section>

            <aside class="space-y-6">
                <article class="rounded-[32px] bg-white p-6 shadow-[0_20px_55px_rgba(89,29,63,.1)] ring-1 ring-fuchsia-100/70 sm:p-8">
                    @include('profile.partials.delete-user-form')
                </article>
            </aside>
        </main>
    </div>
</body>
</html>
