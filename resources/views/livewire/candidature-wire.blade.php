@use('App\CandidatureStatusEnum')
<x-layouts.candidat>
    <div class="flex w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative h-full flex-1  rounded-xl p-2 border border-neutral-200 dark:border-neutral-700">
            <div class="w-full h-full bg-white relative z-10 rounded-lg p-4 border">
                <div class="w-full">
                    <h3 class="text-lg font-semibold ml-3 text-slate-800">Gestion des <b>Classification</b></h3>
                    <p class="text-slate-500 mb-5 ml-3"> modifiez et gérez les parametres des classification.</p>
                </div>
                <div class="relative flex flex-col w-full text-gray-700 bg-white shadow-md rounded-lg bg-clip-border">
                    <div
                        class="w-full   dark:bg-gray-800 p-6 flex flex-col md:flex-row gap-6">
                        <!-- Image du candidat -->
                        <div class="w-3/12 space-y-2">
                            <img src="{{ $this->profilePhotoUrl() }}" alt="Photo du candidat"
                                class="w-full h-auto rounded-lg shadow-md object-cover">
                            {{-- <a  wire:navigate href="{{ route('administrateur.candidats.show', ['candidat' => $candidature->candidat->id]) }}"
                                class="block mt-4 text-center text-sm text-white bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 px-4 py-2 rounded transition">
                                Voir le candidat
                            </a> --}}
                            <div class="p-4 rounded-xl border text-xs text-center {{ CandidatureStatusEnum::from($candidature->decision)->color()}}">{{ CandidatureStatusEnum::from($candidature->decision)->description()}}</div>
                            
                            @canany(['set candidature decision'])
                                @if($candidature->decision == 'EN_ATTENTE' || auth()->user()->can('reset candidature decision'))
                                <flux:modal.trigger name="decision-modal">
                                    <flux:button variant="primary" size="sm" x-data="" class="w-full" x-on:click.prevent="$dispatch('open-modal', 'decision-modal')">
                                        <x-icons.pen width="16" height="16" />
                                        {{ __('Émettre la décision') }}
                                    </flux:button>
                                </flux:modal.trigger>
                                @endif
                            @endcanany
                            <flux:modal name="decision-modal" :show="$errors->isNotEmpty()" focusable class="max-w-xl w-full">
                                <form wire:submit="setDecision" class="space-y-6">
                                    <div>
                                        <flux:heading size="lg">{{ __('Émettre la décision') }}</flux:heading>
                                        <div class="max-w-xl mx-auto mt-6 p-4 border border-red-200 bg-red-50 text-red-700 rounded-lg shadow-sm">
                                            <h2 class="text-lg font-semibold">Confirmation requise</h2>
                                            <p class="mt-1 text-sm">
                                                Vous êtes sur le point de <span class="font-medium">mettre à jour la décision</span>.
                                                <br>
                                                <strong class="text-red-800">Attention :</strong> une fois cette action effectuée, il ne sera plus possible de revenir en arrière.
                                            </p>
                                        </div>

                                    </div>
                                    <flux:select wire:model.change="decision" >
                                        <flux:select.option>Decisions</flux:select.option>
                                        @foreach (CandidatureStatusEnum::cases() as $status)
                                            <flux:select.option value="{{ $status->value }}">{{ $status->label() }}</flux:select.option>
                                        @endforeach
                                    </flux:select>

                                    @if ($decision == 'REJETE')
                                        <flux:select wire:model.change="motif" >
                                            <flux:select.option>Motifs</flux:select.option>
                                            @foreach ($motifs as $m)
                                                <flux:select.option value="{{ $m->id }}">{{ $m->name_fr }}</flux:select.option>
                                            @endforeach
                                        </flux:select>
                                    @endif

                                    @if ($motif == 5 && $decision == 'REJETE')
                                        <flux:input wire:model="description" :label="__('Description')" type="text" />
                                    @endif

                                    <div class="flex justify-end space-x-2">
                                        <flux:button variant="primary" type="submit">{{ __('update') }}</flux:button>
                                    </div>
                                </form>
                            </flux:modal>
                        </div>
                        <div class="tab-wrapper w-9/12" x-data="{ activeTab: 0 }">
                            <div class="flex border-b border-gray-300">
                                <label
                                    @click="activeTab = 0"
                                    class="cursor-pointer px-4 py-2 font-medium text-sm transition duration-200 border-b-2"
                                    :class="activeTab === 0 
                                        ? 'text-blue-600 border-blue-600' 
                                        : 'text-gray-500 border-transparent hover:text-blue-500 hover:border-blue-500'"
                                >
                                    Information Candidature
                                </label>
                                <label
                                    @click="activeTab = 1"
                                    class="cursor-pointer px-4 py-2 font-medium text-sm transition duration-200 border-b-2"
                                    :class="activeTab === 1 
                                        ? 'text-blue-600 border-blue-600' 
                                        : 'text-gray-500 border-transparent hover:text-blue-500 hover:border-blue-500'"
                                >
                                    Information Candidat
                                </label>
                                @canany(['view candidature files'])
                                <label
                                    @click="activeTab = 2"
                                    class="cursor-pointer px-4 py-2 font-medium text-sm transition duration-200 border-b-2"
                                    :class="activeTab === 2 
                                        ? 'text-blue-600 border-blue-600' 
                                        : 'text-gray-500 border-transparent hover:text-blue-500 hover:border-blue-500'"
                                >
                                    Fichiers téléversés
                                </label>
                                @endcanany
                            </div>


                            <div class="tab-panel py-4" :class="{ 'active': activeTab === 0 }"
                                x-show.transition.in.opacity.duration.600="activeTab === 0">
                                <div
                                    class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-800 dark:text-gray-100">
                                    <div>
                                        <span class="font-semibold">Domain:</span> {{ $candidature->domain->name_fr }}
                                    </div>
                                    <div>
                                        <span class="font-semibold">Filiere:</span> {{ $candidature->filiere->name_fr }}
                                    </div>
                                    <div>
                                        <span class="font-semibold">Specialite:</span> {{ $candidature->specialite->name_fr }}
                                    </div>
                                    <div>
                                        <span class="font-semibold">Specialite Choise:</span> {{ $candidature->specialite_concour->name_fr }}
                                    </div>
                                    <div>
                                        <span class="font-semibold">Classification :</span>
                                        {{ $candidature->classification->code }}
                                    </div>
                                    <div>
                                    </div>
                                    <div>
                                        <span class="font-semibold">Moyenne semestres:</span> {{ $candidature->moyenne_semestres }}
                                    </div>
                                    <div>
                                        <span class="font-semibold">moyenne:</span> {{ $candidature->moyenne }}
                                    </div>
                                    <div>
                                        <span class="font-semibold">Type diplome:</span> {{ $candidature->type_diplome }}
                                    </div>
                                    <div>
                                        <span class="font-semibold">Annee diplome:</span> {{ $candidature->annee_diplome }}
                                    </div>
                                    <div class="col-span-2">
                                        <span class="font-semibold">Etablissement diplome:</span> {{ $candidature->etablissement_diplome }}
                                    </div>
                                </div>
                            </div>
                            <div class="tab-panel py-4" :class="{ 'active': activeTab === 1 }"
                                x-show.transition.in.opacity.duration.600="activeTab === 1">
                                <div
                                    class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-800 dark:text-gray-100">
                                    <div>
                                        <span class="font-semibold">Nom (FR):</span> {{ $candidature->candidat->nom }}
                                    </div>
                                    <div>
                                        <span class="font-semibold">Prénom (FR):</span> {{ $candidature->candidat->prenom }}
                                    </div>
                                    <div>
                                        <span class="font-semibold">Nom (AR):</span> {{ $candidature->candidat->nom_ar }}
                                    </div>
                                    <div>
                                        <span class="font-semibold">Prénom (AR):</span> {{ $candidature->candidat->prenom_ar }}
                                    </div>
                                    <div>
                                        <span class="font-semibold">Date de naissance:</span>
                                        {{ $candidature->candidat->date_naissance }}
                                    </div>
                                    <div>
                                        <span class="font-semibold">Genre:</span>
                                        {{ $candidature->candidat->genre === 'H' ? 'Homme' : 'Femme' }}
                                    </div>
                                    <div>
                                        <span class="font-semibold">Email:</span> {{ $candidature->candidat->email }}
                                    </div>
                                    <div>
                                        <span class="font-semibold">Téléphone 1:</span> {{ $candidature->candidat->mobile_1 }}
                                    </div>
                                    <div>
                                        <span class="font-semibold">Téléphone 2:</span> {{ $candidature->candidat->mobile_2 }}
                                    </div>
                                    <div>
                                        <span class="font-semibold">Fixe:</span> {{ $candidature->candidat->fix }}
                                    </div>
                                    <div class="col-span-2">
                                        <span class="font-semibold">Adresse (FR):</span> {{ $candidature->candidat->adresse }}
                                    </div>
                                    <div>
                                        <span class="font-semibold">Numéro Bac:</span> {{ $candidature->candidat->numero_bac }}
                                    </div>
                                    <div>
                                        <span class="font-semibold">Année Bac:</span> {{ $candidature->candidat->annee_bac }}
                                    </div>
                                </div>
                            </div>
                            <div class="tab-panel py-4" :class="{ 'active': activeTab === 2 }"
                                x-show.transition.in.opacity.duration.600="activeTab === 2">
                                <ul class="list-disc list-inside space-y-1">
                                    @if (!is_null($candidature->document))
                                        <!-- Exemple de fichier -->
                                        <li class="flex items-center justify-between p-4 border rounded-lg shadow-sm bg-white">
                                            <div class="flex items-center space-x-4">
                                            <!-- Icône fichier (ex: PDF) -->
                                            <div class="text-red-500">
                                                <!-- Icône PDF (heroicons ou autre) -->
                                                <x-icons.pdf class="size-10" />
                                            </div>

                                            <div>
                                                <p class="font-medium text-gray-900">{{ $candidature->document?->file_name }}</p>
                                                <p class="text-sm text-gray-500">Type: {{ $candidature->document?->file_extension }} | Taille: {{ convertSize($candidature->document?->file_size) }}</p>
                                            </div>
                                            </div>

                                            <div class="flex flex-col items-center gap-2 ">
                                                <button type="button" wire:click="download('{{ $candidature->document?->id }}')"
                                                    class="w-full justify-center flex items-center px-3 py-1.5 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded">
                                                    Afficher
                                                </button>
                                            </div>
                                        </li>
                                    @endif

                                </ul>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

            <x-placeholder-pattern
                class="absolute z-0 inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
        </div>
    </div>


</x-layouts.candidat>
