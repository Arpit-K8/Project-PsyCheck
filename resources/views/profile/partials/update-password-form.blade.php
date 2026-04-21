<section>
    <header>
        <h2 class="text-2xl font-extrabold text-slate-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-2 text-sm text-slate-500">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" class="text-sm font-semibold text-slate-700" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-2 block w-full rounded-2xl border-fuchsia-200 bg-fuchsia-50/40 px-4 py-3 text-slate-800 focus:border-fuchsia-400 focus:ring-fuchsia-300" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-rose-500" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" class="text-sm font-semibold text-slate-700" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-2 block w-full rounded-2xl border-fuchsia-200 bg-fuchsia-50/40 px-4 py-3 text-slate-800 focus:border-fuchsia-400 focus:ring-fuchsia-300" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-rose-500" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" class="text-sm font-semibold text-slate-700" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-2 block w-full rounded-2xl border-fuchsia-200 bg-fuchsia-50/40 px-4 py-3 text-slate-800 focus:border-fuchsia-400 focus:ring-fuchsia-300" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-rose-500" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="rounded-2xl bg-fuchsia-700 px-6 py-3 text-sm font-semibold text-white shadow-[0_12px_26px_rgba(114,29,100,.28)] transition hover:bg-fuchsia-800 focus:bg-fuchsia-800 active:bg-fuchsia-900">
                {{ __('Update Password') }}
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm font-semibold text-fuchsia-700"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
