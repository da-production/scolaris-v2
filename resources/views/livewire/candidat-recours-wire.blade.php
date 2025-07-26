<div>
    <flux:modal.trigger name="add-recours">
        <flux:button variant="danger" size="sm" x-data="" x-on:click.prevent="$dispatch('open-modal', 'add-recours')">
            <x-icons.plus-circle width="24" height="24" />
            {{ __('Recour') }}
        </flux:button>
    </flux:modal.trigger>
    <flux:modal name="add-recours" :show="$errors->isNotEmpty()" focusable class="max-w-xl w-full">
        <form wire:submit="save" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Recour') }}</flux:heading>

            </div>
            <flux:input wire:model="name_fr" :label="__('Lebelle FR')" type="text" />
            
            <div class="flex justify-end space-x-2">
                <flux:button variant="filled" wire:click="clearForm">{{ __('Annuler') }}</flux:button>
                <flux:button variant="primary" type="submit">{{ __('Envoyer') }}</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
