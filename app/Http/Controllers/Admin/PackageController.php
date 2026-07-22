<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\PackageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PackageController extends Controller
{
    public function __construct(
        protected PackageService $packageService
    ) {}

    public function index(): View
    {
        $packages = $this->packageService->getAllPackages();

        return view('package.package_index', compact('packages'));
    }

    public function create(): View
    {
        return view('package.package_form');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'features' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $this->packageService->createPackage($validated);

        return redirect()->route('admin.packages.index')->with('success', 'Paket berhasil ditambahkan.');
    }

    public function edit(int $id): View
    {
        $package = $this->packageService->getPackageById($id);

        return view('package.package_form', compact('package'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'features' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $this->packageService->updatePackage($id, $validated);

        return redirect()->route('admin.packages.index')->with('success', 'Paket berhasil diperbarui.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->packageService->deletePackage($id);

        return redirect()->route('admin.packages.index')->with('success', 'Paket berhasil dihapus.');
    }
}
