<x-layouts.user>
    <div class="flex w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative h-full flex-1 overflow-hidden rounded-xl p-2 border border-neutral-200 dark:border-neutral-700">
            <div class="w-full h-full bg-white relative z-10 rounded-lg p-4 border">
                <div class="w-full">
                    <h3 class="text-lg font-semibold ml-3 text-slate-800">Gestion des rôles</h3>
                    <p class="text-slate-500 mb-5 ml-3">Créez et attribuez des rôles regroupant plusieurs permissions.</p>
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
                                        Permissions
                                    </p>
                                </th>
                                <th class="p-4 border-b border-slate-300 bg-slate-50 w-11">
                                    <div class="w-full flex justify-end">
                                        <flux:modal.trigger name="add-role-modal">
                                            <flux:button variant="primary" size="sm" x-data="" x-on:click.prevent="$dispatch('open-modal', 'add-role-modal')">
                                                <x-icons.plus-circle width="24" height="24" />
                                            {{ __('Ajouter un nouveau role') }}
                                            </flux:button>
                                        </flux:modal.trigger>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr class="hover:bg-slate-50">
                                        
                                    <td class="p-4 border-b border-slate-200">
                                        <p class="block text-sm text-slate-800">
                                            {{ $role->id}}
                                        </p>
                                    </td>
                                    <td class="p-4 border-b border-slate-200">
                                        <p class="block text-sm text-slate-800">
                                            {{ $role->name }}
                                        </p>
                                    </td>
                                    <td class="p-4 border-b border-slate-200">
                                        <div class="flex gap-2">
                                            @foreach ($role->permissions->take(5) as $permission)
                                                <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-teal-700 bg-teal-100 rounded-full">
                                                    {{ $permission->name }}
                                                </span>
                                            @endforeach
                                    
                                            @if ($role->permissions->count() > 5)
                                                <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-teal-700 bg-teal-100 rounded-full">
                                                    + {{ $role->permissions->count() - 5 }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="p-4 border-b border-slate-200">
                                        <div class="flex justify-end text-sm text-slate-800">
                                            
                                            <x-dropdown trigger="Options">
                                                <button wire:click="editRole('{{$role->id}}')"  class="cursor-pointer rounded-md block text-left w-full px-4 py-2 hover:bg-gray-100">{{ __('edit') }}</button>
                                                <button x-on:click="confirm('Are you sure u want to delete {{ $role->name }}') ? @this.call('delete','{{$role->id}}') : null"  class="cursor-pointer rounded-md block text-left w-full px-4 py-2 text-red-500 hover:bg-red-100">{{ __('delete') }}</button>
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
            <flux:modal name="add-role-modal" :show="$errors->isNotEmpty()" focusable class="max-w-lg">
                <form wire:submit="store" class="space-y-6">
                    <div>
                        <flux:heading size="lg">{{ __('Créer un rôle et attribuer des permissions') }}</flux:heading>

                        <flux:subheading>
                            Définissez un nouveau rôle et attribuez-lui les permissions appropriées pour gérer l'accès aux fonctionnalités de votre application.
                        </flux:subheading>
                    </div>

                    <flux:input wire:model="name" :label="__('Name')" type="text" />
                    <div wire:ignore>
                        <select id="permissions-group" multiple  wire:model="selectedpermissions"  >
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

            <flux:modal name="edit-role-modal" :show="$errors->isNotEmpty()" focusable class="max-w-lg">
                <form wire:submit="update" class="space-y-6">
                    <div>
                        <flux:heading size="lg">{{ __('Modifier un rôle et attribuer des permissions') }}</flux:heading>

                        <flux:subheading>
                            Définissez un nouveau rôle et attribuez-lui les permissions appropriées pour gérer l'accès aux fonctionnalités de votre application.
                        </flux:subheading>
                    </div>

                    <flux:input wire:model="name" :label="__('Name')" type="text" />
                    <div wire:ignore>
                        <select id="permissions-group-edit" multiple  wire:model="selectedpermissions"  >
                            <option value=""></option>
                            @foreach ($permissions as $permission)
                                <option 
                                value="{{ $permission->name }}"
                                selected>
                                >{{ $permission->name }}</option>
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

{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/choices.js/10.2.0/choices.min.css" integrity="sha512-oW+fEHZatXKwZQ5Lx5td2J93WJnSFLbnALFOFqy/pTuQyffi9gsUylGGZkD3DTSv8zkoOdU7MT7I6LTDcV8GBQ==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/choices.js/10.2.0/choices.min.js" integrity="sha512-OrRY3yVhfDckdPBIjU2/VXGGDjq3GPcnILWTT39iYiuV6O3cEcAxkgCBVR49viQ99vBFeu+a6/AoFAkNHgFteg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
@endassets

@script
<script defer>
    
    const select = 	new TomSelect("#permissions-group",{
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
	

    Livewire.on('resetTomSelect', () => {
        select.clear();
    });


    const editSelecte = 	new TomSelect("#permissions-group-edit",{
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

    // Appliquer les valeurs par défaut
    Livewire.on('setDefaultSelected', (values) => {
        editSelecte.setValue(values[0]);
    });

	

</script>
@endscript