@props([
    'variant' => 'button', // 'button' or 'menu'
])

<div x-data class="inline-flex items-center">
    @if($variant === 'menu')
        <flux:dropdown position="bottom" align="end">
            <flux:button variant="ghost" size="sm" icon="sun" class="dark:hidden" aria-label="Pilih Tema" />
            <flux:button variant="ghost" size="sm" icon="moon" class="hidden dark:inline-flex" aria-label="Pilih Tema" />

            <flux:menu>
                <flux:menu.item icon="sun" x-on:click="$flux.appearance = 'light'">Terang (Light)</flux:menu.item>
                <flux:menu.item icon="moon" x-on:click="$flux.appearance = 'dark'">Gelap (Dark)</flux:menu.item>
                <flux:menu.item icon="computer-desktop" x-on:click="$flux.appearance = 'system'">Sistem</flux:menu.item>
            </flux:menu>
        </flux:dropdown>
    @else
        <flux:button 
            variant="ghost" 
            size="sm" 
            x-on:click="$flux.appearance = $flux.appearance === 'dark' ? 'light' : 'dark'" 
            aria-label="Ganti Tema"
            class="rounded-lg text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white"
        >
            <flux:icon icon="sun" class="size-5 dark:hidden text-amber-500" />
            <flux:icon icon="moon" class="size-5 hidden dark:block text-indigo-400" />
        </flux:button>
    @endif
</div>
