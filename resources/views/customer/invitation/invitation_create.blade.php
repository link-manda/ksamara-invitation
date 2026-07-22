@extends('layouts.customer')

@section('content')
<div class="mb-6">
    <flux:heading size="xl">{{ __('Buat Undangan Baru') }}</flux:heading>
    <flux:subheading>Silakan pilih paket, template, dan isi data dasar mempelai.</flux:subheading>
</div>

<flux:card class="max-w-2xl">
    <form action="{{ route('customer.invitations.store') }}" method="POST" class="flex flex-col gap-6">
        @csrf
        
        <flux:select name="package_id" label="Pilih Paket" placeholder="Pilih paket undangan" required>
            @foreach($packages as $package)
                <flux:select.option value="{{ $package->id }}">{{ $package->name }} - Rp {{ number_format($package->price, 0, ',', '.') }}</flux:select.option>
            @endforeach
        </flux:select>

        <flux:select name="template_id" label="Pilih Template" placeholder="Pilih desain template" required>
            @foreach($templates as $template)
                <flux:select.option value="{{ $template->id }}">{{ $template->name }}</flux:select.option>
            @endforeach
        </flux:select>

        <flux:input 
            name="slug" 
            label="URL Undangan (Slug)" 
            placeholder="Contoh: romeo-juliet" 
            description="URL akan menjadi: ksamara.com/invitation/romeo-juliet"
            value="{{ old('slug') }}" 
            required 
        />

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <flux:input 
                name="groom_name" 
                label="Nama Mempelai Pria" 
                placeholder="Contoh: Romeo" 
                value="{{ old('groom_name') }}" 
                required 
            />
            
            <flux:input 
                name="bride_name" 
                label="Nama Mempelai Wanita" 
                placeholder="Contoh: Juliet" 
                value="{{ old('bride_name') }}" 
                required 
            />
        </div>

        <div class="flex gap-2 pt-4 border-t border-zinc-200 dark:border-zinc-700">
            <flux:button type="submit" variant="primary">Buat Pesanan & Undangan</flux:button>
            <flux:button href="{{ route('dashboard') }}">Batal</flux:button>
        </div>
    </form>
</flux:card>
@endsection
