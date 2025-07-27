<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        {!! ToastMagic::styles() !!}
    </head>
    <body class="min-h-screen bg-white antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900 bg__gradient">
        <div class="max-w-[85rem] w-full mx-auto flex justify-end">
            <flux:radio.group x-data variant="segmented" x-model="$flux.appearance" class=" scale-75 -mr-10">
                <flux:radio value="light" icon="sun">{{ __('Clair') }}</flux:radio>
                <flux:radio value="dark" icon="moon">{{ __('Sombre') }}</flux:radio>
                <flux:radio value="system" icon="computer-desktop">{{ __('Système') }}</flux:radio>
            </flux:radio.group>
        </div>
        
        <div class="bg-background flex min-h-svh flex-col  gap-6 px-6 md:px-10 md:py-2">
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
        @fluxScripts
        {!! ToastMagic::scripts() !!}
        
    </body>
</html>
