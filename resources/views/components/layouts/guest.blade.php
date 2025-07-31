<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        {!! ToastMagic::styles() !!}
    </head>
    <body class="min-h-screen bg-white antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900 bg__gradient">
        <div class="max-w-[85rem] w-full mx-auto flex justify-end z-10 relative">
            <flux:radio.group x-data variant="segmented" x-model="$flux.appearance" class=" scale-75 -mr-10">
                <flux:radio value="light" icon="sun">{{ __('Clair') }}</flux:radio>
                <flux:radio value="dark" icon="moon">{{ __('Sombre') }}</flux:radio>
                <flux:radio value="system" icon="computer-desktop">{{ __('Système') }}</flux:radio>
            </flux:radio.group>
        </div>
        
        <div class="bg-background flex min-h-svh flex-col  gap-6 px-6 md:px-10 md:py-2 relative z-10">
            <div class="max-w-[85rem] w-full mx-auto bg-white dark:bg-gray-900 rounded-2xl flex flex-wrap justify-center items-center gap-5 p-4">
                
                {{-- Logo MTESS --}}
                <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 font-medium w-24" wire:navigate>
                    <span class="flex w-20 h-20 mb-1 items-center justify-center rounded-md">
                        <img src="{{ asset('images/mtess.png') }}?v=1" alt="Logo MTESS" class="max-w-full max-h-full object-contain">
                    </span>
                    <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
                </a>

                {{-- Textes centraux --}}
                <div class="flex flex-col text-center gap-2 items-center max-w-full px-2">
                    <p class="text-gray-700 dark:text-gray-200 text-lg sm:text-xl md:text-2xl font-semibold">
                        Ministère du Travail, de l'Emploi et de la Sécurité Sociale
                    </p>
                    <p class="text-gray-700 dark:text-gray-200 text-lg sm:text-xl md:text-2xl font-semibold">
                        École Supérieure de la Sécurité Sociale
                    </p>
                </div>

                {{-- Logo ESSS --}}
                <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 font-medium w-24" wire:navigate>
                    <span class="flex w-20 h-20 mb-1 items-center justify-center rounded-md">
                        <img src="{{ asset('images/Logo-esss-300x300.png') }}?v=1" alt="Logo ESSS" class="max-w-full max-h-full object-contain">
                    </span>
                    <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
                </a>
            </div>


            <x-candidat.banner />
            
            <x-candidat.menu />
            <div class="flex max-w-[85rem] mx-auto w-full h-full">
                {{ $slot }}
            </div>
        </div>
        <svg viewBox="0 0 671 1231" fill="none" class="max-w-3xl mt-0 fixed bottom-72 lg:bottom-0 -left-44 lg:left-0 w-auto md:w-2/3 lg:w-1/2 z-0 text-slate-300"><path stroke="currentColor" stroke-width="0.5" stroke-miterlimit="10" d="M-.2 1111.5c242.8-65.3 176.1-401.2 78-537.6-29.9-41.6-53-57.5-78-59.4"></path><path stroke="currentColor" stroke-width="0.5" stroke-miterlimit="10" d="M-.3 1125.1c271.3-73.9 198.4-424.7 90-575.5C57 504.2 30 486.4-.3 482.8"></path><path stroke="currentColor" stroke-width="0.5" stroke-miterlimit="10" d="M-.3 1139.6c285.4-94.2 228.7-440.1 111.2-603.5-38.3-53.3-71.3-73-111.2-77.5"></path><path stroke="currentColor" stroke-width="0.5" stroke-miterlimit="10" d="M-.4 1156.6c281-119.4 253.9-460 127.9-635.3-41.1-57.1-80.1-80.7-127.8-88.8"></path><path stroke="currentColor" stroke-width="0.5" stroke-miterlimit="10" d="M-.4 1181.2c273.6-144 279.7-485.4 144.1-673.9-43.1-59.9-88.8-89.2-144-102.4"></path><path stroke="currentColor" stroke-width="0.5" stroke-miterlimit="10" d="M-.2 1212.3c3.4-2.2 6.8-4.5 10.2-6.7C266 1034.1 304.1 693 159.9 492.4c-44.8-62.3-97.8-98.7-160-117.8"></path><path stroke="currentColor" stroke-width="0.5" stroke-miterlimit="10" d="M28.2 1230.9c2.5-2.1 4.9-4.3 7.4-6.5 227.2-202.3 289.7-535.3 139.6-743.9C129.1 416.4 68.3 371.6-.4 346"></path><path stroke="currentColor" stroke-width="0.5" stroke-miterlimit="10" d="M45.2 1231.1c1-.9 2.1-1.8 3.1-2.8 231.8-206.4 295.5-546.1 142.5-758.9C141.1 400.3 74.9 353.1 0 328"></path><path stroke="currentColor" stroke-width="0.5" stroke-miterlimit="10" d="M64.1 1231.2c233-210.8 296.5-554.6 141.3-770.4C152.5 387.4 80.9 338 .2 313.3"></path><path stroke="currentColor" stroke-width="0.5" stroke-miterlimit="10" d="M82.5 1231.2c232.3-215.3 294.4-561.1 137.6-779.1C163.8 373.8 86.6 322.4-.2 298.5"></path><path stroke="currentColor" stroke-width="0.5" stroke-miterlimit="10" d="M101.3 1231.1C332.8 1011.3 393.1 663.2 235 443.3c-59.8-83-142.3-136.1-235-159.2"></path><path stroke="currentColor" stroke-width="0.5" stroke-miterlimit="10" d="M124.2 1231.2C359 1007.6 420.6 653.7 259.6 429.8 194.4 339.2 102.6 283.6-.1 263"></path><path stroke="currentColor" stroke-width="0.5" stroke-miterlimit="10" d="M-.2 250.5C112.1 268 213 325.9 283.4 423.7c161.8 225 102.8 579.3-129 807.5"></path></svg>
        @fluxScripts
        {!! ToastMagic::scripts() !!}
        
    </body>
</html>
