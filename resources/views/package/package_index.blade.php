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
                <flux:table.column>Aksi</flux:table.column>
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
                        <flux:table.cell>
                            <div class="flex items-center space-x-2">
                                <flux:button href="{{ route('admin.packages.edit', $package->id) }}" size="sm" variant="outline">Edit</flux:button>
                                <flux:modal.trigger name="delete-package-{{ $package->id }}">
                                    <flux:button size="sm" variant="danger">Hapus</flux:button>
                                </flux:modal.trigger>
                                <x-confirm-delete-modal
                                    name="delete-package-{{ $package->id }}"
                                    :action="route('admin.packages.destroy', $package->id)"
                                    heading="Hapus paket ini?"
                                    :text="'Paket \''.$package->name.'\' akan dihapus permanen.'"
                                />
                            </div>
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
