<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePackageRequest;
use App\Http\Requests\Admin\UpdatePackageRequest;
use App\Models\Package;
use App\Services\PackageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PackageController extends Controller
{
    public function __construct(private readonly PackageService $packages) {}

    public function index(): View
    {
        return view('package.package_index', ['packages' => $this->packages->list()]);
    }

    public function create(): View
    {
        return view('package.package_form', ['package' => new Package]);
    }

    public function store(StorePackageRequest $request): RedirectResponse
    {
        $this->packages->create($this->featuresToArray($request->validated()));

        return redirect()->route('admin.packages.index')->with('status', __('Package created.'));
    }

    public function edit(Package $package): View
    {
        return view('package.package_form', ['package' => $package]);
    }

    public function update(UpdatePackageRequest $request, Package $package): RedirectResponse
    {
        $this->packages->update($package, $this->featuresToArray($request->validated()));

        return redirect()->route('admin.packages.index')->with('status', __('Package updated.'));
    }

    public function destroy(Package $package): RedirectResponse
    {
        $this->packages->delete($package);

        return redirect()->route('admin.packages.index')->with('status', __('Package deleted.'));
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function featuresToArray(array $data): array
    {
        $data['features'] = collect(explode("\n", (string) ($data['features'] ?? '')))
            ->map(fn (string $line) => trim($line))
            ->filter()
            ->values()
            ->all();

        return $data;
    }
}
