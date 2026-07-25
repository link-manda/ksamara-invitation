@extends('layouts.admin')

@section('content')
    <div class="mb-6">
        <flux:breadcrumbs>
            <flux:breadcrumbs.item href="{{ route('admin.dashboard') }}">Admin</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Pengaturan Sistem</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <flux:heading size="xl" level="1" class="mt-4">Pengaturan Sistem</flux:heading>
        <flux:subheading>Ubah variabel global, kontak CS, serta pengaturan pembayaran QRIS dan Rekening Bank.</flux:subheading>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <flux:card>
                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-4">
                        <flux:heading size="lg" class="border-b border-zinc-200 dark:border-zinc-800 pb-2">Informasi Umum & CS</flux:heading>

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
                    </div>

                    <div class="space-y-4 pt-4 border-t border-zinc-200 dark:border-zinc-800" x-data="{ qrisPreview: null }">
                        <flux:heading size="lg" class="border-b border-zinc-200 dark:border-zinc-800 pb-2">Pengaturan Pembayaran & QRIS</flux:heading>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
                            <flux:field>
                                <flux:label>Upload Gambar Kode QRIS Resmi</flux:label>
                                <flux:input 
                                    type="file" 
                                    name="qris_image" 
                                    accept="image/jpeg,image/png,image/jpg" 
                                    @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => qrisPreview = e.target.result; reader.readAsDataURL(file); } else { qrisPreview = null; }"
                                />
                                <flux:description>Unggah file gambar QRIS perusahaan (PNG/JPG, Max 2MB).</flux:description>
                                <flux:error name="qris_image" />
                            </flux:field>

                            <div class="flex flex-col gap-2">
                                <flux:label>Preview Kode QRIS Saat Ini</flux:label>
                                <div class="p-3 bg-zinc-50 dark:bg-zinc-800/80 rounded-xl border border-zinc-200 dark:border-zinc-700 text-center inline-block">
                                    <template x-if="qrisPreview">
                                        <div>
                                            <img :src="qrisPreview" class="h-36 w-36 object-cover rounded-lg mx-auto border border-zinc-300 dark:border-zinc-600 shadow-xs mb-1">
                                            <span class="text-xs text-amber-600 dark:text-amber-400 font-medium">Preview Gambar Baru</span>
                                        </div>
                                    </template>

                                    <template x-if="!qrisPreview">
                                        <div>
                                            @if(!empty($settings['qris_image_path']))
                                                <img src="{{ Storage::url($settings['qris_image_path']) }}" class="h-36 w-36 object-cover rounded-lg mx-auto border border-zinc-300 dark:border-zinc-600 shadow-xs mb-1">
                                                <span class="text-xs text-emerald-600 dark:text-emerald-400 font-medium">QRIS Resmi Aktif</span>
                                            @else
                                                <div class="h-36 w-36 bg-zinc-200 dark:bg-zinc-700 rounded-lg flex items-center justify-center text-xs text-zinc-500 mx-auto mb-1">
                                                    QRIS Default
                                                </div>
                                                <span class="text-xs text-zinc-500">Menggunakan QRIS Default</span>
                                            @endif
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <flux:field>
                            <flux:label>Informasi Rekening Bank Transfer (Opsional)</flux:label>
                            <flux:textarea 
                                name="bank_transfer_info" 
                                rows="3" 
                                placeholder="BCA: 1234567890 a.n. PT Samara Invitation&#10;Mandiri: 9876543210 a.n. PT Samara Invitation"
                            >{{ old('bank_transfer_info', $settings['bank_transfer_info'] ?? '') }}</flux:textarea>
                            <flux:description>Instruksi nomor rekening transfer bank alternatif yang akan ditampilkan di modal pembayaran kustomer.</flux:description>
                            <flux:error name="bank_transfer_info" />
                        </flux:field>
                    </div>

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
                        Nomor WhatsApp CS digunakan pada tombol bantuan kustomer dan konfirmasi pembayaran tagihan.
                    </p>

                    <p>
                        Gambar Kode QRIS dan Informasi Bank Transfer akan otomatis tampil pada modal pembayaran kustomer saat hendak melunasi pesanan.
                    </p>
                </flux:text>
            </flux:card>
        </div>
    </div>
@endsection
