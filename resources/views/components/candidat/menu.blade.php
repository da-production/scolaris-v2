<div
    class="flex relative z-50 max-w-[85rem] mx-auto w-full items-center justify-between whitespace-nowrap border-b border-solid border-b-[#dde0e6]  py-3">
    <a wire:navigate href="{{ route('home') }}" class="flex items-center gap-4 text-[#111418]">
        
        <h2 class="text-[#111418] text-sm font-medium leading-normal flex gap-2 items-center">
            <span>Accueil</span>
        </h2>
    </a>
    @if(auth()->guard('candidat')->check())
    <div class="flex flex-1 justify-end gap-8" >
        <div class="flex items-center gap-9">
            <a class="text-[#111418] text-sm font-medium leading-normal" href="{{ route('candidat.profile') }}" wire:navigate>Vos informations</a>
            <a class="text-[#111418] text-sm font-medium leading-normal" href="{{ route('candidat.candidature') }}" wire:navigate>Candidature</a>
            <span class="h-full block w-[1px] bg-gray-300"></span>
            <livewire:candidat.logout-wire />
            {{-- <a class="text-[#111418] text-sm font-medium leading-normal" href="#">Messages</a> --}}
        </div>
        
    </div>
    
    @else
    <div class="flex flex-1 justify-end gap-8">
        <div class="flex items-center gap-9">
            <a wire:navigate class="text-[#111418] text-sm font-medium leading-normal flex items-center justify-center gap-2" href="{{ route('guest.candidat.connexion') }}">
                <x-icons.sign-in class="size-4" />
                Connexion</a>
            {{-- <a class="text-[#111418] text-sm font-medium leading-normal" href="#">Messages</a> --}}
        </div>
        
    </div>
    @endif

</div>