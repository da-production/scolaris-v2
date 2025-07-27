<x-layouts.option>
    <div class="flex w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative h-full flex-1  rounded-xl p-2 border border-neutral-200 dark:border-neutral-700">
            <div class="w-full h-full bg-white relative z-10 rounded-lg p-4 border">
                <div class="w-full">
                    <h3 class="text-lg font-semibold ml-3 text-slate-800">Gestion de <b>INSCRIPTION</b></h3>
                    <p class="text-slate-500 mb-5 ml-3"> modifiez et gérez les parametres de l'application.</p>
                </div>
                <div
                    class="relative flex flex-col w-full text-gray-700 bg-white shadow-md rounded-lg bg-clip-border">
                    <div class="p-4 max-w-xl flex gap-2  items-center">
                        <label for="close_register">{{ __('Fermer les inscription') }}</label>
                        <input wire:model.live="form.close_register" id="close_register" type="checkbox" @checked($form[''] ?? false) />
                    </div>
                    <div class="p-4 max-w-xl flex gap-2  items-center">
                        <label for="can_candidat_reset_password">{{ __('Autorizer la réinitialiser du mot de passe') }} </label>
                        <input wire:model.live="form.can_candidat_reset_password" id="can_candidat_reset_password" type="checkbox" @checked($form['can_candidat_reset_password'] ?? false) />
                    </div>
                    <div class="p-4 max-w-xl flex gap-2  items-center">
                        <label for="can_use_cronjob_candidat">{{ __('Activer les CronJob pour les emails') }} </label>
                        <input wire:model.live="form.can_use_cronjob_candidat" id="can_use_cronjob_candidat" type="checkbox" @checked($form['can_use_cronjob_candidat'] ?? false) />
                    </div>
                    <div class="p-4 max-w-xl flex gap-2  items-center">
                        <label for="candidat_login_otp">{{ __('Activer la double auth 2FA') }} </label>
                        <input wire:model.live="form.candidat_login_otp" id="candidat_login_otp" type="checkbox" @checked($form['candidat_login_otp'] ?? false) />
                    </div>
                    <div class="p-4 max-w-xl flex gap-2  items-center">
                        <label for="upload_multiple_files">{{ __('Activer le téléversement multiple') }} </label>
                        <input wire:model.live="form.upload_multiple_files" id="upload_multiple_files" type="checkbox" @checked($form['upload_multiple_files'] ?? false) />
                    </div>
                    <div class="p-4 max-w-xl ">
                        <label for="files_liste_to_upload">{{ __('Tous les fichiers autorisés par diplôme') }} <br><span class="text-gray-600 text-xs"> (Format : diplome1:fichier1|fichier2__diplome2:fichier1|fichier2)</span> </label>
                        <flux:input wire:model.live.debounce.2000="form.files_liste_to_upload" id="files_liste_to_upload" type="text" class="mt-1" />
                    </div>
                    <div class="p-4 max-w-xl ">
                        <label for="diplomes">{{ __('Diplome') }} <br><span class="text-gray-600 text-xs"> (Format : clé:valeur|clé:valeur) exemple: licence:Licence</span> </label>
                        <flux:input wire:model.live.debounce.2000="form.diplomes" id="diplomes" type="text" class="mt-1" />
                    </div>
                </div>

            </div>

            <x-placeholder-pattern class="absolute z-0 inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
        </div>
    </div>

</x-layouts.option>

