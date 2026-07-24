@props([
    'title',
    'description',
])

<div class="flex w-full flex-col text-center space-y-1.5 mb-2">
    <flux:heading size="xl" level="1" class="font-bold tracking-tight">{{ $title }}</flux:heading>
    <flux:subheading class="text-sm text-zinc-500 dark:text-zinc-400">{{ $description }}</flux:subheading>
</div>

