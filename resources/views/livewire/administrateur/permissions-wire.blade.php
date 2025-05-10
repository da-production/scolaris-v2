<x-layouts.user>
    <div class="flex w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative h-full flex-1 overflow-hidden rounded-xl p-2 border border-neutral-200 dark:border-neutral-700">
            <div class="w-full h-full bg-white relative z-10 rounded-lg p-4 border">
                <div class="w-full">
                    <h3 class="text-lg font-semibold ml-3 text-slate-800">Gestion des Permissions 🔑</h3>
                    <p class="text-slate-500 mb-5 ml-3">Définissez des permissions pour un contrôle précis des accès.</p>
                </div>
                <div
                    class="relative flex flex-col w-full text-gray-700 bg-white shadow-md rounded-lg bg-clip-border">
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
                                        Name
                                    </p>
                                </th>
                                <th class="p-4 border-b border-slate-300 bg-slate-50">
                                    <div class="w-full flex justify-end">
                                        <flux:modal.trigger name="create-role">
                                            <flux:button variant="primary" size="sm" x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-role')">
                                                <x-icons.plus-circle width="24" height="24" />
                                            {{ __('Ajouter une nouvelle permission') }}
                                            </flux:button>
                                        </flux:modal.trigger>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $permission)
                            <tr class="hover:bg-slate-50">
                                <td class="p-4 border-b border-slate-200">
                                    <p class="block text-sm text-slate-800">
                                        {{ $permission->id }}
                                    </p>
                                </td>
                                <td class="p-4 border-b border-slate-200">
                                    <p class="block text-sm text-slate-800">
                                        {{ $permission->name }}
                                    </p>
                                </td>
                                <td class="p-4 border-b border-slate-200">
                                    <div class="flex justify-end gap-2 text-sm text-slate-800">
                                        <flux:button 
                                        variant="danger" 
                                        size="sm" 
                                        x-data=""
                                        x-on:click="confirm('Are you sure you want to delete the permission : {{ $permission->name }}') ? $wire.deletePermission('{{ $permission->id }}') : ''"
                                        >
                                            delete
                                        </flux:button>
                                        <flux:button variant="primary" size="sm" x-data="" wire:click="editPermission('{{ $permission->id }}')">
                                            edit
                                        </flux:button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-5">
                    {{ $permissions->links() }}
                </div>
            </div>
            <flux:modal name="create-role" :show="$errors->isNotEmpty()" focusable class="max-w-lg">
                <form wire:submit="store" class="space-y-6">
                    <div>
                        <flux:heading size="lg">{{ __('Ajouter une nouvelle permission') }}</flux:heading>

                        <flux:subheading>
                            {{ __('Définissez les autorisations et les accès pour les utilisateurs.') }}
                        </flux:subheading>
                    </div>

                    <flux:input wire:model="name" :label="__('Name')" type="text" />
                    <div class="flex justify-end space-x-2">
                        <flux:modal.close>
                            <flux:button variant="filled">{{ __('Cancel') }}</flux:button>
                        </flux:modal.close>

                        <flux:button variant="primary" type="submit">{{ __('Create') }}</flux:button>
                    </div>
                </form>
            </flux:modal>

            <flux:modal name="edit-permission" :show="$errors->isNotEmpty()" focusable class="max-w-lg">
                <form wire:submit="update" class="space-y-6">
                    <div>
                        <flux:heading size="lg">{{ __('Metre a jour') }}</flux:heading>

                        <flux:subheading>
                            {{ __('Définissez les autorisations et les accès pour les utilisateurs.') }}
                        </flux:subheading>
                    </div>

                    <flux:input wire:model="name" :label="__('Name')" type="text" />
                    <div class="flex justify-end space-x-2">
                        <flux:button variant="filled" wire:click="closeEdit">{{ __('Cancel') }}</flux:button>


                        <flux:button variant="primary" type="submit">{{ __('Create') }}</flux:button>
                    </div>
                </form>
            </flux:modal>
            <x-placeholder-pattern class="absolute z-0 inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
        </div>
    </div>

</x-layouts.user>
