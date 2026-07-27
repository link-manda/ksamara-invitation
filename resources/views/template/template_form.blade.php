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
                <form action="{{ isset($template) ? route('admin.templates.update', $template->id) : route('admin.templates.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @if(isset($template))
                        @method('PUT')
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <flux:field>
                            <flux:label>Nama Template <span class="text-red-500 font-bold">*</span></flux:label>
                            <flux:input 
                                name="name" 
                                placeholder="Contoh: Elegan Gold" 
                                value="{{ old('name', $template->name ?? '') }}" 
                                required 
                            />
                            <flux:error name="name" />
                        </flux:field>

                        <flux:field>
                            <flux:label>View Path <span class="text-red-500 font-bold">*</span></flux:label>
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

                    <flux:field class="space-y-2" x-data="{
                        imageUrl: '{{ isset($template) && $template->thumbnail_url ? $template->thumbnail_url : '' }}',
                        fileChosen(event) {
                            const file = event.target.files[0];
                            if (file) {
                                this.imageUrl = URL.createObjectURL(file);
                            }
                        }
                    }">
                        <flux:label>Gambar Thumbnail Preview Template <span class="text-xs text-zinc-400 font-normal">(Opsional - Maks 2MB)</span></flux:label>
                        
                        <div class="flex flex-col sm:flex-row items-start gap-4 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700/80 bg-zinc-50/50 dark:bg-zinc-800/30">
                            <!-- Live Preview Container -->
                            <div class="w-44 h-28 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center overflow-hidden shrink-0 shadow-xs relative">
                                <template x-if="imageUrl">
                                    <img :src="imageUrl" alt="Preview Thumbnail" class="w-full h-full object-cover object-top" />
                                </template>
                                <template x-if="!imageUrl">
                                    <div class="text-center p-2 text-zinc-400 space-y-1">
                                        <flux:icon icon="photo" class="size-6 mx-auto opacity-50" />
                                        <span class="text-[10px] block">Belum Ada Gambar</span>
                                    </div>
                                </template>
                            </div>

                            <div class="flex-1 space-y-2">
                                <input 
                                    type="file" 
                                    name="thumbnail" 
                                    accept="image/png, image/jpeg, image/jpg, image/webp" 
                                    @change="fileChosen"
                                    class="block w-full text-xs text-zinc-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-amber-500/10 file:text-amber-500 hover:file:bg-amber-500/20 cursor-pointer"
                                />
                                <flux:description>Upload gambar contoh desain template. Format: JPG, PNG, WEBP. Maksimal ukuran: 2MB.</flux:description>
                                <flux:error name="thumbnail" />
                            </div>
                        </div>
                    </flux:field>

                    <flux:field class="space-y-2">
                        <div class="flex items-center justify-between">
                            <flux:label>Ketersediaan Paket Undangan</flux:label>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700/80 bg-zinc-50/50 dark:bg-zinc-800/30">
                            @foreach($packages as $package)
                                <flux:checkbox 
                                    name="packages[]" 
                                    value="{{ $package->id }}" 
                                    label="{{ $package->name }}" 
                                    :checked="in_array($package->id, old('packages', isset($template) ? $template->packages->pluck('id')->toArray() : []))"
                                />
                            @endforeach
                        </div>
                        <flux:description>Jika tidak ada paket yang dicentang, template akan otomatis berlaku untuk **Semua Paket (Universal)**.</flux:description>
                        <flux:error name="packages" />
                    </flux:field>

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
                        <strong>Thumbnail Preview</strong> digunakan untuk memberikan contoh visual desain template pada halaman Landing Page publik.
                    </p>
                </flux:text>
            </flux:card>
        </div>
    </div>
@endsection
