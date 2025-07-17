<x-layouts.candidat>
    
    <div class="flex w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative h-full flex-1  rounded-xl p-2 border border-neutral-200 dark:border-neutral-700">
            <div class="w-full h-full bg-white relative z-10 rounded-lg p-4 border">
                <div class="w-full">
                    <h3 class="text-lg font-semibold ml-3 text-slate-800">
                        Gestion des <b>Candidatures ({{ $candidatures->count() }})</b>
                    @if ($specialite)
                        <span class=" text-blue-800 text-lg underline"> : ({{ $specialite->code }}) - {{ $specialite->name_fr }}</span>
                    @endif
                    </h3>
                    <p class="text-slate-500 mb-5 ml-3"> Suivez, évaluez et gérez efficacement les candidatures reçues.</p>
                </div>
                
                @if (!$bySpecialite)
                    <div class="w-full flex gap-2 mb-2">
                        <flux:input wire:model.live.debounce.1000="nom" :placeholder="__('Nom')" type="text" />
                        <flux:input wire:model.live.debounce.1000="prenom" :placeholder="__('Prénom')" type="text" />
                        <flux:select wire:model.change="domain_id" placeholder="domaines">
                            <option>-- Domaines --</option>
                            @foreach ($domaines as $domaine)
                                <flux:select.option value="{{ $domaine->id }}">{{ $domaine->name_fr }}</flux:select.option>
                            @endforeach
                        </flux:select>
                        <flux:select wire:model.change="filiere_id" placeholder="filieres">
                            <flux:select.option>Filieres</flux:select.option>
                            @foreach ($filieres as $filiere)
                                <flux:select.option value="{{ $filiere->id }}">{{ $filiere->name_fr }}</flux:select.option>
                            @endforeach
                        </flux:select>
                        <flux:select wire:model.change="specialite_concour_id" placeholder="specialites">
                            <flux:select.option>Specialites</flux:select.option>
                            @foreach ($specialites as $specialite)
                                <flux:select.option value="{{ $specialite->id }}">{{ $specialite->code }} - {{ $specialite->name_fr }}</flux:select.option>
                            @endforeach
                        </flux:select>
                        <flux:select wire:model.change="specialite_concour_id" placeholder="specialites">
                            <flux:select.option>Specialites concours</flux:select.option>
                            @foreach ($specialiteConcours as $sc)
                                <flux:select.option value="{{ $sc->id }}">{{ $sc->code }} - {{ $sc->name_fr }}</flux:select.option>
                            @endforeach
                        </flux:select>
                        <flux:select wire:model.change="decision" placeholder="Decision">
                            <flux:select.option>Decisions</flux:select.option>
                            @foreach (App\CandidatureStatusEnum::cases() as $status)
                                <flux:select.option value="{{ $status->value }}">{{ $status->name }}</flux:select.option>
                            @endforeach
                        </flux:select>
                        <flux:select wire:model.change="orderBy" placeholder="order">
                            <flux:select.option>Order by</flux:select.option>
                            <flux:select.option value="moyenne">moyenne</flux:select.option>
                            <flux:select.option value="decision">decision</flux:select.option>
                        </flux:select>
                        <flux:select wire:model.change="orderDirection" placeholder="order direction">
                            <flux:select.option>Order direction</flux:select.option>
                            <flux:select.option value="ASC">ascendant</flux:select.option>
                            <flux:select.option value="DESC">descendant</flux:select.option>
                        </flux:select>
                    </div>
                @else   
                    <div class="w-full flex gap-2 mb-2">
                            <label for="rejete" class="px-4 py-2 max-w-xl flex gap-2 border bg-red-500 border-red-600 text-white rounded-lg text-xs cursor-pointer items-center">
                                {{ __('Afficher les rejetes') }}
                                <input wire:model.change="rejete" id="rejete" type="checkbox" />
                            </label>
                    </div>
                @endif
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
                                            Nom / Prénom
                                        </p>
                                    </th>
                                    <th class="p-4 border-b border-slate-300 bg-slate-50">
                                        <p class="block text-sm font-normal leading-none text-slate-500">
                                            Moyenne
                                        </p>
                                    </th>
                                    <th class="p-4 border-b border-slate-300 bg-slate-50">
                                        <p class="block text-sm font-normal leading-none text-slate-500">
                                            Classification concour
                                        </p>
                                    </th>
                                    <th class="p-4 border-b border-slate-300 bg-slate-50">
                                        <p class="block text-sm font-normal leading-none text-slate-500">
                                            Decision
                                        </p>
                                    </th>
                                    <th class="p-4 border-b border-slate-300 bg-slate-50">
                                        <p class="block text-sm font-normal leading-none text-slate-500">
                                            Specialite
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
                                @foreach ($candidatures as $candidature)
                                    <tr class="hover:bg-slate-50">
                                            
                                        <td class="p-4 border-b border-slate-200">
                                            <p class="block text-sm text-slate-800">
                                                {{ $candidature->id}}
                                            </p>
                                        </td>
                                        <td class="p-4 border-b border-slate-200">
                                            <p class="block text-sm text-slate-800">
                                                {{ $candidature->candidat->nom }} - {{ $candidature->candidat->nom_ar }}
                                            </p>
                                            <p class="block text-sm text-slate-800">
                                                {{ $candidature->candidat->prenom }} - {{ $candidature->candidat->prenom_ar }}
                                            </p>
                                        </td>
                                        <td class="p-4 border-b border-slate-200">
                                            <p class="block text-sm text-slate-800">
                                                {{ $candidature->moyenne}}
                                            </p>
                                        </td>
                                        <td class="p-4 border-b border-slate-200">
                                            <p class="block text-sm text-slate-800">
                                                {{ $candidature->classification_concour}}
                                            </p>
                                        </td>
                                        <td class="p-4 border-b border-slate-200">
                                            <p class="block text-sm text-slate-800">
                                                {{ $candidature->decision}}
                                            </p>
                                        </td>
                                        <td class="p-4 border-b border-slate-200">
                                            <p class="block text-sm text-slate-800">
                                                {{ $candidature->specialite_id}}
                                            </p>
                                        </td>
                                        <td class="p-4 border-b border-slate-200">
                                            <p class="block text-sm text-slate-800">
                                                {{ $candidature->date}}
                                            </p>
                                        </td>
                                        <td class="p-4 border-b border-slate-200">
                                            <div class="flex justify-end text-sm text-slate-800">
                                                <a href="{{ route('administrateur.candidats.candidature.detail', $candidature->id) }}">
                                                    <flux:button variant="primary" size="sm" type="button">
                                                        Détail
                                                    </flux:button>
                                                </a>
                                                    
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if (!$bySpecialite)
                        <div class="my-5 mx-4">
                            {{ $candidatures->links() }}
                        </div>
                    @endif
                </div>

            </div>

            <x-placeholder-pattern
                class="absolute z-0 inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
        </div>
    </div>


</x-layouts.candidat>
