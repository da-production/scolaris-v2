<x-layouts.candidat>
    
    <div class="flex w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative h-full flex-1  rounded-xl p-2 border border-neutral-200 dark:border-neutral-700">
            <div class="w-full h-full bg-white relative z-10 rounded-lg p-4 border">
                <div class="w-full">
                    <h3 class="text-lg font-semibold ml-3 text-slate-800">Gestion des <b>Candidats</b></h3>
                    <p class="text-slate-500 mb-5 ml-3"> modifiez et gérez les parametres des classification.</p>
                </div>
                <div class="relative flex flex-col w-full text-gray-700 bg-white shadow-md rounded-lg bg-clip-border">
                    <div class="">
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
                                            Genre
                                        </p>
                                    </th>
                                    <th class="p-4 border-b border-slate-300 bg-slate-50">
                                        <p class="block text-sm font-normal leading-none text-slate-500">
                                            Situation professionnelle
                                        </p>
                                    </th>
                                    <th class="p-4 border-b border-slate-300 bg-slate-50">
                                        <p class="block text-sm font-normal leading-none text-slate-500">
                                            Type diplome
                                        </p>
                                    </th>
                                    <th class="p-4 border-b border-slate-300 bg-slate-50">
                                        <p class="block text-sm font-normal leading-none text-slate-500">
                                            Wilaya
                                        </p>
                                    </th>
                                    <th class="p-4 border-b border-slate-300 bg-slate-50 w-11">
                                        
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($candidats as $candidat)
                                    <tr class="hover:bg-slate-50">
                                            
                                        <td class="p-4 border-b border-slate-200">
                                            <p class="block text-sm text-slate-800">
                                                {{ $candidat->id}}
                                            </p>
                                        </td>
                                        <td class="p-4 border-b border-slate-200">
                                            <p class="block text-sm text-slate-800">
                                                {{ $candidat->nom_fr }} - {{ $candidat->nom_ar }}
                                            </p>
                                            <p class="block text-sm text-slate-800">
                                                {{ $candidat->prenom_fr }} - {{ $candidat->prenom_ar }}
                                            </p>
                                        </td>
                                        <td class="p-4 border-b border-slate-200">
                                            <p class="block text-sm text-slate-800">
                                                {{ $candidat->genre}}
                                            </p>
                                        </td>
                                        <td class="p-4 border-b border-slate-200">
                                            <p class="block text-sm text-slate-800">
                                                {{ $candidat->sit_prof}}
                                            </p>
                                        </td>
                                        <td class="p-4 border-b border-slate-200">
                                            <p class="block text-sm text-slate-800">
                                                {{ $candidat->type_diplome}}
                                            </p>
                                        </td>
                                        <td class="p-4 border-b border-slate-200">
                                            <p class="block text-sm text-slate-800">
                                                {{ $candidat->wilaya}}
                                            </p>
                                        </td>
                                        <td class="p-4 border-b border-slate-200">
                                            <div class="flex justify-end text-sm text-slate-800">
                                                <a href="{{ route('administrateur.candidats.show', ['candidat' => $candidat->id]) }}">
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
                    <div class="my-5">
                        {{ $candidats->links() }}
                    </div>
                </div>

            </div>

            <x-placeholder-pattern
                class="absolute z-0 inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
        </div>
    </div>


</x-layouts.candidat>
