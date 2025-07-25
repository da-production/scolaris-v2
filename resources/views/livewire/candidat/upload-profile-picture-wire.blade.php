<div>
    {{-- Be like water. --}}
    <div class="flex flex-col gap-6 items-center justify-center w-full h-full 
            p-4 rounded-2xl 
            bg-gray-50 dark:bg-neutral-800">
        <img src="{{ $this->profilePhotoUrl() }}" alt="Photo de profil" class="rounded-full size-48 object-cover border shadow">
        @if (canCandidatUpdate())
            <div class="w-full space-y-5 p-4 rounded-2xl 
            bg-gray-100 dark:bg-neutral-800" wire:loading.class="opacity-50 pointer-events-none">
                <flux:input
                    wire:model.change="file"
                    type="file"
                    placeholder="Photo de profile"
                    wire:loading.class="opacity-50 pointer-events-none"
                />
            </div>
        @endif

    </div>
</div>
