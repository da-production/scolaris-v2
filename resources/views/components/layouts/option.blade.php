<section class="w-full ">
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
                <flux:navlist.item 
                :href="route('administrateur.options.domains')" 
                @class([
                    'active' => request()->routeIs('administrateur.options.domains'),
                ])
                wire:navigate>
                    <div class="flex gap-2 items-center 
                        after:content-['1'] after:absolute after:left-[-1rem] after:top-1/2 after:-translate-y-1/2
                    after:bg-teal-500 after:text-white after:text-xs after:w-6 after:h-6 after:rounded-full
                        after:flex after:items-center after:justify-center after:shadow-md after:z-10
                    before:content-[''] before:absolute before:-left-1 before:top-2/2 before:-translate-y-1/2
                    before:h-5 before:w-[2px] before:bg-gray-400
                    ">
                        <x-icons.roles class="size-4" />
                        <span>{{ __('Domains') }}</span>
                    </div>
                </flux:navlist.item>
                <flux:navlist.item :href="route('administrateur.options.filieres')" 
                @class([
                    'active' => request()->routeIs('administrateur.options.filieres'),
                ])
                wire:navigate>
                    <div class="flex gap-2 items-center
                    after:content-['2'] after:absolute after:left-[-1rem] after:top-1/2 after:-translate-y-1/2
                    after:bg-teal-500 after:text-white after:text-xs after:w-6 after:h-6 after:rounded-full
                        after:flex after:items-center after:justify-center after:shadow-md after:z-10
                    before:content-[''] before:absolute before:-left-1 before:top-2/2 before:-translate-y-1/2
                    before:h-5 before:w-[2px] before:bg-gray-400
                    ">
                        <x-icons.roles class="size-4" />
                        <span>{{ __('Filieres') }}</span>
                    </div>
                </flux:navlist.item>

                <flux:navlist.item :href="route('administrateur.options.specialites.concours')" 
                @class([
                    'active' => request()->routeIs('administrateur.options.specialites.concours'),
                ])
                wire:navigate>
                    <div class="flex gap-2 items-center
                    after:content-['3'] after:absolute after:left-[-1rem] after:top-1/2 after:-translate-y-1/2
                    after:bg-teal-500 after:text-white after:text-xs after:w-6 after:h-6 after:rounded-full
                        after:flex after:items-center after:justify-center after:shadow-md after:z-10
                    before:content-[''] before:absolute before:-left-1 before:top-2/2 before:-translate-y-1/2
                    before:h-5 before:w-[2px] before:bg-gray-400
                    ">
                        <x-icons.roles class="size-4" />
                        <span>{{ __('Spécialité concours') }}</span>
                    </div>
                </flux:navlist.item>

                <flux:navlist.item :href="route('administrateur.options.specialites')" 
                @class([
                    'active' => request()->routeIs('administrateur.options.specialites'),
                ])
                wire:navigate>
                    <div class="flex gap-2 items-center
                    after:content-['4'] after:absolute after:left-[-1rem] after:top-1/2 after:-translate-y-1/2
                    after:bg-teal-500 after:text-white after:text-xs after:w-6 after:h-6 after:rounded-full
                        after:flex after:items-center after:justify-center after:shadow-md after:z-10
                    ">
                        <x-icons.roles class="size-4" />
                        <span>{{ __('spécialités apparentée ') }}</span>
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
                <flux:navlist.item :href="route('administrateur.options.cache')" 
                @class([
                    'active' => request()->routeIs('administrateur.options.cache'),
                ])
                wire:navigate>
                    <div class="flex gap-2 items-center">
                        <x-icons.roles class="size-4" />
                        <span>{{ __('Cache') }}</span>
                    </div>
                </flux:navlist.item>
                <flux:navlist.item :href="route('administrateur.options.smtp')" 
                @class([
                    'active' => request()->routeIs('administrateur.options.smtp'),
                ])
                wire:navigate>
                    <div class="flex gap-2 items-center">
                        <x-icons.roles class="size-4" />
                        <span>{{ __('SMTP') }}</span>
                    </div>
                </flux:navlist.item>
                <flux:navlist.item :href="route('administrateur.options.jobs')" 
                @class([
                    'active' => request()->routeIs('administrateur.options.jobs'),
                ])
                wire:navigate>
                    <div class="flex gap-2 items-center">
                        <x-icons.roles class="size-4" />
                        <span>{{ __('Failed Jobs') }}</span>
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
