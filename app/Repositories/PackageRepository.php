<?php

namespace App\Repositories;

use App\Models\Package;
use Illuminate\Database\Eloquent\Collection;

class PackageRepository
{
    /**
     * @return Collection<int, Package>
     */
    public function all(): Collection
    {
        return Package::latest()->get();
    }

    public function find(Package $package): Package
    {
        return $package;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function insert(array $data): Package
    {
        return Package::create($data);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function update(Package $package, array $data): Package
    {
        $package->update($data);

        return $package;
    }

    public function delete(Package $package): void
    {
        $package->delete();
    }
}
