<section>
    <header>
        <h2 class="text-2xl font-extrabold text-slate-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-2 text-sm text-slate-500">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" class="text-sm font-semibold text-slate-700" />
            <x-text-input id="name" name="name" type="text" class="mt-2 block w-full rounded-2xl border-fuchsia-200 bg-fuchsia-50/40 px-4 py-3 text-slate-800 focus:border-fuchsia-400 focus:ring-fuchsia-300" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2 text-rose-500" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-sm font-semibold text-slate-700" />
            <x-text-input id="email" name="email" type="email" class="mt-2 block w-full rounded-2xl border-fuchsia-200 bg-fuchsia-50/40 px-4 py-3 text-slate-800 focus:border-fuchsia-400 focus:ring-fuchsia-300" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2 text-rose-500" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="mt-3 rounded-2xl bg-amber-50 px-4 py-3 text-sm text-amber-800 ring-1 ring-amber-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="font-semibold underline decoration-amber-400 underline-offset-4 transition hover:text-amber-900 focus:outline-none focus:ring-2 focus:ring-amber-300 focus:ring-offset-2">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm font-semibold text-emerald-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="rounded-2xl bg-fuchsia-700 px-6 py-3 text-sm font-semibold text-white shadow-[0_12px_26px_rgba(114,29,100,.28)] transition hover:bg-fuchsia-800 focus:bg-fuchsia-800 active:bg-fuchsia-900">
                {{ __('Save Changes') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
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
