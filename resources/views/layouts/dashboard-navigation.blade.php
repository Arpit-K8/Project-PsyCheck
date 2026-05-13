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
            <div class="rounded-full bg-slate-50 px-4 py-2 text-slate-600 ring-1 ring-slate-200">Next check-in: {{ $checkinText ?? 'N/A' }}</div>

            <button type="button" class="relative inline-flex items-center gap-2 rounded-full bg-rose-50 px-4 py-2 text-rose-700 ring-1 ring-rose-100" aria-label="View notifications">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                    <path d="M12 2.25a5.25 5.25 0 0 0-5.25 5.25v2.325c0 .484-.166.953-.47 1.33l-1.293 1.596a1.875 1.875 0 0 0 1.456 3.054h11.123a1.875 1.875 0 0 0 1.456-3.054l-1.293-1.595a2.122 2.122 0 0 1-.47-1.33V7.5A5.25 5.25 0 0 0 12 2.25Z" />
                    <path d="M9.75 18a2.25 2.25 0 1 0 4.5 0h-4.5Z" />
                </svg>
                <span class="js-nav-notification-badge absolute -right-1 -top-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs font-bold text-white {{ count($notifications ?? []) > 0 ? '' : 'hidden' }}">{{ count($notifications ?? []) }}</span>
            </button>

            <div x-data="{ userMenuOpen: false }" class="relative">
                <button @click="userMenuOpen = !userMenuOpen" @click.away="userMenuOpen = false" type="button" class="inline-flex items-center justify-center gap-2 rounded-full bg-slate-900 px-4 py-2 text-white shadow-[0_10px_24px_rgba(15,23,42,.18)] transition hover:bg-slate-800" aria-label="User Menu">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <span class="ml-1">Menu</span>
                </button>
                
                <div x-show="userMenuOpen" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                     x-transition:leave-end="opacity-0 translate-y-1 scale-95"
                     class="absolute right-0 top-full mt-3 w-48 origin-top-right rounded-2xl bg-white p-2 shadow-[0_20px_55px_rgba(89,29,63,.15)] ring-1 ring-slate-100 focus:outline-none" style="display: none;" x-cloak>
                    
                    <a href="mailto:support@psycheck.app" class="flex w-full items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-slate-700 transition hover:bg-fuchsia-50 hover:text-fuchsia-700">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Support Center
                    </a>
                    
                    <div class="my-1 h-px w-full bg-slate-100"></div>
                    
                    <form method="POST" action="{{ route('logout') }}" x-data="{ loggingOut: false }" @submit="loggingOut = true">
                        @csrf
                        <button type="submit" class="flex w-full items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-rose-600 transition hover:bg-rose-50 hover:text-rose-700 disabled:opacity-50 disabled:cursor-not-allowed" aria-label="Logout" :disabled="loggingOut">
                            <svg x-show="!loggingOut" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                            <svg x-show="loggingOut" x-cloak class="h-4 w-4 shrink-0 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            <span x-text="loggingOut ? 'Exiting...' : 'Exit Session'"></span>
                        </button>
                    </form>
                </div>
            </div>
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

        <button type="button" class="relative inline-flex w-full items-center justify-center gap-2 rounded-full bg-rose-50 px-4 py-2 text-sm font-semibold text-rose-700 ring-1 ring-rose-100" aria-label="View notifications">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                <path d="M12 2.25a5.25 5.25 0 0 0-5.25 5.25v2.325c0 .484-.166.953-.47 1.33l-1.293 1.596a1.875 1.875 0 0 0 1.456 3.054h11.123a1.875 1.875 0 0 0 1.456-3.054l-1.293-1.595a2.122 2.122 0 0 1-.47-1.33V7.5A5.25 5.25 0 0 0 12 2.25Z" />
                <path d="M9.75 18a2.25 2.25 0 1 0 4.5 0h-4.5Z" />
            </svg>
            <span class="js-nav-notification-badge absolute -right-1 -top-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs font-bold text-white {{ count($notifications ?? []) > 0 ? '' : 'hidden' }}">{{ count($notifications ?? []) }}</span>
        </button>

        <div class="rounded-full bg-slate-50 px-4 py-2 text-sm font-semibold text-slate-600 ring-1 ring-slate-200">Next check-in: {{ $checkinText ?? 'N/A' }}</div>

        <div class="my-3 h-px w-full bg-fuchsia-100"></div>

        <a href="mailto:support@psycheck.app" class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-slate-50 px-4 py-2 text-sm font-semibold text-slate-700 ring-1 ring-slate-200 hover:bg-slate-100">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            Support Center
        </a>

        <form method="POST" action="{{ route('logout') }}" class="mt-2" x-data="{ loggingOut: false }" @submit="loggingOut = true">
            @csrf
            <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white shadow-[0_10px_24px_rgba(15,23,42,.18)] transition hover:bg-slate-800 disabled:opacity-75 disabled:cursor-wait" aria-label="Logout" :disabled="loggingOut">
                <svg x-show="!loggingOut" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                <svg x-show="loggingOut" x-cloak class="h-5 w-5 shrink-0 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                <span x-text="loggingOut ? 'Exiting...' : 'Exit Session'"></span>
            </button>
        </form>
    </div>
</header>
