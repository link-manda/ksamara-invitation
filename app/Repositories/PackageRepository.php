<?php

namespace App\Repositories;

use App\Models\Package;
use Illuminate\Database\Eloquent\Collection;

class PackageRepository
{
    public function getAll(): Collection
    {
        return Package::all();
    }

    public function getById(int $id): ?Package
    {
        return Package::findOrFail($id);
    }

    public function create(array $data): Package
    {
        return Package::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $package = Package::findOrFail($id);

        return $package->update($data);
    }

    public function delete(int $id): bool
    {
        $package = Package::findOrFail($id);

        return $package->delete();
    }
}
