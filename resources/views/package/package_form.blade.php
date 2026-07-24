@extends('layouts.admin')

@section('content')
    <div class="mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('admin.packages.index') }}">Paket</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ isset($package) ? 'Edit Paket' : 'Tambah Paket' }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <flux:heading size="xl" level="1" class="mt-4">{{ isset($package) ? 'Edit Paket' : 'Tambah Paket' }}</flux:heading>
        <flux:subheading>Kelola tingkat layanan, harga, serta pembatasan kuota foto dan musik latar.</flux:subheading>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <flux:card>
                <form action="{{ isset($package) ? route('admin.packages.update', $package->id) : route('admin.packages.store') }}" method="POST" class="space-y-6">
                    @csrf
                    @if(isset($package))
                        @method('PUT')
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <flux:field>
                            <flux:label>Nama Paket</flux:label>
                            <flux:input 
                                name="name" 
                                placeholder="Contoh: Paket Premium" 
                                value="{{ old('name', $package->name ?? '') }}" 
                                required 
                            />
                            <flux:error name="name" />
                        </flux:field>

                        <flux:field>
                            <flux:label>Harga (Rp)</flux:label>
                            <flux:input 
                                name="price" 
                                type="number" 
                                placeholder="Contoh: 150000" 
                                value="{{ old('price', $package->price ?? '') }}" 
                                required 
                            />
                            <flux:error name="price" />
                        </flux:field>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <flux:field>
                            <flux:label>Maksimal Foto Galeri</flux:label>
                            <flux:input 
                                name="max_photos" 
                                type="number" 
                                placeholder="0 untuk unlimited" 
                                value="{{ old('max_photos', $package->max_photos ?? 0) }}" 
                                required 
                            />
                            <flux:description>Isi 0 jika tidak ada batasan kuota foto.</flux:description>
                            <flux:error name="max_photos" />
                        </flux:field>

                        <flux:field>
                            <flux:label>Fitur Paket (Pisahkan per baris)</flux:label>
                            <flux:textarea 
                                name="features" 
                                placeholder="RSVP Online&#10;Galeri Foto&#10;Amplop Digital" 
                                rows="4"
                            >{{ old('features', isset($package) && is_array($package->features) ? implode("\n", $package->features) : (isset($package) && is_string($package->features) ? $package->features : '')) }}</flux:textarea>
                            <flux:error name="features" />
                        </flux:field>
                    </div>

                    @php
                        $isActive = session()->hasOldInput() 
                            ? (bool) old('is_active') 
                            : (bool) ($package->is_active ?? true);

                        $enableBgm = session()->hasOldInput() 
                            ? (bool) old('enable_bgm') 
                            : (bool) ($package->enable_bgm ?? false);
                    @endphp

                    <div class="p-4 rounded-xl border border-zinc-200 dark:border-zinc-700/80 bg-zinc-50/60 dark:bg-zinc-800/40 space-y-4">
                        <flux:checkbox 
                            name="is_active" 
                            label="Aktifkan Paket Ini?" 
                            description="Paket yang aktif dapat dibeli oleh pelanggan."
                            value="1" 
                            :checked="$isActive"
                        />

                        <flux:separator />

                        <flux:checkbox 
                            name="enable_bgm" 
                            label="Izinkan BGM (Background Music)?" 
                            description="Mengaktifkan fitur pilihan lagu latar pada undangan kustomer."
                            value="1" 
                            :checked="$enableBgm"
                        />
                    </div>

                    <div class="pt-4 border-t border-zinc-200 dark:border-zinc-700 flex items-center justify-end gap-3">
                        <flux:button href="{{ route('admin.packages.index') }}" variant="outline">Batal</flux:button>
                        <flux:button type="submit" variant="primary" icon="check">Simpan Paket</flux:button>
                    </div>
                </form>
            </flux:card>
        </div>

        <div class="space-y-6">
            <flux:card>
                <div class="flex items-center gap-2 mb-3">
                    <flux:icon icon="sparkles" class="text-amber-500 size-5" />
                    <flux:heading size="lg">Informasi Paket</flux:heading>
                </div>
                <flux:text class="text-sm space-y-3 leading-relaxed">
                    <p>
                        <strong>Maksimal Foto Galeri</strong> membatasi jumlah unggahan gambar yang dapat disimpan oleh kustomer pada modul galeri.
                    </p>
                    <p>
                        <strong>Fitur Musik Latar (BGM)</strong> mengontrol ketersediaan pemutar lagu latar pada form builder kustomer.
                    </p>
                </flux:text>
            </flux:card>
        </div>
    </div>
@endsection
