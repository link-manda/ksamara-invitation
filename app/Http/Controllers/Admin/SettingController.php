<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        ]);

        $this->settingService->updateSettings($data);

        return redirect()->back()->with('toast', 'Pengaturan berhasil diperbarui.');
    }
}
