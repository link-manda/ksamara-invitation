<x-layouts::admin>
    <h1 class="text-xl font-semibold">
        {{ $package->exists ? __('Edit Package') : __('New Package') }}
    </h1>

    <form
        method="POST"
        action="{{ $package->exists ? route('admin.packages.update', $package) : route('admin.packages.store') }}"
        class="mt-6 max-w-lg space-y-4"
    >
        @csrf
        @if ($package->exists)
            @method('PUT')
        @endif

        <div>
            <label for="name" class="block text-sm font-medium">{{ __('Name') }}</label>
            <input type="text" name="name" id="name" value="{{ old('name', $package->name) }}"
                class="mt-1 block w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm dark:border-zinc-700 dark:bg-zinc-800">
            @error('name')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="price" class="block text-sm font-medium">{{ __('Price') }}</label>
            <input type="number" name="price" id="price" value="{{ old('price', $package->price) }}"
                class="mt-1 block w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm dark:border-zinc-700 dark:bg-zinc-800">
            @error('price')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="features" class="block text-sm font-medium">{{ __('Features') }}</label>
            <textarea name="features" id="features" rows="4"
                placeholder="{{ __('One feature per line') }}"
                class="mt-1 block w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm dark:border-zinc-700 dark:bg-zinc-800">{{ old('features', is_array($package->features) ? implode("\n", $package->features) : '') }}</textarea>
            @error('features')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-2">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" name="is_active" id="is_active" value="1"
                @checked(old('is_active', $package->is_active))
                class="rounded border-zinc-300 dark:border-zinc-700">
            <label for="is_active" class="text-sm font-medium">{{ __('Active') }}</label>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="rounded-lg bg-zinc-900 px-4 py-2 text-sm font-medium text-white dark:bg-zinc-100 dark:text-zinc-900">
                {{ __('Save') }}
            </button>
            <a href="{{ route('admin.packages.index') }}" class="rounded-lg border border-zinc-300 px-4 py-2 text-sm font-medium dark:border-zinc-700">
                {{ __('Cancel') }}
            </a>
        </div>
    </form>
</x-layouts::admin>
