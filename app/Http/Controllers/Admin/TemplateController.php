<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\TemplateService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TemplateController extends Controller
{
    public function __construct(private readonly TemplateService $templateService) {}

    public function index(): View
    {
        $templates = $this->templateService->getAllTemplates();

        return view('template.template_index', compact('templates'));
    }

    public function create(): View
    {
        return view('template.template_form');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'view_path' => 'required|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $this->templateService->createTemplate($validated);

        return redirect()->route('admin.templates.index')
            ->with('toast', 'Template berhasil ditambahkan!');
    }

    public function edit(int $id): View
    {
        $template = $this->templateService->getTemplateById($id);

        return view('template.template_form', compact('template'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $template = $this->templateService->getTemplateById($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'view_path' => 'required|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $this->templateService->updateTemplate($template, $validated);

        return redirect()->route('admin.templates.index')
            ->with('toast', 'Template berhasil diperbarui!');
    }

    public function destroy(int $id): RedirectResponse
    {
        $template = $this->templateService->getTemplateById($id);
        $this->templateService->deleteTemplate($template);

        return redirect()->route('admin.templates.index')
            ->with('toast', 'Template berhasil dihapus!');
    }
}
