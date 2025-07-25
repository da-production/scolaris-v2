<div
    class="flex relative z-50 max-w-[85rem] mx-auto w-full items-center justify-between whitespace-nowrap border-b border-solid border-b-[#dde0e6]  py-3">
    <a wire:navigate href="{{ route('home') }}" class="flex items-center gap-4 text-[#111418]">
        
        <h2 class="bg-white dark:bg-neutral-800 
            text-[#111418] dark:text-white 
            px-3 py-0.5 rounded-lg shadow 
            gap-2 text-sm font-medium leading-normal 
            flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><!-- Icon from Solar by 480 Design - https://creativecommons.org/licenses/by/4.0/ --><g fill="none" stroke="currentColor" stroke-width="1.5"><path d="M2 12.204c0-2.289 0-3.433.52-4.381c.518-.949 1.467-1.537 3.364-2.715l2-1.241C9.889 2.622 10.892 2 12 2s2.11.622 4.116 1.867l2 1.241c1.897 1.178 2.846 1.766 3.365 2.715S22 9.915 22 12.203v1.522c0 3.9 0 5.851-1.172 7.063S17.771 22 14 22h-4c-3.771 0-5.657 0-6.828-1.212S2 17.626 2 13.725z" opacity=".5"/><path stroke-linecap="round" d="M12 15v3"/></g></svg>
            <span class="hidden sm:inline">Accueil</span>
        </h2>
    </a>
    @if(auth()->guard('candidat')->check())
    <div class="flex flex-1 justify-end gap-4" >
        <div class="flex items-center gap-9">
            <a class="text-[#111418] dark:text-white text-sm font-medium leading-normal" href="{{ route('candidat.profile') }}" wire:navigate>Vos informations</a>
            <a class="text-[#111418] dark:text-white text-sm font-medium leading-normal" href="{{ route('candidat.candidature') }}" wire:navigate>Candidature</a>
            <span class="h-full block w-[1px] bg-gray-300"></span>
            <livewire:candidat.logout-wire />
        </div>
        
    </div>
    
    @else
    <div class="flex flex-1 justify-end gap-8">
        <div class="flex items-center gap-9">
            <a wire:navigate class="bg-white dark:bg-neutral-800 
            text-[#111418] dark:text-white 
            px-3 py-0.5 rounded-lg shadow 
            text-sm font-medium leading-normal 
            flex items-center justify-center gap-2" href="{{ route('guest.candidat.connexion') }}">
                <x-icons.sign-in class="size-4" />
                <span class="hidden sm:inline">Connexion</span>
                </a>
        </div>
        
    </div>
    @endif

</div>