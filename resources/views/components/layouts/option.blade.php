<section class="w-full bg__gradient">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">Gestion des paramètres des applications <b>SCOLARIS</b> et <b>SCOLARIS INSCRIPTION</b></flux:heading>
        <flux:subheading size="lg" class="mb-6">Configurez et personnalisez les paramètres des applications depuis une interface centralisée pour assurer leur bon fonctionnement.</flux:subheading>
        <flux:separator variant="subtle" />
    </div>


    <div class="flex items-start max-md:flex-col">
        <div class="mr-10 w-full pb-4 md:w-[220px]">
            <flux:navlist>
                <flux:navlist.item :href="route('administrateur.options.index')" 
                @class([
                    'active' => request()->routeIs('administrateur.options.index'),
                ])
                wire:navigate >
                    <div class="flex gap-2 items-center">
                        <x-icons.users class="size-4" />
                        <span>{{ __('Scolaris') }}</span>
                    </div>
                </flux:navlist.item>
                <flux:navlist.item :href="route('administrateur.options.inscription')" 
                @class([
                    'active' => request()->routeIs('administrateur.options.inscription'),
                ])
                wire:navigate>
                    <div class="flex gap-2 items-center">
                        <x-icons.roles class="size-4" />
                        <span>{{ __('Inscription') }}</span>
                    </div>
                </flux:navlist.item>
                <flux:navlist.item :href="route('administrateur.options.classifications')" 
                @class([
                    'active' => request()->routeIs('administrateur.options.classifications'),
                ])
                wire:navigate>
                    <div class="flex gap-2 items-center">
                        <x-icons.roles class="size-4" />
                        <span>{{ __('Classifications') }}</span>
                    </div>
                </flux:navlist.item>
                <flux:navlist.item :href="route('administrateur.options.specialites')" 
                @class([
                    'active' => request()->routeIs('administrateur.options.specialites'),
                ])
                wire:navigate>
                    <div class="flex gap-2 items-center">
                        <x-icons.roles class="size-4" />
                        <span>{{ __('Spécialité') }}</span>
                    </div>
                </flux:navlist.item>
                <flux:navlist.item :href="route('administrateur.options.filieres')" 
                @class([
                    'active' => request()->routeIs('administrateur.options.filieres'),
                ])
                wire:navigate>
                    <div class="flex gap-2 items-center">
                        <x-icons.roles class="size-4" />
                        <span>{{ __('Filieres') }}</span>
                    </div>
                </flux:navlist.item>
                <flux:navlist.item :href="route('administrateur.options.motifs')" 
                @class([
                    'active' => request()->routeIs('administrateur.options.motifs'),
                ])
                wire:navigate>
                    <div class="flex gap-2 items-center">
                        <x-icons.roles class="size-4" />
                        <span>{{ __('Motifs') }}</span>
                    </div>
                </flux:navlist.item>
                <flux:navlist.item :href="route('administrateur.options.exercices')" 
                @class([
                    'active' => request()->routeIs('administrateur.options.exercices'),
                ])
                wire:navigate>
                    <div class="flex gap-2 items-center">
                        <x-icons.roles class="size-4" />
                        <span>{{ __('Exercices') }}</span>
                    </div>
                </flux:navlist.item>
            </flux:navlist>
        </div>

        <flux:separator class="md:hidden" />

        <div class="flex-1 self-stretch max-md:pt-6">

            <div class=" w-full">
                {{ $slot }}
            </div>
        </div>
    </div>
    <x-toaster-hub />
</section>
