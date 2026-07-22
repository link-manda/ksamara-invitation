@extends('layouts.admin')

@section('content')
    <div class="mb-6">
        <flux:heading size="xl" level="1">{{ __('Dashboard Admin') }}</flux:heading>
        <flux:subheading>Ringkasan statistik platform Samara Invitation.</flux:subheading>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <flux:card>
            <flux:heading size="sm" class="text-slate-500 mb-1">Total Pelanggan</flux:heading>
            <flux:heading size="2xl">{{ number_format($stats['total_customers'], 0, ',', '.') }}</flux:heading>
        </flux:card>
        
        <flux:card>
            <flux:heading size="sm" class="text-slate-500 mb-1">Total Undangan</flux:heading>
            <flux:heading size="2xl">{{ number_format($stats['total_invitations'], 0, ',', '.') }}</flux:heading>
        </flux:card>
        
        <flux:card>
            <flux:heading size="sm" class="text-slate-500 mb-1">Pendapatan Lunas</flux:heading>
            <flux:heading size="2xl" class="text-green-600">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</flux:heading>
        </flux:card>
        
        <flux:card>
            <flux:heading size="sm" class="text-slate-500 mb-1">Pesanan Pending</flux:heading>
            <flux:heading size="2xl" class="text-amber-600">{{ number_format($stats['pending_orders'], 0, ',', '.') }}</flux:heading>
        </flux:card>
    </div>

    <flux:card>
        <div class="text-center py-12">
            <flux:heading size="lg" class="mb-2">Selamat Datang, Admin!</flux:heading>
            <flux:subheading>Gunakan navigasi di samping untuk mengelola Pelanggan, Pesanan, Paket, dan Template Desain.</flux:subheading>
        </div>
    </flux:card>
@endsection
