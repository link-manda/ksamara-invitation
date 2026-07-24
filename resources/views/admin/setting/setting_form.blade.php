@extends('layouts.admin')

@section('content')
    <div class="mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('admin.dashboard') }}">Admin</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Pengaturan Sistem</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <flux:heading size="xl" level="1" class="mt-4">Pengaturan Sistem</flux:heading>
        <flux:subheading>Ubah variabel global yang digunakan di seluruh aplikasi Samara Invitation.</flux:subheading>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <flux:card>
                <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <flux:field>
                            <flux:label>Nomor WhatsApp CS</flux:label>
                            <flux:input 
                                name="whatsapp_cs" 
                                value="{{ old('whatsapp_cs', $settings['whatsapp_cs'] ?? '') }}" 
                                placeholder="6281234567890" 
                            />
                            <flux:description>Gunakan format 628... tanpa tanda + atau 0.</flux:description>
                            <flux:error name="whatsapp_cs" />
                        </flux:field>

                        <flux:field>
                            <flux:label>URL Logo Perusahaan</flux:label>
                            <flux:input 
                                name="logo_url" 
                                value="{{ old('logo_url', $settings['logo_url'] ?? '') }}" 
                                placeholder="https://example.com/logo.png" 
                            />
                            <flux:description>Link URL gambar logo publik perusahaan.</flux:description>
                            <flux:error name="logo_url" />
                        </flux:field>
                    </div>

                    <flux:field>
                        <flux:label>Teks Footer Aplikasi</flux:label>
                        <flux:input 
                            name="footer_text" 
                            value="{{ old('footer_text', $settings['footer_text'] ?? '') }}" 
                            placeholder="© 2026 Samara Invitation. Hak cipta dilindungi." 
                        />
                        <flux:description>Teks hak cipta yang akan muncul di bagian bawah undangan kustomer.</flux:description>
                        <flux:error name="footer_text" />
                    </flux:field>

                    <div class="pt-4 border-t border-zinc-200 dark:border-zinc-700 flex items-center justify-end">
                        <flux:button type="submit" variant="primary" icon="check">Simpan Pengaturan</flux:button>
                    </div>
                </form>
            </flux:card>
        </div>

        <div class="space-y-6">
            <flux:card>
                <div class="flex items-center gap-2 mb-3">
                    <flux:icon icon="cog" class="text-amber-500 size-5" />
                    <flux:heading size="lg">Informasi Pengaturan</flux:heading>
                </div>
                <flux:text class="text-sm space-y-3 leading-relaxed">
                    <p>
                        Nilai yang disimpan di sini berlaku secara global untuk seluruh kustomer dan halaman publik.
                    </p>
                    <p>
                        Nomor WhatsApp CS digunakan pada tombol bantuan kustomer di halaman tagihan.
                    </p>
                </flux:text>
            </flux:card>
        </div>
    </div>
@endsection
