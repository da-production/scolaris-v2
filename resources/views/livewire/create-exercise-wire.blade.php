<x-layouts.option>
    <div class="flex w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative h-full flex-1  rounded-xl p-2 border border-neutral-200 dark:border-neutral-700">
            <div class="w-full h-full bg-white relative z-10 rounded-lg p-4 border">
                <div class="w-full">
                    <h3 class="text-lg font-semibold ml-3 text-slate-800">Initialise un nouveau exercise pour l'annee en cour</h3>
                    <hr />
                </div>
                <div class="relative flex w-full text-gray-700 bg-white shadow-md rounded-lg bg-clip-border">
                    <form wire:submit="store" class="p-4 w-4/12 flex flex-col gap-4">
                        
                        <flux:input wire:model="opened_at" :label="__('Date d\'ouverture')" type="date" />
                        <flux:input wire:model="closed_at" :label="__('Date cloture')" type="date" />
                        <flux:input wire:model="closed_trait" :label="__('Date cloture traitement')" type="date" />
                        <flux:input wire:model="displayed_at" :label="__('Date d\'affichage')" type="date" />
                        <div>
                            <flux:button variant="primary" type="submit">{{ __('Create') }}</flux:button>
                        </div>
                        @if (!is_null($error))
                            <div class=" p-4 rounded-xl bg-red-50 border border-red-300 text-red-800 text-sm font-medium shadow-sm">
                                {{$error}}
                            </div>
                        @endif
                    </form>
                    <div class="p-4 w-8/12 ">
                        <div class="bg-blue-50 border border-blue-200 text-blue-900 px-6 py-4 rounded-xl shadow-md max-w-3xl mx-auto my-4">
                            <div class="flex items-start space-x-4">
                                <svg class="w-6 h-6 text-blue-500 mt-1" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13 16h-1v-4h-1m1-4h.01M12 9v2m0 4v.01m0 2a9 9 0 110-18 9 9 0 010 18z" />
                                </svg>
                                <div>
                                <h2 class="text-lg font-semibold mb-1">Attention : Initialisation d'un nouvel exercice</h2>
                                <p class="text-sm leading-relaxed">
                                    En lançant un <strong>nouvel exercice annuel</strong>, tous les exercices précédents seront automatiquement <strong>clôturés</strong>.<br>
                                    De plus, tous les candidats ayant une candidature encore en cours de traitement auront désormais le statut :
                                    <em class="text-red-600 font-medium">"Non classé ou ne figure pas parmi les 100 premiers du classement"</em>.
                                </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <x-placeholder-pattern
                class="absolute z-0 inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
        </div>
    </div>


</x-layouts.option>
