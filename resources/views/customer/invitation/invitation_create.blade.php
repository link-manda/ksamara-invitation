@extends('layouts.customer')

@section('content')
<div class="mb-6">
    <flux:heading size="xl" level="1">{{ __('Buat Undangan Baru') }}</flux:heading>
    <flux:subheading>Silakan pilih paket, template, dan isi data dasar pasangan mempelai.</flux:subheading>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6" x-data="{
    groom: '{{ old('groom_name', '') }}',
    bride: '{{ old('bride_name', '') }}',
    slug: '{{ old('slug', '') }}'
}">
    <div class="lg:col-span-2">
        <flux:card>
            <form action="{{ route('customer.invitations.store') }}" method="POST" class="flex flex-col gap-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <flux:field>
                        <flux:label>Pilih Paket Undangan</flux:label>
                        <flux:select name="package_id" placeholder="Pilih paket undangan" required>
                            @foreach($packages as $package)
                                <flux:select.option value="{{ $package->id }}">{{ $package->name }} - Rp {{ number_format($package->price, 0, ',', '.') }}</flux:select.option>
                            @endforeach
                        </flux:select>
                        <flux:error name="package_id" />
                    </flux:field>

                    <flux:field>
                        <flux:label>Pilih Desain Template</flux:label>
                        <flux:select name="template_id" placeholder="Pilih desain template" required>
                            @foreach($templates as $template)
                                <flux:select.option value="{{ $template->id }}">{{ $template->name }}</flux:select.option>
                            @endforeach
                        </flux:select>
                        <flux:error name="template_id" />
                    </flux:field>
                </div>

                <flux:field>
                    <flux:label>URL Undangan (Slug)</flux:label>
                    <flux:input 
                        name="slug" 
                        placeholder="Contoh: romeo-juliet" 
                        x-model="slug"
                        required 
                    />
                    <flux:description>URL unik undangan Anda. Contoh: {{ config('app.url') }}/<span x-text="slug || 'slug-undangan'" class="font-semibold text-amber-600 dark:text-amber-400"></span></flux:description>
                    <flux:error name="slug" />
                </flux:field>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <flux:field>
                        <flux:label>Nama Mempelai Pria</flux:label>
                        <flux:input 
                            name="groom_name" 
                            placeholder="Contoh: Romeo" 
                            x-model="groom"
                            required 
                        />
                        <flux:error name="groom_name" />
                    </flux:field>
                    
                    <flux:field>
                        <flux:label>Nama Mempelai Wanita</flux:label>
                        <flux:input 
                            name="bride_name" 
                            placeholder="Contoh: Juliet" 
                            x-model="bride"
                            required 
                        />
                        <flux:error name="bride_name" />
                    </flux:field>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                    <flux:button href="{{ route('dashboard') }}" variant="outline">Batal</flux:button>
                    <flux:button type="submit" variant="primary" icon="check">Buat Pesanan & Undangan</flux:button>
                </div>
            </form>
        </flux:card>
    </div>

    <div class="space-y-6">
        <flux:card class="border-amber-200/60 dark:border-amber-900/40 bg-linear-to-br from-amber-50/50 to-orange-50/30 dark:from-zinc-900 dark:to-zinc-900/90">
            <div class="flex items-center gap-2 mb-4">
                <flux:icon icon="sparkles" class="text-amber-500 size-5" />
                <flux:heading size="lg">Preview Undangan</flux:heading>
            </div>
            
            <div class="space-y-4">
                <div class="p-4 rounded-xl bg-white dark:bg-zinc-800/80 border border-zinc-200 dark:border-zinc-700 text-center shadow-xs">
                    <div class="text-xs uppercase tracking-wider text-amber-600 dark:text-amber-400 font-semibold mb-1">Judul Undangan</div>
                    <div class="text-lg font-bold text-zinc-900 dark:text-white" x-text="(groom && bride) ? ('Pernikahan ' + groom + ' & ' + bride) : 'Pernikahan Mempelai Pria & Wanita'"></div>
                    <div class="text-xs text-zinc-500 mt-2 font-mono" x-text="slug ? ('/' + slug) : '/slug-undangan'"></div>
                </div>

                <flux:text class="text-xs space-y-2 leading-relaxed text-zinc-600 dark:text-zinc-400">
                    <p class="flex items-start gap-1.5">
                        <flux:icon icon="light-bulb" class="size-4 text-amber-500 shrink-0 mt-0.5" />
                        <span><strong>Langkah Selanjutnya:</strong> Setelah membuat undangan, Anda dapat melengkapi informasi resepsi, galeri foto, musik latar, serta amplop digital di halaman edit undangan.</span>
                    </p>
                    <p class="flex items-start gap-1.5">
                        <flux:icon icon="credit-card" class="size-4 text-amber-500 shrink-0 mt-0.5" />
                        <span>Pesanan akan otomatis dibuat dalam status <em>Pending</em> dan dapat dilunasi kapan saja melalui menu <strong>Pesanan Saya</strong>.</span>
                    </p>
                </flux:text>
            </div>
        </flux:card>
    </div>
</div>
@endsection
