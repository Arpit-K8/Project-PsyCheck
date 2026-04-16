<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[#f8ebf1] bg-[radial-gradient(circle_at_50%_-20%,#b23673_0,#e39fb8_40%,#f8ebf1_82%)] text-slate-800 antialiased selection:bg-fuchsia-200 selection:text-fuchsia-900" style="font-family: 'Instrument Sans', sans-serif;">
        <div class="mx-auto max-w-7xl px-4 pb-10 pt-8 sm:px-8 lg:px-10">
            <div class="text-center text-white">
                <h1 class="text-4xl font-extrabold tracking-tight sm:text-6xl drop-shadow-sm">PsyCheck</h1>
                <p class="mt-3 text-xl font-medium text-white/90 drop-shadow-sm">For Mental Health Self-Assessment and Support Guidance</p>
            </div>

            <section class="mt-9 overflow-hidden rounded-[44px] bg-white px-6 pb-14 pt-6 shadow-[0_30px_90px_rgba(89,29,63,.22)] sm:px-10 lg:px-14 lg:pb-16">
                <header class="flex flex-wrap items-center justify-between gap-4 border-b border-fuchsia-50/50 pb-6">
                    <a href="{{ url('/') }}" class="flex items-center group">
                        <img src="{{ asset('images/Logo.png') }}"
                            alt="PsyCheck logo"
                            class="h-20 w-20 shrink-0 object-cover transition-transform duration-300 group-hover:scale-105 group-hover:drop-shadow-lg lg:h-24 lg:w-24" />

                        <div class="flex flex-col">
                            <p class="text-xl font-bold text-fuchsia-700">PsyCheck</p>
                            <p class="text-xs uppercase tracking-[0.22em] text-slate-400">Mental Wellness Platform</p>
                        </div>
                    </a>

                    <nav class="hidden items-center gap-12 text-base font-semibold text-slate-600 lg:flex">
                        <a href="{{ url('/') }}" class="transition-colors hover:text-fuchsia-700">Home</a>
                        <a href="{{ url('/#features') }}" class="transition-colors hover:text-fuchsia-700">Features</a>
                        <a href="{{ url('/#testimonials') }}" class="transition-colors hover:text-fuchsia-700">Testimonials</a>
                    </nav>

                    <div class="flex items-center gap-3">
                        @if (Route::has('login') && !request()->routeIs('login'))
                            <a href="{{ route('login') }}" class="rounded-xl bg-slate-50 px-8 py-3 text-base font-medium text-slate-700 transition-all hover:bg-slate-100 hover:text-fuchsia-700">Login</a>
                        @endif

                        @if (Route::has('register') && !request()->routeIs('register'))
                            <a href="{{ route('register') }}" class="rounded-xl bg-fuchsia-700 px-8 py-3 text-base font-medium text-white shadow-md transition-all hover:scale-105 hover:bg-fuchsia-800 hover:shadow-lg hover:shadow-fuchsia-600/20">Register</a>
                        @endif
                    </div>
                </header>

                <main class="mt-14 grid gap-12 lg:grid-cols-2 lg:items-center">
                    <article class="relative z-10">
                        <div class="absolute left-48 top-2 -z-10 hidden h-24 w-24 opacity-45 lg:block" style="background-image: radial-gradient(circle, #d672b6 2px, transparent 2px); background-size: 18px 18px;"></div>

                        <h2 class="max-w-xl text-4xl font-bold leading-[1.1] text-slate-800 sm:text-5xl lg:text-[3.5rem]">
                            <span class="text-fuchsia-700">PsyCheck:</span><br>
                            Your Secure Mental Wellness Access
                        </h2>

                        <p class="mt-6 max-w-lg text-lg leading-relaxed tracking-wide text-slate-600">
                            Access your personalized assessment experience, review your progress, and continue your mental wellness journey with confidence.
                        </p>

                        <div class="mt-8 w-full max-w-xl rounded-3xl border border-fuchsia-100/70 bg-slate-50/60 p-6 sm:p-8">
                            {{ $slot }}
                        </div>
                    </article>

                    <aside class="relative mx-auto w-full max-w-xl">
                        <div class="absolute inset-4 rounded-full border border-fuchsia-100/50"></div>
                        <div class="absolute inset-10 rounded-full border border-fuchsia-100/50"></div>
                        <div class="absolute inset-16 rounded-full border border-fuchsia-100/50"></div>
                        <div class="absolute inset-24 rounded-full border border-fuchsia-100/50"></div>

                        <div class="relative mx-auto flex aspect-square w-full max-w-xl items-center justify-center rounded-full bg-fuchsia-50 shadow-inner">
                            <img src="https://images.unsplash.com/photo-1493836512294-502baa1986e2?auto=format&fit=crop&w=900&q=80" alt="Person in reflective mood" class="h-[74%] w-auto rounded-b-[120px] object-cover drop-shadow-2xl" />
                        </div>

                        <div class="absolute left-10 top-16 hidden h-20 w-20 transform overflow-hidden rounded-full border-4 border-white shadow-xl transition duration-500 hover:scale-110 md:block">
                            <img src="https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=250&q=80" alt="Profile 1" class="h-full w-full object-cover" />
                        </div>
                        <div class="absolute -bottom-1 left-20 hidden h-16 w-16 cursor-pointer transform overflow-hidden rounded-full border-4 border-white shadow-xl transition duration-500 hover:scale-110 md:block">
                            <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=250&q=80" alt="Profile 2" class="h-full w-full object-cover" />
                        </div>
                        <div class="absolute right-10 top-1/2 hidden h-14 w-14 transform overflow-hidden rounded-full border-4 border-white shadow-xl transition duration-500 hover:scale-110 md:block">
                            <img src="https://images.unsplash.com/photo-1551836022-d5d88e9218df?auto=format&fit=crop&w=250&q=80" alt="Support" class="h-full w-full object-cover" />
                        </div>

                        <div class="absolute right-0 top-28 -z-10 hidden h-20 w-20 opacity-80 md:block animate-pulse" style="background-image: radial-gradient(circle, #ca65b1 2px, transparent 2px); background-size: 15px 15px;"></div>
                        <div class="absolute left-0 top-1/2 -z-10 hidden h-20 w-20 opacity-80 md:block animate-pulse" style="background-image: radial-gradient(circle, #ca65b1 2px, transparent 2px); background-size: 15px 15px;"></div>
                    </aside>
                </main>
            </div>
        </div>
    </body>
</html>
