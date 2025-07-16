<x-layouts.option>
    <div class="flex w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative h-full flex-1  rounded-xl p-2 border border-neutral-200 dark:border-neutral-700">
            <div class="w-full h-full bg-white relative z-10 rounded-lg p-4 border">
                <div class="w-full">
                    <h3 class="text-lg font-semibold ml-3 text-slate-800">Gestion de <b>SCOLARIS</b></h3>
                    <p class="text-slate-500 mb-5 ml-3"> modifiez et gérez les parametres de l'application.</p>
                </div>
                <div class="relative flex flex-col w-full text-gray-700 bg-white shadow-md rounded-lg bg-clip-border">
                    <div class="max-w-xl">
                        <div class="p-4">
                            <flux:input wire:model.live="form.autorized_emails" :label="__('Email autorizer')"
                                type="number" />
                        </div>
                        <div class="p-4">
                            <flux:input wire:model.live="form.max" :label="__('Quotas candidats a retenir')"
                                type="number" />
                        </div>
                    </div>
                </div>

            </div>

            <x-placeholder-pattern
                class="absolute z-0 inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
        </div>
    </div>

</x-layouts.option>
