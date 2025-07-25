<x-layouts.option>
    <div class="flex w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative h-full flex-1  rounded-xl p-2 border border-neutral-200 dark:border-neutral-700">
            <div class="w-full h-full bg-white relative z-10 rounded-lg p-4 border">
                <div class="w-full">
                    <h3 class="text-lg flex justify-between items-center font-semibold ml-3 text-slate-800">
                        <div>Gestion des <b>Tâches</b></div>
                        <flux:button variant="danger" class="flex flex-nowrap items-center gap-1" size="sm" wire:click="deleteJobs()">
                            <div class="flex gap-1 items-center">
                                <span>{{ __('Supprimer les jobs') }}</span>
                                <x-icons.clear width="24" height="24" />
                            </div>
                        </flux:button>
                    </h3>
                    <p class="text-slate-500 mb-5 ml-3"> gérez les Tâches échouées.</p>
                </div>
                <div class="relative flex flex-col w-full text-gray-700 bg-white shadow-md rounded-lg bg-clip-border">
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
                                        Connection
                                    </p>
                                </th>
                                <th class="p-4 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        Queue
                                    </p>
                                </th>
                                <th class="p-4 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        Failed at
                                    </p>
                                </th>
                                <th class="p-4 border-b border-slate-300 bg-slate-50 w-11">
                                    <div class="w-full flex justify-end gap-1">
                                        
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($failedJobs as $fail)
                                <tr class="hover:bg-slate-50" >
                                    <td class="p-4 border-b border-slate-200">
                                        <p class="block text-sm text-slate-800">
                                            {{ $fail->id}}
                                        </p>
                                    </td>
                                    <td class="p-4 border-b border-slate-200">
                                        <p class=" text-sm text-slate-800 flex gap-2 items-center">
                                            {{ $fail->connection }}
                                        </p>
                                    </td>
                                    <td class="p-4 border-b border-slate-200">
                                        <p class=" text-sm text-slate-800 flex gap-2 items-center">
                                            {{ $fail->queue }}
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
                                            {{ $fail->failed_at }}
                                        </p>
                                    </td>
                                    <td class="p-4 border-b border-slate-200">
                                        <div class="flex justify-end text-sm text-slate-800">
                                            <button wire:click="displayFialed('{{$fail->id}}')"  class="cursor-pointer rounded-md block text-left w-full px-4 py-2 hover:bg-gray-100">{{ __('Detail') }}</button>
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


    <flux:modal name="display-detail" :show="$errors->isNotEmpty()" focusable class="max-w-xl w-full">
        @if (!is_null($job))
            <form wire:submit="saveSousSpecialite" class="space-y-6">
                <div>
                    <flux:heading size="lg">{{ __('Tâche') }}</flux:heading>

                </div>
                

                <div class="p-4 max-w-xl flex flex-col gap-2 ">
                    <div>
                        <strong>ID:</strong> <span>{{ $job->id }}</span>
                    </div>
                    <div>
                        <strong>UUID:</strong> <span>{{ $job->uuid }}</span>
                    </div>
                    <div>
                        <strong>Connection:</strong> <span>{{ $job->connection }}</span>
                    </div>
                    <div>
                        <strong>Queue:</strong> <span>{{ $job->queue }}</span>
                    </div>
                    <strong class="mb-2">payload [command class] :</strong>
                    <p class="bg-gray-100 rounded overflow-x-auto text-xs">
                        {{ $job->payload['command_class'] }}
                    </p>
                    <strong class="mb-2">payload [command data] :</strong>
                    <pre class="bg-gray-100 rounded overflow-x-auto text-xs">
                        {{ json_encode($job->payload['command_data'] ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}
                    </pre>
                    <strong class="mb-2">exception :</strong>
                    <pre class="bg-gray-100 rounded overflow-x-auto text-xs">
                        {{ $job->exception }}
                    </pre>
                </div>
                
                <div class="flex justify-end space-x-2">
                    <flux:button variant="filled" wire:click="clear">{{ __('Cancel') }}</flux:button>
                    {{-- <flux:button variant="primary" wire:click="retry('{{ $job->id }}')" >{{ __('Try') }}</flux:button>
                    <flux:button variant="primary" wire:click="forget('{{ $job->id }}')">{{ __('forget') }}</flux:button> --}}

                </div>
            </form>
        @endif
    </flux:modal>


</x-layouts.option>
