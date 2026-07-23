@extends('layouts.admin')

@section('content')
    <div class="mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('admin.packages.index') }}">Paket</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ isset($package) ? 'Edit Paket' : 'Tambah Paket' }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <flux:heading size="xl" level="1" class="mt-4">{{ isset($package) ? 'Edit Paket' : 'Tambah Paket' }}</flux:heading>
        <flux:subheading>Lengkapi form di bawah ini untuk {{ isset($package) ? 'mengubah' : 'menambahkan' }} paket undangan.</flux:subheading>
    </div>

    <flux:card>
        <form action="{{ isset($package) ? route('admin.packages.update', $package->id) : route('admin.packages.store') }}" method="POST">
            @csrf
            @if(isset($package))
                @method('PUT')
            @endif

            <div class="space-y-6">
                <flux:input 
                    name="name" 
                    label="Nama Paket" 
                    placeholder="Contoh: Paket Premium" 
                    value="{{ old('name', $package->name ?? '') }}" 
                    required 
                />

                <flux:input 
                    name="price" 
                    type="number" 
                    label="Harga (Rp)" 
                    placeholder="Contoh: 150000" 
                    value="{{ old('price', $package->price ?? '') }}" 
                    required 
                />

                <flux:textarea 
                    name="features" 
                    label="Fitur (Pisahkan dengan baris baru)" 
                    placeholder="RSVP&#10;Galeri Foto&#10;Buku Tamu" 
                    rows="5"
                >{{ old('features', isset($package) && is_array($package->features) ? implode("\n", $package->features) : (isset($package) && is_string($package->features) ? $package->features : '')) }}</flux:textarea>

                <flux:input 
                    name="max_photos" 
                    type="number" 
                    label="Maksimal Foto Galeri" 
                    value="{{ old('max_photos', $package->max_photos ?? 0) }}" 
                    required 
                />

                @php
                    $isActive = session()->hasOldInput() 
                        ? (bool) old('is_active') 
                        : (bool) ($package->is_active ?? true);

                    $enableBgm = session()->hasOldInput() 
                        ? (bool) old('enable_bgm') 
                        : (bool) ($package->enable_bgm ?? false);
                @endphp

                <flux:checkbox 
                    name="is_active" 
                    label="Aktifkan paket ini?" 
                    value="1" 
                    :checked="$isActive"
                />

                <flux:checkbox 
                    name="enable_bgm" 
                    label="Izinkan BGM (Background Music)?" 
                    value="1" 
                    :checked="$enableBgm"
                />
            </div>

            <div class="flex mt-6 space-x-2">
                <flux:button type="submit" variant="primary">Simpan</flux:button>
                <flux:button href="{{ route('admin.packages.index') }}" variant="outline">Batal</flux:button>
            </div>
        </form>
    </flux:card>
@endsection
