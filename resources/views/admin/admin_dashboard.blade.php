@extends('layouts.admin')

@section('content')
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <flux:heading size="xl" level="1" class="font-bold tracking-tight">{{ __('Dashboard Overview') }}</flux:heading>
            <flux:subheading>Selamat datang kembali di panel administrasi Samara Invitation.</flux:subheading>
        </div>
        
        <div class="flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20 text-xs font-medium self-start md:self-auto">
            <span class="size-2 rounded-full bg-emerald-500 animate-pulse"></span>
            <span>Semua Layanan Berjalan Normal</span>
        </div>
    </div>

    <!-- Stat Cards Top Bar -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <flux:card class="flex items-center justify-between p-6">
            <div>
                <flux:heading size="sm" class="text-zinc-500 mb-1">Total Pelanggan</flux:heading>
                <flux:heading size="2xl" class="font-bold">{{ number_format($stats['total_customers'], 0, ',', '.') }}</flux:heading>
            </div>
            <div class="p-3 rounded-xl bg-blue-500/10 text-blue-600 dark:text-blue-400">
                <flux:icon icon="users" class="size-6" />
            </div>
        </flux:card>
        
        <flux:card class="flex items-center justify-between p-6">
            <div>
                <flux:heading size="sm" class="text-zinc-500 mb-1">Total Undangan</flux:heading>
                <flux:heading size="2xl" class="font-bold">{{ number_format($stats['total_invitations'], 0, ',', '.') }}</flux:heading>
            </div>
            <div class="p-3 rounded-xl bg-indigo-500/10 text-indigo-600 dark:text-indigo-400">
                <flux:icon icon="envelope" class="size-6" />
            </div>
        </flux:card>
        
        <flux:card class="flex items-center justify-between p-6">
            <div>
                <flux:heading size="sm" class="text-zinc-500 mb-1">Pendapatan Lunas</flux:heading>
                <flux:heading size="2xl" class="font-bold text-emerald-600 dark:text-emerald-400">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</flux:heading>
            </div>
            <div class="p-3 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">
                <flux:icon icon="banknotes" class="size-6" />
            </div>
        </flux:card>
        
        <flux:card class="flex items-center justify-between p-6">
            <div>
                <flux:heading size="sm" class="text-zinc-500 mb-1">Pesanan Pending</flux:heading>
                <flux:heading size="2xl" class="font-bold text-amber-600 dark:text-amber-400">{{ number_format($stats['pending_orders'], 0, ',', '.') }}</flux:heading>
            </div>
            <div class="p-3 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400">
                <flux:icon icon="clock" class="size-6" />
            </div>
        </flux:card>
    </div>

    <!-- Main Grid Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Orders (Left 2 Columns) -->
        <div class="lg:col-span-2">
            <flux:card class="flex flex-col gap-6">
                <div class="flex items-center justify-between">
                    <div>
                        <flux:heading size="lg">Transaksi & Pesanan Terbaru</flux:heading>
                        <flux:subheading>5 pesanan pelanggan terkini yang masuk ke sistem.</flux:subheading>
                    </div>
                    <flux:button href="{{ route('admin.orders.index') }}" variant="ghost" size="sm" icon-trailing="chevron-right">
                        Lihat Semua
                    </flux:button>
                </div>

                <flux:table>
                    <flux:table.columns>
                        <flux:table.column>ID Pesanan</flux:table.column>
                        <flux:table.column>Pelanggan</flux:table.column>
                        <flux:table.column>Paket</flux:table.column>
                        <flux:table.column>Tagihan</flux:table.column>
                        <flux:table.column>Status</flux:table.column>
                        <flux:table.column align="center">Aksi</flux:table.column>
                    </flux:table.columns>
                    <flux:table.rows>
                        @forelse($stats['recent_orders'] as $order)
                        <flux:table.row>
                            <flux:table.cell>
                                <span class="font-mono font-medium text-zinc-900 dark:text-white">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                            </flux:table.cell>
                            <flux:table.cell>
                                <div class="font-medium text-zinc-900 dark:text-white">{{ $order->user->name ?? 'N/A' }}</div>
                                <div class="text-xs text-zinc-500">{{ $order->user->email ?? '' }}</div>
                            </flux:table.cell>
                            <flux:table.cell class="font-medium">{{ $order->package->name ?? 'N/A' }}</flux:table.cell>
                            <flux:table.cell class="font-semibold text-zinc-900 dark:text-white">Rp {{ number_format($order->amount, 0, ',', '.') }}</flux:table.cell>
                            <flux:table.cell>
                                @if($order->status === \App\Enums\OrderStatus::Paid)
                                    <flux:badge color="success">Lunas</flux:badge>
                                @elseif($order->status === \App\Enums\OrderStatus::Pending)
                                    <flux:badge color="warning">Pending</flux:badge>
                                @else
                                    <flux:badge color="danger">Batal</flux:badge>
                                @endif
                            </flux:table.cell>
                            <flux:table.cell align="center">
                                @if($order->status === \App\Enums\OrderStatus::Pending)
                                    <form action="{{ route('admin.orders.mark-paid', $order->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <flux:button type="submit" variant="ghost" size="sm" icon="check-circle" class="text-emerald-600 dark:text-emerald-400">
                                            Tandai Lunas
                                        </flux:button>
                                    </form>
                                @else
                                    <span class="text-xs text-zinc-400">-</span>
                                @endif
                            </flux:table.cell>
                        </flux:table.row>
                        @empty
                        <flux:table.row>
                            <flux:table.cell colspan="6" class="text-center py-8 text-zinc-500">Belum ada pesanan terbaru.</flux:table.cell>
                        </flux:table.row>
                        @endforelse
                    </flux:table.rows>
                </flux:table>
            </flux:card>
        </div>

        <!-- Quick Actions & System Info (Right 1 Column) -->
        <div class="space-y-6">
            <!-- Quick Actions Card -->
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

            <!-- Platform Health & Info Card -->
            <flux:card class="flex flex-col gap-4 border-amber-200/60 dark:border-amber-900/40 bg-linear-to-br from-amber-50/40 to-orange-50/20 dark:from-zinc-900 dark:to-zinc-900/90">
                <div class="flex items-center gap-2">
                    <flux:icon icon="sparkles" class="text-amber-500 size-5" />
                    <flux:heading size="lg">Status Layanan Platform</flux:heading>
                </div>

                <div class="space-y-3 pt-1">
                    <div class="flex items-center justify-between text-xs text-zinc-600 dark:text-zinc-400">
                        <span>Paket Aktif Dipublikasi:</span>
                        <span class="font-bold text-zinc-900 dark:text-white">{{ $stats['total_packages'] }} Paket</span>
                    </div>

                    <div class="flex items-center justify-between text-xs text-zinc-600 dark:text-zinc-400">
                        <span>Template Desain Aktif:</span>
                        <span class="font-bold text-zinc-900 dark:text-white">{{ $stats['total_templates'] }} Template</span>
                    </div>

                    <div class="flex items-center justify-between text-xs text-zinc-600 dark:text-zinc-400">
                        <span>WhatsApp CS Terhubung:</span>
                        <span class="font-bold text-emerald-600 dark:text-emerald-400">Aktif</span>
                    </div>
                </div>
            </flux:card>
        </div>
    </div>
@endsection
