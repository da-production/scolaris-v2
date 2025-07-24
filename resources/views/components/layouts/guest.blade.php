<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        {!! ToastMagic::styles() !!}
    </head>
    <body class="min-h-screen bg-white antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900 bg__gradient">
        <div class="bg-background flex min-h-svh flex-col  gap-6 p-6 md:p-10">
            <div class="max-w-[85rem] w-full  mx-auto bg-white rounded-2xl flex gap-5 justify-center p-4">
                <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 font-medium" wire:navigate>
                        <span class="flex size-20 mb-1 items-center justify-center rounded-md">
                            <img src="{{ asset('images/mtess.png') }}?v=1"  alt="" srcset="">
                        </span>
                    
                        <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
                    </a>
                <div
                    class="flex flex-col gap-2 justify-center items-center">
                    
                    <p class="text-gray-700 text-2xl">Ministère du Travail , de l'Emploi et de la Sécurité Sociale</p>
                    <p class="text-gray-700 text-2xl">Ecole Supérieure de la Sécurité Sociale</p>
                </div>
                <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 font-medium" wire:navigate>
                        <span class="flex size-20 mb-1 items-center justify-center rounded-md">
                            <img src="{{ asset('images/Logo-esss-300x300.png') }}?v=1"  alt="" srcset="">
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
