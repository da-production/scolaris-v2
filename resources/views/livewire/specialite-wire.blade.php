<x-layouts.option>
    <div class="flex w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative h-full flex-1  rounded-xl p-2 border border-neutral-200 dark:border-neutral-700">
            <div class="w-full h-full bg-white relative z-10 rounded-lg p-4 border">
                <div class="w-full">
                    <h3 class="text-lg font-semibold ml-3 text-slate-800">Gestion des <b>Specialite</b></h3>
                    <p class="text-slate-500 mb-5 ml-3"> modifiez et gérez les parametres des Specialite.</p>
                </div>
                <div class="relative flex flex-col w-full text-gray-700 bg-white shadow-md rounded-lg bg-clip-border">
                    <table class="w-full text-left table-auto min-w-max">
                        <thead>
                            <tr>
                                <th class="p-4 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        ID / code
                                    </p>
                                </th>
                                <th class="p-4 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        Lebelle
                                    </p>
                                </th>
                                <th class="p-4 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        Specialite Concour
                                    </p>
                                </th>
                                <th class="p-4 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        Description
                                    </p>
                                </th>
                                <th class="p-4 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        Etat
                                    </p>
                                </th>
                                <th class="p-4 border-b border-slate-300 bg-slate-50 w-11">
                                    <div class="w-full flex justify-end">
                                        <flux:modal.trigger name="add-specialite-modal">
                                            <flux:button variant="primary" size="sm" x-data="" x-on:click.prevent="$dispatch('open-modal', 'add-specialite-modal')">
                                                <x-icons.plus-circle width="24" height="24" />
                                            {{ __('Ajouter') }}
                                            </flux:button>
                                        </flux:modal.trigger>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($specialites as $specialite)
                                <tr class="hover:bg-slate-50">
                                        
                                    <td class="p-4 border-b border-slate-200">
                                        <p class="block text-sm text-slate-800">
                                            {{ $specialite->id}} / {{ $specialite->code}}
                                        </p>
                                    </td>
                                    <td class="p-4 border-b border-slate-200">
                                        <p class="block text-sm text-slate-800">
                                            filiere: {{ $specialite->filiere?->name_fr }}
                                        </p>
                                        <p class="block text-sm text-slate-800">
                                            FR: {{ $specialite->name_fr }}
                                        </p>
                                        <p class="block text-sm text-slate-800">
                                            AR: {{ $specialite->name_ar }}
                                        </p>
                                        <p class="block text-sm text-slate-800">
                                            Coefficient: {{ $specialite->coefficient }}
                                        </p>
                                    </td>
                                    <td class="p-4 border-b border-slate-200">
                                        <p class=" text-sm text-slate-800 flex gap-2 items-center">
                                            <span class=" text-xs px-2 py-0.5 rounded-2xl bg-teal-100 text-teal-500 border-teal-200 border "> @isnull($specialite->specialiteConcour?->name_fr, 'Non renseigné')  </span>
                                        </p>
                                    </td>
                                    {{-- <td class="p-4 border-b border-slate-200">
                                        <p class=" text-sm text-slate-800 flex gap-2 items-center">
                                            <span wire:click="displaySousSpecialites({{ $specialite->id }})" class="cursor-pointer text-xs px-2 py-0.5 rounded-2xl bg-teal-100 text-teal-500 border-teal-200 border ">{{ $specialite->sous_specialites_count }} | Afficher</span>
                                            <span wire:click="createSousSpecialite({{ $specialite->id }})" class="cursor-pointer text-xs underline text-teal-500" >Ajouter</span>
                                        </p>
                                    </td> --}}
                                    <td class="p-4 border-b border-slate-200">
                                        <p class="block text-sm text-slate-800">
                                            @isnull($specialite->description, 'non renseigné')
                                        </p>
                                    </td>
                                    <td class="p-4 border-b border-slate-200">
                                        @if ($specialite->is_active)
                                            <span class="text-green-500 font-semibold text-xs px-1 py-0.5 rounded bg-green-100 border border-green-200">Actif</span>
                                            
                                        @else
                                            <span class="text-red-500 font-semibold text-xs px-1 py-0.5 rounded bg-red-100 border border-red-200">Inactif</span>
                                        @endif
                                    </td>
                                    <td class="p-4 border-b border-slate-200">
                                        <div class="flex justify-end text-sm text-slate-800">
                                            
                                            <x-dropdown trigger="Options">
                                                <button wire:click="editSpecialite('{{$specialite->id}}')"  class="cursor-pointer rounded-md block text-left w-full px-4 py-2 hover:bg-gray-100">{{ __('edit') }}</button>
                                                <button x-on:click="confirm('Are you sure u want to delete {{ $specialite->name_fr }}') ? @this.call('delete','{{$specialite->id}}') : null"  class="cursor-pointer rounded-md block text-left w-full px-4 py-2 text-red-500 hover:bg-red-100">{{ __('delete') }}</button>
                                            </x-dropdown>
                                            
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

            <x-placeholder-pattern
                class="absolute z-0 inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
        </div>
    </div>

    <flux:modal name="add-specialite-modal" :show="$errors->isNotEmpty()" focusable class="max-w-xl w-full">
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
            <flux:select wire:model="specialite_concour_id" placeholder="Specialite Concours">
                <flux:select.option>specialite concour</flux:select.option>
                @foreach ($cSpecialites as $cSpecialite)
                    <flux:select.option value="{{ $cSpecialite->id }}"  >{{ $cSpecialite->name_fr }}</flux:select.option>
                @endforeach
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

    <flux:modal name="add-sous-specialite-modal" :show="$errors->isNotEmpty()" focusable class="max-w-xl w-full">
        <form wire:submit="saveSousSpecialite" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Ajouter une sous specialite') }}</flux:heading>

            </div>

            <flux:input wire:model="code" :label="__('Code')" type="text" />
            <flux:input wire:model="name_fr" :label="__('Lebelle FR')" type="text" />
            <flux:input wire:model="name_ar" :label="__('Lebelle AR')" type="text" />
            <flux:input wire:model="ponderation" :label="__('Ponderation')" type="text" />
            <div class="p-4 max-w-xl flex gap-2  items-center">
                <label for="is_active">{{ __('Activer') }}</label>
                <input wire:model="is_active" id="is_active" type="checkbox" />
            </div>
            
            <div class="flex justify-end space-x-2">
                <flux:button variant="filled" wire:click="clearForm">{{ __('Cancel') }}</flux:button>
                @if (is_null($sous_specialite_id))
                    <flux:button variant="primary" type="submit">{{ __('Create') }}</flux:button>
                @else
                    <flux:button variant="primary" type="submit">{{ __('update') }}</flux:button>
                @endif
            </div>
        </form>
    </flux:modal>

    <flux:modal name="display-sous-specialites-modal" :show="$errors->isNotEmpty()" focusable class="max-w-4xl w-full">
        <div wire:submit="saveSousSpecialite" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('liste des sous specialite') }}</flux:heading>

            </div>
            @if (is_null($sous_specialites))
                <div class="p-4">
                    <p class="text-gray-500">Aucune sous spécialité trouvée.</p>
                </div>
            @else
                
            <div class="overflow-x-auto p-4">
                @if (!is_null($sous_specialite_id))
                    <form wire:submit="updateSousSpecialite" class="flex flex-col w-full items-end gap-4 p-4 bg-gray-100 rounded-2xl">
                        <div class="flex w-full gap-2">
                            <flux:input wire:model="name_fr" :label="__('Libellé FR')" type="text" class="w-full"  />
                            <flux:input wire:model="name_ar" :label="__('Libellé AR')" type="text" class="w-full"  />
                        </div>
                        <div class="flex w-full gap-2">
                            <flux:input wire:model="code" :label="__('Code')" type="text" class="w-full"  />
                            <flux:input wire:model="ponderation" :label="__('Pondération')" type="text" class="w-full"  />
                        </div>
                        

                        <div class="flex w-full items-center gap-2">
                            <label for="is_active" class="text-sm text-gray-700 dark:text-gray-300">{{ __('Activer') }}</label>
                            <input wire:model="is_active" id="is_active" type="checkbox" class="mt-1" />
                        </div>

                        <div class="flex gap-2 ml-auto">
                            <flux:button variant="filled" wire:click="clearForm">{{ __('Cancel') }}</flux:button>
                            <flux:button variant="primary" type="submit">{{ __('Update') }}</flux:button>
                        </div>
                    </form>

                @endif
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Nom</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Code</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Description</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Moyen</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Statut</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($sous_specialites as $sous_specialite)
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-gray-100">
                                    <div class="flex flex-col">
                                        <span class="font-semibold">{{ $sous_specialite->name_fr }}</span>
                                        <span class="text-gray-500 text-xs dark:text-gray-400">{{ $sous_specialite->name_ar }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                    {{ $sous_specialite->code }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                    {{ $sous_specialite->description }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">
                                    {{ $sous_specialite->ponderation }}
                                </td>
                                <td class="px-4 py-3">
                                    @if ($sous_specialite->is_active)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                            Actif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                                            Inactif
                                        </span>
                                    @endif
                                </td>
                                <td class="p-4 border-b border-slate-200">
                                    <div class="flex justify-end text-sm text-slate-800">
                                        
                                        <x-dropdown trigger="Options">
                                            <button wire:click="editSousSpecialite('{{$sous_specialite->id}}')"  class="cursor-pointer rounded-md block text-left w-full px-4 py-2 hover:bg-gray-100">{{ __('edit') }}</button>
                                            <button x-on:click="confirm('Are you sure u want to delete {{ $sous_specialite->name_fr }}') ? @this.call('deleteSousSpecialite','{{$sous_specialite->id}}') : null"  class="cursor-pointer rounded-md block text-left w-full px-4 py-2 text-red-500 hover:bg-red-100">{{ __('delete') }}</button>
                                        </x-dropdown>
                                        
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            
            <div class="flex justify-end space-x-2">
                <flux:button variant="filled" wire:click="clearForm">{{ __('Cancel') }}</flux:button>
                
            </div>
        </div>
    </flux:modal>

</x-layouts.option>
