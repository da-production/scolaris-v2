<div x-data="{ open: false }" class="relative inline-block" x-cloak>
    <button @click="open = ! open" @click.away="open = false" class="cursor-pointer relative items-center font-medium justify-center gap-2 whitespace-nowrap disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none h-8 text-sm rounded-md px-3 inline-flex bg-teal-500 hover:bg-teal-600 text-white border border-black/10 dark:border-0 shadow-[inset_0px_1px_--theme(--color-white/.2)] *:transition-opacity [&[data-flux-loading]>:not([data-flux-loading-indicator])]:opacity-0 [&[data-flux-loading]>[data-flux-loading-indicator]]:opacity-100 data-flux-loading:pointer-events-none">
        {{ $trigger ?? 'Dropdown' }}
    </button>

    <div x-ref="dropdown"
         x-show="open"
         @click.outside="open = false"
         x-transition:enter="transition ease-out duration-200 transform opacity-0 scale-95"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150 transform opacity-100 scale-100"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute right-0 mt-2 w-48 bg-white border rounded-lg shadow-lg z-50 p-2">
        {{ $slot }}
    </div>
</div>