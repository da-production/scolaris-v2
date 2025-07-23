<div class="max-w-md w-full mx-auto mt-16">
    <div class=" bg-white border border-gray-200 rounded-xl shadow-2xs dark:bg-neutral-900 dark:border-neutral-700 ">
        <div class="p-4 sm:p-7">
            <div class="text-center">
                <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 font-medium" wire:navigate>
                    <span class="flex size-24 mb-1 items-center justify-center rounded-md">
                        <img src="{{ asset('images/Logo-esss-300x300.png') }}"  alt="" srcset="">
                    </span>
                
                    <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
                </a>
                {{-- <h1 class="block text-2xl font-bold text-gray-800 dark:text-white">Inscription</h1> --}}
            </div>
            @include('components.alerts.rate-limite')
            <div class="mt-5">
                @error('valide')
                    <p class="text-sm text-red-500 dark:text-neutral-400">
                        {{ $message }}
                    </p>
                @enderror
                
                <!-- Form -->
                <form wire:submit="save">
                    <div class="grid gap-y-4">
                        <!-- Form Group -->
                        <div class="grid gap-y-4">
                            <!-- Password -->
                            <flux:input
                                wire:model="password"
                                :label="__('Password')"
                                type="password"
                                
                                autocomplete="new-password"
                                :placeholder="__('Password')"
                            />

                            <!-- Confirm Password -->
                            <flux:input
                                wire:model="password_confirmation"
                                :label="__('Confirm password')"
                                type="password"
                                
                                autocomplete="new-password"
                                :placeholder="__('Confirm password')"
                            />
                        </div>
                        @if (!$errors->has('rateErrorMessage'))
                            
                        <!-- End Form Group -->
                        <div class="flex items-center justify-end">
                            <flux:button type="submit" variant="primary" class="w-full" >
                                {{ __('Réinitialiser') }}
                            </flux:button>
                        </div>
                        @endif
                    </div>
                </form>
                <!-- End Form -->
            </div>
        </div>
    </div>
</div>