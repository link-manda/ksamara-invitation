@extends('layouts.customer')

@section('content')
<div class="mb-6">
    <flux:heading size="xl">Pantauan RSVP: {{ $invitation->title }}</flux:heading>
    <flux:subheading>Daftar tamu yang telah mengonfirmasi kehadiran beserta ucapan mereka.</flux:subheading>
</div>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <flux:card>
        <flux:heading size="sm" class="text-slate-500">Total Konfirmasi Tamu</flux:heading>
        <flux:heading size="2xl">{{ $stats['total'] }}</flux:heading>
    </flux:card>
    <flux:card>
        <flux:heading size="sm" class="text-slate-500">Hadir</flux:heading>
        <flux:heading size="2xl" class="text-green-600">{{ $stats['hadir'] }}</flux:heading>
    </flux:card>
    <flux:card>
        <flux:heading size="sm" class="text-slate-500">Tidak Hadir</flux:heading>
        <flux:heading size="2xl" class="text-red-600">{{ $stats['tidak_hadir'] }}</flux:heading>
    </flux:card>
    <flux:card>
        <flux:heading size="sm" class="text-slate-500">Masih Ragu</flux:heading>
        <flux:heading size="2xl" class="text-amber-600">{{ $stats['ragu'] }}</flux:heading>
    </flux:card>
</div>

<flux:card>
    <flux:table>
        <flux:table.columns>
            <flux:table.column>Nama Tamu</flux:table.column>
            <flux:table.column>Status</flux:table.column>
            <flux:table.column>Jumlah Orang</flux:table.column>
            <flux:table.column>Waktu</flux:table.column>
            <flux:table.column>Pesan / Ucapan</flux:table.column>
            <flux:table.column align="center">Aksi</flux:table.column>
        </flux:table.columns>
        <flux:table.rows>
            @forelse($rsvps as $rsvp)
            <flux:table.row>
                <flux:table.cell>
                    <span class="font-medium text-zinc-900 dark:text-white">{{ $rsvp->guest_name }}</span>
                </flux:table.cell>
                <flux:table.cell>
                    @if($rsvp->status === \App\Enums\RsvpStatus::Hadir)
                        <flux:badge color="success">Hadir</flux:badge>
                    @elseif($rsvp->status === \App\Enums\RsvpStatus::TidakHadir)
                        <flux:badge color="danger">Tidak Hadir</flux:badge>
                    @else
                        <flux:badge color="warning">Masih Ragu</flux:badge>
                    @endif
                </flux:table.cell>
                <flux:table.cell>{{ $rsvp->guest_count }}</flux:table.cell>
                <flux:table.cell>{{ $rsvp->created_at->format('d M Y, H:i') }}</flux:table.cell>
                <flux:table.cell>
                    <div class="max-w-xs truncate text-slate-500" title="{{ $rsvp->message }}">
                        {{ $rsvp->message ?? '-' }}
                    </div>
                </flux:table.cell>
                <flux:table.cell align="center">
                    <flux:dropdown align="end">
                        <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom" aria-label="Aksi" />
                        <flux:menu>
                            <form action="{{ route('customer.rsvp.destroy', $rsvp->id) }}" method="POST" onsubmit="return confirm('Hapus ucapan/RSVP tamu ini?');" class="w-full">
                                @csrf
                                @method('DELETE')
                                <flux:menu.item type="submit" icon="trash" variant="danger">
                                    Hapus RSVP
                                </flux:menu.item>
                            </form>
                        </flux:menu>
                    </flux:dropdown>
                </flux:table.cell>
            </flux:table.row>
            @empty
            <flux:table.row>
                <flux:table.cell colspan="6" class="text-center text-slate-500 py-6">
                    Belum ada data RSVP yang masuk.
                </flux:table.cell>
            </flux:table.row>
            @endforelse
        </flux:table.rows>
    </flux:table>
</flux:card>
@endsection
