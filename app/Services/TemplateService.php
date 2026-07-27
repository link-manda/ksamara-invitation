<?php

namespace App\Services;

use App\Models\Template;
use App\Repositories\TemplateRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class TemplateService
{
    public function __construct(private readonly TemplateRepository $repository) {}

    public function getAllTemplates(): Collection
    {
        return $this->repository->getAll();
    }

    public function getTemplateById(int $id): ?Template
    {
        return $this->repository->getById($id);
    }

    public function createTemplate(array $data): Template
    {
        $packages = $data['packages'] ?? [];
        unset($data['packages']);

        if (isset($data['thumbnail'])) {
            $data['thumbnail_path'] = $data['thumbnail']->store('templates/thumbnails', 'public');
            unset($data['thumbnail']);
        }

        $data['is_active'] = isset($data['is_active']) ? (bool) $data['is_active'] : false;

        $template = $this->repository->create($data);
        $template->packages()->sync($packages);

        return $template;
    }

    public function updateTemplate(Template $template, array $data): bool
    {
        $packages = $data['packages'] ?? [];
        unset($data['packages']);

        if (isset($data['thumbnail'])) {
            if ($template->thumbnail_path) {
                Storage::disk('public')->delete($template->thumbnail_path);
            }
            $data['thumbnail_path'] = $data['thumbnail']->store('templates/thumbnails', 'public');
            unset($data['thumbnail']);
        }

        $data['is_active'] = isset($data['is_active']) ? (bool) $data['is_active'] : false;

        $updated = $this->repository->update($template, $data);
        $template->packages()->sync($packages);

        return $updated;
    }

    public function deleteTemplate(Template $template): bool
    {
        if ($template->thumbnail_path) {
            Storage::disk('public')->delete($template->thumbnail_path);
        }

        return $this->repository->delete($template);
    }
}
