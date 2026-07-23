@extends('layouts.admin')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <flux:heading size="xl" level="1">Manajemen Paket</flux:heading>
            <flux:subheading>Daftar semua paket undangan yang tersedia.</flux:subheading>
        </div>
        <flux:button href="{{ route('admin.packages.create') }}" variant="primary" icon="plus">Tambah Paket</flux:button>
    </div>

    <flux:card>
        <flux:table>
            <flux:table.columns>
                <flux:table.column>ID</flux:table.column>
                <flux:table.column>Nama Paket</flux:table.column>
                <flux:table.column>Harga</flux:table.column>
                <flux:table.column>Status</flux:table.column>
                <flux:table.column align="center">Aksi</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse ($packages as $package)
                    <flux:table.row>
                        <flux:table.cell>{{ $package->id }}</flux:table.cell>
                        <flux:table.cell>{{ $package->name }}</flux:table.cell>
                        <flux:table.cell>Rp {{ number_format($package->price, 0, ',', '.') }}</flux:table.cell>
                        <flux:table.cell>
                            @if ($package->is_active)
                                <flux:badge color="green" size="sm">Aktif</flux:badge>
                            @else
                                <flux:badge color="zinc" size="sm">Non-aktif</flux:badge>
                            @endif
                        </flux:table.cell>
                        <flux:table.cell align="center">
                            <flux:dropdown align="end">
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom" aria-label="Aksi" />
                                <flux:menu>
                                    <flux:menu.item icon="pencil-square" href="{{ route('admin.packages.edit', $package->id) }}">
                                        Edit Paket
                                    </flux:menu.item>
                                    <flux:menu.separator />
                                    <form action="{{ route('admin.packages.destroy', $package->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus paket ini?');" class="w-full">
                                        @csrf
                                        @method('DELETE')
                                        <flux:menu.item type="submit" icon="trash" variant="danger">
                                            Hapus Paket
                                        </flux:menu.item>
                                    </form>
                                </flux:menu>
                            </flux:dropdown>
                        </flux:table.cell>
                    </flux:table.row>
                @empty
                    <flux:table.row>
                        <flux:table.cell colspan="5" class="text-center text-zinc-500">Belum ada paket yang ditambahkan.</flux:table.cell>
                    </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>
    </flux:card>
@endsection
