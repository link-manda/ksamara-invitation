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
            <flux:table.column>Paket Terkait</flux:table.column>
            <flux:table.column>Status</flux:table.column>
            <flux:table.column align="center">Aksi</flux:table.column>
        </flux:table.columns>
        <flux:table.rows>
            @foreach($templates as $template)
            <flux:table.row>
                <flux:table.cell>
                    <div class="flex items-center gap-3">
                        @if($template->thumbnail_url)
                            <img src="{{ $template->thumbnail_url }}" alt="{{ $template->name }}" class="w-10 h-10 rounded-lg object-cover object-top border border-zinc-200 dark:border-zinc-700 shrink-0 shadow-xs" />
                        @else
                            <div class="w-10 h-10 rounded-lg bg-zinc-100 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 flex items-center justify-center text-zinc-400 shrink-0">
                                <flux:icon icon="photo" class="size-5 opacity-60" />
                            </div>
                        @endif
                        <span class="font-medium text-zinc-900 dark:text-white">{{ $template->name }}</span>
                    </div>
                </flux:table.cell>
                <flux:table.cell>
                    <flux:badge size="sm" color="zinc">{{ $template->view_path }}</flux:badge>
                </flux:table.cell>
                <flux:table.cell>
                    <div class="flex flex-wrap gap-1">
                        @forelse($template->packages as $pkg)
                            <flux:badge size="sm" color="amber">{{ $pkg->name }}</flux:badge>
                        @empty
                            <flux:badge size="sm" color="zinc">Semua Paket</flux:badge>
                        @endforelse
                    </div>
                </flux:table.cell>
                <flux:table.cell>
                    @if($template->is_active)
                        <flux:badge color="green" size="sm">Aktif</flux:badge>
                    @else
                        <flux:badge color="red" size="sm">Tidak Aktif</flux:badge>
                    @endif
                </flux:table.cell>
                <flux:table.cell align="center">
                    <flux:dropdown align="end">
                        <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom" aria-label="Aksi" />
                        <flux:menu>
                            <flux:menu.item icon="pencil-square" href="{{ route('admin.templates.edit', $template->id) }}">
                                Edit Template
                            </flux:menu.item>
                            <flux:menu.separator />
                            <flux:menu.item 
                                as="button" 
                                type="button" 
                                icon="trash" 
                                variant="danger" 
                                x-data 
                                @click="$dispatch('open-delete-modal', { 
                                    action: '{{ route('admin.templates.destroy', $template->id) }}', 
                                    title: 'Hapus Template', 
                                    message: 'Apakah Anda yakin ingin menghapus template {{ $template->name }}?' 
                                })"
                            >
                                Hapus Template
                            </flux:menu.item>
                        </flux:menu>
                    </flux:dropdown>
                </flux:table.cell>
            </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</flux:card>
@endsection
