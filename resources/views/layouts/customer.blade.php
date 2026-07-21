<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-zinc-50 text-zinc-900 antialiased dark:bg-zinc-900 dark:text-zinc-100">
    <div class="mx-auto flex min-h-screen max-w-5xl flex-col">
        <header class="border-b border-zinc-200 px-4 py-4 dark:border-zinc-800">
            <a href="{{ route('dashboard') }}" class="text-lg font-semibold">{{ config('app.name') }}</a>
        </header>

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
