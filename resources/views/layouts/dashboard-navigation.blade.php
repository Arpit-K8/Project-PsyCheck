<header x-data="{ open: false }" class="mb-6 rounded-[32px] bg-white/80 px-6 py-3 shadow-[0_20px_60px_rgba(89,29,63,.12)] backdrop-blur">
    <div class="hidden items-center justify-between gap-4 sm:flex">
        <div class="flex items-center group">
            <img src="{{ asset('images/Logo.png') }}"
                alt="PsyCheck logo"
                class="h-20 w-20 shrink-0 object-cover transition-transform duration-300 group-hover:scale-105 group-hover:drop-shadow-lg lg:h-24 lg:w-24" />

            <div class="flex flex-col">
                <p class="text-xl font-bold text-fuchsia-700">PsyCheck</p>
                <p class="text-xs uppercase tracking-[0.22em] text-slate-400">Mental Wellness Platform</p>
            </div>
        </div>

        <div class="flex flex-wrap items-center justify-end gap-3 text-sm font-semibold">
            <div class="rounded-full bg-fuchsia-50 px-4 py-2 text-fuchsia-700 ring-1 ring-fuchsia-100">Today: {{ now()->format('M d, Y') }}</div>
            <div class="rounded-full bg-slate-50 px-4 py-2 text-slate-600 ring-1 ring-slate-200">Next check-in in 3 days</div>

            <button type="button" class="inline-flex items-center gap-2 rounded-full bg-rose-50 px-4 py-2 text-rose-700 ring-1 ring-rose-100" aria-label="View notifications">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                    <path d="M12 2.25a5.25 5.25 0 0 0-5.25 5.25v2.325c0 .484-.166.953-.47 1.33l-1.293 1.596a1.875 1.875 0 0 0 1.456 3.054h11.123a1.875 1.875 0 0 0 1.456-3.054l-1.293-1.595a2.122 2.122 0 0 1-.47-1.33V7.5A5.25 5.25 0 0 0 12 2.25Z" />
                    <path d="M9.75 18a2.25 2.25 0 1 0 4.5 0h-4.5Z" />
                </svg>
            </button>

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
    </div>

    <div class="flex items-center justify-between gap-4 sm:hidden">
        <div class="flex items-center group">
            <img src="{{ asset('images/Logo.png') }}"
                alt="PsyCheck logo"
                class="h-16 w-16 shrink-0 object-cover transition-transform duration-300 group-hover:scale-105 group-hover:drop-shadow-lg" />

            <div class="flex flex-col">
                <p class="text-lg font-bold text-fuchsia-700">PsyCheck</p>
                <p class="text-[10px] uppercase tracking-[0.2em] text-slate-400">Mental Wellness Platform</p>
            </div>
        </div>

        <button @click="open = !open" type="button" class="inline-flex items-center justify-center rounded-xl bg-fuchsia-50 p-2 text-fuchsia-700 ring-1 ring-fuchsia-100" aria-label="Toggle menu">
            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div x-cloak x-show="open" x-transition class="mt-3 space-y-3 border-t border-fuchsia-100 pt-3 sm:hidden">
        <div class="rounded-full bg-fuchsia-50 px-4 py-2 text-sm font-semibold text-fuchsia-700 ring-1 ring-fuchsia-100">Today: {{ now()->format('M d, Y') }}</div>

        <button type="button" class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-rose-50 px-4 py-2 text-sm font-semibold text-rose-700 ring-1 ring-rose-100" aria-label="View notifications">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                <path d="M12 2.25a5.25 5.25 0 0 0-5.25 5.25v2.325c0 .484-.166.953-.47 1.33l-1.293 1.596a1.875 1.875 0 0 0 1.456 3.054h11.123a1.875 1.875 0 0 0 1.456-3.054l-1.293-1.595a2.122 2.122 0 0 1-.47-1.33V7.5A5.25 5.25 0 0 0 12 2.25Z" />
                <path d="M9.75 18a2.25 2.25 0 1 0 4.5 0h-4.5Z" />
            </svg>
        </button>

        <div class="rounded-full bg-slate-50 px-4 py-2 text-sm font-semibold text-slate-600 ring-1 ring-slate-200">Next check-in in 3 days</div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="inline-flex w-full items-center justify-center rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white shadow-[0_10px_24px_rgba(15,23,42,.18)] transition hover:bg-slate-800" aria-label="Logout">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                    <path fill-rule="evenodd" d="M10 3.75A2.75 2.75 0 0 0 7.25 6.5v2a.75.75 0 0 1-1.5 0v-2A4.25 4.25 0 0 1 10 2.25h5A4.25 4.25 0 0 1 19.25 6.5v11A4.25 4.25 0 0 1 15 21.75h-5A4.25 4.25 0 0 1 5.75 17.5v-2a.75.75 0 0 1 1.5 0v2A2.75 2.75 0 0 0 10 20.25h5a2.75 2.75 0 0 0 2.75-2.75v-11A2.75 2.75 0 0 0 15 3.75h-5Zm1.78 5.72a.75.75 0 0 0-1.06 1.06l1.72 1.72H3a.75.75 0 0 0 0 1.5h9.44l-1.72 1.72a.75.75 0 1 0 1.06 1.06l3-3a.75.75 0 0 0 0-1.06l-3-3Z" clip-rule="evenodd" />
                </svg>
                <p class="ml-2">Exit</p>
            </button>
        </form>
    </div>
</header>
