@extends('layouts.admin')

@section('content')
    <div class="mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('admin.templates.index') }}">Template</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ isset($template) ? 'Edit Template' : 'Tambah Template' }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <flux:heading size="xl" level="1" class="mt-4">{{ isset($template) ? 'Edit Template' : 'Tambah Template' }}</flux:heading>
        <flux:subheading>Kelola dan konfigurasi desain template undangan digital di sistem.</flux:subheading>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <flux:card>
                <form action="{{ isset($template) ? route('admin.templates.update', $template->id) : route('admin.templates.store') }}" method="POST" class="space-y-6">
                    @csrf
                    @if(isset($template))
                        @method('PUT')
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <flux:field>
                            <flux:label>Nama Template</flux:label>
                            <flux:input 
                                name="name" 
                                placeholder="Contoh: Elegan Gold" 
                                value="{{ old('name', $template->name ?? '') }}" 
                                required 
                            />
                            <flux:error name="name" />
                        </flux:field>

                        <flux:field>
                            <flux:label>View Path</flux:label>
                            <flux:input 
                                name="view_path" 
                                placeholder="Contoh: themes.elegan_gold" 
                                value="{{ old('view_path', $template->view_path ?? '') }}" 
                                required 
                            />
                            <flux:description>Format dot notation (folder.filename).</flux:description>
                            <flux:error name="view_path" />
                        </flux:field>
                    </div>

                    <div class="p-4 rounded-xl border border-zinc-200 dark:border-zinc-700/80 bg-zinc-50/60 dark:bg-zinc-800/40">
                        <flux:checkbox 
                            name="is_active" 
                            label="Aktifkan Template Ini" 
                            description="Template yang aktif dapat dipilih kustomer saat membuat undangan."
                            value="1"
                            :checked="old('is_active', $template->is_active ?? true)"
                        />
                    </div>

                    <div class="pt-4 border-t border-zinc-200 dark:border-zinc-700 flex items-center justify-end gap-3">
                        <flux:button href="{{ route('admin.templates.index') }}" variant="outline">Batal</flux:button>
                        <flux:button type="submit" variant="primary" icon="check">Simpan Template</flux:button>
                    </div>
                </form>
            </flux:card>
        </div>

        <div class="space-y-6">
            <flux:card>
                <div class="flex items-center gap-2 mb-3">
                    <flux:icon icon="information-circle" class="text-amber-500 size-5" />
                    <flux:heading size="lg">Panduan Template</flux:heading>
                </div>
                <flux:text class="text-sm space-y-3 leading-relaxed">
                    <p>
                        <strong>View Path</strong> menentukan lokasi file Blade yang digunakan untuk merender tampilan undangan kustomer.
                    </p>
                    <p class="text-xs bg-zinc-100 dark:bg-zinc-800 p-2.5 rounded-lg border border-zinc-200 dark:border-zinc-700 font-mono text-amber-600 dark:text-amber-400">
                        resources/views/templates/bali_classic.blade.php &rarr; themes.bali_classic
                    </p>
                    <p>
                        Pastikan file Blade sudah tersedia di direktori <code>resources/views/</code> sebelum mengaktifkan template ini.
                    </p>
                </flux:text>
            </flux:card>
        </div>
    </div>
@endsection
