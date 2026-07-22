<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Samara Invitation') }} - Customer</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance
</head>
<body class="min-h-screen bg-white dark:bg-zinc-900">

    <flux:header container class="border-b border-zinc-200 bg-zinc-50 dark:bg-zinc-900 dark:border-zinc-700">
        <flux:brand href="/" logo="https://fluxui.dev/img/demo/logo.png" name="Samara" class="max-lg:hidden dark:hidden" />
        <flux:brand href="/" logo="https://fluxui.dev/img/demo/dark-mode-logo.png" name="Samara" class="max-lg:hidden hidden dark:flex" />

        <flux:spacer />

        <flux:navbar class="max-lg:hidden">
            <flux:navbar.item href="{{ route('dashboard') }}" :current="request()->routeIs('dashboard')">Dashboard</flux:navbar.item>
            <flux:navbar.item href="{{ route('customer.invitations.create') }}" :current="request()->routeIs('customer.invitations.create')">Buat Undangan</flux:navbar.item>
            <flux:navbar.item href="{{ route('customer.orders.index') }}" :current="request()->routeIs('customer.orders.*')">Pesanan Saya</flux:navbar.item>
            <form method="POST" action="{{ route('logout') }}" class="inline-block">
                @csrf
                <flux:navbar.item as="button" type="submit">
                    Keluar
                </flux:navbar.item>
            </form>
        </flux:navbar>

        <flux:spacer />

        <!-- Mobile toggle -->
        <flux:sidebar.toggle class="lg:hidden" icon="bars-3" />
    </flux:header>

    <!-- Mobile sidebar -->
    <flux:sidebar stashable sticky class="lg:hidden bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />
        <flux:brand href="/" logo="https://fluxui.dev/img/demo/logo.png" name="Samara" class="px-2 dark:hidden" />
        <flux:brand href="/" logo="https://fluxui.dev/img/demo/dark-mode-logo.png" name="Samara" class="px-2 hidden dark:flex" />
        
        <flux:navlist variant="outline">
            <flux:navlist.item href="{{ route('dashboard') }}" :current="request()->routeIs('dashboard')">Dashboard</flux:navlist.item>
            <flux:navlist.item href="{{ route('customer.invitations.create') }}" :current="request()->routeIs('customer.invitations.create')">Buat Undangan</flux:navlist.item>
            <flux:navlist.item href="{{ route('customer.orders.index') }}" :current="request()->routeIs('customer.orders.*')">Pesanan Saya</flux:navlist.item>
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <flux:navlist.item as="button" type="submit" class="w-full text-left">
                    Keluar
                </flux:navlist.item>
            </form>
        </flux:navlist>
    </flux:sidebar>

    <flux:main container>
        <x-flash-messages />

        @yield('content')
    </flux:main>

    @fluxScripts
    @stack('script')
</body>
</html>
