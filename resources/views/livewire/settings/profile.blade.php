<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your name and email address')">

            <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6  max-w-lg">
                <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name" />

                <div>
                    <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" />

                    @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail &&! auth()->user()->hasVerifiedEmail())
                        <div>
                            <flux:text class="mt-4">
                                {{ __('Your email address is unverified.') }}

                                <flux:link class="text-sm cursor-pointer" wire:click.prevent="resendVerificationNotification">
                                    {{ __('Click here to re-send the verification email.') }}
                                </flux:link>
                            </flux:text>

                            @if (session('status') === 'verification-link-sent')
                                <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                                    {{ __('A new verification link has been sent to your email address.') }}
                                </flux:text>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="flex items-center gap-4">
                    <div class="flex items-center justify-end">
                        <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
                    </div>

                    <x-action-message class="me-3" on="profile-updated">
                        {{ __('Enregistrer.') }}
                    </x-action-message>
                </div>
            </form>
            <div class="max-w-lg bg-white rounded-2xl shadow-lg p-6 space-y-4">
                <h2 class="text-xl font-semibold text-gray-800">Changer d'exercice</h2>
                <p class="text-gray-600 text-sm">
                    Sélectionnez un exercice parmi la liste pour le remplacer dans votre routine.
                </p>

                <div>
                    <label for="exercice" class="block text-sm font-medium text-gray-700 mb-1">
                    Choisir un exercice
                    </label>
                    <select id="exercice" wire:model.change="exercice" class="w-full border border-gray-300 rounded-lg p-2 text-sm text-gray-800 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option  selected>-- Sélectionner un exercice --</option>
                
                    @foreach ($exercices as $exercice)
                        <option value="{{ $exercice->annee }}">{{ $exercice->annee }}</option>
                        
                    @endforeach
                    </select>
                </div>

                
            </div>

            
            <livewire:settings.delete-user-form />
        </x-settings.layout>
</section>
