<?php

namespace App\Services;

use App\Repositories\SettingRepository;

class SettingService
{
    public function __construct(private readonly SettingRepository $repository) {}

    public function getAllSettings(): array
    {
        return $this->repository->getAll();
    }

    public function updateSettings(array $settings): void
    {
        foreach ($settings as $key => $value) {
            $this->repository->updateByKey($key, $value);
        }
    }
}
