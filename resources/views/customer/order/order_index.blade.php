@extends('layouts.customer')

@section('content')
<div class="mb-6">
    <flux:heading size="xl" level="1">Pesanan Saya</flux:heading>
    <flux:subheading>Riwayat pesanan dan tagihan transaksi undangan digital Anda.</flux:subheading>
</div>

@php
    $totalPaid = $orders->where('status', \App\Enums\OrderStatus::Paid)->sum('amount');
    $totalPending = $orders->where('status', \App\Enums\OrderStatus::Pending)->sum('amount');
@endphp

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <flux:card class="flex items-center justify-between p-6">
        <div>
            <flux:heading size="sm" class="text-zinc-500 mb-1">Total Pesanan</flux:heading>
            <flux:heading size="2xl" class="font-bold">{{ number_format($orders->count(), 0, ',', '.') }}</flux:heading>
        </div>
        <div class="p-3 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400">
            <flux:icon icon="shopping-bag" class="size-6" />
        </div>
    </flux:card>

    <flux:card class="flex items-center justify-between p-6">
        <div>
            <flux:heading size="sm" class="text-zinc-500 mb-1">Total Transaksi Lunas</flux:heading>
            <flux:heading size="2xl" class="font-bold text-green-600 dark:text-green-400">Rp {{ number_format($totalPaid, 0, ',', '.') }}</flux:heading>
        </div>
        <div class="p-3 rounded-xl bg-green-500/10 text-green-600 dark:text-green-400">
            <flux:icon icon="check-circle" class="size-6" />
        </div>
    </flux:card>

    <flux:card class="flex items-center justify-between p-6">
        <div>
            <flux:heading size="sm" class="text-zinc-500 mb-1">Tagihan Pending</flux:heading>
            <flux:heading size="2xl" class="font-bold text-amber-600 dark:text-amber-400">Rp {{ number_format($totalPending, 0, ',', '.') }}</flux:heading>
        </div>
        <div class="p-3 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400">
            <flux:icon icon="clock" class="size-6" />
        </div>
    </flux:card>
</div>

<flux:card>
    <flux:table>
        <flux:table.columns>
            <flux:table.column>ID Pesanan</flux:table.column>
            <flux:table.column>Paket</flux:table.column>
            <flux:table.column>Total Tagihan</flux:table.column>
            <flux:table.column>Status</flux:table.column>
            <flux:table.column>Tanggal</flux:table.column>
            <flux:table.column align="center">Aksi</flux:table.column>
        </flux:table.columns>
        <flux:table.rows>
            @forelse($orders as $order)
            <flux:table.row>
                <flux:table.cell>
                    <span class="font-mono font-medium text-zinc-900 dark:text-white">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                </flux:table.cell>
                <flux:table.cell class="font-medium">{{ $order->package->name }}</flux:table.cell>
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
                <flux:table.cell class="text-zinc-500">{{ $order->created_at->format('d M Y, H:i') }}</flux:table.cell>
                <flux:table.cell align="center">
                    <div class="flex items-center justify-center gap-2">
                        @if($order->status === \App\Enums\OrderStatus::Pending)
                            <flux:modal.trigger name="payment-modal-{{ $order->id }}">
                                <flux:button variant="primary" size="sm" icon="qr-code">
                                    Bayar QRIS
                                </flux:button>
                            </flux:modal.trigger>
                        @endif

                        @php
                            $waMessage = urlencode("Halo Admin Samara, saya ingin menanyakan pesanan #ORD-".str_pad($order->id, 5, '0', STR_PAD_LEFT));
                            $waLink = "https://wa.me/6281234567890?text=" . $waMessage;
                        @endphp
                        <flux:button href="{{ $waLink }}" target="_blank" variant="ghost" size="sm" icon="chat-bubble-left-right">
                            CS
                        </flux:button>
                    </div>
                </flux:table.cell>
            </flux:row>
            @empty
            <flux:table.row>
                <flux:table.cell colspan="6" class="text-center py-10 text-zinc-500">
                    <div class="p-3 rounded-full bg-zinc-100 dark:bg-zinc-800 inline-block mb-2">
                        <flux:icon icon="shopping-bag" class="size-6 text-zinc-400" />
                    </div>
                    <div>Belum ada riwayat pesanan.</div>
                </flux:table.cell>
            </flux:table.row>
            @endforelse
        </flux:table.rows>
    </flux:table>
</flux:card>

@foreach($orders as $order)
    @if($order->status === \App\Enums\OrderStatus::Pending)
    <flux:modal name="payment-modal-{{ $order->id }}" class="max-w-md text-center">
        <div class="space-y-4">
            <div>
                <flux:heading size="lg">Pembayaran QRIS</flux:heading>
                <flux:subheading class="mt-1">
                    Tagihan #ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }} senilai <strong class="text-amber-600 dark:text-amber-400">Rp {{ number_format($order->amount, 0, ',', '.') }}</strong>
                </flux:subheading>
            </div>
            
            <div class="bg-white p-4 rounded-xl border border-zinc-200 dark:border-zinc-700 shadow-xs inline-block">
                <img src="https://placehold.co/300x300?text=QRIS+Samara+Invitation" alt="QRIS" class="w-56 h-56 rounded-lg mx-auto object-cover">
            </div>

            <flux:text class="text-xs text-zinc-500">
                Pindai kode QRIS menggunakan e-wallet (GoPay, OVO, Dana, ShopeePay) atau Mobile Banking (BCA, Mandiri, BRI, BNI).
            </flux:text>

            @php
                $waMessage = urlencode("Halo Admin Samara, saya ingin mengonfirmasi pembayaran untuk pesanan #ORD-".str_pad($order->id, 5, '0', STR_PAD_LEFT)." senilai Rp ".number_format($order->amount, 0, ',', '.').". Berikut adalah bukti transfer saya:");
                $waLink = "https://wa.me/6281234567890?text=" . $waMessage;
            @endphp

            <div class="space-y-2 pt-2 border-t border-zinc-200 dark:border-zinc-700">
                <flux:button href="{{ $waLink }}" target="_blank" variant="primary" class="w-full bg-[#25D366] hover:bg-[#20bd5a] text-white border-transparent" icon="chat-bubble-left-ellipsis">
                    Konfirmasi Pembayaran via WA
                </flux:button>
                <flux:modal.close>
                    <flux:button variant="outline" class="w-full">Tutup</flux:button>
                </flux:modal.close>
            </div>
        </div>
    </flux:modal>
    @endif
@endforeach
@endsection
