@extends('layouts.customer')

@section('content')
    @if (session('status') === 'email-verified')
        <div x-data="{ show: true }" x-show="show" x-transition class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-700 dark:text-emerald-300 flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-3">
                <div class="p-2.5 rounded-lg bg-emerald-500/20 text-emerald-600 dark:text-emerald-400">
                    <flux:icon icon="check-circle" class="size-6" />
                </div>
                <div>
                    <h4 class="text-sm font-bold">Verifikasi Email Berhasil</h4>
                    <p class="text-xs text-emerald-600/90 dark:text-emerald-400/90 mt-0.5">Selamat datang di Samara Invitation. Alamat email Anda telah terverifikasi resmi dan akun siap digunakan sepenuhnya.</p>
                </div>
            </div>
            <button @click="show = false" type="button" class="text-emerald-600 hover:text-emerald-800 dark:text-emerald-400 dark:hover:text-emerald-200 p-1.5 rounded-lg hover:bg-emerald-500/10">
                <flux:icon icon="x-mark" class="size-4" />
            </button>
        </div>
    @endif

    <div class="flex items-center justify-between mb-6">

        <div>
            <flux:heading size="xl" level="1">{{ __('Dashboard Saya') }}</flux:heading>
            <flux:subheading>Kelola undangan pernikahan digital dan kelola daftar tamu Anda.</flux:subheading>
        </div>
        @if(!$has_invitation)
            <flux:button href="{{ route('customer.invitations.create') }}" variant="primary" icon="plus">Buat Undangan Baru</flux:button>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <flux:card class="flex items-center justify-between p-6">
            <div>
                <flux:heading size="sm" class="text-zinc-500 mb-1">Total Undangan Anda</flux:heading>
                <flux:heading size="2xl" class="font-bold">{{ number_format($stats['total_invitations'], 0, ',', '.') }}</flux:heading>
            </div>
            <div class="p-3 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400">
                <flux:icon icon="envelope" class="size-6" />
            </div>
        </flux:card>
        
        <flux:card class="flex items-center justify-between p-6">
            <div>
                <flux:heading size="sm" class="text-zinc-500 mb-1">Tamu Konfirmasi Hadir</flux:heading>
                <flux:heading size="2xl" class="font-bold text-green-600 dark:text-green-400">{{ number_format($stats['total_guests'], 0, ',', '.') }}</flux:heading>
            </div>
            <div class="p-3 rounded-xl bg-green-500/10 text-green-600 dark:text-green-400">
                <flux:icon icon="users" class="size-6" />
            </div>
        </flux:card>
        
        <flux:card class="flex items-center justify-between p-6">
            <div>
                <flux:heading size="sm" class="text-zinc-500 mb-1">Tagihan Belum Dibayar</flux:heading>
                <flux:heading size="2xl" class="font-bold text-red-600 dark:text-red-400">Rp {{ number_format($stats['unpaid_bills'], 0, ',', '.') }}</flux:heading>
            </div>
            <div class="p-3 rounded-xl bg-red-500/10 text-red-600 dark:text-red-400">
                <flux:icon icon="credit-card" class="size-6" />
            </div>
        </flux:card>
    </div>

    <div class="mb-4">
        <flux:heading size="lg" level="2">Daftar Undangan Digital</flux:heading>
    </div>

    @if($invitations->isEmpty())
        <flux:card class="text-center py-12 border-dashed">
            <div class="p-4 rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-400 inline-block mb-3">
                <flux:icon icon="sparkles" class="size-8" />
            </div>
            <flux:heading size="lg" class="mb-1">Anda belum memiliki undangan digital.</flux:heading>
            <flux:subheading class="mb-6 max-w-md mx-auto">Mulai buat undangan pernikahan digital Anda yang elegan hanya dalam beberapa langkah mudah.</flux:subheading>
            <flux:button href="{{ route('customer.invitations.create') }}" variant="primary" icon="plus">Buat Undangan Baru Sekarang</flux:button>
        </flux:card>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($invitations as $invitation)
                <flux:card class="flex flex-col justify-between gap-6 border-zinc-200/80 dark:border-zinc-800 hover:border-amber-500/50 transition-colors">
                    <div class="space-y-3">
                        <div class="flex items-start justify-between gap-2">
                            <flux:heading size="lg" class="font-bold text-zinc-900 dark:text-white leading-snug">{{ $invitation->title }}</flux:heading>
                            @if($invitation->status === \App\Enums\InvitationStatus::Published)
                                <flux:badge color="success">Published</flux:badge>
                            @elseif($invitation->status === \App\Enums\InvitationStatus::Draft)
                                <flux:badge color="zinc">Draft</flux:badge>
                            @else
                                <flux:badge color="danger">Inactive</flux:badge>
                            @endif
                        </div>

                        <div class="text-xs text-zinc-500 font-mono flex items-center gap-1 bg-zinc-100 dark:bg-zinc-800/80 p-2 rounded-lg border border-zinc-200/60 dark:border-zinc-700/60">
                            <flux:icon icon="link" class="size-3.5 text-amber-500 shrink-0" />
                            <a href="{{ route('public.invitation.show', $invitation->slug) }}" target="_blank" class="text-amber-600 dark:text-amber-400 hover:underline truncate">
                                /{{ $invitation->slug }}
                            </a>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-zinc-200 dark:border-zinc-800 gap-2">
                        <div class="flex items-center gap-2">
                            <flux:button href="{{ route('customer.invitations.edit', $invitation->id) }}" variant="outline" size="sm" icon="pencil-square">
                                Edit Data
                            </flux:button>

                            <flux:button href="{{ route('customer.invitations.rsvps.index', $invitation->id) }}" variant="ghost" size="sm" icon="users">
                                Tamu
                            </flux:button>
                        </div>

                        <flux:dropdown align="end">
                            <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom" aria-label="Aksi Lainnya" />
                            <flux:menu>
                                <flux:menu.item icon="arrow-top-right-on-square" href="{{ route('public.invitation.show', $invitation->slug) }}" target="_blank">
                                    Lihat Undangan Live
                                </flux:menu.item>
                                
                                <form action="{{ route('customer.invitations.toggle-status', $invitation->id) }}" method="POST" class="w-full">
                                    @csrf
                                    @method('PATCH')
                                    <flux:menu.item type="submit" icon="{{ $invitation->status === \App\Enums\InvitationStatus::Published ? 'eye-slash' : 'eye' }}">
                                        {{ $invitation->status === \App\Enums\InvitationStatus::Published ? 'Unpublish Undangan' : 'Publish Undangan' }}
                                    </flux:menu.item>
                                </form>

                                <flux:menu.separator />

                                <flux:menu.item 
                                    as="button" 
                                    type="button" 
                                    icon="trash" 
                                    variant="danger" 
                                    x-data 
                                    @click="$dispatch('open-delete-modal', { 
                                        action: '{{ route('customer.invitations.destroy', $invitation->id) }}', 
                                        title: 'Hapus Data Undangan', 
                                        message: 'Apakah Anda yakin ingin menghapus data undangan ini? Seluruh file galeri dan data tamu akan dihapus permanen dan biaya tidak dapat di-refund.' 
                                    })"
                                >
                                    Hapus Undangan
                                </flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>
                    </div>
                </flux:card>
            @endforeach
        </div>
    @endif
@endsection
