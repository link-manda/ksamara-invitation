<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-zinc-50 antialiased dark:bg-zinc-950 selection:bg-amber-500 selection:text-white">
        <div class="flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10 relative overflow-hidden">
            <!-- Background Glow Effect -->
            <div class="absolute -top-40 -left-40 size-96 rounded-full bg-amber-500/10 dark:bg-amber-500/5 blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-40 -right-40 size-96 rounded-full bg-rose-500/10 dark:bg-rose-500/5 blur-3xl pointer-events-none"></div>

            <div class="flex w-full max-w-md flex-col gap-6 relative z-10">
                <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 font-medium group" wire:navigate>
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400 group-hover:scale-105 transition-transform">
                        <x-app-logo-icon class="size-7 fill-current" />
                    </div>
                    <span class="text-lg font-bold tracking-tight text-zinc-900 dark:text-white">
                        Samara <span class="text-amber-600 dark:text-amber-400">Invitation</span>
                    </span>
                </a>

                <div class="rounded-2xl border border-zinc-200/80 bg-white/90 dark:bg-zinc-900/90 dark:border-zinc-800 shadow-2xl backdrop-blur-sm">
                    <div class="p-8 sm:p-10">{{ $slot }}</div>
                </div>
            </div>
        </div>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>

