@extends('layouts.customer')

@section('content')
<div class="mb-6">
    <flux:heading size="xl" level="1">Manajemen Detail Undangan</flux:heading>
    <flux:subheading>Lengkapi data pernikahan Anda. Halaman ini menyimpan otomatis setiap perubahan saat Anda menekan tombol Simpan.</flux:subheading>
</div>

@if ($errors->any())
    <div class="mb-6 p-4 rounded-xl bg-red-500/10 dark:bg-red-500/20 border border-red-500/20 dark:border-red-500/30 text-red-700 dark:text-red-300 flex items-start gap-3 shadow-xs">
        <flux:icon icon="exclamation-triangle" class="size-5 text-red-500 shrink-0 mt-0.5" />
        <div class="space-y-1 text-xs">
            <h4 class="font-bold text-sm text-red-800 dark:text-red-200">Terdapat kesalahan pengisian data ({{ $errors->count() }} kesalahan)</h4>
            <p>Mohon periksa tab yang ditandai badge merah dan lengkapi field yang membutuhkan perbaikan.</p>
        </div>
    </div>
@endif

<form action="{{ route('customer.invitations.update', $invitation->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div x-data="{ tab: '{{ $errors->hasAny(['events', 'events.*']) ? 'acara' : ($errors->hasAny(['galleries', 'galleries.*']) ? 'galeri' : ($errors->hasAny(['music_path', 'envelopes', 'envelopes.*']) ? 'pengaturan' : (request()->query('tab') === 'galeri' ? 'galeri' : 'mempelai'))) }}' }" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="flex gap-1 border-b border-zinc-200 dark:border-zinc-700 overflow-x-auto">
                <button
                    type="button"
                    @click="tab = 'mempelai'"
                    :class="tab === 'mempelai' ? 'border-amber-600 text-amber-600 dark:text-amber-500 font-bold' : 'border-transparent text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300 font-medium'"
                    class="px-4 py-2 text-sm border-b-2 whitespace-nowrap transition-colors flex items-center gap-1.5"
                >
                    <span>Data Mempelai</span>
                    @if($errors->hasAny(['title', 'groom_name', 'bride_name', 'groom_parents', 'bride_parents']))
                        <span class="px-1.5 py-0.5 text-[10px] font-bold bg-red-500/15 dark:bg-red-500/30 text-red-600 dark:text-red-400 border border-red-500/30 rounded-full">Error</span>
                    @endif
                </button>

                <button
                    type="button"
                    @click="tab = 'acara'"
                    :class="tab === 'acara' ? 'border-amber-600 text-amber-600 dark:text-amber-500 font-bold' : 'border-transparent text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300 font-medium'"
                    class="px-4 py-2 text-sm border-b-2 whitespace-nowrap transition-colors flex items-center gap-1.5"
                >
                    <span>Rangkaian Acara</span>
                    @if($errors->hasAny(['events', 'events.*']))
                        <span class="px-1.5 py-0.5 text-[10px] font-bold bg-red-500/15 dark:bg-red-500/30 text-red-600 dark:text-red-400 border border-red-500/30 rounded-full">Error</span>
                    @endif
                </button>

                <button
                    type="button"
                    @click="tab = 'galeri'"
                    :class="tab === 'galeri' ? 'border-amber-600 text-amber-600 dark:text-amber-500 font-bold' : 'border-transparent text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300 font-medium'"
                    class="px-4 py-2 text-sm border-b-2 whitespace-nowrap transition-colors flex items-center gap-1.5"
                >
                    <span>Galeri Foto/Video</span>
                    @if($errors->hasAny(['galleries', 'galleries.*']))
                        <span class="px-1.5 py-0.5 text-[10px] font-bold bg-red-500/15 dark:bg-red-500/30 text-red-600 dark:text-red-400 border border-red-500/30 rounded-full">Error</span>
                    @endif
                </button>

                <button
                    type="button"
                    @click="tab = 'pengaturan'"
                    :class="tab === 'pengaturan' ? 'border-amber-600 text-amber-600 dark:text-amber-500 font-bold' : 'border-transparent text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300 font-medium'"
                    class="px-4 py-2 text-sm border-b-2 whitespace-nowrap transition-colors flex items-center gap-1.5"
                >
                    <span>Pengaturan (BGM & Amplop)</span>
                    @if($errors->hasAny(['music_path', 'envelopes', 'envelopes.*']))
                        <span class="px-1.5 py-0.5 text-[10px] font-bold bg-red-500/15 dark:bg-red-500/30 text-red-600 dark:text-red-400 border border-red-500/30 rounded-full">Error</span>
                    @endif
                </button>
            </div>

            <div>
                <!-- Tab Mempelai -->
                <div x-show="tab === 'mempelai'">
                    <flux:card class="flex flex-col gap-6">
                        <flux:field>
                            <flux:label class="flex items-center gap-1">Judul Undangan <span class="text-red-500 font-bold">*</span></flux:label>
                            <flux:input name="title" placeholder="Contoh: Pernikahan Romeo & Juliet" value="{{ old('title', $invitation->title) }}" required />
                            <flux:error name="title" />
                        </flux:field>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <flux:heading size="lg">Mempelai Pria</flux:heading>
                                <flux:field>
                                    <flux:label class="flex items-center gap-1">Nama Panggilan/Lengkap Pria <span class="text-red-500 font-bold">*</span></flux:label>
                                    <flux:input name="groom_name" value="{{ old('groom_name', $invitation->groom_name) }}" required />
                                    <flux:error name="groom_name" />
                                </flux:field>

                                <flux:field>
                                    <flux:label class="flex items-center gap-1.5">
                                        <span>Nama Orang Tua Pria</span>
                                        <span class="text-xs text-zinc-400 dark:text-zinc-500 font-normal">(Opsional)</span>
                                    </flux:label>
                                    <flux:textarea name="groom_parents" placeholder="Putra dari Bapak X dan Ibu Y" rows="3">{{ old('groom_parents', $invitation->groom_parents) }}</flux:textarea>
                                    <flux:error name="groom_parents" />
                                </flux:field>
                            </div>

                            <div class="space-y-4">
                                <flux:heading size="lg">Mempelai Wanita</flux:heading>
                                <flux:field>
                                    <flux:label class="flex items-center gap-1">Nama Panggilan/Lengkap Wanita <span class="text-red-500 font-bold">*</span></flux:label>
                                    <flux:input name="bride_name" value="{{ old('bride_name', $invitation->bride_name) }}" required />
                                    <flux:error name="bride_name" />
                                </flux:field>

                                <flux:field>
                                    <flux:label class="flex items-center gap-1.5">
                                        <span>Nama Orang Tua Wanita</span>
                                        <span class="text-xs text-zinc-400 dark:text-zinc-500 font-normal">(Opsional)</span>
                                    </flux:label>
                                    <flux:textarea name="bride_parents" placeholder="Putri dari Bapak A dan Ibu B" rows="3">{{ old('bride_parents', $invitation->bride_parents) }}</flux:textarea>
                                    <flux:error name="bride_parents" />
                                </flux:field>
                            </div>
                        </div>
                    </flux:card>
                </div>

                <!-- Tab Acara -->
                <div x-show="tab === 'acara'" x-cloak>
                    <flux:card class="flex flex-col gap-6">
                        <div>
                            <flux:heading size="lg">Daftar Acara (Akad/Pemberkatan & Resepsi)</flux:heading>
                            <flux:subheading>Isi satu atau lebih rangkaian acara. Isi nama acara untuk menyimpan.</flux:subheading>
                        </div>
                        
                        @for ($i = 0; $i < 2; $i++)
                            @php 
                                $event = $invitation->events->get($i); 
                            @endphp
                            <div class="p-4 border border-zinc-200 dark:border-zinc-700/80 rounded-xl space-y-4 bg-zinc-50/50 dark:bg-zinc-800/30">
                                <flux:heading size="md" class="text-amber-600 dark:text-amber-400">Acara {{ $i + 1 }}</flux:heading>
                                <input type="hidden" name="events[{{ $i }}][id]" value="{{ $event?->id ?? '' }}">
                                
                                <flux:field>
                                    <flux:label class="flex items-center gap-1.5">
                                        <span>Nama Acara</span>
                                        <span class="text-red-500 font-bold">*</span>
                                        <span class="text-xs text-zinc-400 dark:text-zinc-500 font-normal">(Wajib jika diisi)</span>
                                    </flux:label>
                                    <flux:input name="events[{{ $i }}][name]" placeholder="Contoh: Akad Nikah" value="{{ old('events.'.$i.'.name', $event?->name ?? '') }}" />
                                    <flux:error name="events.{{ $i }}.name" />
                                </flux:field>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <flux:field>
                                        <flux:label class="flex items-center gap-1">Waktu Mulai <span class="text-red-500 font-bold">*</span></flux:label>
                                        <flux:input type="datetime-local" name="events[{{ $i }}][start_time]" value="{{ old('events.'.$i.'.start_time', $event?->start_time?->format('Y-m-d\TH:i') ?? '') }}" />
                                        <flux:error name="events.{{ $i }}.start_time" />
                                    </flux:field>

                                    <flux:field>
                                        <flux:label class="flex items-center gap-1.5">
                                            <span>Waktu Selesai</span>
                                            <span class="text-xs text-zinc-400 dark:text-zinc-500 font-normal">(Opsional)</span>
                                        </flux:label>
                                        <flux:input type="datetime-local" name="events[{{ $i }}][end_time]" value="{{ old('events.'.$i.'.end_time', $event?->end_time?->format('Y-m-d\TH:i') ?? '') }}" />
                                        <flux:error name="events.{{ $i }}.end_time" />
                                    </flux:field>
                                </div>
                                
                                <flux:field>
                                    <flux:label class="flex items-center gap-1">Nama Tempat/Gedung <span class="text-red-500 font-bold">*</span></flux:label>
                                    <flux:input name="events[{{ $i }}][location_name]" placeholder="Contoh: Gedung Serbaguna XYZ" value="{{ old('events.'.$i.'.location_name', $event?->location_name ?? '') }}" />
                                    <flux:error name="events.{{ $i }}.location_name" />
                                </flux:field>

                                <flux:field>
                                    <flux:label class="flex items-center gap-1">Alamat Lengkap <span class="text-red-500 font-bold">*</span></flux:label>
                                    <flux:textarea name="events[{{ $i }}][location_address]" rows="2">{{ old('events.'.$i.'.location_address', $event?->location_address ?? '') }}</flux:textarea>
                                    <flux:error name="events.{{ $i }}.location_address" />
                                </flux:field>

                                <flux:field>
                                    <flux:label class="flex items-center gap-1.5">
                                        <span>Link Google Maps</span>
                                        <span class="text-xs text-zinc-400 dark:text-zinc-500 font-normal">(Opsional)</span>
                                    </flux:label>
                                    <flux:input name="events[{{ $i }}][google_maps_link]" placeholder="https://goo.gl/maps/..." value="{{ old('events.'.$i.'.google_maps_link', $event?->google_maps_link ?? '') }}" />
                                    <flux:error name="events.{{ $i }}.google_maps_link" />
                                </flux:field>
                            </div>
                        @endfor
                    </flux:card>
                </div>

                <!-- Tab Galeri -->
                <div x-show="tab === 'galeri'" x-cloak>
                    <flux:card class="flex flex-col gap-6">
                        <div>
                            <flux:heading size="lg">Unggah Galeri (Foto & Video Singkat)</flux:heading>
                            <flux:subheading>
                                Pilih gambar. (Format jpg, png, webp. Maksimal 2MB/file). 
                                @if($invitation->order && $invitation->order->package && $invitation->order->package->max_photos > 0)
                                    <br><span class="text-amber-600 font-medium">Batas maksimal dari paket Anda: {{ $invitation->order->package->max_photos }} file.</span>
                                @endif
                            </flux:subheading>
                        </div>
                        
                        <div x-data="{ previews: [] }">
                            <flux:field>
                                <flux:label class="flex items-center gap-1.5">
                                    <span>Pilih File Foto (Multi Select)</span>
                                    <span class="text-xs text-zinc-400 dark:text-zinc-500 font-normal">(Opsional)</span>
                                </flux:label>
                                <flux:input type="file" name="galleries[]" multiple accept="image/*" 
                                    @change="previews = []; Array.from($event.target.files).forEach(file => { const reader = new FileReader(); reader.onload = (e) => previews.push(e.target.result); reader.readAsDataURL(file); })"
                                />
                                <flux:error name="galleries" />
                                <flux:error name="galleries.*" />
                            </flux:field>

                            <!-- Preview of new files -->
                            <template x-if="previews.length > 0">
                                <div class="mt-4">
                                    <flux:heading size="md" class="mb-3">Preview Upload Baru</flux:heading>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                                        <template x-for="src in previews" :key="src">
                                            <div class="rounded-lg overflow-hidden border border-zinc-200 dark:border-zinc-700 aspect-square">
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
                                        <div class="relative rounded-lg overflow-hidden border border-zinc-200 dark:border-zinc-700 aspect-square group">
                                            <img src="{{ Storage::url($gallery->file_path) }}" alt="Foto galeri" class="w-full h-full object-cover">
                                            <flux:modal.trigger name="delete-gallery-{{ $gallery->id }}">
                                                <flux:button
                                                    type="button"
                                                    variant="danger"
                                                    size="sm"
                                                    icon="trash"
                                                    class="absolute top-2 right-2 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 sm:group-focus-within:opacity-100 transition-opacity"
                                                    aria-label="Hapus foto galeri"
                                                />
                                            </flux:modal.trigger>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </flux:card>
                </div>

                <!-- Tab Pengaturan -->
                <div x-show="tab === 'pengaturan'" x-cloak class="space-y-6">
                    <!-- BGM Section -->
                    <flux:card class="flex flex-col gap-6">
                        <div>
                            <flux:heading size="lg">Lagu Latar (BGM)</flux:heading>
                            <flux:subheading>Pilih lagu latar yang akan diputar saat tamu membuka undangan.</flux:subheading>
                        </div>
                        
                        @if($invitation->order && $invitation->order->package && $invitation->order->package->enable_bgm)
                            <flux:field>
                                <flux:label class="flex items-center gap-1.5">
                                    <span>Background Music (BGM)</span>
                                    <span class="text-xs text-zinc-400 dark:text-zinc-500 font-normal">(Opsional)</span>
                                </flux:label>
                                <flux:select name="music_path" placeholder="Pilih BGM (Opsional)">
                                    <flux:select.option value="">Tanpa Musik</flux:select.option>
                                    <flux:select.option value="bgm/wedding_piano.mp3" {{ old('music_path', $invitation->music_path) === 'bgm/wedding_piano.mp3' ? 'selected' : '' }}>Piano Klasik Romantis</flux:select.option>
                                    <flux:select.option value="bgm/wedding_acoustic.mp3" {{ old('music_path', $invitation->music_path) === 'bgm/wedding_acoustic.mp3' ? 'selected' : '' }}>Gitar Akustik Menenangkan</flux:select.option>
                                    <flux:select.option value="bgm/wedding_lofi.mp3" {{ old('music_path', $invitation->music_path) === 'bgm/wedding_lofi.mp3' ? 'selected' : '' }}>Lo-Fi Aesthetic</flux:select.option>
                                </flux:select>
                                <flux:error name="music_path" />
                            </flux:field>
                        @else
                            <div class="p-4 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20 text-sm">
                                Paket Anda tidak termasuk fitur Musik Latar. Silakan upgrade paket Anda untuk menggunakan fitur ini.
                            </div>
                        @endif
                    </flux:card>

                    <!-- Amplop Section -->
                    <flux:card class="flex flex-col gap-6">
                        <div>
                            <flux:heading size="lg">Amplop Digital (Kirim Hadiah)</flux:heading>
                            <flux:subheading>Masukkan informasi rekening atau e-wallet. Isi nama bank untuk menyimpan.</flux:subheading>
                        </div>

                        @for ($i = 0; $i < 2; $i++)
                            @php 
                                $envelope = $invitation->digitalEnvelopes->get($i); 
                            @endphp
                            <div class="p-4 border border-zinc-200 dark:border-zinc-700/80 rounded-xl space-y-4 bg-zinc-50/50 dark:bg-zinc-800/30">
                                <flux:heading size="md" class="text-amber-600 dark:text-amber-400">Rekening / E-Wallet {{ $i + 1 }}</flux:heading>
                                <input type="hidden" name="envelopes[{{ $i }}][id]" value="{{ $envelope?->id ?? '' }}">
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <flux:field>
                                        <flux:label class="flex items-center gap-1.5">
                                            <span>Nama Bank / E-Wallet</span>
                                            <span class="text-red-500 font-bold">*</span>
                                            <span class="text-xs text-zinc-400 dark:text-zinc-500 font-normal">(Wajib jika diisi)</span>
                                        </flux:label>
                                        <flux:input name="envelopes[{{ $i }}][bank_name]" placeholder="Contoh: BCA / GoPay" value="{{ old('envelopes.'.$i.'.bank_name', $envelope?->bank_name ?? '') }}" />
                                        <flux:error name="envelopes.{{ $i }}.bank_name" />
                                    </flux:field>

                                    <flux:field>
                                        <flux:label class="flex items-center gap-1">Atas Nama <span class="text-red-500 font-bold">*</span></flux:label>
                                        <flux:input name="envelopes[{{ $i }}][account_name]" placeholder="Contoh: Budi Santoso" value="{{ old('envelopes.'.$i.'.account_name', $envelope?->account_name ?? '') }}" />
                                        <flux:error name="envelopes.{{ $i }}.account_name" />
                                    </flux:field>
                                </div>

                                <flux:field>
                                    <flux:label class="flex items-center gap-1.5">
                                        <span>Nomor Rekening / No. HP</span>
                                        <span class="text-xs text-zinc-400 dark:text-zinc-500 font-normal">(Opsional)</span>
                                    </flux:label>
                                    <flux:input name="envelopes[{{ $i }}][account_number]" value="{{ old('envelopes.'.$i.'.account_number', $envelope?->account_number ?? '') }}" />
                                    <flux:error name="envelopes.{{ $i }}.account_number" />
                                </flux:field>
                                
                                <div class="mt-2" x-data="{ preview: null }">
                                    <flux:field>
                                        <flux:label class="flex items-center gap-1.5">
                                            <span>Upload QRIS</span>
                                            <span class="text-xs text-zinc-400 dark:text-zinc-500 font-normal">(Opsional, Max 2MB)</span>
                                        </flux:label>
                                        <flux:input type="file" name="envelopes[{{ $i }}][qr_code_file]" accept="image/jpeg,image/png,image/jpg" 
                                            @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => preview = e.target.result; reader.readAsDataURL(file); } else { preview = null; }"
                                        />
                                        <flux:error name="envelopes.{{ $i }}.qr_code_file" />
                                    </flux:field>
                                    
                                    <div class="mt-3 flex items-start gap-4">
                                        @if(isset($envelope->qr_code_path))
                                            <div x-show="!preview" class="flex flex-col gap-2">
                                                <span class="text-sm text-green-600 dark:text-green-400 font-medium flex items-center gap-1.5"><flux:icon icon="check-circle" class="size-4 text-emerald-500" /> QRIS Tersimpan:</span>
                                                <img src="{{ Storage::url($envelope->qr_code_path) }}" class="h-20 w-20 object-cover rounded-lg border border-zinc-200 dark:border-zinc-700">
                                            </div>
                                        @endif
                                        
                                        <div x-show="preview" style="display: none;" class="flex flex-col gap-2">
                                            <span class="text-sm text-amber-600 font-medium">Preview Upload Baru:</span>
                                            <img :src="preview" class="h-20 w-20 object-cover rounded-lg border border-zinc-200 dark:border-zinc-700">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </flux:card>
                </div>
            </div>
        </div>

        <!-- Right Side Panel -->
        <div class="space-y-6">
            <flux:card class="sticky top-6 space-y-6">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs uppercase tracking-wider text-zinc-500 font-semibold">Status Undangan</span>
                        @if($invitation->status === \App\Enums\InvitationStatus::Published)
                            <flux:badge color="success">Published</flux:badge>
                        @elseif($invitation->status === \App\Enums\InvitationStatus::Draft)
                            <flux:badge color="zinc">Draft</flux:badge>
                        @else
                            <flux:badge color="danger">Inactive</flux:badge>
                        @endif
                    </div>
                    <div class="text-sm font-semibold text-zinc-900 dark:text-white truncate">
                        {{ $invitation->title }}
                    </div>
                    <div class="text-xs text-amber-600 dark:text-amber-400 font-mono mt-1">
                        /{{ $invitation->slug }}
                    </div>
                </div>

                <flux:separator />

                <div class="space-y-3">
                    <div class="flex justify-between text-xs text-zinc-600 dark:text-zinc-400">
                        <span>Foto Galeri Terunggah:</span>
                        <span class="font-bold text-zinc-900 dark:text-white">{{ $invitation->galleries->count() }} file</span>
                    </div>
                    <div class="flex justify-between text-xs text-zinc-600 dark:text-zinc-400">
                        <span>Rangkaian Acara:</span>
                        <span class="font-bold text-zinc-900 dark:text-white">{{ $invitation->events->count() }} acara</span>
                    </div>
                    <div class="flex justify-between text-xs text-zinc-600 dark:text-zinc-400">
                        <span>Amplop Digital:</span>
                        <span class="font-bold text-zinc-900 dark:text-white">{{ $invitation->digitalEnvelopes->count() }} rekening</span>
                    </div>
                </div>

                <div class="pt-2 space-y-3">
                    <flux:button type="submit" variant="primary" icon="check" class="w-full">
                        Simpan Detail Undangan
                    </flux:button>

                    <flux:button href="{{ route('public.invitation.show', $invitation->slug) }}" target="_blank" variant="outline" icon="arrow-top-right-on-square" class="w-full">
                        Lihat Undangan Live
                    </flux:button>
                </div>
            </flux:card>
        </div>
    </div>
</form>

@foreach($invitation->galleries as $gallery)
    <x-confirm-delete-modal
        name="delete-gallery-{{ $gallery->id }}"
        :action="route('customer.invitations.galleries.destroy', [$invitation, $gallery])"
        heading="Hapus foto galeri?"
        text="Foto ini akan dihapus permanen dari galeri undangan."
    />
@endforeach
@endsection
