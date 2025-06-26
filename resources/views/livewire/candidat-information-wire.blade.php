<div class="w-full flex gap-5 ">
    <div class="w-4/12">
        {{-- upload profile --}}
    </div>
    <form wire:submit="updateProfile" class="w-8/12 space-y-5">
        <flux:input
            wire:model.change="nin"
            :label="__('NIN')"
            type="text"
            autofocus
            autocomplete="nin"
            placeholder="NIN"
        />
        <div class="grid grid-cols-2 gap-3 w-full">
            <flux:input
                wire:model="nom"
                :label="__('Nom')"
                type="text"
                
                autofocus
                autocomplete="nom"
                placeholder="Nom"
            />
            <flux:input
                wire:model="prenom"
                :label="__('Prénom')"
                type="text"
                
                autofocus
                autocomplete="prenom"
                placeholder="Prénom"
            />
        </div>
        <div class="grid grid-cols-2 gap-3 w-full">
            <flux:input
                wire:model="nom_ar"
                :label="__('Nom')"
                type="text"
                
                autofocus
                autocomplete="nom_ar"
                placeholder="Nom"
            />
            <flux:input
                wire:model="prenom_ar"
                :label="__('Prénom')"
                type="text"
                
                autofocus
                autocomplete="prenom_ar"
                placeholder="Prénom"
            />
        </div>
        <div class="grid grid-cols-2 gap-3 w-full">
            <flux:input
                wire:model="date_naissance"
                :label="__('date naissance')"
                type="text"
                
                autofocus
                autocomplete="date_naissance"
                placeholder="date naissance"
            />
            <flux:input
                wire:model="lieu_naissance"
                :label="__('lieu naissance')"
                type="text"
                
                autofocus
                autocomplete="lieu_naissance"
                placeholder="lieu naissance"
            />
        </div>
        <flux:input
            wire:model="adresse"
            :label="__('Adresse')"
            type="text"
            
            autofocus
            autocomplete="adresse"
            placeholder="Adresse"
        />
        <flux:input
            wire:model="adresse_ar"
            :label="__('Adresse AR')"
            type="text"
            
            autofocus
            autocomplete="adresse_ar"
            placeholder="Adresse AR"
        />
        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="" >
                {{ __('Update') }}
            </flux:button>
        </div>
    </form>
    {{-- Success is as dangerous as failure. --}}
</div>
