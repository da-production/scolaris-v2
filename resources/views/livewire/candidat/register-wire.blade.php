<div class="max-w-md w-full mx-auto mt-16">
    <div class=" bg-white border border-gray-200 rounded-xl shadow-2xs dark:bg-neutral-900 dark:border-neutral-700 ">
        <div class="p-4 sm:p-7">
            
            @include('components.alerts.rate-limite')
            @if (canCandidatUpdate())
                
                
            <div class="mt-5">
                @error('valide')
                    <p class="text-sm text-red-500 dark:text-neutral-400">
                        {{ $message }}
                    </p>
                @enderror
                
                <!-- Form -->
                <form wire:submit="register">
                    <div class="grid gap-y-4">
                        <!-- End Form Group -->
                        {{-- <flux:input
                            wire:model.live="nin"
                            :label="__('NIN')"
                            type="text"
                            required
                            autofocus
                            autocomplete="nin"
                            placeholder="nin"
                            :readonly="$processing"
                        /> --}}
                        <div class="flex gap-2">
                            <flux:input
                                wire:model="numero_bac"
                                :label="__('Numéro du Bac')"
                                type="text"
                                required
                                autofocus
                                autocomplete="numero_bac"
                                placeholder="Numéro du Bac"
                            />
                            <flux:input
                                wire:model="annee_bac"
                                :label="__('Année du Bac')"
                                type="text"
                                required
                                autofocus
                                autocomplete="annee_bac"
                                placeholder="Année du Bac"
                            />
                        </div>
                        <!-- Form Group -->
                        <flux:input
                            wire:model="email"
                            :label="__('Adresse e-mail')"
                            type="text"
                            required
                            autofocus
                            autocomplete="email"
                            placeholder="email@exemple.com"
                        />
                        <!-- Form Group -->
                        <div class="grid gap-y-4">
                            <!-- Password -->
                            <flux:input
                                wire:model="password"
                                :label="__('Password')"
                                type="password"
                                required
                                autocomplete="new-password"
                                :placeholder="__('Password')"
                            />

                            <!-- Confirm Password -->
                            <flux:input
                                wire:model="password_confirmation"
                                :label="__('Confirm password')"
                                type="password"
                                required
                                autocomplete="new-password"
                                :placeholder="__('Confirm password')"
                            />
                        </div>
                        @if (!$errors->has('rateErrorMessage'))
                            
                        <!-- End Form Group -->
                        <div class="flex items-center justify-end">
                            <flux:button type="submit" variant="primary" class="w-full" :disabled="$processing">
                                {{ __('Inscription') }}
                            </flux:button>
                        </div>
                        @endif
                    </div>
                </form>
                <!-- End Form -->
            </div>
            
            @else
                <div class="bg-yellow-100 border border-yellow-400 text-yellow-800 px-4 py-3 rounded relative mt-5" role="alert">
                    <strong class="font-bold">Attention !</strong>
                    <span class="block sm:inline">Les inscriptions sont clôturées.Vous ne pouvez plus vous inscrire pour l\'exercice en cours.</span>
                </div>

            @endif
        </div>
    </div>
</div>