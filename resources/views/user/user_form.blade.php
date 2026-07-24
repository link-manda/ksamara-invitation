@extends('layouts.admin')

@section('content')
    <div class="mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('admin.users.index') }}">Pelanggan</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>{{ isset($user) ? 'Edit Pelanggan' : 'Tambah Pelanggan' }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <flux:heading size="xl" level="1" class="mt-4">{{ isset($user) ? 'Edit Pelanggan' : 'Tambah Pelanggan' }}</flux:heading>
        <flux:subheading>Kelola data kredensial dan informasi kontak pelanggan.</flux:subheading>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <flux:card>
                <form action="{{ isset($user) ? route('admin.users.update', $user->id) : route('admin.users.store') }}" method="POST" class="space-y-6">
                    @csrf
                    @if(isset($user))
                        @method('PUT')
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <flux:field>
                            <flux:label>Nama Lengkap</flux:label>
                            <flux:input 
                                name="name" 
                                placeholder="Contoh: Budi Santoso" 
                                value="{{ old('name', $user->name ?? '') }}" 
                                required 
                            />
                            <flux:error name="name" />
                        </flux:field>

                        <flux:field>
                            <flux:label>Alamat Email</flux:label>
                            <flux:input 
                                type="email"
                                name="email" 
                                placeholder="Contoh: budi@example.com" 
                                value="{{ old('email', $user->email ?? '') }}" 
                                required 
                            />
                            <flux:error name="email" />
                        </flux:field>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <flux:field>
                            <flux:label>Nomor HP / WhatsApp</flux:label>
                            <flux:input 
                                name="phone_number" 
                                placeholder="Contoh: 08123456789" 
                                value="{{ old('phone_number', $user->phone_number ?? '') }}" 
                            />
                            <flux:description>Gunakan format angka tanpa tanda plus (+) atau strip (-).</flux:description>
                            <flux:error name="phone_number" />
                        </flux:field>
                    </div>

                    <div class="p-5 rounded-xl border border-zinc-200 dark:border-zinc-700/80 bg-zinc-50/60 dark:bg-zinc-800/40 space-y-4">
                        <div>
                            <flux:heading size="lg">Pengaturan Kata Sandi</flux:heading>
                            <flux:subheading>Biarkan kosong jika tidak ingin mengubah kata sandi.</flux:subheading>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <flux:field>
                                <flux:label>Password Baru</flux:label>
                                <flux:input 
                                    type="password"
                                    name="password" 
                                    placeholder="Minimal 8 karakter" 
                                />
                                <flux:error name="password" />
                            </flux:field>

                            <flux:field>
                                <flux:label>Konfirmasi Password</flux:label>
                                <flux:input 
                                    type="password"
                                    name="password_confirmation" 
                                    placeholder="Ulangi password baru" 
                                />
                                <flux:error name="password_confirmation" />
                            </flux:field>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-zinc-200 dark:border-zinc-700 flex items-center justify-end gap-3">
                        <flux:button href="{{ route('admin.users.index') }}" variant="outline">Batal</flux:button>
                        <flux:button type="submit" variant="primary" icon="check">Simpan Pelanggan</flux:button>
                    </div>
                </form>
            </flux:card>
        </div>

        <div class="space-y-6">
            <flux:card>
                <div class="flex items-center gap-2 mb-3">
                    <flux:icon icon="user-circle" class="text-amber-500 size-5" />
                    <flux:heading size="lg">Informasi Akun</flux:heading>
                </div>
                <flux:text class="text-sm space-y-3 leading-relaxed">
                    <p>
                        Pengguna yang dibuat oleh Admin secara otomatis mendapatkan akun kustomer terverifikasi.
                    </p>
                    <p>
                        Kata sandi default untuk akun pelanggan baru adalah <code>password123</code> jika bidang password dikosongkan.
                    </p>
                </flux:text>
            </flux:card>
        </div>
    </div>
@endsection
