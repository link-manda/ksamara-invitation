@extends('layouts.customer')

@section('content')
<div class="mb-6">
    <flux:heading size="xl">Manajemen Detail Undangan</flux:heading>
    <flux:subheading>Lengkapi data pernikahan Anda. Halaman ini menyimpan otomatis setiap perubahan saat Anda menekan tombol Simpan.</flux:subheading>
</div>

<form action="{{ route('customer.invitations.update', $invitation->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <flux:tab.group>
        <flux:tabs>
            <flux:tab name="mempelai">Data Mempelai</flux:tab>
            <flux:tab name="acara">Rangkaian Acara</flux:tab>
            <flux:tab name="galeri">Galeri Foto/Video</flux:tab>
            <flux:tab name="amplop">Amplop Digital</flux:tab>
        </flux:tabs>

        <flux:tab.panel name="mempelai">
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
        </flux:tab.panel>

        <flux:tab.panel name="acara">
            <flux:card class="flex flex-col gap-6">
                <flux:heading size="lg">Daftar Acara (Akad/Pemberkatan & Resepsi)</flux:heading>
                <flux:subheading>Isi satu atau lebih rangkaian acara. Isi nama acara untuk menyimpan.</flux:subheading>
                
                @for ($i = 0; $i < 2; $i++)
                    @php 
                        $event = $invitation->events->get($i); 
                    @endphp
                    <div class="p-4 border border-zinc-200 dark:border-zinc-700 rounded-lg space-y-4">
                        <flux:heading size="md">Acara {{ $i + 1 }}</flux:heading>
                        <input type="hidden" name="events[{{ $i }}][id]" value="{{ $event->id ?? '' }}">
                        <flux:input name="events[{{ $i }}][name]" label="Nama Acara" placeholder="Contoh: Akad Nikah" value="{{ old('events.'.$i.'.name', $event->name ?? '') }}" />
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <flux:input type="datetime-local" name="events[{{ $i }}][start_time]" label="Waktu Mulai" value="{{ old('events.'.$i.'.start_time', isset($event->start_time) ? $event->start_time->format('Y-m-d\TH:i') : '') }}" />
                            <flux:input type="datetime-local" name="events[{{ $i }}][end_time]" label="Waktu Selesai (Opsional)" value="{{ old('events.'.$i.'.end_time', isset($event->end_time) ? $event->end_time->format('Y-m-d\TH:i') : '') }}" />
                        </div>
                        
                        <flux:input name="events[{{ $i }}][location_name]" label="Nama Tempat/Gedung" placeholder="Contoh: Gedung Serbaguna XYZ" value="{{ old('events.'.$i.'.location_name', $event->location_name ?? '') }}" />
                        <flux:textarea name="events[{{ $i }}][location_address]" label="Alamat Lengkap" rows="2">{{ old('events.'.$i.'.location_address', $event->location_address ?? '') }}</flux:textarea>
                        <flux:input name="events[{{ $i }}][google_maps_link]" label="Link Google Maps (Opsional)" placeholder="https://goo.gl/maps/..." value="{{ old('events.'.$i.'.google_maps_link', $event->google_maps_link ?? '') }}" />
                    </div>
                @endfor
            </flux:card>
        </flux:tab.panel>

        <flux:tab.panel name="galeri">
            <flux:card class="flex flex-col gap-6">
                <flux:heading size="lg">Unggah Galeri (Foto & Video Singkat)</flux:heading>
                <flux:subheading>Pilih gambar. (Format jpg, png, webp. Maksimal 5MB/file).</flux:subheading>
                
                <flux:input type="file" name="galleries[]" label="Pilih File (Bisa multi)" multiple accept="image/*" />

                @if($invitation->galleries->count() > 0)
                    <div class="mt-4">
                        <flux:heading size="md" class="mb-3">Galeri Terunggah</flux:heading>
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
        </flux:tab.panel>

        <flux:tab.panel name="amplop">
            <flux:card class="flex flex-col gap-6">
                <flux:heading size="lg">Amplop Digital (Kirim Hadiah)</flux:heading>
                <flux:subheading>Masukkan informasi rekening atau e-wallet. Isi nama bank untuk menyimpan.</flux:subheading>

                @for ($i = 0; $i < 2; $i++)
                    @php 
                        $envelope = $invitation->digitalEnvelopes->get($i); 
                    @endphp
                    <div class="p-4 border border-zinc-200 dark:border-zinc-700 rounded-lg space-y-4">
                        <flux:heading size="md">Rekening / E-Wallet {{ $i + 1 }}</flux:heading>
                        <input type="hidden" name="envelopes[{{ $i }}][id]" value="{{ $envelope->id ?? '' }}">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <flux:input name="envelopes[{{ $i }}][bank_name]" label="Nama Bank / E-Wallet" placeholder="Contoh: BCA / GoPay" value="{{ old('envelopes.'.$i.'.bank_name', $envelope->bank_name ?? '') }}" />
                            <flux:input name="envelopes[{{ $i }}][account_name]" label="Atas Nama" placeholder="Contoh: Budi Santoso" value="{{ old('envelopes.'.$i.'.account_name', $envelope->account_name ?? '') }}" />
                        </div>
                        <flux:input name="envelopes[{{ $i }}][account_number]" label="Nomor Rekening / No. HP" value="{{ old('envelopes.'.$i.'.account_number', $envelope->account_number ?? '') }}" />
                        
                        <div class="mt-2">
                            <flux:input type="file" name="envelopes[{{ $i }}][qr_code_file]" label="Upload QRIS (Opsional, Max 2MB)" accept="image/jpeg,image/png,image/jpg" />
                            @if(isset($envelope->qr_code_path))
                                <div class="mt-2 text-sm text-green-600 dark:text-green-400 font-medium">✓ QRIS sudah diunggah.</div>
                            @endif
                        </div>
                    </div>
                @endfor
            </flux:card>
        </flux:tab.panel>
    </flux:tab.group>

    <div class="mt-6 flex justify-end">
        <flux:button type="submit" variant="primary" icon="check" class="w-full sm:w-auto">Simpan Detail Undangan</flux:button>
    </div>
</form>
@endsection
