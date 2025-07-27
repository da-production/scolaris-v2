@use('App\CandidatureStatusEnum')
<x-layouts.candidat>
    
    <div class="flex w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative h-full flex-1  rounded-xl p-2 border border-neutral-200 dark:border-neutral-700">
            <div class="w-full h-full bg-white relative z-10 rounded-lg p-4 border">
                <div class="w-full">
                    <h3 class="text-lg font-semibold ml-3 text-slate-800">
                        Gestion des <b>recours ({{ $recours->count() }})</b>
                    </h3>
                    <p class="text-slate-500 mb-5 ml-3"> Suivez, évaluez et gérez efficacement les recours de chaque candidatures reçues.</p>
                </div>
                
                
                <div class="relative  flex flex-col w-full text-gray-700 bg-white shadow-md rounded-lg bg-clip-border">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left table-auto min-w-max">
                            <thead>
                                <tr>
                                    <th class="p-4 border-b border-slate-300 bg-slate-50">
                                        <p class="block text-sm font-normal leading-none text-slate-500">
                                            ID
                                        </p>
                                    </th>
                                    <th class="p-4 border-b border-slate-300 bg-slate-50">
                                        <p class="block text-sm font-normal leading-none text-slate-500">
                                            Etat
                                        </p>
                                    </th>
                                    <th class="p-4 border-b border-slate-300 bg-slate-50">
                                        <p class="block text-sm font-normal leading-none text-slate-500">
                                            Candidature / Candidat
                                        </p>
                                    </th>
                                    <th class="p-4 border-b border-slate-300 bg-slate-50">
                                        <p class="block text-sm font-normal leading-none text-slate-500">
                                            Date
                                        </p>
                                    </th>
                                    <th class="p-4 border-b border-slate-300 bg-slate-50 w-11">
                                        
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recours as $recour)
                                    <tr class="hover:bg-slate-50">
                                            
                                        <td class="p-4 border-b border-slate-200">
                                            <p class="block text-sm text-slate-800">
                                                {{ $recour->id}}
                                            </p>
                                        </td>
                                        <td class="p-4 border-b border-slate-200">
                                            <p class="block text-sm text-slate-800">
                                                <span class="text-xs border px-2 py-0.5 rounded-lg {{ $recour->status->color() }} ">{{ $recour->status->label() }} </span>
                                            </p>
                                        </td>
                                        <td class="p-4 border-b border-slate-200">
                                            <p class="block text-sm text-slate-800">
                                                Candidature ID: {{ $recour->candidature->id}}
                                            </p>
                                            <p class="block text-sm text-slate-800">
                                                Candidat: {{ $recour->candidature->candidat->nom }} / {{ $recour->candidature->candidat->prenom }}
                                            </p>
                                        </td>
                                        <td class="p-4 border-b border-slate-200">
                                            <p class="block text-sm text-slate-800">
                                                {{ $recour->created_at}}
                                            </p>
                                        </td>
                                        <td class="p-4 border-b border-slate-200">
                                            <div class="flex justify-end text-sm text-slate-800">
                                                <flux:modal.trigger name="display-recour">
                                                    <flux:button variant="primary" size="sm" x-data="" x-on:click.prevent="$dispatch('open-modal', 'display-recour')">
                                                        <x-icons.plus-circle width="24" height="24" />
                                                    {{ __('Détail') }}
                                                    </flux:button>
                                                </flux:modal.trigger>
                                                
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $recours->links() }}
                </div>

            </div>

            <x-placeholder-pattern
                class="absolute z-0 inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
        </div>
    </div>

    <flux:modal name="display-recour" :show="$errors->isNotEmpty()" focusable class="max-w-xl w-full">
        <form wire:submit="save" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Ajouter une specialite') }}</flux:heading>

            </div>
            <flux:select wire:model="filiere_id" placeholder="filieres">
                <flux:select.option>Filieres</flux:select.option>
                @foreach ($filieres as $filiere)
                    <flux:select.option value="{{ $filiere->id }}">{{ $filiere->name_fr }}</flux:select.option>
                @endforeach
            </flux:select>
            </flux:select>
            <flux:input wire:model="name_fr" :label="__('Lebelle FR')" type="text" />
            <flux:input wire:model="name_ar" :label="__('Lebelle AR')" type="text" />
            <flux:input wire:model="coefficient" :label="__('coefficient')" type="text" />
            <div class="p-4 max-w-xl flex gap-2  items-center">
                <label for="is_active">{{ __('Activer') }}</label>
                <input wire:model="is_active" id="is_active" type="checkbox" />
            </div>
            
            <div class="flex justify-end space-x-2">
                <flux:button variant="filled" wire:click="clearForm">{{ __('Cancel') }}</flux:button>
                @if (is_null($id))
                    <flux:button variant="primary" type="submit">{{ __('Create') }}</flux:button>
                @else
                    <flux:button variant="primary" type="submit">{{ __('update') }}</flux:button>
                @endif
            </div>
        </form>
    </flux:modal>



</x-layouts.candidat>
