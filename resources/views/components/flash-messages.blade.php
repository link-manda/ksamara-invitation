@if (session('success') || session('toast'))
    <flux:callout variant="success" icon="check-circle" heading="{{ session('success') ?? session('toast') }}" class="mb-4" />
@endif

@if (session('error'))
    <flux:callout variant="danger" icon="x-circle" heading="{{ session('error') }}" class="mb-4" />
@endif

@if (session('warning'))
    <flux:callout variant="warning" icon="exclamation-triangle" heading="{{ session('warning') }}" class="mb-4" />
@endif

@if ($errors->any())
    <flux:callout variant="danger" icon="exclamation-triangle" heading="Terjadi kesalahan pada input Anda:" class="mb-4">
        <flux:callout.text>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </flux:callout.text>
    </flux:callout>
@endif
