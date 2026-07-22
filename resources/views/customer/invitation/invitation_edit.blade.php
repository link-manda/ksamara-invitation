@extends('layouts.customer')

@section('content')
<div class="mb-6">
    <flux:heading size="xl">Manajemen Detail Undangan</flux:heading>
    <flux:subheading>Lengkapi data pernikahan Anda. Halaman ini menyimpan otomatis setiap perubahan saat Anda menekan tombol Simpan.</flux:subheading>
</div>

<form action="{{ route('customer.invitations.update', $invitation->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div x-data="{ tab: 'mempelai' }">
        <div class="flex gap-1 border-b border-zinc-200 dark:border-zinc-700 overflow-x-auto">
            @foreach (['mempelai' => 'Data Mempelai', 'acara' => 'Rangkaian Acara', 'galeri' => 'Galeri Foto/Video', 'pengaturan' => 'Pengaturan (BGM & Amplop)'] as $key => $label)
                <button
                    type="button"
                    @click="tab = '{{ $key }}'"
                    :class="tab === '{{ $key }}' ? 'border-amber-600 text-amber-600 dark:text-amber-500' : 'border-transparent text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300'"
                    class="px-4 py-2 text-sm font-medium border-b-2 whitespace-nowrap"
                >{{ $label }}</button>
            @endforeach
        </div>

        <div class="mt-6">
            <div x-show="tab === 'mempelai'">
            <flux:card class="flex flex-col gap-6">
                <flux:input name="title" label="Judul Undangan" placeholder="Contoh: Pernikahan Romeo & Juliet" value="{{ old('title', $invitation->title) }}" required />
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <flux:heading size="lg">Mempelai Pria</flux:heading>
                        <flux:input name="groom_name" label="Nama Panggilan/Lengkap" value="{{ old('groom_name', $invitation->groom_name) }}" required />
                        <flux:textarea name="groom_parents" label="Nama Orang Tua Pria" placeholder="Putra dari Bapak X dan Ibu Y" rows="3">{{ old('groom_parents', $invitation->groom_parents) }}</flux:textarea>
                    </div>

                    <div class="space-y-4">
                        <flux:heading size="lg">Mempelai Wanita</flux:heading>
                        <flux:input name="bride_name" label="Nama Panggilan/Lengkap" value="{{ old('bride_name', $invitation->bride_name) }}" required />
                        <flux:textarea name="bride_parents" label="Nama Orang Tua Wanita" placeholder="Putri dari Bapak A dan Ibu B" rows="3">{{ old('bride_parents', $invitation->bride_parents) }}</flux:textarea>
                    </div>
                </div>
            </flux:card>
        </div>

        <div x-show="tab === 'acara'" x-cloak>
            <flux:card class="flex flex-col gap-6">
                <flux:heading size="lg">Daftar Acara (Akad/Pemberkatan & Resepsi)</flux:heading>
                <flux:subheading>Isi satu atau lebih rangkaian acara. Isi nama acara untuk menyimpan.</flux:subheading>
                
                @for ($i = 0; $i < 2; $i++)
                    @php 
                        $event = $invitation->events->get($i); 
                    @endphp
                    <div class="p-4 border border-zinc-200 dark:border-zinc-700 rounded-lg space-y-4">
                        <flux:heading size="md">Acara {{ $i + 1 }}</flux:heading>
                        <input type="hidden" name="events[{{ $i }}][id]" value="{{ $event?->id ?? '' }}">
                        <flux:input name="events[{{ $i }}][name]" label="Nama Acara" placeholder="Contoh: Akad Nikah" value="{{ old('events.'.$i.'.name', $event?->name ?? '') }}" />
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <flux:input type="datetime-local" name="events[{{ $i }}][start_time]" label="Waktu Mulai" value="{{ old('events.'.$i.'.start_time', $event?->start_time?->format('Y-m-d\TH:i') ?? '') }}" />
                            <flux:input type="datetime-local" name="events[{{ $i }}][end_time]" label="Waktu Selesai (Opsional)" value="{{ old('events.'.$i.'.end_time', $event?->end_time?->format('Y-m-d\TH:i') ?? '') }}" />
                        </div>
                        
                        <flux:input name="events[{{ $i }}][location_name]" label="Nama Tempat/Gedung" placeholder="Contoh: Gedung Serbaguna XYZ" value="{{ old('events.'.$i.'.location_name', $event?->location_name ?? '') }}" />
                        <flux:textarea name="events[{{ $i }}][location_address]" label="Alamat Lengkap" rows="2">{{ old('events.'.$i.'.location_address', $event?->location_address ?? '') }}</flux:textarea>
                        <flux:input name="events[{{ $i }}][google_maps_link]" label="Link Google Maps (Opsional)" placeholder="https://goo.gl/maps/..." value="{{ old('events.'.$i.'.google_maps_link', $event?->google_maps_link ?? '') }}" />
                    </div>
                @endfor
            </flux:card>
        </div>

        <div x-show="tab === 'galeri'" x-cloak>
            <flux:card class="flex flex-col gap-6">
                <flux:heading size="lg">Unggah Galeri (Foto & Video Singkat)</flux:heading>
                <flux:subheading>
                    Pilih gambar. (Format jpg, png, webp. Maksimal 5MB/file). 
                    @if($invitation->order && $invitation->order->package && $invitation->order->package->max_photos > 0)
                        <br><span class="text-amber-600 font-medium">Batas maksimal dari paket Anda: {{ $invitation->order->package->max_photos }} file.</span>
                    @endif
                </flux:subheading>
                
                <div x-data="{ previews: [] }">
                    <flux:input type="file" name="galleries[]" label="Pilih File (Bisa multi)" multiple accept="image/*" 
                        @change="previews = []; Array.from($event.target.files).forEach(file => { const reader = new FileReader(); reader.onload = (e) => previews.push(e.target.result); reader.readAsDataURL(file); })"
                    />

                    <!-- Preview of new files -->
                    <template x-if="previews.length > 0">
                        <div class="mt-4">
                            <flux:heading size="md" class="mb-3">Preview Upload Baru</flux:heading>
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                                <template x-for="src in previews" :key="src">
                                    <div class="rounded overflow-hidden border border-zinc-200 dark:border-zinc-700 aspect-square">
                                        <img :src="src" class="w-full h-full object-cover">
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>

                @if($invitation->galleries->count() > 0)
                    <div class="mt-4">
                        <flux:heading size="md" class="mb-3">Galeri Terunggah ({{ $invitation->galleries->count() }} file)</flux:heading>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                            @foreach($invitation->galleries as $gallery)
                                <div class="rounded overflow-hidden border border-zinc-200 dark:border-zinc-700 aspect-square">
                                    <img src="{{ Storage::url($gallery->file_path) }}" alt="Gallery" class="w-full h-full object-cover">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </flux:card>
        </div>

        <div x-show="tab === 'pengaturan'" x-cloak>
            <div class="flex flex-col gap-6">
                <!-- BGM Section -->
                <flux:card class="flex flex-col gap-6">
                    <flux:heading size="lg">Lagu Latar (BGM)</flux:heading>
                    <flux:subheading>Pilih lagu latar yang akan diputar saat tamu membuka undangan.</flux:subheading>
                    
                    @if($invitation->order && $invitation->order->package && $invitation->order->package->enable_bgm)
                        <flux:select name="music_path" label="Background Music (BGM)" placeholder="Pilih BGM (Opsional)">
                            <flux:select.option value="">Tanpa Musik</flux:select.option>
                            <flux:select.option value="bgm/wedding_piano.mp3" {{ old('music_path', $invitation->music_path) === 'bgm/wedding_piano.mp3' ? 'selected' : '' }}>Piano Klasik Romantis</flux:select.option>
                            <flux:select.option value="bgm/wedding_acoustic.mp3" {{ old('music_path', $invitation->music_path) === 'bgm/wedding_acoustic.mp3' ? 'selected' : '' }}>Gitar Akustik Menenangkan</flux:select.option>
                            <flux:select.option value="bgm/wedding_lofi.mp3" {{ old('music_path', $invitation->music_path) === 'bgm/wedding_lofi.mp3' ? 'selected' : '' }}>Lo-Fi Aesthetic</flux:select.option>
                        </flux:select>
                    @else
                        <div class="p-4 rounded bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 border border-amber-200 dark:border-amber-800 text-sm">
                            Paket Anda tidak termasuk fitur Musik Latar. Silakan upgrade paket Anda untuk menggunakan fitur ini.
                        </div>
                    @endif
                </flux:card>

                <!-- Amplop Section -->
                <flux:card class="flex flex-col gap-6">
                    <flux:heading size="lg">Amplop Digital (Kirim Hadiah)</flux:heading>
                    <flux:subheading>Masukkan informasi rekening atau e-wallet. Isi nama bank untuk menyimpan.</flux:subheading>

                    @for ($i = 0; $i < 2; $i++)
                        @php 
                            $envelope = $invitation->digitalEnvelopes->get($i); 
                        @endphp
                        <div class="p-4 border border-zinc-200 dark:border-zinc-700 rounded-lg space-y-4">
                            <flux:heading size="md">Rekening / E-Wallet {{ $i + 1 }}</flux:heading>
                            <input type="hidden" name="envelopes[{{ $i }}][id]" value="{{ $envelope?->id ?? '' }}">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <flux:input name="envelopes[{{ $i }}][bank_name]" label="Nama Bank / E-Wallet" placeholder="Contoh: BCA / GoPay" value="{{ old('envelopes.'.$i.'.bank_name', $envelope?->bank_name ?? '') }}" />
                                <flux:input name="envelopes[{{ $i }}][account_name]" label="Atas Nama" placeholder="Contoh: Budi Santoso" value="{{ old('envelopes.'.$i.'.account_name', $envelope?->account_name ?? '') }}" />
                            </div>
                            <flux:input name="envelopes[{{ $i }}][account_number]" label="Nomor Rekening / No. HP" value="{{ old('envelopes.'.$i.'.account_number', $envelope?->account_number ?? '') }}" />
                            
                            <div class="mt-2" x-data="{ preview: null }">
                                <flux:input type="file" name="envelopes[{{ $i }}][qr_code_file]" label="Upload QRIS (Opsional, Max 2MB)" accept="image/jpeg,image/png,image/jpg" 
                                    @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => preview = e.target.result; reader.readAsDataURL(file); } else { preview = null; }"
                                />
                                
                                <div class="mt-3 flex items-start gap-4">
                                    @if(isset($envelope->qr_code_path))
                                        <div x-show="!preview" class="flex flex-col gap-2">
                                            <span class="text-sm text-green-600 dark:text-green-400 font-medium">✓ QRIS Tersimpan:</span>
                                            <img src="{{ Storage::url($envelope->qr_code_path) }}" class="h-20 w-20 object-cover rounded border border-zinc-200 dark:border-zinc-700">
                                        </div>
                                    @endif
                                    
                                    <div x-show="preview" style="display: none;" class="flex flex-col gap-2">
                                        <span class="text-sm text-amber-600 font-medium">Preview Upload Baru:</span>
                                        <img :src="preview" class="h-20 w-20 object-cover rounded border border-zinc-200 dark:border-zinc-700">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor
                </flux:card>
            </div>
        </div>
    </div>

    <div class="mt-6 flex justify-end">
        <flux:button type="submit" variant="primary" icon="check" class="w-full sm:w-auto">Simpan Detail Undangan</flux:button>
    </div>
</form>
@endsection
