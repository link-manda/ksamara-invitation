@props([
    'variant' => 'nav', // 'nav' (sidebar item) or 'icon' (header icon button)
])

<div x-data="{
    isDark: document.documentElement.classList.contains('dark'),
    toggleTheme() {
        this.isDark = !this.isDark;
        if (this.isDark) {
            document.documentElement.classList.add('dark');
            localStorage.setItem('flux.appearance', 'dark');
            if (window.Flux) window.Flux.appearance = 'dark';
            if (this.$flux) this.$flux.appearance = 'dark';
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('flux.appearance', 'light');
            if (window.Flux) window.Flux.appearance = 'light';
            if (this.$flux) this.$flux.appearance = 'light';
        }
    }
}" class="inline-block w-full">
    @if($variant === 'icon')
        <button 
            type="button" 
            x-on:click="toggleTheme()" 
            class="p-2 rounded-lg text-zinc-500 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white transition-colors cursor-pointer flex items-center justify-center"
            :aria-label="isDark ? 'Ganti ke Mode Terang' : 'Ganti ke Mode Gelap'"
        >
            <span x-show="isDark" class="flex items-center">
                <flux:icon icon="sun" class="size-5 text-amber-400" />
            </span>
            <span x-show="!isDark" class="flex items-center">
                <flux:icon icon="moon" class="size-5 text-indigo-500" />
            </span>
        </button>
    @else
        <flux:navlist.item 
            as="button" 
            type="button" 
            x-on:click="toggleTheme()" 
            class="w-full text-left cursor-pointer"
        >
            <span x-show="isDark" class="flex items-center gap-2">
                <flux:icon icon="sun" class="size-4 text-amber-400" />
                <span>Mode Terang</span>
            </span>
            <span x-show="!isDark" class="flex items-center gap-2">
                <flux:icon icon="moon" class="size-4 text-indigo-500" />
                <span>Mode Gelap</span>
            </span>
        </flux:navlist.item>
    @endif
</div>
