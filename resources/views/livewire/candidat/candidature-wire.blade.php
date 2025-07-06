@use('App\TypeDiplomEnum')
@use('App\CandidatureStatusEnum')

<div class="w-full">
    <div class="flex flex-wrap">
        <!-- Left Column: 4/12 -->
        <div class="w-full md:w-4/12">
            <div class="bg-blue-100 p-4">
                @if (is_null($id))
                    <span class="text-gray-500"> Veuillez compléter les informations de la candidature pour pouvoir téléverser le fichier. </span>
                @else
                    <h2 class="text-lg font-bold mb-4">Téléversement de documents</h2>
                    
                    <x-filepond::upload 
                        wire:model="file"
                        id="filepond-photo"
                    />
                    @if (count($files) > 0)
                        <div class="mb-4">
                            <h3 class="text-sm font-semibold mb-2">Fichiers déjà téléversés :</h3>
                            <ul class="list-disc list-inside space-y-1">
                                @foreach($files as $f)
                                    <!-- Exemple de fichier -->
                                    <li class="flex items-center justify-between p-4 border rounded-lg shadow-sm bg-white">
                                        <div class="flex items-center space-x-4">
                                        <!-- Icône fichier (ex: PDF) -->
                                        <div class="text-red-500">
                                            <!-- Icône PDF (heroicons ou autre) -->
                                            <x-icons.pdf class="size-10" />
                                        </div>

                                        <div>
                                            <p class="font-medium text-gray-900">{{ $f->file_name }}</p>
                                            <p class="text-sm text-gray-500">Type: {{ $f->file_extension }} | Taille: {{ convertSize($f->file_size) }}</p>
                                        </div>
                                        </div>

                                        <div class="flex flex-col items-center gap-2">
                                            <button type="button" wire:click="download('{{ $f->id }}')"
                                                class="w-full justify-center flex items-center px-3 py-1.5 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 rounded">
                                                Afficher
                                            </button>
                                            <button type="button" x-on:click="confirm('Are you sure u want to delete {{ $f->file_name }}') ? @this.call('deleteFile','{{$f->id}}') : null"
                                                class="w-full justify-center flex items-center px-3 py-1.5 text-xs font-medium text-white bg-red-600 hover:bg-red-700 rounded">
                                                Supprimer
                                            </button>
                                        </div>
                                    </li>

                                @endforeach
                            </ul>
                        </div>
                        
                    @endif
                    <div class="w-full rounded-xl p-6 space-y-4 border shadow-sm 
                            bg-yellow-50 border-yellow-300 text-yellow-800 
                            dark:bg-yellow-900 dark:border-yellow-600 dark:text-yellow-100">

                    <h2 class="text-xl font-bold text-yellow-900 dark:text-yellow-50">
                        📎 Instructions pour le téléversement des fichiers :
                    </h2>

                    <ul class="list-disc list-inside space-y-1 text-yellow-800 dark:text-yellow-100">
                        <li>Seuls les fichiers au format <strong>PDF</strong> sont acceptés.</li>
                        <li>La taille maximale autorisée est de <strong>2 Mo</strong> par fichier.</li>
                        <li>Merci de vérifier la lisibilité et l’orientation de vos documents avant l’envoi.</li>
                    </ul>

                    <div class="text-sm italic text-yellow-700 dark:text-yellow-200 pt-2">
                        ⚠️ Tout fichier non conforme sera rejeté automatiquement.
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Right Column: 8/12 -->
        <div class="w-full md:w-8/12">
            @if ($decision != 'EN_ATTENTE')
                <div class="w-full">
                    <div class="bg-sky-100 border border-sky-400 text-sky-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Resultat !</strong>
                        <span class="block sm:inline">{{ CandidatureStatusEnum::tryFrom($decision)?->description() }}</span>
                    </div>
                </div>
            @endif
            <div class=" p-6  bg-white dark:bg-gray-900 shadow-md rounded-lg">
                <form wire:submit="save" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    

                    {{-- Domaine --}}
                    <div>
                        <flux:select id="domain_id" wire:model.change="domain_id">
                            <option value="">-- Domaine (optionnel) --</option>
                            @foreach($domains as $domain)
                                <option value="{{ $domain->id }}">{{ $domain->name_fr }} - {{ $domain->name_ar }}</option>
                            @endforeach
                        </flux:select>
                    </div>

                    {{-- Filière --}}
                    <div>
                        <flux:select id="filiere_id" wire:model.change="filiere_id" :disabled="count($filieres) == 0 ?? false" >
                            <option value="">-- Filière --</option>
                            @foreach($filieres as $filiere)
                                <option value="{{ $filiere->id }}">{{ $filiere->name_fr }} - {{ $filiere->name_ar }}</option>
                            @endforeach
                        </flux:select>
                    </div>
                    {{-- Spécialité Concours --}}
                    <div>
                        <flux:select id="specialite_concour_id" wire:model.change="specialite_concour_id" :disabled="count($filieres) == 0 ?? false" >
                            <option value="">-- Specialite chois --</option>
                            @foreach($specialiteConcours as $sc)
                                <option value="{{ $sc->id }}">{{ $sc->name_fr }} - {{ $sc->name_ar }}</option>
                            @endforeach
                        </flux:select>
                    </div>

                    {{-- Spécialité --}}
                    <div>
                        <flux:select id="specialite_id" wire:model="specialite_id" :disabled="count($specialites) == 0 ?? false">
                            <option value="">-- Specialite --</option>
                            @foreach($specialites as $specialite)
                                <option value="{{ $specialite->id }}">{{ $specialite->name_fr }} - {{ $specialite->name_ar }}</option>
                            @endforeach
                        </flux:select>
                    </div>

                    

                    {{-- Classification --}}
                    <div>
                        <flux:select id="classification_id" wire:model="classification_id" >
                            <option value="">-- Classification --</option>
                            @foreach($classifications as $classification)
                                <option value="{{ $classification->id }}">{{ $classification->code }}</option>
                            @endforeach
                        </flux:select>
                    </div>


                    {{-- Type Diplôme --}}
                    <div>
                        <flux:select id="type_diplome" wire:model.change="type_diplome" >
                            <option value="">-- type diplome --</option>
                            @foreach(TypeDiplomEnum::cases() as $type)
                                <option value="{{ $type->value }}">{{ $type->name }}</option>
                            @endforeach
                        </flux:select>
                    </div>

                    @if (!is_null($type_diplome) && !empty($type_diplome))
                        {{-- Numéro BAC --}}
                        {{-- Moyenne --}}
                        <div>
                            <flux:input wire:model="moyenne_semestres" placeholder="{{ TypeDiplomEnum::labelFromValue($type_diplome)  }}" />
                        </div>

                        {{-- Année Diplôme --}}
                        <div>
                            <flux:input id="annee_diplome" wire:model="annee_diplome" placeholder="annee diplome" />
                        </div>

                        {{-- Établissement Diplôme --}}
                        <div class="md:col-span-2">
                            <flux:input id="etablissement_diplome" wire:model="etablissement_diplome" placeholder="etablissement_diplome" />
                        </div>
                    @endif

                    {{-- Submit --}}
                    <div class="md:col-span-2 text-right">
                        <flux:button type="submit" variant="primary" class="" >
                            {{ __('Enregistrer') }}
                        </flux:button>
                    </div>
                </form>
            </div>
        </div>
        <div class="w-full mt-4">
            <div class="w-full rounded-xl p-6 space-y-4 border shadow-sm 
            bg-yellow-50 border-yellow-300 text-yellow-800 
            dark:bg-yellow-900 dark:border-yellow-600 dark:text-yellow-100">

                <h2 class="text-xl font-bold text-yellow-900 dark:text-yellow-50">
                    ⚠️ Instructions obligatoires pour être accepté :
                </h2>

                <ul class="list-disc list-inside space-y-1 text-yellow-800 dark:text-yellow-100">
                    <li>Remplir <strong>tous les champs obligatoires</strong> du formulaire.</li>
                    <li>Fournir une <strong>moyenne correcte</strong> (sur 20) et vérifiable.</li>
                    <li>Entrer un <strong>numéro de BAC valide</strong>.</li>
                    <li>Indiquer une <strong>année de diplôme</strong> au format correct (ex: 2023 ou 2023-06-01).</li>
                    <li>Joindre les <strong>documents justificatifs</strong> : relevés, diplôme, etc.</li>
                    <li>Choisir une <strong>spécialité conforme</strong> au concours sélectionné.</li>
                    <li>Respecter la <strong>date limite</strong> de dépôt du dossier.</li>
                </ul>

                <div class="text-sm italic text-yellow-700 dark:text-yellow-200 pt-2">
                    ⚠️ Toute erreur ou omission peut entraîner le rejet de votre dossier sans préavis.
                </div>
            </div>


        </div>
    </div>
    @filepondScripts
    <script>
        document.addEventListener('livewire:navigated', () => {
            const filepondElement = document.querySelector('.filepond--drop-label > label');
            filepondElement.innerHTML = 'Déposer le fichier ici ou  <span class="filepond--label-action" tabindex="0"> cliquer pour sélectionner </span>';
            document.querySelector('.filepond--credits').style.display = 'none'; // Hide the credits link
        });
    </script>

</div>
