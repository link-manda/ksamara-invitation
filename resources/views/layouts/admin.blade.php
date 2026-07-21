<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-zinc-50 text-zinc-900 antialiased dark:bg-zinc-900 dark:text-zinc-100">
    <div class="flex min-h-screen flex-col md:flex-row">
        <aside class="w-full shrink-0 border-b border-zinc-200 bg-white md:w-56 md:border-b-0 md:border-r dark:border-zinc-800 dark:bg-zinc-950">
            <div class="p-4">
                <a href="{{ route('admin.dashboard') }}" class="text-lg font-semibold">{{ config('app.name') }}</a>
                <p class="text-xs text-zinc-500">{{ __('Admin') }}</p>
            </div>
            <nav class="flex flex-col gap-1 p-2">
                <a href="{{ route('admin.dashboard') }}" class="rounded-lg px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-zinc-100 dark:bg-zinc-800' : 'hover:bg-zinc-100 dark:hover:bg-zinc-800' }}">
                    {{ __('Dashboard') }}
                </a>
                <a href="{{ route('admin.packages.index') }}" class="rounded-lg px-3 py-2 text-sm font-medium {{ request()->routeIs('admin.packages.*') ? 'bg-zinc-100 dark:bg-zinc-800' : 'hover:bg-zinc-100 dark:hover:bg-zinc-800' }}">
                    {{ __('Packages') }}
                </a>
            </nav>
        </aside>

        <main class="flex-1 p-4 md:p-8">
            @if (session('status'))
                <div class="mb-4 rounded-lg bg-green-50 px-4 py-3 text-sm text-green-800 dark:bg-green-900/30 dark:text-green-300">
                    {{ session('status') }}
                </div>
            @endif

            {{ $slot }}
        </main>
    </div>
</body>
</html>
