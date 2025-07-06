@use('Carbon\Carbon')
<div class="w-full max-w-[85rem] flex gap-5 ">
    
    

    <div class="w-4/12">
        {{-- upload profile --}}
        <livewire:candidat.upload-profile-picture-wire />
    </div>
    <form wire:submit="updateProfile" class="w-8/12 relative" >
        <div  wire:loading>
            <div class="absolute top-0 left-0 size-full flex items-center justify-center z-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 24 24"><!-- Icon from SVG Spinners by Utkarsh Verma - https://github.com/n3r4zzurr0/svg-spinners/blob/main/LICENSE --><path fill="currentColor" d="M12,1A11,11,0,1,0,23,12,11,11,0,0,0,12,1Zm0,19a8,8,0,1,1,8-8A8,8,0,0,1,12,20Z" opacity=".25"/><path fill="currentColor" d="M10.14,1.16a11,11,0,0,0-9,8.92A1.59,1.59,0,0,0,2.46,12,1.52,1.52,0,0,0,4.11,10.7a8,8,0,0,1,6.66-6.61A1.42,1.42,0,0,0,12,2.69h0A1.57,1.57,0,0,0,10.14,1.16Z"><animateTransform attributeName="transform" dur="0.75s" repeatCount="indefinite" type="rotate" values="0 12 12;360 12 12"/></path></svg>
            </div>
        </div>
        
        @if (canCandidatUpdate())
        <div class="w-full space-y-5 " wire:loading.class="opacity-50 pointer-events-none">
            
                
    
            <flux:input
                wire:model.change="nin"
                :label="__('NIN')"
                type="text"
                autofocus
                autocomplete="nin"
                placeholder="NIN"
                wire:loading.class="opacity-50 pointer-events-none"
            />
            <div class="grid grid-cols-2 gap-3 w-full" >
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
            <div class="grid grid-cols-2 gap-3 w-full rtl">
                <flux:input
                    wire:model="nom_ar"
                    :label="__('اللقب')"
                    type="text"
                    autofocus
                    autocomplete="nom_ar"
                    placeholder="اللقب"
                />
                <flux:input
                    wire:model="prenom_ar"
                    :label="__('الإسم')"
                    type="text"
                    autofocus
                    autocomplete="prenom_ar"
                    placeholder="الإسم"
                />
            </div>
            <div class="grid grid-cols-3 gap-3 w-full">
                <flux:select wire:model="wilaya_id" placeholder="Wilaya" label="Wilaya">
                    @foreach ($wilayas as $wilaya)
                        <flux:select.option value="{{ $wilaya->id }}">({{ $wilaya->code }}) {{ $wilaya->name_fr }} - {{ $wilaya->name_ar }}</flux:select.option>
                    @endforeach
                </flux:select>
                <flux:input
                    wire:model="date_naissance"
                    :label="__('date naissance')"
                    type="text"
                    autofocus
                    autocomplete="date_naissance"
                    placeholder="aaaa-mm-jj"
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
            <div class="flex items-center justify-end">
                @if (canCandidatUpdate())
                    <flux:button type="submit" variant="primary" class="" >
                        {{ __('Enregistrer') }}
                    </flux:button>
                @endif
                
            </div>
        </div>
        @else
        <div class="w-full space-y-5 " wire:loading.class="opacity-50 pointer-events-none">
            <div class="w-full">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Inscriptions fermées !</strong>
                    <span class="block sm:inline">Vous ne pouvez plus mettre à jour vos informations.</span>
                </div>
            </div>
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-lg font-semibold mb-4">Vos Informations</h2>
                <ul class="space-y-2 text-gray-700">
                    <li><span class="font-medium">(numero/annee) bac :</span> {{ $candidat->numero_bac }} - {{ $candidat->annee_bac }}</li>
                    <li><span class="font-medium">Nom :</span> {{ $candidat->nom }} - {{ $candidat->nom_ar }}</li>
                    <li><span class="font-medium">Prénom :</span> {{ $candidat->prenom }} - {{ $candidat->prenom_ar }}</li>
                    <li><span class="font-medium">Date/Lieu de naissance :</span> {{ $candidat->date_naissance }} - {{ $candidat->lieu_naissance }}</li>
                    <li><span class="font-medium">Email :</span> {{ $candidat->email }}</li>
                    <li><span class="font-medium">Téléphone :</span> {{ $candidat->mobile_1 }} / {{ $candidat->mobile_2 }} / {{ $candidat->fix }}</li>
                    <li><span class="font-medium">Wilaya :</span> @isnull($candidat->wilaya->name_fr,'Non renseigné')</li>
                    <li><span class="font-medium">Adresse :</span> {{ $candidat->adresse }} | <span class="rtl">{{ $candidat->ar }}</span></li>
                </ul>
            </div>

        </div>
        @endif


    </form>
    {{-- Success is as dangerous as failure. --}}
</div>
