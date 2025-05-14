<x-layouts.option>
    <div class="flex w-full flex-1 flex-col gap-4 rounded-xl" x-data="{isChecked:{{ $is_closed }}}">
        <div class="relative h-full flex-1  rounded-xl p-2 border border-neutral-200 dark:border-neutral-700">
            <div class="w-full h-full bg-white relative z-10 rounded-lg p-4 border">
                <div class="w-full">
                    <h3 class="text-lg font-semibold ml-3 text-slate-800">Initialise un nouveau exercise pour l'annee en cour</h3>
                    <hr />
                </div>
                <div class="relative flex w-full text-gray-700 bg-white shadow-md rounded-lg bg-clip-border">
                    <form wire:submit="update" class="p-4 w-4/12 flex flex-col gap-4">
                        
                        <flux:input wire:model="opened_at" :label="__('Date d\'ouverture')" type="text" />
                        <flux:input wire:model="closed_at" :label="__('Date cloture')" type="text" />
                        <flux:input wire:model="closed_trait" :label="__('Date cloture traitement')" type="text" />
                        <flux:input wire:model="displayed_at" :label="__('Date d\'affichage')" type="text" />
                        @if (!$is_closed)
                            
                        <div>
                            <flux:button variant="primary" type="submit" x-on:click="console.log(isChecked)">{{ __('Update') }}</flux:button>
                        </div>
                        @endif
                        @if (!is_null($error))
                            <div class=" p-4 rounded-xl bg-red-50 border border-red-300 text-red-800 text-sm font-medium shadow-sm">
                                {{$error}}
                            </div>
                        @endif
                    </form>
                    <div class="p-4 w-8/12 ">
                            @if ($is_closed)
                                <div class="bg-blue-50 border border-blue-200 text-blue-900 px-6 py-4 rounded-xl shadow-md max-w-3xl mx-auto my-4">
                                    <div class="flex items-start space-x-4">
                                        <svg class="w-6 h-6 text-blue-500 mt-1" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13 16h-1v-4h-1m1-4h.01M12 9v2m0 4v.01m0 2a9 9 0 110-18 9 9 0 010 18z" />
                                        </svg>
                                        <div>
                                        <h2 class="text-lg font-semibold mb-1">Exercice clôturer </h2>
                                        <p class="text-sm leading-relaxed">
                                            Tous les candidats ayant une candidature en attente ont été mis à jour avec le statut 
                                            <em class="text-red-600 font-medium">« non classé »</em>.
                                        </p>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="bg-yellow-50 border border-yellow-200 text-yellow-900 px-6 py-4 rounded-xl shadow-md max-w-3xl mx-auto my-4">
                                    <div class="flex items-start space-x-4">
                                        <svg class="w-6 h-6 text-yellow-500 mt-1" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13 16h-1v-4h-1m1-4h.01M12 9v2m0 4v.01m0 2a9 9 0 110-18 9 9 0 010 18z" />
                                        </svg>
                                        <div>
                                        <h2 class="text-lg font-semibold mb-1">Attention </h2>
                                        <p class="text-sm leading-relaxed">
                                            Si vous <strong>clôturé</strong> l'exercice.<br>
                                            tous les candidats ayant une candidature encore en cours de traitement auront désormais le statut :
                                            <em class="text-red-600 font-medium">"Non classé ou ne figure pas parmi les 100 premiers du classement"</em>.
                                        </p>
                                        <p class="mt-2">
                                            <label class="flex gap-2 items-center" for="cloture"><strong>clôturé</strong> <input id="cloture" type="checkbox"  wire:model="is_closed" x-model="isChecked" /></label>
                                        </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                    </div>
                </div>

            </div>

            <x-placeholder-pattern
                class="absolute z-0 inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
        </div>
    </div>


</x-layouts.option>
