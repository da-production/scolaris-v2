<div class="max-w-md w-full mx-auto mt-16">
    <div class=" bg-white border border-gray-200 rounded-xl shadow-2xs dark:bg-neutral-900 dark:border-neutral-700 ">
        <div class="p-4 sm:p-7">
            
            @include('components.alerts.rate-limite')

            @session('error')
                <div class="max-w-md mx-auto my-4">
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-md">
                        <div class="flex items-center">
                            <!-- Icon -->
                            <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12c0 4.418-3.582 8-8 8s-8-3.582-8-8 3.582-8 8-8 8 3.582 8 8z"></path>
                            </svg>
                            <!-- Alert Message -->
                            <div>
                                <strong class="font-semibold">Warning!</strong>
                                <p class="text-sm">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            @endsession
            <div class="mt-5">
                @error('valide')
                    <p class="text-sm text-red-500 dark:text-neutral-400">
                        {{ $message }}
                    </p>
                @enderror
                    
                
                <!-- Form -->
                <form wire:submit="login">
                    <div class="grid gap-y-4">
                        <!-- Form Group -->
                        <div class="grid gap-y-4">
                            <!-- Password -->
                            <flux:input
                                wire:model="code"
                                :label="__('Code OTP')"
                                type="text"
                                required
                                autocomplete="otp"
                                :placeholder="__('otp')"
                            />

                        </div>
                        <!-- End Form Group -->
                        <div class="flex items-center justify-end">
                            <flux:button type="submit" variant="primary" class="w-full" >
                                {{ __('Connexion') }}
                            </flux:button>
                        </div>
                    </div>
                </form>
                <!-- End Form -->
            </div>
        </div>
    </div>
</div>