@props([
    'title',
    'description',
])

<div class="flex w-full flex-col text-center space-y-1.5 mb-2">
    <flux:heading size="xl" level="1" class="font-bold tracking-tight text-slate-900 font-serif">{{ $title }}</flux:heading>
    <flux:subheading class="text-sm text-slate-600 font-light">{{ $description }}</flux:subheading>
</div>
