@props([
    'name' => 'confirm-delete-modal',
    'action' => '',
    'method' => 'DELETE',
    'heading' => 'Konfirmasi Hapus Data',
    'text' => 'Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.',
])

<div x-data="{
    actionUrl: '{{ $action }}',
    title: '{{ $heading }}',
    message: '{{ $text }}'
}"
x-on:open-delete-modal.window="
    actionUrl = $event.detail.action;
    title = $event.detail.title || title;
    message = $event.detail.message || message;
    $dispatch('modal-show', { name: '{{ $name }}' });
">
    <flux:modal name="{{ $name }}" class="md:max-w-md">
        <div class="space-y-6">
            <div class="flex items-center gap-3">
                <div class="p-2.5 rounded-full bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 shrink-0">
                    <flux:icon icon="exclamation-triangle" class="size-6" />
                </div>
                <div>
                    <flux:heading size="lg" x-text="title">{{ $heading }}</flux:heading>
                    <flux:subheading x-text="message" class="mt-1">{{ $text }}</flux:subheading>
                </div>
            </div>

            <form :action="actionUrl || '{{ $action }}'" action="{{ $action }}" method="POST" class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                @csrf
                @method($method)
                <flux:modal.close>
                    <flux:button type="button" variant="outline">Batal</flux:button>
                </flux:modal.close>
                <flux:button type="submit" variant="danger" icon="trash">Ya, Hapus Data</flux:button>
            </form>
        </div>
    </flux:modal>
</div>
