@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <flux:heading size="xl">Manajemen Pesanan</flux:heading>
    <flux:subheading>Pantau dan kelola seluruh transaksi keuangan dari pelanggan.</flux:subheading>
</div>

<flux:card>
    <flux:table>
        <flux:table.columns>
            <flux:table.column>ID Pesanan</flux:table.column>
            <flux:table.column>Pelanggan</flux:table.column>
            <flux:table.column>Paket</flux:table.column>
            <flux:table.column>Tagihan</flux:table.column>
            <flux:table.column>Status</flux:table.column>
            <flux:table.column>Aksi</flux:table.column>
        </flux:table.columns>
        <flux:table.rows>
            @forelse($orders as $order)
            <flux:table.row>
                <flux:table.cell>
                    <span class="font-medium text-slate-900 dark:text-white">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                </flux:table.cell>
                <flux:table.cell>
                    <div>{{ $order->user->name }}</div>
                    <div class="text-xs text-slate-500">{{ $order->user->email }}</div>
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
                <flux:table.cell>
                    @if($order->status === \App\Enums\OrderStatus::Pending)
                        <form action="{{ route('admin.orders.mark-paid', $order->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <flux:button type="submit" size="sm" variant="outline" icon="check-circle" class="text-green-600 hover:text-green-700">Tandai Lunas</flux:button>
                        </form>
                    @else
                        <span class="text-slate-400 text-sm">Selesai</span>
                    @endif
                </flux:table.cell>
            </flux:table.row>
            @empty
            <flux:table.row>
                <flux:table.cell colspan="6" class="text-center py-6 text-slate-500">Tidak ada pesanan.</flux:table.cell>
            </flux:table.row>
            @endforelse
        </flux:table.rows>
    </flux:table>
</flux:card>
@endsection
