<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Connectez-vous à votre compte')" :description="__('Entrez votre adresse e-mail et votre mot de passe ci-dessous pour vous connecter.')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    @if (session('auth_conflict'))
        <div class="p-3 text-xs text-center bg-orange-100 border rounded-lg border-orange-200 text-orange-600 dark:text-orange-400">
            {{ session('auth_conflict') }}
        </div>
    @endif

    <form wire:submit="login" class="flex flex-col gap-6">
        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Adresse e-mail')"
            type="email"
            required
            autofocus
            autocomplete="email"
            placeholder="email@exemple.com"
        />

        <!-- Password -->
        <div class="relative">
            <flux:input
                wire:model="password"
                :label="__('Mot de passe')"
                type="password"
                required
                autocomplete="current-password"
                :placeholder="__('Mot de passe')"
            />

            @if (Route::has('password.request'))
                <flux:link class="absolute right-0 top-0 text-sm" :href="route('password.request')" wire:navigate>
                    {{ __('Mot de passe oublié ?') }}
                </flux:link>
            @endif
        </div>

        <!-- Remember Me -->
        <flux:checkbox wire:model="remember" :label="__('Rester connecté')" />

        <div class="flex items-center justify-end">
            <flux:button variant="primary" type="submit" class="w-full">{{ __('Se connecter') }}</flux:button>
        </div>
    </form>

    {{-- @if (Route::has('register'))
        <div class="space-x-1 text-center text-sm text-zinc-600 dark:text-zinc-400">
            {{ __('Don\'t have an account?') }}
            <flux:link :href="route('register')" wire:navigate>{{ __('Sign up') }}</flux:link>
        </div>
    @endif --}}
</div>
