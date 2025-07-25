<x-layouts.option>
    <div class="flex w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative h-full flex-1  rounded-xl p-2 border border-neutral-200 dark:border-neutral-700">
            <div class="w-full h-full bg-white relative z-10 rounded-lg p-4 border">
                <div class="w-full">
                    <h3 class="text-lg font-semibold ml-3 text-slate-800">Gestion des <b>filieres</b></h3>
                    <p class="text-slate-500 mb-5 ml-3"> modifiez et gérez les parametres des filieres.</p>
                </div>
                <div class="relative flex flex-col w-full text-gray-700 bg-white shadow-md rounded-lg bg-clip-border">
                    <table class="w-full text-left table-auto min-w-max">
                        <thead>
                            <tr>
                                <th class="p-4 w-1 border-b border-slate-300 bg-slate-50"></th>
                                <th class="p-4 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        ID 
                                    </p>
                                </th>
                                <th class="p-4 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        Lebelle 
                                    </p>
                                </th>
                                <th class="p-4 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        Etat
                                    </p>
                                </th>
                                <th class="p-4 border-b border-slate-300 bg-slate-50 w-11">
                                    <div class="w-full flex justify-end">
                                        <flux:modal.trigger name="add-filiere-modal">
                                            <flux:button variant="primary" size="sm" x-data="" x-on:click.prevent="$dispatch('open-modal', 'add-filiere-modal')">
                                                <x-icons.plus-circle width="24" height="24" />
                                            {{ __('Ajouter une filiere') }}
                                            </flux:button>
                                        </flux:modal.trigger>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody wire:sortable="updateOrder" wire:sortable.options="{ animation: 100 }">
                            @foreach ($filieres as $filiere)
                                <tr class="hover:bg-slate-50"  wire:sortable.item="{{ $filiere->id }}" wire:key="filiere-{{ $filiere->id }}">
                                    <td class="p-4 border-b border-slate-200">
                                        <x-icons.drag class="cursor-grab focus:cursor-grabbing" width="28" height="28" wire:sortable.handle ></x-icons.drag>
                                    </td>  
                                    <td class="p-4 border-b border-slate-200">
                                        <p class="block text-sm text-slate-800">
                                            {{ $filiere->id}}
                                        </p>
                                    </td>
                                    <td class="p-4 border-b border-slate-200">
                                        <p class="block text-sm text-slate-800">
                                            Domaine: {{ $filiere->domain?->name_fr }}
                                        </p>
                                        <p class="block text-sm text-slate-800">
                                            FR: {{ $filiere->name_fr }}
                                        </p>
                                        <p class="block text-sm text-slate-800">
                                            AR: {{ $filiere->name_ar }}
                                        </p>
                                    </td>
                                    <td class="p-4 border-b border-slate-200">
                                        @if ($filiere->is_active)
                                            <span class="text-green-500 font-semibold text-xs px-1 py-0.5 rounded bg-green-100 border border-green-200">Actif</span>
                                            
                                        @else
                                            <span class="text-red-500 font-semibold text-xs px-1 py-0.5 rounded bg-red-100 border border-red-200">Inactif</span>
                                        @endif
                                    </td>
                                    <td class="p-4 border-b border-slate-200">
                                        <div class="flex justify-end text-sm text-slate-800">
                                            
                                            <x-dropdown trigger="Options">
                                                <button wire:click="editMotif('{{$filiere->id}}')"  class="cursor-pointer rounded-md block text-left w-full px-4 py-2 hover:bg-gray-100">{{ __('edit') }}</button>
                                                <button x-on:click="confirm('Are you sure u want to delete {{ $filiere->name_fr }}') ? @this.call('delete','{{$filiere->id}}') : null"  class="cursor-pointer rounded-md block text-left w-full px-4 py-2 text-red-500 hover:bg-red-100">{{ __('delete') }}</button>
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

    <flux:modal name="add-filiere-modal" :show="$errors->isNotEmpty()" focusable class="max-w-xl w-full">
        <form wire:submit="save" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Ajouter une filiere') }}</flux:heading>

            </div>
            <flux:select wire:model="domain_id" placeholder="Domaines">
                <flux:select.option>Domaines</flux:select.option>
                @foreach ($domains as $domain)
                    <flux:select.option value="{{ $domain->id }}">{{ $domain->name_fr }}</flux:select.option>
                @endforeach
            </flux:select>
            <flux:input wire:model="name_fr" :label="__('Lebelle FR')" type="text" />
            <flux:input wire:model="name_ar" :label="__('Lebelle AR')" type="text" />
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

</x-layouts.option>
