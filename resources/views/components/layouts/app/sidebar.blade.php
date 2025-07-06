@use("Illuminate\Support\Str")
@use('App\Models\SpecialiteConcour')

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <livewire:user-auth-logout />
        <flux:sidebar sticky stashable class="border-r border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="mr-5 flex items-center space-x-2" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Platform')" class="grid">
                    <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                    <flux:navlist.item  :href="route('administrateur.candidats.index')" :current="request()->routeIs('administrateur.candidats.index')" wire:navigate >
                        <div class="flex items-center gap-2">
                            <x-icons.students class="w-5 h-5" />
                            {{ __('Candidats') }}
                        </div>
                    </flux:navlist.item>
                    <flux:navlist.item :href="route('administrateur.candidats.candidatures')" :current="request()->routeIs('administrateur.candidats.candidatures')" wire:navigate>
                        <div class="flex items-center gap-2">
                            <x-icons.candidature class="w-5 h-5" />
                            {{ __('Candidatures') }}
                        </div>
                    </flux:navlist.item>
                </flux:navlist.group>

                <flux:navlist.group :heading="__('Candidatures par specialite')" class="grid">
                    @foreach (SpecialiteConcour::all() as $specialite)
                        <flux:navlist.item  :href="route('administrateur.candidats.candidatures.specialite', ['specialite_concour_id' => $specialite->id])" :current="request()->routeIs('administrateur.candidats.candidatures.specialite')" wire:navigate class="py-2">
                            <div class="flex items-center gap-2">
                                <x-icons.folder-open class="w-5 h-5" />
                                <div class="flex justify-between w-full items-center">
                                    <span class="text-sm font-semibold text-slate-800 dark:text-slate-200">
                                        {{ $specialite->code }}
                                    </span>
                                    @if ($specialite->is_active)
                                        <span class="text-xs font-semibold bg-green-500 dark:bg-green-400 p-1 rounded-full"></span>
                                    @else
                                        <span class="text-xs font-semibold bg-red-500 dark:bg-red-400 p-1 rounded-full">
                                        </span>
                                        
                                    @endif
                                </div>
                            </div>
                        </flux:navlist.item>
                    @endforeach
                </flux:navlist.group>
            </flux:navlist>

            <flux:spacer />

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Settings')" class="grid">
                    <livewire:connected-user-wire />
                    @hasAnyOf(['root', 'administrator'],['view options'])
                        <flux:navlist.item icon="users" :current="Str::contains(Route::currentRouteName(), 'administrateur.options')" href="{{ route('administrateur.options.index') }}">
                            {{ __('Options') }}
                        </flux:navlist.item>
                    @endhasAnyOf
                    <flux:navlist.item icon="users" :current="Str::contains(Route::currentRouteName(), 'administrateur.utilisateurs')" href="{{ route('administrateur.utilisateurs.index') }}">
                    {{ __('UAC & RBAC') }}
                    </flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist>

            <!-- Desktop User Menu -->
            <flux:dropdown position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevrons-up-down"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-left text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item href="/settings/profile" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full" id="logout-form">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-left text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item href="/settings/profile" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        @use('App\Models\Exercice')
        @php
            $is_closed = Exercice::where('annee', auth()->user()->exercice)->pluck('is_closed')->first();
        @endphp
        @if ($is_closed)
            <div class="bg-red-100 border-b border-red-400 text-red-700 px-4 py-3  relative" role="alert">
                <strong class="font-bold">Vous travailler dans un exercice clôture</strong>
            </div>
        @endif
        {{ $slot }}


        @fluxScripts
        <script>
            @if(config('app.enable_reverb'))
            document.addEventListener('livewire:init', () => {
                console.log('Livewire is loaded!');
                // Already initialized via Livewire in most setups
                window.Echo.private(`logout.user.{{ auth()->user()->id }}`)
                    .listen('.forced.logout', (e) => {
                        console.log('User forced to logout!', e);
                        window.Livewire.dispatch('Login:logoutUser',{id: e.id});
                        // Optional: force logout in frontend
                        // window.location.href = '/logout'; // or emit Livewire logout action
                    });
            });
            @endif

        </script>
    </body>
</html>
