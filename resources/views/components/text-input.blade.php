@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full rounded-xl border border-fuchsia-100 bg-fuchsia-50/40 px-3.5 py-2.5 text-sm text-slate-700 shadow-sm transition placeholder:text-slate-400 focus:border-fuchsia-400 focus:bg-white focus:ring-fuchsia-300']) }}>
