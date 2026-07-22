<?php

namespace App\Services;

use App\Models\Package;
use App\Repositories\PackageRepository;
use Illuminate\Database\Eloquent\Collection;

class PackageService
{
    public function __construct(
        protected PackageRepository $packageRepository
    ) {}

    public function getAllPackages(): Collection
    {
        return $this->packageRepository->getAll();
    }

    public function getPackageById(int $id): ?Package
    {
        return $this->packageRepository->getById($id);
    }

    public function createPackage(array $data): Package
    {
        // Parse features string into array
        if (isset($data['features']) && is_string($data['features'])) {
            $features = array_filter(array_map('trim', explode("\n", $data['features'])));
            $data['features'] = array_values($features);
        } else {
            $data['features'] = [];
        }

        $data['is_active'] = isset($data['is_active']) ? (bool) $data['is_active'] : false;
        $data['enable_bgm'] = isset($data['enable_bgm']) ? true : false;

        return $this->packageRepository->create($data);
    }

    public function updatePackage(int $id, array $data): bool
    {
        // Parse features string into array
        if (isset($data['features']) && is_string($data['features'])) {
            $features = array_filter(array_map('trim', explode("\n", $data['features'])));
            $data['features'] = array_values($features);
        } else {
            $data['features'] = [];
        }

        $data['is_active'] = isset($data['is_active']) ? (bool) $data['is_active'] : false;
        $data['enable_bgm'] = isset($data['enable_bgm']) ? true : false;

        return $this->packageRepository->update($id, $data);
    }

    public function deletePackage(int $id): bool
    {
        return $this->packageRepository->delete($id);
    }
}
