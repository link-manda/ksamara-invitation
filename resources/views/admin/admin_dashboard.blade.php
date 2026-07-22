@extends('layouts.admin')

@section('content')
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <flux:heading size="xl">{{ __('Admin Dashboard') }}</flux:heading>
        <p class="text-zinc-500">Selamat datang di panel admin Samara Invitation.</p>
    </div>
@endsection
