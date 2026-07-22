@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <flux:heading size="xl">{{ isset($user) ? 'Edit Pelanggan' : 'Tambah Pelanggan' }}</flux:heading>
    <flux:subheading>Lengkapi form di bawah ini untuk menyimpan data pelanggan.</flux:subheading>
</div>

<flux:card class="max-w-2xl">
    <form action="{{ isset($user) ? route('admin.users.update', $user->id) : route('admin.users.store') }}" method="POST" class="flex flex-col gap-6">
        @csrf
        @if(isset($user))
            @method('PUT')
        @endif

        <flux:input 
            name="name" 
            label="Nama Lengkap" 
            placeholder="Contoh: Budi Santoso" 
            value="{{ old('name', $user->name ?? '') }}" 
            required 
        />

        <flux:input 
            type="email"
            name="email" 
            label="Alamat Email" 
            placeholder="Contoh: budi@example.com" 
            value="{{ old('email', $user->email ?? '') }}" 
            required 
        />

        <flux:input 
            name="phone_number" 
            label="Nomor HP/WhatsApp" 
            placeholder="Contoh: 08123456789" 
            value="{{ old('phone_number', $user->phone_number ?? '') }}" 
        />

        <div class="space-y-3">
            <flux:heading size="lg">Pengaturan Password</flux:heading>
            <flux:subheading>Biarkan kosong jika tidak ingin mengubah password. (Default: password123 jika membuat pelanggan baru)</flux:subheading>
            
            <flux:input 
                type="password"
                name="password" 
                label="Password Baru" 
                placeholder="********" 
            />

            <flux:input 
                type="password"
                name="password_confirmation" 
                label="Konfirmasi Password" 
                placeholder="********" 
            />
        </div>

        <div class="flex gap-2 pt-4 border-t border-zinc-200 dark:border-zinc-700">
            <flux:button type="submit" variant="primary">Simpan</flux:button>
            <flux:button href="{{ route('admin.users.index') }}">Batal</flux:button>
        </div>
    </form>
</flux:card>
@endsection
