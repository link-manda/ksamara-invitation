<?php

namespace App\Repositories;

use App\Models\Setting;

class SettingRepository
{
    public function getAll(): array
    {
        return Setting::pluck('value', 'key')->toArray();
    }

    public function getByKey(string $key): ?string
    {
        $setting = Setting::where('key', $key)->first();

        return $setting ? $setting->value : null;
    }

    public function updateByKey(string $key, ?string $value): Setting
    {
        return Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }
}
