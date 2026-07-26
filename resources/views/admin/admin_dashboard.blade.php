@extends('layouts.admin')

@section('content')
    <div class="mb-6">
        <flux:heading size="xl" level="1" class="font-bold tracking-tight">Ringkasan Dashboard</flux:heading>
        <flux:subheading>Data operasional dihitung saat halaman ini dimuat.</flux:subheading>
    </div>

    <div class="grid grid-cols-1 gap-6 mb-8 sm:grid-cols-2 lg:grid-cols-4">
        <flux:card class="flex items-center justify-between p-6">
            <div>
                <flux:heading size="sm" class="mb-1 text-zinc-500">Total Pelanggan</flux:heading>
                <flux:heading size="2xl" class="font-bold">{{ number_format($stats['total_customers'], 0, ',', '.') }}</flux:heading>
                <flux:text size="sm" class="mt-1">Akun customer, akumulatif</flux:text>
            </div>
            <div class="p-3 text-blue-600 rounded-xl bg-blue-500/10 dark:text-blue-400">
                <flux:icon icon="users" class="size-6" />
            </div>
        </flux:card>

        <flux:card class="flex items-center justify-between p-6">
            <div>
                <flux:heading size="sm" class="mb-1 text-zinc-500">Total Undangan</flux:heading>
                <flux:heading size="2xl" class="font-bold">{{ number_format($stats['total_invitations'], 0, ',', '.') }}</flux:heading>
                <flux:text size="sm" class="mt-1">Seluruh undangan, akumulatif</flux:text>
            </div>
            <div class="p-3 text-indigo-600 rounded-xl bg-indigo-500/10 dark:text-indigo-400">
                <flux:icon icon="envelope" class="size-6" />
            </div>
        </flux:card>

        <flux:card class="flex items-center justify-between p-6">
            <div>
                <flux:heading size="sm" class="mb-1 text-zinc-500">Pendapatan Lunas</flux:heading>
                <flux:heading size="2xl" class="font-bold text-emerald-600 dark:text-emerald-400">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</flux:heading>
                <flux:text size="sm" class="mt-1">Status lunas, akumulatif</flux:text>
            </div>
            <div class="p-3 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">
                <flux:icon icon="banknotes" class="size-6" />
            </div>
        </flux:card>

        <a href="{{ route('admin.orders.index') }}" class="block rounded-xl focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-500">
            <flux:card class="flex items-center justify-between h-full p-6 transition hover:border-amber-300 dark:hover:border-amber-700">
                <div>
                    <flux:heading size="sm" class="mb-1 text-zinc-500">Perlu Verifikasi</flux:heading>
                    <flux:heading size="2xl" class="font-bold text-amber-600 dark:text-amber-400">{{ number_format($stats['pending_orders'], 0, ',', '.') }}</flux:heading>
                    <flux:text size="sm" class="mt-1">Rp {{ number_format($stats['pending_amount'], 0, ',', '.') }} pending</flux:text>
                </div>
                <div class="p-3 text-amber-600 rounded-xl bg-amber-500/10 dark:text-amber-400">
                    <flux:icon icon="clock" class="size-6" />
                </div>
            </flux:card>
        </a>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <flux:card class="flex flex-col gap-6">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <flux:heading size="lg">Perlu Verifikasi Pembayaran</flux:heading>
                        <flux:subheading>Lima pesanan pending tertua yang perlu ditindaklanjuti.</flux:subheading>
                    </div>
                    <flux:button href="{{ route('admin.orders.index') }}" variant="ghost" size="sm" icon-trailing="chevron-right">
                        Lihat Semua
                    </flux:button>
                </div>

                <flux:table>
                    <flux:table.columns>
                        <flux:table.column>Pesanan</flux:table.column>
                        <flux:table.column>Pelanggan</flux:table.column>
                        <flux:table.column>Paket</flux:table.column>
                        <flux:table.column>Nominal</flux:table.column>
                        <flux:table.column>Dibuat</flux:table.column>
                        <flux:table.column align="center">Aksi</flux:table.column>
                    </flux:table.columns>
                    <flux:table.rows>
                        @forelse ($stats['pending_orders_queue'] as $order)
                            @php
                                $order_number = '#ORD-'.str_pad((string) $order->id, 5, '0', STR_PAD_LEFT);
                                $formatted_amount = 'Rp '.number_format($order->amount, 0, ',', '.');
                            @endphp
                            <flux:table.row>
                                <flux:table.cell>
                                    <span class="font-mono font-medium text-zinc-900 dark:text-white">{{ $order_number }}</span>
                                </flux:table.cell>
                                <flux:table.cell>
                                    <div class="font-medium text-zinc-900 dark:text-white">{{ $order->user->name ?? 'N/A' }}</div>
                                    <div class="text-xs text-zinc-500">{{ $order->user->email ?? '' }}</div>
                                </flux:table.cell>
                                <flux:table.cell class="font-medium">{{ $order->package->name ?? 'N/A' }}</flux:table.cell>
                                <flux:table.cell class="font-semibold text-zinc-900 dark:text-white">{{ $formatted_amount }}</flux:table.cell>
                                <flux:table.cell>
                                    <time datetime="{{ $order->created_at?->toIso8601String() }}" class="block text-sm text-zinc-900 dark:text-white">
                                        {{ $order->created_at?->format('d M Y, H:i') }}
                                    </time>
                                    <span class="text-xs text-zinc-500">{{ $order->created_at?->locale('id')->diffForHumans() }}</span>
                                </flux:table.cell>
                                <flux:table.cell align="center">
                                    <flux:button
                                        type="button"
                                        variant="ghost"
                                        size="sm"
                                        icon="check-circle"
                                        class="text-emerald-600 dark:text-emerald-400"
                                        x-data
                                        x-on:click="$dispatch('open-paid-confirmation', {
                                            action: @js(route('admin.orders.mark-paid', $order->id)),
                                            orderNumber: @js($order_number),
                                            customer: @js($order->user->name ?? 'N/A'),
                                            packageName: @js($order->package->name ?? 'N/A'),
                                            amount: @js($formatted_amount),
                                        })"
                                    >
                                        Tandai Lunas
                                    </flux:button>
                                </flux:table.cell>
                            </flux:table.row>
                        @empty
                            <flux:table.row>
                                <flux:table.cell colspan="6" class="py-10 text-center text-zinc-500">
                                    Tidak ada pembayaran yang perlu diverifikasi.
                                </flux:table.cell>
                            </flux:table.row>
                        @endforelse
                    </flux:table.rows>
                </flux:table>
            </flux:card>
        </div>

        <div class="space-y-6">
            <flux:card class="flex flex-col gap-4">
                <div>
                    <flux:heading size="lg">Pintasan Aksi Admin</flux:heading>
                    <flux:subheading>Akses cepat pembuatan data dan konfigurasi.</flux:subheading>
                </div>

                <div class="grid grid-cols-2 gap-3 pt-2">
                    <flux:button href="{{ route('admin.users.create') }}" variant="outline" icon="user-plus" class="flex-col justify-center h-20 text-xs text-center gap-1.5">
                        Tambah Pelanggan
                    </flux:button>
                    <flux:button href="{{ route('admin.packages.create') }}" variant="outline" icon="square-3-stack-3d" class="flex-col justify-center h-20 text-xs text-center gap-1.5">
                        Tambah Paket
                    </flux:button>
                    <flux:button href="{{ route('admin.templates.create') }}" variant="outline" icon="swatch" class="flex-col justify-center h-20 text-xs text-center gap-1.5">
                        Tambah Template
                    </flux:button>
                    <flux:button href="{{ route('admin.settings.edit') }}" variant="outline" icon="cog-8-tooth" class="flex-col justify-center h-20 text-xs text-center gap-1.5">
                        Pengaturan Sistem
                    </flux:button>
                </div>
            </flux:card>

            <flux:card class="flex flex-col gap-4">
                <div class="flex items-center gap-2">
                    <flux:icon icon="squares-2x2" class="text-indigo-500 size-5" />
                    <flux:heading size="lg">Kesiapan Konten</flux:heading>
                </div>
                <flux:subheading>Konten aktif yang siap dipublikasikan kepada pelanggan.</flux:subheading>

                <dl class="space-y-3 pt-1 text-sm">
                    <div class="flex items-center justify-between gap-4">
                        <dt class="text-zinc-500 dark:text-zinc-400">Paket aktif</dt>
                        <dd class="font-bold text-zinc-900 dark:text-white">{{ $stats['total_packages'] }} Paket</dd>
                    </div>
                    <div class="flex items-center justify-between gap-4">
                        <dt class="text-zinc-500 dark:text-zinc-400">Template aktif</dt>
                        <dd class="font-bold text-zinc-900 dark:text-white">{{ $stats['total_templates'] }} Template</dd>
                    </div>
                </dl>
            </flux:card>
        </div>
    </div>
@endsection
