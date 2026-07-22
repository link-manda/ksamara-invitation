@props([
    'name',
    'action',
    'method' => 'DELETE',
    'heading' => 'Hapus data ini?',
    'text' => 'Tindakan ini tidak bisa dibatalkan.',
])

<flux:modal name="{{ $name }}" class="min-w-[22rem]">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">{{ $heading }}</flux:heading>
            <flux:subheading class="mt-2">{{ $text }}</flux:subheading>
        </div>

        <form action="{{ $action }}" method="POST">
            @csrf
            @method($method)

            <div class="flex justify-end gap-2">
                <flux:modal.close>
                    <flux:button variant="ghost">Batal</flux:button>
                </flux:modal.close>
                <flux:button type="submit" variant="danger">Hapus</flux:button>
            </div>
        </form>
    </div>
</flux:modal>
