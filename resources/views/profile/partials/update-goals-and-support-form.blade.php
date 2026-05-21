<section>
    <header>
        <h2 class="text-2xl font-extrabold text-slate-900">
            {{ __('Wellness Goals & Support Circle') }}
        </h2>

        <p class="mt-2 text-sm text-slate-500">
            {{ __('Set your baseline target scores, specify emergency contacts, and authorize automatic critical alerts for your trusted support network.') }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')
        <input type="hidden" name="form_type" value="support_circle" />

        <!-- Target Wellness Score -->
        <div>
            <x-input-label for="target_score" :value="__('Target Score (%)')" class="text-sm font-semibold text-slate-700" />
            <div class="mt-2 flex items-center gap-4">
                <input id="target_score" name="target_score" type="number" min="1" max="100" class="block w-32 rounded-2xl border-fuchsia-200 bg-fuchsia-50/40 px-4 py-3 text-slate-800 focus:border-fuchsia-400 focus:ring-fuchsia-300" :value="old('target_score', $user->target_score ?? 75)" required />
                <span class="text-sm text-slate-500">
                    {{ __('Recommended: 75% to 90% for a healthy, balanced state.') }}
                </span>
            </div>
            <x-input-error class="mt-2 text-rose-500" :messages="$errors->get('target_score')" />
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            <!-- Emergency Contact Name -->
            <div>
                <x-input-label for="emergency_contact_name" :value="__('Emergency Contact Name')" class="text-sm font-semibold text-slate-700" />
                <x-text-input id="emergency_contact_name" name="emergency_contact_name" type="text" class="mt-2 block w-full rounded-2xl border-fuchsia-200 bg-fuchsia-50/40 px-4 py-3 text-slate-800 focus:border-fuchsia-400 focus:ring-fuchsia-300" :value="old('emergency_contact_name', $user->emergency_contact_name)" placeholder="e.g. Jane Doe" />
                <x-input-error class="mt-2 text-rose-500" :messages="$errors->get('emergency_contact_name')" />
            </div>

            <!-- Emergency Contact Phone -->
            <div>
                <x-input-label for="emergency_contact_phone" :value="__('Emergency Contact Phone')" class="text-sm font-semibold text-slate-700" />
                <x-text-input id="emergency_contact_phone" name="emergency_contact_phone" type="text" class="mt-2 block w-full rounded-2xl border-fuchsia-200 bg-fuchsia-50/40 px-4 py-3 text-slate-800 focus:border-fuchsia-400 focus:ring-fuchsia-300" :value="old('emergency_contact_phone', $user->emergency_contact_phone)" placeholder="e.g. +1 234 567 890" />
                <x-input-error class="mt-2 text-rose-500" :messages="$errors->get('emergency_contact_phone')" />
            </div>
        </div>

        <hr class="border-fuchsia-100" />

        <!-- Trusted Email -->
        <div>
            <x-input-label for="trusted_email" :value="__('Trusted Contact Email Address')" class="text-sm font-semibold text-slate-700" />
            <x-text-input id="trusted_email" name="trusted_email" type="email" class="mt-2 block w-full rounded-2xl border-fuchsia-200 bg-fuchsia-50/40 px-4 py-3 text-slate-800 focus:border-fuchsia-400 focus:ring-fuchsia-300" :value="old('trusted_email', $user->trusted_email)" placeholder="e.g. support-buddy@example.com" />
            <span class="mt-1 block text-xs text-slate-400">
                {{ __('If you set a trusted email address, PsyCheck will notify them automatically if your score falls into a critical range.') }}
            </span>
            <x-input-error class="mt-2 text-rose-500" :messages="$errors->get('trusted_email')" />
        </div>

        <!-- Alert Toggle Checkbox -->
        <div class="rounded-2xl bg-fuchsia-50/40 p-4 ring-1 ring-fuchsia-100/70">
            <div class="flex items-start gap-3">
                <input type="checkbox" id="alert_on_critical" name="alert_on_critical" value="1" class="mt-1 h-5 w-5 rounded border-fuchsia-300 text-fuchsia-600 focus:ring-fuchsia-500 accent-fuchsia-700" {{ old('alert_on_critical', $user->alert_on_critical ?? true) ? 'checked' : '' }} />
                <div class="flex flex-col">
                    <label for="alert_on_critical" class="text-sm font-semibold text-slate-800 cursor-pointer">
                        {{ __('Enable Trusted Email Alerts') }}
                    </label>
                    <span class="text-xs text-slate-500 mt-1">
                        {{ __('Automatically send an email alert to your trusted contact if your wellness score is critical (< 50%).') }}
                    </span>
                </div>
            </div>
            <x-input-error class="mt-2 text-rose-500" :messages="$errors->get('alert_on_critical')" />
        </div>

        <!-- Submit Button -->
        <div class="flex items-center gap-4">
            <x-primary-button class="rounded-2xl bg-fuchsia-700 px-6 py-3 text-sm font-semibold text-white shadow-[0_12px_26px_rgba(114,29,100,.28)] transition hover:bg-fuchsia-800 focus:bg-fuchsia-800 active:bg-fuchsia-900">
                {{ __('Save Support Settings') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm font-semibold text-fuchsia-700"
                >{{ __('Saved successfully.') }}</p>
            @endif
        </div>
    </form>
</section>
