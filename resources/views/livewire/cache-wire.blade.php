<x-layouts.option>
    <div class="flex w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative h-full flex-1  rounded-xl p-2 border border-neutral-200 dark:border-neutral-700">
            <div class="w-full h-full bg-white relative z-10 rounded-lg p-4 border">
                <div class="w-full">
                    <h3 class="text-lg font-semibold ml-3 text-slate-800">🧹 Vider le cache</h3>
                    <p class="text-slate-500 mb-5 ml-3"> Nettoyez les caches système</p>
                </div>
                <div class="relative flex flex-col w-full text-gray-700 bg-white shadow-md rounded-lg bg-clip-border">
                    <div
                        class="p-4 space-y-4 max-w-md  bg-white dark:bg-zinc-900 rounded-xl border-zinc-200 dark:border-zinc-700">
                        @if (session()->has('message'))
                            <div
                                class="bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 p-2 rounded text-sm font-medium">
                                {{ session('message') }}
                            </div>
                        @endif

                        @php
                            $btnClasses =
                                'w-full px-4 py-2 border-2 border-dashed border-zinc-800 dark:border-zinc-300 text-zinc-800 dark:text-zinc-100 rounded-md hover:bg-zinc-100 dark:hover:bg-zinc-800 transition';
                        @endphp

                        <button wire:click="clearConfig" class="{{ $btnClasses }}">
                            Vider le cache de configuration
                        </button>

                        <button wire:click="clearRoute" class="{{ $btnClasses }}">
                            Vider le cache des routes
                        </button>

                        <button wire:click="clearView" class="{{ $btnClasses }}">
                            Vider le cache des vues
                        </button>

                        <button wire:click="clearAppCache" class="{{ $btnClasses }}">
                            Vider le cache de l'application
                        </button>

                        <button wire:click="clearAll" class="{{ $btnClasses }}">
                            Vider tous les caches
                        </button>
                    </div>
                </div>

            </div>

            <x-placeholder-pattern
                class="absolute z-0 inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
        </div>
    </div>


</x-layouts.option>
