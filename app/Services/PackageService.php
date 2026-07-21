<?php

namespace App\Services;

use App\Models\Package;
use App\Repositories\PackageRepository;
use Illuminate\Database\Eloquent\Collection;

class PackageService
{
    public function __construct(private readonly PackageRepository $packages) {}

    /**
     * @return Collection<int, Package>
     */
    public function list(): Collection
    {
        return $this->packages->all();
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): Package
    {
        return $this->packages->insert($data);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function update(Package $package, array $data): Package
    {
        return $this->packages->update($package, $data);
    }

    public function delete(Package $package): void
    {
        $this->packages->delete($package);
    }
}
