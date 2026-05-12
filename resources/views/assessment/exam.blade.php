<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>PsyCheck | Exam</title>

	<link rel="preconnect" href="https://fonts.bunny.net">
	<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />
	<script src="https://cdn.tailwindcss.com"></script>
	<style>
		body { font-family: 'Instrument Sans', sans-serif; }
        .q-scroll::-webkit-scrollbar { width: 6px; }
        .q-scroll::-webkit-scrollbar-track { background: transparent; }
        .q-scroll::-webkit-scrollbar-thumb { background: #fbcfe8; border-radius: 4px; }
	</style>
</head>
<body class="min-h-screen bg-[#f8ebf1] bg-[radial-gradient(circle_at_50%_-20%,#b23673_0,#e39fb8_34%,#f8ebf1_82%)] text-slate-800 antialiased py-8">

    <div class="mx-auto max-w-7xl px-4 sm:px-8 lg:px-10">
        
        <form id="exam-form" action="{{ route('assessment.exam.submit', ['track' => $track, 'module' => request('module')]) }}" method="POST">
            @csrf

            <div class="grid gap-8 lg:grid-cols-[minmax(0,1.8fr)_minmax(320px,1fr)] xl:grid-cols-[minmax(0,2fr)_minmax(380px,1fr)] items-start">
                
                <!-- Left Screen: Questions -->
                <div class="relative min-h-[600px] overflow-hidden rounded-[32px] bg-white/95 p-8 shadow-[0_24px_70px_rgba(89,29,63,.10)] ring-1 ring-fuchsia-100/70 backdrop-blur-sm sm:p-12 flex flex-col">
                    <div class="pointer-events-none absolute -right-24 -top-24 h-56 w-56 rounded-full bg-fuchsia-100/60 blur-3xl"></div>
                    <div class="pointer-events-none absolute -bottom-28 -left-20 h-64 w-64 rounded-full bg-rose-100/70 blur-3xl"></div>

                    <div class="relative z-10 flex items-center justify-between mb-8 gap-4">
                        <div class="inline-flex items-center gap-2 rounded-full bg-fuchsia-50 px-4 py-2 text-sm font-bold uppercase tracking-[0.14em] text-fuchsia-700 ring-1 ring-fuchsia-200/80 shadow-sm">
                            {{ ucfirst($track) }} Assessment
                        </div>
                        <p class="text-sm font-bold text-slate-500" id="q-counter">Question 1 of {{ count($questions) }}</p>
                    </div>

                    <!-- Question Container -->
                    <div class="relative z-10 flex-1 q-scroll overflow-y-auto pr-2">
                        @foreach($questions as $index => $question)
                            <div class="question-slide {{ $index === 0 ? 'block' : 'hidden' }}" data-index="{{ $index }}" data-qid="{{ $question->id }}" data-module="{{ $question->module }}">
                                @if($index % 30 === 0)
                                    <div class="mb-6">
                                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-fuchsia-600">Section {{ floor($index / 30) + 1 }} — {{ $question->module }}</p>
                                    </div>
                                @endif

                                <h2 class="max-w-3xl text-3xl font-black leading-tight text-slate-900 sm:text-[2.15rem]">{{ $question->question_text }}</h2>
                                
                                <div class="mt-10 space-y-4">
                                    @foreach($question->options as $optIndex => $option)
                                        <label class="group relative flex cursor-pointer items-center rounded-2xl border-2 border-slate-100 bg-white p-5 transition-all duration-200 hover:-translate-y-0.5 hover:border-fuchsia-300 hover:bg-fuchsia-50 hover:shadow-[0_12px_30px_rgba(190,24,93,.08)] has-[:checked]:border-fuchsia-600 has-[:checked]:bg-fuchsia-50 has-[:checked]:ring-1 has-[:checked]:ring-fuchsia-600">
                                            <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option['score'] }}" class="peer sr-only option-input" data-qindex="{{ $index }}">
                                            
                                            <div class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full border-2 border-slate-300 bg-white peer-checked:border-fuchsia-600 peer-checked:bg-fuchsia-600 transition-colors">
                                                <svg class="h-3 w-3 text-white opacity-0 peer-checked:opacity-100" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                                            </div>
                                            
                                            <span class="ml-4 text-[1.05rem] font-semibold leading-relaxed text-slate-700 peer-checked:text-fuchsia-900">{{ $option['text'] }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Navigation Footer -->
                    <div class="relative z-10 mt-8 flex items-center justify-between border-t border-slate-100 pt-6">
                        <button type="button" id="btn-prev" class="rounded-xl px-6 py-3 text-sm font-bold text-slate-500 transition hover:bg-slate-100 hover:text-slate-900 disabled:cursor-not-allowed disabled:opacity-50">
                            &larr; Previous
                        </button>
                        <button type="button" id="btn-next" class="rounded-xl bg-slate-900 px-8 py-3 text-sm font-bold text-white shadow-md transition hover:bg-slate-800 hover:shadow-lg">
                            Next &rarr;
                        </button>
                    </div>

                    <!-- Privacy Message -->
                    <div class="relative z-10 mt-6 flex items-start gap-3 rounded-2xl bg-fuchsia-50/50 p-4 text-sm text-slate-600 ring-1 ring-fuchsia-100/50">
                        <svg class="mt-0.5 h-5 w-5 shrink-0 text-fuchsia-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <div class="space-y-1.5">
                            <p class="leading-relaxed"><strong>Your honesty matters.</strong> Please answer truthfully. This is a safe space—your responses are completely private, encrypted, and never shared with anyone.</p>
                            <p class="leading-relaxed text-slate-500 text-xs font-medium uppercase tracking-wider mt-2">Note: For the most accurate evaluation, please answer all questions before submitting.</p>
                        </div>
                    </div>
                </div>

                <!-- Right Screen: Aside -->
                <aside class="space-y-6 lg:sticky lg:top-8">
                    
                    <!-- Timer Box -->
                    <div class="relative overflow-hidden rounded-[32px] bg-white/95 p-8 text-center shadow-[0_24px_70px_rgba(89,29,63,.10)] ring-1 ring-fuchsia-100/70 backdrop-blur-sm">
                        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,#fbcfe8_0,transparent_50%)] opacity-20 pointer-events-none"></div>
                        <p class="text-xs font-bold uppercase tracking-[0.24em] text-fuchsia-600">Time Remaining</p>
                        <div class="mt-3 text-5xl font-black tracking-tight text-slate-900" id="timer-display">60:00</div>
                        <p class="mt-4 rounded-xl border border-slate-100 bg-slate-50 p-3 text-xs font-semibold text-slate-500">
                            ⚠️ This session of test will be terminated after 1 hour.
                        </p>
                    </div>

                    <!-- Question Grid Box -->
                    <div class="rounded-[32px] bg-white/95 p-8 shadow-[0_24px_70px_rgba(89,29,63,.10)] ring-1 ring-fuchsia-100/70 backdrop-blur-sm">
                        <div class="mb-6 flex items-center justify-between gap-3">
                            <p class="text-sm font-bold text-slate-800">Questions Progress</p>
                            <span class="rounded-md bg-fuchsia-50 px-2 py-1 text-xs font-bold text-fuchsia-600" id="answered-count">0 / {{ count($questions) }}</span>
                        </div>

                        <div class="grid grid-cols-5 gap-3 max-h-96 overflow-y-auto pr-2 q-scroll">
                            @foreach($questions as $index => $question)
                                <button type="button" class="q-grid-btn flex h-12 items-center justify-center rounded-xl border-2 border-slate-100 bg-white text-sm font-bold text-slate-500 transition hover:border-fuchsia-300 hover:bg-fuchsia-50 data-[active=true]:border-fuchsia-600 data-[active=true]:bg-fuchsia-600 data-[active=true]:text-white data-[answered=true]:border-fuchsia-600 data-[answered=true]:bg-fuchsia-50 data-[answered=true]:text-fuchsia-800" data-target="{{ $index }}">
                                    {{ $index + 1 }}
                                </button>
                            @endforeach
                        </div>

                        <div class="mt-10 border-t border-slate-100 pt-6">
                            <button type="submit" id="btn-submit" class="w-full rounded-2xl bg-fuchsia-600 px-6 py-4 text-center text-lg font-black text-white shadow-[0_10px_25px_rgba(190,24,93,.26)] transition-all hover:-translate-y-1 hover:bg-fuchsia-700 hover:shadow-[0_15px_35px_rgba(190,24,93,.36)]">
                                Submit Test Now
                            </button>
                        </div>
                    </div>

                </aside>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const totalQuestions = {{ count($questions) }};
            const perSectionSize = 30; // fixed 30 questions per section
            let currentIndex = 0;
            let answeredQuestions = new Set();

            const slides = document.querySelectorAll('.question-slide');
            const gridBtns = document.querySelectorAll('.q-grid-btn');
            const btnPrev = document.getElementById('btn-prev');
            const btnNext = document.getElementById('btn-next');
            const qCounter = document.getElementById('q-counter');
            const answeredCountEl = document.getElementById('answered-count');
            const optionInputs = document.querySelectorAll('.option-input');

            // --- UI Navigation Logic ---
            function updateUI() {
                // Show active slide
                slides.forEach((slide, idx) => {
                    if (idx === currentIndex) {
                        slide.classList.remove('hidden');
                        slide.classList.add('block');
                    } else {
                        slide.classList.add('hidden');
                        slide.classList.remove('block');
                    }
                });

                // Update Grid active state
                gridBtns.forEach((btn, idx) => {
                    if (idx === currentIndex) {
                        btn.dataset.active = 'true';
                    } else {
                        btn.dataset.active = 'false';
                    }
                });

                // Update Counter (per-section)
                const currentSectionIndex = Math.floor(currentIndex / perSectionSize);
                const currentSectionQuestion = (currentIndex % perSectionSize) + 1;
                const sectionTitle = slides[currentIndex]?.dataset?.module || '';
                qCounter.textContent = `Question ${currentSectionQuestion} of ${perSectionSize} — ${sectionTitle}`;

                // Update Prev/Next buttons
                btnPrev.disabled = currentIndex === 0;
                
                if (currentIndex === totalQuestions - 1) {
                    btnNext.textContent = 'Finish Test';
                    btnNext.classList.add('bg-fuchsia-600', 'hover:bg-fuchsia-700');
                    btnNext.classList.remove('bg-slate-900', 'hover:bg-slate-800');
                } else {
                    btnNext.textContent = 'Next \u2192'; // Next arrow
                    btnNext.classList.remove('bg-fuchsia-600', 'hover:bg-fuchsia-700');
                    btnNext.classList.add('bg-slate-900', 'hover:bg-slate-800');
                }
            }

            // Next button click
            btnNext.addEventListener('click', () => {
                if (currentIndex < totalQuestions - 1) {
                    currentIndex++;
                    updateUI();
                } else {
                    const examForm = document.getElementById('exam-form');
                    if (typeof examForm.requestSubmit === 'function') {
                        examForm.requestSubmit();
                    } else {
                        examForm.submit();
                    }
                }
            });

            // Prev button click
            btnPrev.addEventListener('click', () => {
                if (currentIndex > 0) {
                    currentIndex--;
                    updateUI();
                }
            });

            // Grid button click
            gridBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    currentIndex = parseInt(btn.dataset.target);
                    updateUI();
                });
            });

            // Handle Option Selection
            optionInputs.forEach(input => {
                input.addEventListener('change', (e) => {
                    const qIndex = parseInt(e.target.dataset.qindex);
                    answeredQuestions.add(qIndex);
                    
                    // Mark grid button as answered
                    gridBtns[qIndex].dataset.answered = 'true';
                    
                    // Update Answered Count
                    answeredCountEl.textContent = `${answeredQuestions.size} / ${totalQuestions}`;

                    // Auto advance logic (optional, but requested for smooth UX often)
                    setTimeout(() => {
                        if (currentIndex === qIndex && currentIndex < totalQuestions - 1) {
                            currentIndex++;
                            updateUI();
                        }
                    }, 400); // 400ms delay to show the selected animation
                });
            });

            // Initialize UI
            updateUI();


            // --- Timer Logic ---
            const timerDisplay = document.getElementById('timer-display');
            let timeLeft = 60 * 60; // 60 minutes in seconds

            function formatTime(seconds) {
                const m = Math.floor(seconds / 60).toString().padStart(2, '0');
                const s = (seconds % 60).toString().padStart(2, '0');
                return `${m}:${s}`;
            }

            const timerInterval = setInterval(() => {
                timeLeft--;
                timerDisplay.textContent = formatTime(timeLeft);

                // Warning colors when < 5 mins
                if (timeLeft < 300) {
                    timerDisplay.classList.add('text-rose-600');
                    timerDisplay.classList.remove('text-slate-900');
                }

                if (timeLeft <= 0) {
                    clearInterval(timerInterval);
                    timerDisplay.textContent = "00:00";
                    // Auto submit form
                    alert("Time is up! Submitting your test automatically.");
                    document.getElementById('exam-form').submit();
                }
            }, 1000);
        });
    </script>
</body>
</html>
