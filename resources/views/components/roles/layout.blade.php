<section class="w-full">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">Gestion des Utilisateurs, Rôles et Permissions Avancées</flux:heading>
        <flux:subheading size="lg" class="mb-6">Ce module permet une gestion flexible des accès en combinant un système basé sur les rôles (RBAC) et des permissions individuelles (UAC).
            <br /> Chaque utilisateur peut avoir un rôle défini ainsi que des permissions supplémentaires pour une personnalisation fine des autorisations.
            <br /> Assurez un contrôle précis et sécurisé des accès sur la plateforme. 🚀</flux:subheading>
        <flux:separator variant="subtle" />
    </div>


    <div class="flex items-start max-md:flex-col">
        <div class="mr-10 w-full pb-4 md:w-[220px]">
            <flux:navlist>
                <flux:navlist.item :href="route('administrateur.utilisateurs.roles')" wire:navigate>{{ __('Roles') }}</flux:navlist.item>
                <flux:navlist.item :href="route('administrateur.utilisateurs.permissions')" wire:navigate>{{ __('Permissions') }}</flux:navlist.item>
            </flux:navlist>
        </div>

        <flux:separator class="md:hidden" />

        <div class="flex-1 self-stretch max-md:pt-6">

            <div class=" w-full">
                {{ $slot }}
            </div>
        </div>
    </div>
    <x-toaster-hub />
</section>
