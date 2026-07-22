@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <flux:heading size="xl">{{ __('Daftar Template') }}</flux:heading>
        <flux:subheading>Kelola desain template undangan yang tersedia.</flux:subheading>
    </div>
    <flux:button href="{{ route('admin.templates.create') }}" variant="primary" icon="plus">Tambah Template</flux:button>
</div>

<flux:card>
    <flux:table>
        <flux:table.columns>
            <flux:table.column>Nama Template</flux:table.column>
            <flux:table.column>View Path</flux:table.column>
            <flux:table.column>Status</flux:table.column>
            <flux:table.column>Aksi</flux:table.column>
        </flux:table.columns>
        <flux:table.rows>
            @foreach($templates as $template)
            <flux:table.row>
                <flux:table.cell>
                    <span class="font-medium text-zinc-900 dark:text-white">{{ $template->name }}</span>
                </flux:table.cell>
                <flux:table.cell>
                    <flux:badge size="sm" color="zinc">{{ $template->view_path }}</flux:badge>
                </flux:table.cell>
                <flux:table.cell>
                    @if($template->is_active)
                        <flux:badge color="green" size="sm">Aktif</flux:badge>
                    @else
                        <flux:badge color="red" size="sm">Tidak Aktif</flux:badge>
                    @endif
                </flux:table.cell>
                <flux:table.cell>
                    <div class="flex gap-2">
                        <flux:button href="{{ route('admin.templates.edit', $template->id) }}" size="sm" variant="ghost" icon="pencil-square" />
                        <flux:modal.trigger name="delete-template-{{ $template->id }}">
                            <flux:button size="sm" variant="ghost" color="danger" icon="trash" />
                        </flux:modal.trigger>
                        <x-confirm-delete-modal
                            name="delete-template-{{ $template->id }}"
                            :action="route('admin.templates.destroy', $template->id)"
                            heading="Hapus template ini?"
                            :text="'Template \''.$template->name.'\' akan dihapus permanen.'"
                        />
                    </div>
                </flux:table.cell>
            </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</flux:card>
@endsection
