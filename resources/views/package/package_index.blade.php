<x-layouts::admin>
    <div class="flex items-center justify-between">
        <h1 class="text-xl font-semibold">{{ __('Packages') }}</h1>
        <a href="{{ route('admin.packages.create') }}" class="rounded-lg bg-zinc-900 px-4 py-2 text-sm font-medium text-white dark:bg-zinc-100 dark:text-zinc-900">
            {{ __('New Package') }}
        </a>
    </div>

    <div class="mt-6 overflow-x-auto rounded-lg border border-zinc-200 dark:border-zinc-800">
        <table class="min-w-full divide-y divide-zinc-200 text-sm dark:divide-zinc-800">
            <thead class="bg-zinc-50 dark:bg-zinc-900">
                <tr>
                    <th class="px-4 py-3 text-left font-medium">{{ __('Name') }}</th>
                    <th class="px-4 py-3 text-left font-medium">{{ __('Price') }}</th>
                    <th class="px-4 py-3 text-left font-medium">{{ __('Status') }}</th>
                    <th class="px-4 py-3 text-right font-medium">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                @forelse ($packages as $package)
                    <tr>
                        <td class="px-4 py-3">{{ $package->name }}</td>
                        <td class="px-4 py-3">Rp{{ number_format($package->price, 0, ',', '.') }}</td>
                        <td class="px-4 py-3">
                            <span class="rounded-full px-2 py-1 text-xs {{ $package->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : 'bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400' }}">
                                {{ $package->is_active ? __('Active') : __('Inactive') }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.packages.edit', $package) }}" class="text-zinc-600 hover:underline dark:text-zinc-300">{{ __('Edit') }}</a>
                            <form method="POST" action="{{ route('admin.packages.destroy', $package) }}" class="inline" onsubmit="return confirm('{{ __('Delete this package?') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ml-3 text-red-600 hover:underline dark:text-red-400">{{ __('Delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-zinc-500">{{ __('No packages yet.') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts::admin>
