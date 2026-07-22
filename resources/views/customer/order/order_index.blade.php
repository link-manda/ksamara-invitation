@extends('layouts.customer')

@section('content')
<div class="mb-6">
    <flux:heading size="xl">Pesanan Saya</flux:heading>
    <flux:subheading>Riwayat pesanan dan tagihan undangan digital Anda.</flux:subheading>
</div>

<flux:card>
    <flux:table>
        <flux:table.columns>
            <flux:table.column>ID Pesanan</flux:table.column>
            <flux:table.column>Paket</flux:table.column>
            <flux:table.column>Total Tagihan</flux:table.column>
            <flux:table.column>Status</flux:table.column>
            <flux:table.column>Tanggal</flux:table.column>
            <flux:table.column>Aksi</flux:table.column>
        </flux:table.columns>
        <flux:table.rows>
            @forelse($orders as $order)
            <flux:table.row>
                <flux:table.cell>
                    <span class="font-medium">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                </flux:table.cell>
                <flux:table.cell>{{ $order->package->name }}</flux:table.cell>
                <flux:table.cell>Rp {{ number_format($order->amount, 0, ',', '.') }}</flux:table.cell>
                <flux:table.cell>
                    @if($order->status === \App\Enums\OrderStatus::Paid)
                        <flux:badge color="success">Lunas</flux:badge>
                    @elseif($order->status === \App\Enums\OrderStatus::Pending)
                        <flux:badge color="warning">Pending</flux:badge>
                    @else
                        <flux:badge color="danger">Batal</flux:badge>
                    @endif
                </flux:table.cell>
                <flux:table.cell>{{ $order->created_at->format('d M Y') }}</flux:table.cell>
                <flux:table.cell>
                    @if($order->status === \App\Enums\OrderStatus::Pending)
                        <flux:modal.trigger name="payment-modal-{{ $order->id }}">
                            <flux:button size="sm" variant="primary" icon="qr-code">Bayar Sekarang</flux:button>
                        </flux:modal.trigger>
                    @else
                        <span class="text-slate-400 text-sm">Selesai</span>
                    @endif
                </flux:table.cell>
            </flux:table.row>
            @empty
            <flux:table.row>
                <flux:table.cell colspan="6" class="text-center py-6 text-slate-500">Belum ada riwayat pesanan.</flux:table.cell>
            </flux:table.row>
            @endforelse
        </flux:table.rows>
    </flux:table>
</flux:card>

@foreach($orders as $order)
    @if($order->status === \App\Enums\OrderStatus::Pending)
    <flux:modal name="payment-modal-{{ $order->id }}" class="max-w-sm text-center">
        <flux:heading size="lg" class="mb-2">Pembayaran QRIS</flux:heading>
        <flux:subheading class="mb-4">Silakan pindai kode QRIS di bawah ini untuk melakukan pembayaran senilai <strong class="text-slate-900 dark:text-white">Rp {{ number_format($order->amount, 0, ',', '.') }}</strong>.</flux:subheading>
        
        <div class="bg-gray-100 p-4 rounded-xl mb-6 inline-block w-full">
            <img src="https://placehold.co/300x300?text=QRIS+Placeholder" alt="QRIS" class="w-full h-auto rounded-lg mx-auto">
        </div>

        @php
            $waMessage = urlencode("Halo Admin Samara, saya ingin mengonfirmasi pembayaran untuk pesanan #ORD-".str_pad($order->id, 5, '0', STR_PAD_LEFT)." senilai Rp ".number_format($order->amount, 0, ',', '.').". Berikut adalah bukti transfer saya:");
            $waLink = "https://wa.me/6281234567890?text=" . $waMessage;
        @endphp

        <div class="space-y-3">
            <flux:button href="{{ $waLink }}" target="_blank" variant="primary" class="w-full bg-[#25D366] hover:bg-[#20bd5a] text-white border-transparent" icon="chat-bubble-left-ellipsis">Konfirmasi via WhatsApp</flux:button>
            <flux:modal.close>
                <flux:button variant="ghost" class="w-full">Tutup</flux:button>
            </flux:modal.close>
        </div>
    </flux:modal>
    @endif
@endforeach
@endsection
