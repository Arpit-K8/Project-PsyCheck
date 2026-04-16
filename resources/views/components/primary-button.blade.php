<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center rounded-xl bg-fuchsia-700 px-5 py-2.5 text-xs font-semibold uppercase tracking-widest text-white shadow-[0_10px_26px_rgba(114,29,100,.28)] transition-all duration-200 hover:-translate-y-0.5 hover:bg-fuchsia-800 hover:shadow-[0_14px_32px_rgba(114,29,100,.35)] focus:outline-none focus:ring-2 focus:ring-fuchsia-400 focus:ring-offset-2 active:translate-y-0']) }}>
    {{ $slot }}
</button>
