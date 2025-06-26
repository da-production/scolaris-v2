<div x-data="{ 
        slideOverOpen: false 
    }"
    class="relative z-50 w-auto h-auto">
    
    <flux:navlist.item icon="users"  @click="slideOverOpen=true" >
        <div class="flex items-center justify-between">
            <span>Utilisateur connecté </span>
            <span class=" bg-teal-600 text-white text-xs font-semibold rounded-full px-2 py-0.5 shadow">
                {{ count($onlineUsers) }}
            </span>
        </div>
    </flux:navlist.item>
    <template x-teleport="body">
        <div 
            x-show="slideOverOpen"
            @keydown.window.escape="slideOverOpen=false"
            class="relative z-[99]">
            <div x-show="slideOverOpen" x-transition.opacity.duration.600ms @click="slideOverOpen = false" class="fixed inset-0 bg-black bg-opacity-10"></div>
            <div class="fixed inset-0 overflow-hidden">
                <div class="absolute inset-0 overflow-hidden">
                    <div class="fixed inset-y-0 right-0 flex max-w-full pl-10">
                        <div 
                            x-show="slideOverOpen" 
                            @click.away="slideOverOpen = false"
                            x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700" 
                            x-transition:enter-start="translate-x-full" 
                            x-transition:enter-end="translate-x-0" 
                            x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700" 
                            x-transition:leave-start="translate-x-0" 
                            x-transition:leave-end="translate-x-full" 
                            class="w-screen max-w-md">
                            <div class="flex flex-col h-full py-5 overflow-y-scroll bg-white border-l shadow-lg border-neutral-100/70">
                                <div class="px-4 sm:px-5">
                                    <div class="flex items-start justify-between pb-1">
                                        <h2 class="text-base font-semibold leading-6 text-gray-900" id="slide-over-title">Utilisateur connecté</h2>
                                        <div class="flex items-center h-auto ml-3">
                                            <button @click="slideOverOpen=false" class="absolute top-0 right-0 z-30 flex items-center justify-center px-3 py-2 mt-4 mr-5 space-x-1 text-xs font-medium uppercase border rounded-md border-neutral-200 text-neutral-600 hover:bg-neutral-100">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                <span>Close</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="relative flex-1 px-4 mt-5 sm:px-5">
                                    <div class="absolute inset-0 px-4 sm:px-5">
                                        <div class="relative h-full overflow-hidden rounded-md border-neutral-300">
                                            @foreach ($onlineUsers as $user)
                                                <div class="max-w-sm mx-auto mt-6">
                                                    <div class="bg-white shadow-md rounded p-4 flex items-center justify-between">
                                                        <div>
                                                            <h2 class="text-lg font-semibold text-gray-800">{{ $user->name }}</h2>
                                                            <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                                        </div>
                                                        <button
                                                            wire:click="logoutUser('{{ $user->id }}')"
                                                            type="button"
                                                            class="text-red-500 hover:text-red-700 transition"
                                                            title="Se déconnecter"
                                                        >
                                                            <!-- Heroicons logout icon -->
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-9V5m0 0V3m0 2h3m-3 0h-3"/>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>

@script
<script>
    Echo.join('app')
    .here((users) => {
        console.log('Currently connected users:', users)
    })
    .joining((user) => {
        console.log(user.name + ' has joined');
        Livewire.dispatch('user-joined', {'user':user});
    })
    .leaving((user) => {
        console.log(user.name + ' has left');
        Livewire.dispatch('user-left', {'user':user});
    });
</script>
@endscript