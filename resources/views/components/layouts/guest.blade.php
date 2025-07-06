<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        {!! ToastMagic::styles() !!}
    </head>
    <body class="min-h-screen bg-white antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900 bg__gradient">
        <div class="bg-background flex min-h-svh flex-col  gap-6 p-6 md:p-10">
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
