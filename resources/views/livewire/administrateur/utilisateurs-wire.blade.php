<x-layouts.user>
    <div class="flex w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative h-full flex-1  rounded-xl p-2 border border-neutral-200 dark:border-neutral-700">
            <div class="w-full h-full bg-white relative z-10 rounded-lg p-4 border">
                <div class="w-full">
                    <h3 class="text-lg font-semibold ml-3 text-slate-800">Gestion des utilisateur</h3>
                    <p class="text-slate-500 mb-5 ml-3">Ajoutez, modifiez et gérez les utilisateurs avec des rôles et permissions adaptées.</p>
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
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        Roles
                                    </p>
                                </th>
                                <th class="p-4 border-b border-slate-300 bg-slate-50">
                                    <p class="block text-sm font-normal leading-none text-slate-500">
                                        Permissions
                                    </p>
                                </th>
                                <th class="p-4 border-b border-slate-300 bg-slate-50 w-11">
                                    <div class="w-full flex justify-end">
                                        <flux:modal.trigger name="add-user-modal">
                                            <flux:button variant="primary" size="sm" x-data="" x-on:click.prevent="$dispatch('open-modal', 'add-user-modal')">
                                                <x-icons.plus-circle width="24" height="24" />
                                            {{ __('Ajouter un nouveau utilisateur') }}
                                            </flux:button>
                                        </flux:modal.trigger>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="hover:bg-slate-50">
                                        
                                    <td class="p-4 border-b border-slate-200">
                                        <p class="block text-sm text-slate-800">
                                            {{ $user->id}}
                                        </p>
                                    </td>
                                    <td class="p-4 border-b border-slate-200">
                                        <p class="block text-sm text-slate-800">
                                            {{ $user->name }}
                                        </p>
                                    </td>
                                    <td class="p-4 border-b border-slate-200">
                                        <div class="flex gap-2">
                                            @forelse ($user->roles->take(3) as $role)
                                                <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-teal-700 bg-teal-100 rounded-full">
                                                    {{ $role->name }}
                                                </span>
                                            @empty
                                                <span class="inline-flex items-center justify-center  text-xs font-bold leading-none text-gray-400  rounded-full">
                                                    n'a pas de rôle.
                                                </span>
                                            @endforelse
                                    
                                            @if ($user->roles->count() > 3)
                                                <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-teal-700 bg-teal-100 rounded-full">
                                                    + {{ $user->roles->count() - 3 }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="p-4 border-b border-slate-200">
                                        <div class="flex gap-2">
                                            @forelse ($user->permissions->take(3) as $permission)
                                                <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-teal-700 bg-teal-100 rounded-full">
                                                    {{ $permission->name }}
                                                </span>
                                            @empty
                                                <span class="inline-flex items-center justify-center  text-xs font-bold leading-none text-gray-400  rounded-full">
                                                    n'a pas de permission.
                                                </span>
                                            @endforelse
                                    
                                            @if ($user->permissions->count() > 3)
                                                <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-teal-700 bg-teal-100 rounded-full">
                                                    + {{ $user->permissions->count() - 3 }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="p-4 border-b border-slate-200">
                                        <div class="flex justify-end text-sm text-slate-800">
                                            
                                            <x-dropdown trigger="Options">
                                                <button wire:click="edit('{{$user->id}}')"  class="cursor-pointer rounded-md block text-left w-full px-4 py-2 hover:bg-gray-100">{{ __('edit') }}</button>
                                                <button x-on:click="confirm('Are you sure u want to delete {{ $user->name }}') ? @this.call('delete','{{$user->id}}') : null"  class="cursor-pointer rounded-md block text-left w-full px-4 py-2 text-red-500 hover:bg-red-100">{{ __('delete') }}</button>
                                            </x-dropdown>
                                            
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- $orders = Order::paginate() -->
                </div>

            </div>

            {{-- Modals --}}
            <flux:modal name="add-user-modal" :show="$errors->isNotEmpty()" focusable class="max-w-lg">
                <form wire:submit="store" class="space-y-6">
                    <div>
                        <flux:heading size="lg">{{ __('Créer un rôle et attribuer des permissions') }}</flux:heading>

                        <flux:subheading>
                            Définissez un nouveau rôle et attribuez-lui les permissions appropriées pour gérer l'accès aux fonctionnalités de votre application.
                        </flux:subheading>
                    </div>

                    <flux:input wire:model="form.name" :label="__('Name')" type="text" />
                    <flux:input wire:model="form.email" :label="__('Email')" type="text" />
                    <flux:input wire:model="form.password" :label="__('Password')" type="password" />
                    <flux:input wire:model="form.password_confirmation" :label="__('Password confirmation')" type="password" />
                    <div wire:ignore>
                        <select id="roles-group" multiple >
                            <label for="" class="text-sm font-medium select-none text-zinc-800 dark:text-white">Roles</label>
                            <option value=""></option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div wire:ignore>
                        <label for="" class="text-sm font-medium select-none text-zinc-800 dark:text-white">Permissions</label>
                        <select id="permissions-group" multiple >
                            <option value=""></option>
                            @foreach ($permissions as $permission)
                                <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <flux:modal.close>
                            <flux:button variant="filled">{{ __('Cancel') }}</flux:button>
                        </flux:modal.close>

                        <flux:button variant="primary" type="submit">{{ __('Create') }}</flux:button>
                    </div>
                </form>
            </flux:modal>

            <flux:modal name="edit-user-modal" :show="$errors->isNotEmpty()" focusable class="max-w-lg">
                <form wire:submit="update" class="space-y-6">
                    <div>
                        <flux:heading size="lg">{{ __('Créer un rôle et attribuer des permissions') }}</flux:heading>

                        <flux:subheading>
                            Définissez un nouveau rôle et attribuez-lui les permissions appropriées pour gérer l'accès aux fonctionnalités de votre application.
                        </flux:subheading>
                    </div>

                    <flux:input wire:model="form.name" :label="__('Name')" type="text" />
                    <flux:input wire:model="form.email" :label="__('Email')" type="text" />
                    <flux:input wire:model="form.password" :label="__('Password')" type="password" />
                    <flux:input wire:model="form.password_confirmation" :label="__('Password confirmation')" type="password" />
                    <div wire:ignore>
                        <label for="" class="text-sm font-medium select-none text-zinc-800 dark:text-white">Roles</label>
                        <select id="edit-roles-group" multiple >
                            <option value=""></option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div wire:ignore>
                        <label for="" class="text-sm font-medium select-none text-zinc-800 dark:text-white">Permissions</label>
                        <select id="edit-permissions-group" multiple >
                            <option value=""></option>
                            @foreach ($permissions as $permission)
                                <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <flux:modal.close>
                            <flux:button variant="filled">{{ __('Cancel') }}</flux:button>
                        </flux:modal.close>

                        <flux:button variant="primary" type="submit">{{ __('Update') }}</flux:button>
                    </div>
                </form>
            </flux:modal>
            <x-placeholder-pattern class="absolute z-0 inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
        </div>
    </div>

</x-layouts.user>

@assets
<link href="https://cdnjs.cloudflare.com/ajax/libs/tom-select/2.3.0/css/tom-select.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/tom-select/2.3.0/js/tom-select.complete.min.js"></script>

@endassets

@script
<script defer>
    
    const roles = new TomSelect("#roles-group",{
		plugins: ['remove_button'],
		create: true,
		onItemAdd:function(){
			this.setTextboxValue('');
			this.refreshOptions();
            console.log(this.items)
            Livewire.dispatch('updateSelectedRoles', { values: this.items });
		},
        onItemRemove: function(value) {
            Livewire.dispatch('updateSelectedRoles', { values: this.items }); // Met à jour Livewire
        },
		render:{
			option:function(data,escape){
				return '<div class="d-flex"><span>' + escape(data.value) + '</span></div>';
			},
			item:function(data,escape){
				return '<div>' + escape(data.value) + '</div>';
			}
		}
	});
    const permissions = new TomSelect("#permissions-group",{
		plugins: ['remove_button'],
		create: true,
		onItemAdd:function(){
			this.setTextboxValue('');
			this.refreshOptions();
            console.log(this.items)
            Livewire.dispatch('updateSelectedPermissions', { values: this.items });
		},
        onItemRemove: function(value) {
            Livewire.dispatch('updateSelectedPermissions', { values: this.items }); // Met à jour Livewire
        },
		render:{
			option:function(data,escape){
				return '<div class="d-flex"><span>' + escape(data.value) + '</span></div>';
			},
			item:function(data,escape){
				return '<div>' + escape(data.value) + '</div>';
			}
		}
	});

    const editroles = new TomSelect("#edit-roles-group",{
		plugins: ['remove_button'],
		create: true,
		onItemAdd:function(){
			this.setTextboxValue('');
			this.refreshOptions();
            console.log(this.items)
            Livewire.dispatch('updateSelectedRoles', { values: this.items });
		},
        onItemRemove: function(value) {
            Livewire.dispatch('updateSelectedRoles', { values: this.items }); // Met à jour Livewire
        },
		render:{
			option:function(data,escape){
				return '<div class="d-flex"><span>' + escape(data.value) + '</span></div>';
			},
			item:function(data,escape){
				return '<div>' + escape(data.value) + '</div>';
			}
		}
	});
    const editpermissions = new TomSelect("#edit-permissions-group",{
		plugins: ['remove_button'],
		create: true,
		onItemAdd:function(){
			this.setTextboxValue('');
			this.refreshOptions();
            console.log(this.items)
            Livewire.dispatch('updateSelectedPermissions', { values: this.items });
		},
        onItemRemove: function(value) {
            Livewire.dispatch('updateSelectedPermissions', { values: this.items }); // Met à jour Livewire
        },
		render:{
			option:function(data,escape){
				return '<div class="d-flex"><span>' + escape(data.value) + '</span></div>';
			},
			item:function(data,escape){
				return '<div>' + escape(data.value) + '</div>';
			}
		}
	});
	
	Livewire.on('setDefaultRoles', (values) => {
        editroles.setValue(values[0]);
    });
	Livewire.on('setDefaultPermissions', (values) => {
        editpermissions.setValue(values[0]);
    });

    Livewire.on('resetTomSelect', () => {
        roles.clear();
        editroles.clear();
        
        permissions.clear();
        editpermissions.clear();
    });


	

</script>
@endscript