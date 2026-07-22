@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <flux:heading size="xl">{{ __('Daftar Pelanggan') }}</flux:heading>
        <flux:subheading>Kelola data pelanggan yang terdaftar di sistem.</flux:subheading>
    </div>
    <flux:button href="{{ route('admin.users.create') }}" variant="primary" icon="plus">Tambah Pelanggan</flux:button>
</div>

<flux:card>
    <flux:table>
        <flux:table.columns>
            <flux:table.column>Nama</flux:table.column>
            <flux:table.column>Email</flux:table.column>
            <flux:table.column>No. HP</flux:table.column>
            <flux:table.column>Tanggal Daftar</flux:table.column>
            <flux:table.column>Aksi</flux:table.column>
        </flux:table.columns>
        <flux:table.rows>
            @foreach($users as $user)
            <flux:table.row>
                <flux:table.cell>
                    <span class="font-medium text-zinc-900 dark:text-white">{{ $user->name }}</span>
                </flux:table.cell>
                <flux:table.cell>{{ $user->email }}</flux:table.cell>
                <flux:table.cell>{{ $user->phone_number ?? '-' }}</flux:table.cell>
                <flux:table.cell>{{ $user->created_at->format('d M Y') }}</flux:table.cell>
                <flux:table.cell>
                    <div class="flex gap-2">
                        <flux:button href="{{ route('admin.users.edit', $user->id) }}" size="sm" variant="ghost" icon="pencil-square" />
                        <flux:modal.trigger name="delete-user-{{ $user->id }}">
                            <flux:button size="sm" variant="ghost" color="danger" icon="trash" />
                        </flux:modal.trigger>
                        <x-confirm-delete-modal
                            name="delete-user-{{ $user->id }}"
                            :action="route('admin.users.destroy', $user->id)"
                            heading="Hapus pelanggan ini?"
                            :text="'Data pelanggan \''.$user->name.'\' akan dihapus permanen.'"
                        />
                    </div>
                </flux:table.cell>
            </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</flux:card>
@endsection
