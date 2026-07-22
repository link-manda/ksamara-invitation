<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Samara Invitation') }} - Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance
</head>
<body class="min-h-screen bg-zinc-50 dark:bg-zinc-900">

    <flux:sidebar sticky stashable class="bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <flux:brand href="{{ route('admin.dashboard') }}" logo="https://fluxui.dev/img/demo/logo.png" name="Samara Admin" class="px-2 dark:hidden" />
        <flux:brand href="{{ route('admin.dashboard') }}" logo="https://fluxui.dev/img/demo/dark-mode-logo.png" name="Samara Admin" class="px-2 hidden dark:flex" />

        <flux:navlist variant="outline">
            <flux:navlist.item icon="home" href="{{ route('admin.dashboard') }}" :current="request()->routeIs('admin.dashboard')">Dashboard</flux:navlist.item>
            <flux:navlist.item icon="users" href="{{ route('admin.users.index') }}" :current="request()->routeIs('admin.users.*')">Pelanggan</flux:navlist.item>
            <flux:navlist.item icon="square-3-stack-3d" href="{{ route('admin.packages.index') }}" :current="request()->routeIs('admin.packages.*')">Paket</flux:navlist.item>
            <flux:navlist.item icon="swatch" href="{{ route('admin.templates.index') }}" :current="request()->routeIs('admin.templates.*')">Template</flux:navlist.item>
        </flux:navlist>

        <flux:spacer />

        <flux:navlist variant="outline">
            <flux:navlist.item icon="cog-6-tooth" href="#">Pengaturan</flux:navlist.item>
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <flux:navlist.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full text-left">
                    Keluar
                </flux:navlist.item>
            </form>
        </flux:navlist>
    </flux:sidebar>

    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-3" inset="left" />
        <flux:spacer />
    </flux:header>

    <flux:main container>
        @if (session('success'))
            <div class="mb-4 p-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </flux:main>

    @fluxScripts
    @stack('script')
</body>
</html>
