<header
    class="flex relative z-50 max-w-[85rem] mx-auto w-full items-center justify-between whitespace-nowrap border-b border-solid border-b-[#f0f2f5] px-10 py-3">
    <div class="flex items-center gap-4 text-[#111418]">
        <div class="size-4">
            <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M39.475 21.6262C40.358 21.4363 40.6863 21.5589 40.7581 21.5934C40.7876 21.655 40.8547 21.857 40.8082 22.3336C40.7408 23.0255 40.4502 24.0046 39.8572 25.2301C38.6799 27.6631 36.5085 30.6631 33.5858 33.5858C30.6631 36.5085 27.6632 38.6799 25.2301 39.8572C24.0046 40.4502 23.0255 40.7407 22.3336 40.8082C21.8571 40.8547 21.6551 40.7875 21.5934 40.7581C21.5589 40.6863 21.4363 40.358 21.6262 39.475C21.8562 38.4054 22.4689 36.9657 23.5038 35.2817C24.7575 33.2417 26.5497 30.9744 28.7621 28.762C30.9744 26.5497 33.2417 24.7574 35.2817 23.5037C36.9657 22.4689 38.4054 21.8562 39.475 21.6262ZM4.41189 29.2403L18.7597 43.5881C19.8813 44.7097 21.4027 44.9179 22.7217 44.7893C24.0585 44.659 25.5148 44.1631 26.9723 43.4579C29.9052 42.0387 33.2618 39.5667 36.4142 36.4142C39.5667 33.2618 42.0387 29.9052 43.4579 26.9723C44.1631 25.5148 44.659 24.0585 44.7893 22.7217C44.9179 21.4027 44.7097 19.8813 43.5881 18.7597L29.2403 4.41187C27.8527 3.02428 25.8765 3.02573 24.2861 3.36776C22.6081 3.72863 20.7334 4.58419 18.8396 5.74801C16.4978 7.18716 13.9881 9.18353 11.5858 11.5858C9.18354 13.988 7.18717 16.4978 5.74802 18.8396C4.58421 20.7334 3.72865 22.6081 3.36778 24.2861C3.02574 25.8765 3.02429 27.8527 4.41189 29.2403Z"
                    fill="currentColor"></path>
            </svg>
        </div>
        <h2 class="text-[#111418] text-lg font-bold leading-tight tracking-[-0.015em]">ESSS Concours</h2>
    </div>
    @if(auth()->guard('candidat')->check())
    <div class="flex flex-1 justify-end gap-8">
        <div class="flex items-center gap-9">
            <a class="text-[#111418] text-sm font-medium leading-normal" href="#">Vos informations</a>
            <a class="text-[#111418] text-sm font-medium leading-normal" href="#">Candidature</a>
            {{-- <a class="text-[#111418] text-sm font-medium leading-normal" href="#">Messages</a> --}}
        </div>
        <div class="relative inline-block text-left">
            <button id="dropdown-button" class="inline-flex justify-center w-full text-sm font-medium   focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-blue-500">
                <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10"
                    style='background-image: url("{{ asset('images/default-avatar-icon.jpg') }}");'>
                </div>
            </button>
            <div id="dropdown-menu" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 ">
                <div class="py-2 p-2" role="menu" aria-orientation="vertical" aria-labelledby="dropdown-button">
                    <livewire:candidat.logout-wire />
                </div>
            </div>
        </div>
        
    </div>
    <script>
        const dropdownButton = document.getElementById('dropdown-button');
        const dropdownMenu = document.getElementById('dropdown-menu');
        let isDropdownOpen = true; // Set to true to open the dropdown by default, false to close it by default

        // Function to toggle the dropdown
        function toggleDropdown() {
            isDropdownOpen = !isDropdownOpen;
            if (isDropdownOpen) {
                dropdownMenu.classList.remove('hidden');
            } else {
                dropdownMenu.classList.add('hidden');
            }
        }

        // Initialize the dropdown state
        toggleDropdown();

        // Toggle the dropdown when the button is clicked
        dropdownButton.addEventListener('click', toggleDropdown);

        // Close the dropdown when clicking outside of it
        window.addEventListener('click', (event) => {
            if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.classList.add('hidden');
                isDropdownOpen = false;
            }
        });
    </script>
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

</header>