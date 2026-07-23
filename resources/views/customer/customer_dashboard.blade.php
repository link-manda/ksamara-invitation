@extends('layouts.customer')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <flux:heading size="xl" level="1">{{ __('Dashboard') }}</flux:heading>
            <flux:subheading>Selamat datang di area customer Samara Invitation.</flux:subheading>
        </div>
        @if(!$has_invitation)
            <flux:button href="{{ route('customer.invitations.create') }}" variant="primary" icon="plus">Buat Undangan Baru</flux:button>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <flux:card>
            <flux:heading size="sm" class="text-slate-500 mb-1">Total Undangan Anda</flux:heading>
            <flux:heading size="2xl">{{ number_format($stats['total_invitations'], 0, ',', '.') }}</flux:heading>
        </flux:card>
        
        <flux:card>
            <flux:heading size="sm" class="text-slate-500 mb-1">Total Tamu Konfirmasi Hadir</flux:heading>
            <flux:heading size="2xl" class="text-green-600">{{ number_format($stats['total_guests'], 0, ',', '.') }}</flux:heading>
        </flux:card>
        
        <flux:card>
            <flux:heading size="sm" class="text-slate-500 mb-1">Tagihan Belum Dibayar</flux:heading>
            <flux:heading size="2xl" class="text-red-600">Rp {{ number_format($stats['unpaid_bills'], 0, ',', '.') }}</flux:heading>
        </flux:card>
    </div>

    @if($invitations->isEmpty())
        <flux:card class="text-center py-12">
            <flux:heading size="lg" class="mb-2">Anda belum memiliki undangan.</flux:heading>
            <flux:subheading class="mb-4">Mulai buat undangan pernikahan digital Anda sekarang.</flux:subheading>
            <flux:button href="{{ route('customer.invitations.create') }}" variant="primary">Buat Undangan</flux:button>
        </flux:card>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($invitations as $invitation)
                <flux:card class="flex flex-col gap-4">
                    <div>
                        <flux:heading size="lg">{{ $invitation->title }}</flux:heading>
                        <flux:subheading class="mt-1">
                            URL: <a href="{{ route('public.invitation.show', $invitation->slug) }}" target="_blank" class="text-amber-600 hover:underline">/{{ $invitation->slug }}</a>
                        </flux:subheading>
                    </div>

                    <div class="flex items-center justify-between">
                        <span class="text-sm text-slate-500">Status:</span>
                        @if($invitation->status === \App\Enums\InvitationStatus::Published)
                            <flux:badge color="success">Published</flux:badge>
                        @elseif($invitation->status === \App\Enums\InvitationStatus::Draft)
                            <flux:badge color="zinc">Draft</flux:badge>
                        @else
                            <flux:badge color="danger">Inactive</flux:badge>
                        @endif
                    </div>

                    <div class="flex items-center justify-between mt-auto pt-4 border-t border-zinc-200 dark:border-zinc-700">
                        <span class="text-xs text-slate-500 font-medium">Aksi</span>
                        <flux:dropdown align="end">
                            <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom" aria-label="Aksi" />
                            <flux:menu>
                                <flux:menu.item icon="pencil-square" href="{{ route('customer.invitations.edit', $invitation->id) }}">
                                    Edit Data Undangan
                                </flux:menu.item>
                                <flux:menu.item icon="arrow-top-right-on-square" href="{{ route('public.invitation.show', $invitation->slug) }}" target="_blank">
                                    Lihat Undangan Live
                                </flux:menu.item>
                                <flux:menu.item icon="users" href="{{ route('customer.invitations.rsvps.index', $invitation->id) }}">
                                    Daftar RSVP & Tamu
                                </flux:menu.item>
                                
                                <form action="{{ route('customer.invitations.toggle-status', $invitation->id) }}" method="POST" class="w-full">
                                    @csrf
                                    @method('PATCH')
                                    <flux:menu.item type="submit" icon="{{ $invitation->status === \App\Enums\InvitationStatus::Published ? 'eye-slash' : 'eye' }}">
                                        {{ $invitation->status === \App\Enums\InvitationStatus::Published ? 'Unpublish Undangan' : 'Publish Undangan' }}
                                    </flux:menu.item>
                                </form>

                                <flux:menu.separator />

                                <form action="{{ route('customer.invitations.destroy', $invitation->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data undangan ini? Biaya tidak dapat di-refund.');" class="w-full">
                                    @csrf
                                    @method('DELETE')
                                    <flux:menu.item type="submit" icon="trash" variant="danger">
                                        Hapus Undangan
                                    </flux:menu.item>
                                </form>
                            </flux:menu>
                        </flux:dropdown>
                    </div>
                </flux:card>
            @endforeach
        </div>
    @endif
@endsection
