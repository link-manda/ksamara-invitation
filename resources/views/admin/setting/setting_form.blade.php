@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <flux:heading size="xl">Pengaturan Sistem</flux:heading>
    <flux:subheading>Ubah variabel global yang digunakan di seluruh aplikasi Samara Invitation.</flux:subheading>
</div>

<flux:card>
    <form action="{{ route('settings.update') }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="space-y-6">
            <flux:input 
                name="whatsapp_cs" 
                label="Nomor WhatsApp CS" 
                value="{{ old('whatsapp_cs', $settings['whatsapp_cs'] ?? '') }}" 
                placeholder="6281234567890" 
                description="Nomor WhatsApp tanpa tanda plus (+) atau awalan 0."
            />

            <flux:input 
                name="footer_text" 
                label="Teks Footer" 
                value="{{ old('footer_text', $settings['footer_text'] ?? '') }}" 
                placeholder="© 2026 Samara Invitation. Hak cipta dilindungi." 
                description="Teks yang akan muncul di bagian bawah undangan kustomer."
            />

            <flux:input 
                name="logo_url" 
                label="URL Logo Perusahaan" 
                value="{{ old('logo_url', $settings['logo_url'] ?? '') }}" 
                placeholder="https://example.com/logo.png" 
                description="Link URL untuk logo yang akan ditampilkan."
            />

            <div class="pt-4 flex items-center justify-end">
                <flux:button type="submit" variant="primary">Simpan Pengaturan</flux:button>
            </div>
        </div>
    </form>
</flux:card>
@endsection
