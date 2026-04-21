<section class="space-y-6">
    <header>
        <h2 class="text-2xl font-extrabold text-slate-900">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-2 text-sm text-slate-500">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-danger-button
        class="rounded-2xl bg-rose-600 px-5 py-3 text-sm font-semibold text-white shadow-[0_12px_24px_rgba(225,29,72,.22)] transition hover:bg-rose-700 focus:bg-rose-700 active:bg-rose-800"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Delete Account') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 sm:p-8">
            @csrf
            @method('delete')

            <h2 class="text-2xl font-extrabold text-slate-900">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-3 text-sm text-slate-500">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full rounded-2xl border-rose-200 bg-rose-50/40 px-4 py-3 text-slate-800 focus:border-rose-400 focus:ring-rose-300"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-rose-500" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button class="rounded-2xl border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-100" x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3 rounded-2xl bg-rose-600 px-5 py-3 text-sm font-semibold text-white shadow-[0_12px_24px_rgba(225,29,72,.22)] transition hover:bg-rose-700 focus:bg-rose-700 active:bg-rose-800">
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
