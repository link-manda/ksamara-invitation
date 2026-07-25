<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Services\SettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function __construct(private readonly SettingService $settingService) {}

    public function edit(): View
    {
        $settings = $this->settingService->getAllSettings();

        return view('admin.setting.setting_form', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'whatsapp_cs' => ['nullable', 'string', 'max:255'],
            'footer_text' => ['nullable', 'string', 'max:255'],
            'logo_url' => ['nullable', 'string', 'max:255'],
            'bank_transfer_info' => ['nullable', 'string', 'max:1000'],
            'qris_image' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
        ]);

        if ($request->hasFile('qris_image')) {
            $currentSettings = $this->settingService->getAllSettings();
            if (! empty($currentSettings['qris_image_path']) && Storage::disk('public')->exists($currentSettings['qris_image_path'])) {
                Storage::disk('public')->delete($currentSettings['qris_image_path']);
            }

            $path = $request->file('qris_image')->store('settings', 'public');
            $data['qris_image_path'] = $path;
        }

        unset($data['qris_image']);

        $this->settingService->updateSettings($data);

        return NotificationHelper::backWithSuccess('Pengaturan berhasil diperbarui.');
    }
}
