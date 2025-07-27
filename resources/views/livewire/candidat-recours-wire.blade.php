<div>
    <flux:modal.trigger name="add-recours">
        <flux:button variant="danger" size="sm" x-data="" x-on:click.prevent="$dispatch('open-modal', 'add-recours')">
            <x-icons.plus-circle width="24" height="24" />
            {{ __('Recour') }}
        </flux:button>
    </flux:modal.trigger>
    <flux:modal name="add-recours" :show="$errors->isNotEmpty()" focusable class="max-w-xl w-full">
        <form wire:submit="store" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Recour') }}</flux:heading>

            </div>
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4 rounded">
                <div class="flex">
                    
                    <p class="text-sm text-yellow-700">
                    ⚠ Vous ne pouvez envoyer <strong>qu’un seul recours</strong>.
                    </p>
                </div>
            </div>

                @if (count($recours) == 0)            
                    <textarea wire:model="content" class="w-full outline-0 ring-0 border border-gray-200 rounded-lg p-2 text-gray-700 text-sm" rows="4"></textarea>
                    @error('content')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                @endif
                @foreach ($recours as $recour)
                    <div class="my-5 rounded-xl bg-gray-{{ is_null($recour->user_id) ? '100' : '200' }} text-gray-700 py-2 px-4 flex flex-col gap-2" style="text-align: {{ is_null($recour->user_id) ? 'left' : 'right' }}">

                        <p>{{ $recour->content }}</p>
                        <p class="flex gap-1 text-xs text-gray-500 {{ is_null($recour->user_id) ? 'justify-start' : 'justify-end' }}"> 
                            <x-icons.calendar width="14" height="14" />
                            {{ $recour->created_at }}
                            @if (is_null($recour->user_id))
                                <span> | </span>
                                {{ $recour->status->label() }} 
                                @if ($recour->status->name != "EN_ATTENTE")
                                <span></span>
                                le : 
                                {{ $recour->updated_at }}
                                
                                @endif
                            @endif
                        </p>
                    </div>
                @endforeach
            <div class="flex justify-end space-x-2">
                <flux:button variant="filled" wire:click="clearForm">{{ __('Annuler') }}</flux:button>
                @if (count($recours) == 0)
                    <flux:button variant="primary" type="submit">{{ __('Envoyer') }}</flux:button>
                @endif
            </div>
        </form>
    </flux:modal>
</div>
