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
                                                <flux:modal.trigger>
                                                    <flux:button variant="primary" size="sm" wire:click="openModal({{ $recour->id }})" >
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

    <flux:modal name="display-recour" :show="$errors->isNotEmpty()" focusable class="max-w-7xl w-full space-y-6">
        <flux:heading size="lg">Detail</flux:heading>
        <hr />
        <div class="grid grid-cols-2  gap-4">

            <div
                class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-800 dark:text-gray-100">
                <div>
                    <span class="font-semibold">Nom (FR):</span> {{ $recour->candidature->candidat->nom }}
                </div>
                <div>
                    <span class="font-semibold">Prénom (FR):</span> {{ $recour->candidature->candidat->prenom }}
                </div>
                <div>
                    <span class="font-semibold">Domain:</span> {{ $recour->candidature->domain->name_fr }}
                </div>
                <div>
                    <span class="font-semibold">Filiere:</span> {{ $recour->candidature->filiere->name_fr }}
                </div>
                <div>
                    <span class="font-semibold">Specialite:</span> {{ $recour->candidature->specialite->name_fr }}
                </div>
                <div>
                    <span class="font-semibold">Specialite Choise:</span> {{ $recour->candidature->specialite_concour->name_fr }}
                </div>
                <div>
                    <span class="font-semibold">Classification :</span>
                    {{ $recour->candidature->classification->code }}
                </div>
                <div>
                </div>
                <div>
                    <span class="font-semibold">Moyenne semestres:</span> {{ $recour->candidature->moyenne_semestres }}
                </div>
                <div>
                    <span class="font-semibold">moyenne:</span> {{ $recour->candidature->moyenne }}
                </div>
                <div>
                    <span class="font-semibold">Type diplome:</span> {{ $recour->candidature->type_diplome }}
                </div>
                <div>
                    <span class="font-semibold">Annee diplome:</span> {{ $recour->candidature->annee_diplome }}
                </div>
                <div class="col-span-2">
                    <span class="font-semibold">Etablissement diplome:</span> {{ $recour->candidature->etablissement_diplome }}
                </div>
            </div>
            <form wire:submit="save" class="space-y-6 col-span-1">

                @foreach ($candidatureRecours as $r)
                    <div class=" rounded-xl bg-gray-{{ is_null($r->user_id) ? '100' : '200' }} text-gray-700 py-2 px-4 flex flex-col gap-2" style="text-align: {{ is_null($r->user_id) ? 'left' : 'right' }}">

                        <p class="relative">
                            {{ $r->content }}
                            
                        </p>
                        <p class="flex gap-1 text-xs text-gray-500 {{ is_null($r->user_id) ? 'justify-start' : 'justify-end' }}"> 
                            <x-icons.calendar width="14" height="14" />
                            {{ $r->created_at }}
                            @if (is_null($r->user_id))
                                <span> | </span>
                                {{ $r->status->label() }} 
                                @if ($r->status->name != "EN_ATTENTE")
                                <span></span>
                                le : 
                                {{ $r->updated_at }}
                                
                                @endif
                                <div class="flex justify-end">
                                    <x-dropdown trigger="Action" size="sm" >
                                        <button wire:click="setStatus('APPROUVE')" class="cursor-pointer rounded-md block text-left w-full px-4 py-2 hover:bg-gray-100">Approuvé</button>
                                        <button wire:click="setStatus('REJETE')" class="cursor-pointer rounded-md block text-left w-full px-4 py-2 hover:bg-gray-100">Rejeté</button>
                                    </x-dropdown>
                                </div>
                            @endif
                        </p>
                    </div>
                @endforeach
                <textarea wire:model="content" class="w-full outline-0 ring-0 border border-gray-200 rounded-lg p-2 text-gray-700 text-sm" rows="4"></textarea>
                @error('content')
                    <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
                <div class="flex justify-end space-x-2">

                    <flux:button variant="filled" size="sm" wire:click="clearForm">{{ __('Annuler') }}</flux:button>
                    <flux:button variant="primary" size="sm" type="submit">{{ __('Envoye') }}</flux:button>
                    <a target="_blank" href="{{ route('administrateur.candidats.candidature.detail', $recour->candidature->id) }}">
                        <flux:button variant="primary" size="sm" type="button">
                            Afficher la candidature
                        </flux:button>
                    </a>
                </div>
                
            </form>
        </div>

    </flux:modal>



</x-layouts.candidat>
