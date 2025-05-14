<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your name and email address')">
        <div class="flex w-full flex-1 flex-col gap-4 rounded-xl">
            <div class="relative h-full flex-1  rounded-xl p-2 border border-neutral-200 dark:border-neutral-700">
                <div class="w-full h-full bg-white relative z-10 rounded-lg p-4 border">
                    <div class="w-full">
                        <h3 class="text-lg font-semibold ml-3 text-slate-800">Logs</h3>
                        <p class="text-slate-500 mb-5 ml-3"> modifiez et gérez les parametres des classification.</p>
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
                                            user
                                        </p>
                                    </th>
                                    <th class="p-4 border-b border-slate-300 bg-slate-50">
                                        <p class="block text-sm font-normal leading-none text-slate-500">
                                            action
                                        </p>
                                    </th>
                                    <th class="p-4 border-b border-slate-300 bg-slate-50">
                                        <p class="block text-sm font-normal leading-none text-slate-500">
                                            Entité
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
                                @foreach ($logs as $log)
                                    <tr class="hover:bg-slate-50">
                                            
                                        <td class="p-4 border-b border-slate-200">
                                            <p class="block text-sm text-slate-800">
                                                {{ $log->id}}
                                            </p>
                                        </td>
                                        <td class="p-4 border-b border-slate-200">
                                            <p class="block text-sm text-slate-800">
                                                {{ $log->user->name }}
                                            </p>
                                        </td>
                                        <td class="p-4 border-b border-slate-200">
                                            <p class="block text-sm text-slate-800">
                                                {{ $log->action }}
                                            </p>
                                        </td>
                                        <td class="p-4 border-b border-slate-200">
                                            <p class="block text-sm text-slate-800">
                                                {{ $log->model_type }}
                                            </p>
                                        </td>
                                        <td class="p-4 border-b border-slate-200">
                                            <p class="block text-sm text-slate-800">
                                                {{ $log->created_at }}
                                            </p>
                                        </td>
                                        <td class="p-4 border-b border-slate-200">
                                            <div class="flex justify-end text-sm text-slate-800">
                                                <flux:button variant="primary" wire:click="detail('{{ $log->id }}')" size="sm" type="button">
                                                    Détail
                                                </flux:button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-5">
                            {{ $logs->links() }}
                        </div>
                    </div>

                </div>

                <x-placeholder-pattern
                    class="absolute z-0 inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
        </div>

        

    </x-settings.layout>
    <flux:modal name="log-detail-modal" :show="$errors->isNotEmpty()" focusable class="max-w-xl w-full" wire:key="$log->id">
        <div lass="space-y-6">
            @if (!is_null($log))
                
                <div class="flex justify-between items-center border-b pb-2 dark:border-gray-700 mt-6">
                    <h2 class="text-lg font-semibold">Journal d'activité</h2>
                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ $log->created_at }}</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="col-span-1 sm:col-span-2 mt-2">
                        <span class="font-medium">User-Agent :</span>
                        <pre class="mt-1 p-2 bg-gray-100 dark:bg-gray-800 rounded text-xs whitespace-pre-wrap">{{ $log->payload['user_agent'] ?? '-' }}</pre>
                    </div>
                    <div><span class="font-medium">Action :</span> {{ $log->action }}</div>
                    <div><span class="font-medium">Modèle :</span> {{ $log->model_type }}</div>
                    <div><span class="font-medium">Utilisateur ID :</span> {{ $log->user_id }}</div>
                    <div><span class="font-medium">Email :</span> {{ $log->payload['email'] ?? '-' }}</div>
                    <div><span class="font-medium">IP :</span> {{ $log->payload['ip'] ?? '-' }}</div>
                    <div><span class="font-medium">Méthode :</span> {{ $log->payload['method'] ?? '-' }}</div>
                    <div><span class="font-medium">URL :</span> {{ $log->payload['url'] ?? '-' }}</div>
                    <div><span class="font-medium">Navigateur :</span> {{ $log->payload['browser'] ?? '-' }} {{ $log->payload['browser_version'] ?? '' }}</div>
                    <div><span class="font-medium">Plateforme :</span> {{ $log->payload['platform'] ?? '-' }} {{ $log->payload['platform_version'] ?? '' }}</div>
                    <div><span class="font-medium">Device :</span> {{ $log->payload['device'] ?? '-' }}</div>
                    <div><span class="font-medium">Robot :</span> {{ $log->payload['is_robot'] ? 'Oui' : 'Non' }}</div>
                    <div class="col-span-1 sm:col-span-2">
                        <span class="font-medium">Description :</span> {{ $log->payload['description'] ?? '-' }}
                    </div>
                </div>
            @endif

            <div class="flex justify-end space-x-2">
                <flux:button variant="filled" wire:click="clear">{{ __('Cancel') }}</flux:button>
                
            </div>
        </div>
    </flux:modal>
</section>
