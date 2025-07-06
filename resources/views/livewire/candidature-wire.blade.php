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
                        class="max-w-7xl  bg-white dark:bg-gray-800 rounded-xl shadow p-6 flex flex-col md:flex-row gap-6">
                        <!-- Image du candidat -->
                        <div class="w-3/12">
                            <img src="{{ $this->profilePhotoUrl() }}" alt="Photo du candidat"
                                class="w-full h-auto rounded-lg shadow-md object-cover">
                            <a 
                                class="block mt-4 text-center text-sm text-white bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 px-4 py-2 rounded transition">
                                Voir la candidature
                            </a>
                        </div>

                        <!-- Informations -->
                        <div
                            class="w-9/12 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-800 dark:text-gray-100">
                            <div>
                                <span class="font-semibold">Nom (FR):</span> {{ $candidat['nom_fr'] }}
                            </div>
                            <div>
                                <span class="font-semibold">Prénom (FR):</span> {{ $candidat['prenom_fr'] }}
                            </div>
                            <div>
                                <span class="font-semibold">Nom (AR):</span> {{ $candidat['nom_ar'] }}
                            </div>
                            <div>
                                <span class="font-semibold">Prénom (AR):</span> {{ $candidat['prenom_ar'] }}
                            </div>
                            <div>
                                <span class="font-semibold">Date de naissance:</span> {{ $candidat['date_naissance'] }}
                            </div>
                            <div>
                                <span class="font-semibold">Genre:</span>
                                {{ $candidat['genre'] === 'H' ? 'Homme' : 'Femme' }}
                            </div>
                            <div>
                                <span class="font-semibold">Email:</span> {{ $candidat['email'] }}
                            </div>
                            <div>
                                <span class="font-semibold">Téléphone 1:</span> {{ $candidat['tel_mobile_1'] }}
                            </div>
                            <div>
                                <span class="font-semibold">Téléphone 2:</span> {{ $candidat['tel_mobile_2'] }}
                            </div>
                            @if ($candidat['fix'])
                                <div>
                                    <span class="font-semibold">Fixe:</span> {{ $candidat['fix'] }}
                                </div>
                            @endif
                            <div class="col-span-2">
                                <span class="font-semibold">Adresse (FR):</span> {{ $candidat['adresse_fr'] }}
                            </div>
                            <div class="col-span-2">
                                <span class="font-semibold">Adresse (AR):</span> {{ $candidat['adresse_ar'] }}
                            </div>
                            <div>
                                <span class="font-semibold">Numéro Bac:</span> {{ $candidat['num_bac'] }}
                            </div>
                            <div>
                                <span class="font-semibold">Année Bac:</span> {{ $candidat['annnee_bac'] }}
                            </div>
                            <div>
                                <span class="font-semibold">Filière Bac:</span> {{ $candidat['filiere_bac'] }}
                            </div>
                            <div>
                                <span class="font-semibold">Moyenne Bac:</span> {{ $candidat['moyenne_bac'] }}
                            </div>
                            <div>
                                <span class="font-semibold">Diplôme:</span> {{ $candidat['type_diplome'] }}
                            </div>
                            <div>
                                <span class="font-semibold">Année diplôme:</span> {{ $candidat['annee_diplome'] }}
                            </div>
                            <div class="col-span-2">
                                <span class="font-semibold">Établissement:</span>
                                {{ $candidat['etablissement_diplome'] }}
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
